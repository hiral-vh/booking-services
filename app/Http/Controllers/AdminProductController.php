<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminProductMaster;
use App\AdminCategoryMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminProductController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
  /*Product List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('product_master/product_list', $this->data);
    }
    /*Product Add Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['category_list'] = AdminCategoryMaster::categoryListAscOrder();
        }
        return view('product_master/product_add', $this->data);
    }
    /*Product Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'category' => 'required',
                        /* 'box_quantity' => 'required', */
                        'inner_quantity' => 'required',
                        'price' => 'required',
						'file_img'=>'mimes:jpeg,jpg,png,gif'
            ]);
            if ($validator->fails()) {
                return redirect("/product-add")
                                ->withErrors($validator, 'Product')
                                ->withInput();
            } else {
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/product');
                    $image->move($destinationPath, $photo);
                }
                 $slug =SlugHelper::slug(Input::post('name'),'mf_product_master', $field = 'slug', $key = NULL, $value = NULL);
				
                $data_array = array(
                    'name' => Input::post('name'),
                    'category_fk' => Input::post('category'),
					'image' => $photo,
					/* 'box_quantity'=>Input::post('box_quantity'), */
					'inner_quantity'=>Input::post('inner_quantity'),
					'price'=>Input::post('price'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminProductMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Product successfully inserted.");
                    return redirect('product');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('product-add');
                }
            }
        }
    }
    /*Product Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['product_data'] = AdminProductMaster::editRecordById($id);
			$this->data['category_list'] = AdminCategoryMaster::categoryListAscOrder();
        }
        return view('product_master/product_edit', $this->data);
    }
    /*Product Update*/
    public function update(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customMessages = [
                'name.required' => 'Please enter name.',
            ];
            $rules = [
                'name' => 'required',
                'category' => 'required',
				/* 'box_quantity' => 'required', */
				'inner_quantity' => 'required',
				'price' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("price-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Price')
                                ->withInput();
            } else {
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/product');
                    $image->move($destinationPath, $photo);
                }else{
                    $photo = Input::post('old_img');
                }
                $data_array = array(
                    'name' => Input::post('name'),
                    'category_fk' => Input::post('category'),
					'image' => $photo,
					/* 'box_quantity'=>Input::post('box_quantity'), */
					'inner_quantity'=>Input::post('inner_quantity'),
					'price'=>Input::post('price'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('name') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('name'),'mf_product_master', $field = 'slug', $key = NULL, $value = NULL); 
					 
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminProductMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Product updated successfully.');
                return redirect('/product');
            }
        }
    }
	/*Product Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminProductMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Product successfully deleted.");
                return redirect('product');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('product');
            }
        }
    }
    /*product Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $product = AdminProductMaster::productList();
            $n =1;
            foreach($product as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($product)
                            ->addColumn('Action', function ($product) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="product-edit?id='.$product->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$product->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a> <i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i>';
                                return $action;
                            })
                            ->editColumn('category', function ($product) {
                                $c_name = $product->category;
                                return $c_name;
                            })
                            ->rawColumns(['category','Action'])
                            ->make(true);
        }
    }
	
	/* function import_product(Request $request) {
			   set_time_limit(30000);
				$i = 0;
			 
				 $rawCSV = fopen("D:/XAMMP/htdocs/morefose/public/all_product.csv", "r");
				  
					while(!feof($rawCSV)) {
					$row = fgetcsv($rawCSV, 2000, ',', '"');
					if($i != 0){
					
						$datataa = AdminCategoryMaster::exitcheck($row['2']);
						if(empty($datataa))
						{
						
						$this->data['admin_login'] = $admin_login = Session::get('admin_login');
						$slug =SlugHelper::slug($row['2'],'mf_category_master', $field = 'slug', $key = NULL, $value = NULL);
						 $data_array = array(
							'name' => $row['2'],
							'slug' => $slug,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $admin_login['id']
						);
						$insert = new AdminCategoryMaster($data_array);
						$insert->save();
						$cat_insert = $insert->id;
						
						}
						else{
							$cat_insert = $datataa->id;
							
						}
						
						    $this->data['admin_login'] = $admin_login = Session::get('admin_login');
							$slug =SlugHelper::slug($row['1'],'mf_product_master', $field = 'slug', $key = NULL, $value = NULL);
					
							$data_array = array(
								'name' => $row['1'],
								'category_fk' => $cat_insert,
								'box_quantity'=>$row['3'],
								'inner_quantity'=>$row['4'],
								'slug' => $slug,
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => $admin_login['id']
							);
							$insert = new AdminProductMaster($data_array);
							$insert->save();
							$update = $insert->id;
					
						
						
					}
					$i++; 
				
				}
				fclose($rawCSV);
				return redirect('/');
			
			
		} */
  
}

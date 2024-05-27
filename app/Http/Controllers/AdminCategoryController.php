<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminCategoryMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminCategoryController extends Controller {

    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }

    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('category_master/category_list', $this->data);
    }

    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('category_master/category_add', $this->data);
    }

    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'category' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect("/category-add")
                                ->withErrors($validator, 'Category')
                                ->withInput();
            } else {
                 $slug =SlugHelper::slug(Input::post('category'),'mf_category_master', $field = 'slug', $key = NULL, $value = NULL);
                 $data_array = array(
                    'name' => Input::post('category'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminCategoryMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Category successfully inserted.");
                    return redirect('category');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('category-add');
                }
            }
        }
    }

    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['category_data'] = AdminCategoryMaster::editRecordById($id);
        }
        return view('category_master/category_edit', $this->data);
    }

    public function update(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customMessages = [
                'category.required' => 'Please enter category.',
            ];
            $rules = [
                'category' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("category-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Category')
                                ->withInput();
            } else {
                $data_array = array(
                    'name' => Input::post('category'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('category') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('category'),'mf_category_master', $field = 'slug', $key = NULL, $value = NULL); 
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminCategoryMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Category updated successfully.');
                return redirect('/category');
            }
        }
    }

    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminCategoryMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Category successfully deleted.");
                return redirect('category');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('category');
            }
        }
    }

    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $category = AdminCategoryMaster::categoryList();
            $n =1;
            foreach($category as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($category)
                            ->addColumn('Action', function ($category) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="category-edit?id='.$category->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$category->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
                                return $action;
                            })
                            ->editColumn('Category', function ($category) {
                                $c_name = $category->name;
                                return $c_name;
                            })
                            ->rawColumns(['Category','Action'])
                            ->make(true);
        }
    }

}

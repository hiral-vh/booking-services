<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminVanMaster;
use App\AdminDistributorMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminVanController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
    /*VAN List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('van_master/van_list', $this->data);
    }
   /*VAN List Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['distributor'] = AdminDistributorMaster::distributorList();
        }
        return view('van_master/van_add', $this->data);
    }
   /*VAN Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'driver' => 'required',
                        'van_no' => 'required'
                        
            ]);
            if ($validator->fails()) {
                return redirect("/van-add")
                                ->withErrors($validator, 'Van')
                                ->withInput();
            } else {
                 $slug =SlugHelper::slug(Input::post('van_no'),'mf_van_master', $field = 'slug', $key = NULL, $value = NULL);
				 
                $data_array = array(
                    'driver' => Input::post('driver'),
					'van_no'=>Input::post('van_no'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminVanMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "VAN successfully inserted.");
                    return redirect('van');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('van-add');
                }
            }
        }
    }
    /*VAN Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['van_data'] = AdminVanMaster::editRecordById($id);
			$this->data['distributor'] = AdminDistributorMaster::distributorList();
        }
        return view('van_master/van_edit', $this->data);
    }
  /*VAN Update*/
    public function update(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customMessages = [
                'driver.required' => 'Please enter driver.',
            ];
            $rules = [
                'driver' => 'required',
				'van_no' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("van-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Van')
                                ->withInput();
            } else {
                $data_array = array(
                    'driver' => Input::post('driver'),
					'van_no'=>Input::post('van_no'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('van_no') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('van_no'),'mf_van_master', $field = 'slug', $key = NULL, $value = NULL);
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminVanMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Van updated successfully.');
                return redirect('/van');
            }
        }
    }
    /*Van Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminVanMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Van successfully deleted.");
                return redirect('van');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('van');
            }
        }
    }
   /*Van List Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $van = AdminVanMaster::vanList();
            $n =1;
            foreach($van as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($van)
                            ->addColumn('Action', function ($van) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="van-edit?id='.$van->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$van->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
                                return $action;
                            })
                            ->editColumn('driver', function ($van) {
                                $c_name = $van->driver;
                                return $c_name;
                            })
                            ->rawColumns(['driver','Action'])
                            ->make(true);
        }
    }
	
	
	
	
}

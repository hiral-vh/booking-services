<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Announcement;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AnnouncementController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
    /*announcement List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('announcement/announcement_list', $this->data);
    }
   /*announcement List Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('announcement/announcement_add', $this->data);
    }
   /*announcement Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'title' => 'required',
						'file_img'=>'mimes:jpeg,jpg,png,gif'
            ]);
            if ($validator->fails()) {
                return redirect("/announcement-add")
                                ->withErrors($validator, 'Announcement')
                                ->withInput();
            } else {
                 
				
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/announcement');
                    $image->move($destinationPath, $photo);
                }
                $data_array = array(
                   
                    'title' => Input::post('title'),
					'image' => $photo,
					'description'=>Input::post('description'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new Announcement($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Announcement successfully inserted.");
                    return redirect('announcement');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('announcement-add');
                }
            }
        }
    }
    /*announcement Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['announcement_data'] = Announcement::editRecordById($id);
        }
        return view('announcement/announcement_edit', $this->data);
    }
  /*announcement Update*/
    public function update(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customMessages = [
                'title.required' => 'Please enter title.',
            ];
            $rules = [
                'title' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("announcement-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Announcement')
                                ->withInput();
            } else {
				
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/announcement');
                    $image->move($destinationPath, $photo);
                }else{
                    $photo = Input::post('old_img');
                }
                $data_array = array(
                    'title' => Input::post('title'),
					'image' => $photo,
					'description'=>Input::post('description'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                $update = Announcement::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Announcement updated successfully.');
                return redirect('/announcement');
            }
        }
    }
    /*announcement Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = Announcement::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Announcement successfully deleted.");
                return redirect('announcement');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('announcement');
            }
        }
    }
   /*Employee List Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $announcement = Announcement::announcementList();
            $n =1;
            foreach($announcement as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($announcement)
                            ->addColumn('Action', function ($announcement) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="announcement-edit?id='.$announcement->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$announcement->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a> <a href="javascript:void(0);" onclick="openmodal('.$announcement->id.');" data-toggle="modal" data-target="#large-Modal"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
                                return $action;
                            })
                            ->editColumn('title', function ($announcement) {
                                $c_name = $announcement->title;
                                return $c_name;
                            })
							->editColumn('description', function ($announcement) {
                                $c_name = mb_strimwidth($announcement->description, 0, 30, "...");
                                return $c_name;
                            })
                            ->rawColumns(['title','description','Action'])
                            ->make(true);
        }
    }
	public function GetDescriptionAjax(Request $request) {
        $session = Session::get('event_login');
		 $product=Announcement::editRecordById($request->id);
		
		 echo $product->description;
		}
	
}

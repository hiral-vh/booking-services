<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class CmsController extends Controller
{
    public function rules () {
		return array_merge(
			[
                'description'    => 'required',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['module']='CMS '.'List ';
        $this->data['cms']=Cms::getCms();
        return view('admin.cms.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='CMS '.'Add ';
        return view('admin.cms.create',$this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('cms/create')->withErrors($validator,"admin")->withInput();
        }else{
            $createCms=([
                "title"=>$request->title,
                "description"=>$request->description,
                "created_at"=>now(),
                "created_by"=>Auth::guard('admin')->user()->id,
            ]);

            $cms=Cms::createCms($createCms);

            if($cms)
            {
                Session::flash('success', 'CMS '.trans('messages.createdSuccessfully'));
                return redirect('cms');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('cms');
            }
        }
    }

    public function edit($id)
    {
        $this->data['module']='CMS '.'Edit ';
        $this->data['cms']=Cms::findCms($id);
        return view('admin.cms.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateCms=([
                "description"=>$request->description,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('admin')->user()->id,
            ]);

            $cms=Cms::updateCms($id,$updateCms);

            if($cms)
            {
                Session::flash('success', 'CMS '.trans('messages.updatedSuccessfully'));
                return redirect()->route('cms.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }

    }

    public function destroy($id)
    {
        $cms=Cms::deleteCms($id);

        if($cms)
            {
                Session::flash('success', 'CMS '.trans('messages.deletedSuccessfully'));
                return redirect('cms');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('cms');
            }
    }

    public function updateCmsStatus(Request $request)
    {
            $cmsUpdateStatus = Cms::findCms($request->id);
            $st = $cmsUpdateStatus->status==1?0:1;
            $cmsUpdateStatus->update(["status"=>$st]);
            return $st;
    }
}

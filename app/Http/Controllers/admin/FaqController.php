<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class FaqController extends Controller
{
    public function rules () {
		return array_merge(
			[
                'question'     => 'required|max:100',
                'answer'  => 'required|max:200',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['module']='FAQ '.'List ';
        $this->data['faq']=Faq::getFaq();
        return view('admin.faq.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='FAQ '.'Add ';
        return view('admin.faq.create',$this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('faq/create')->withErrors($validator,"admin")->withInput();
        }else{
            $createFaq=([
                "question"=>$request->question,
                "answer"=>$request->answer,
                "created_at"=>now(),
                "created_by"=>Auth::guard('admin')->user()->id,
            ]);

            $faq=Faq::createFaq($createFaq);

            if($faq)
            {
                Session::flash('success', 'FAQ '.trans('messages.createdSuccessfully'));
                return redirect('faq');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('faq');
            }
        }
    }

    public function show()
    {

    }


    public function edit($id)
    {
        $this->data['module']='FAQ '.'Edit ';
        $this->data['faq']=Faq::findFaq($id);
        return view('admin.faq.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateFaq=([
                "question"=>$request->question,
                "answer"=>$request->answer,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('admin')->user()->id,
            ]);

            $faq=Faq::updateFaq($id,$updateFaq);

            if($faq)
            {
                Session::flash('success', 'FAQ '.trans('messages.updatedSuccessfully'));
                return redirect('faq');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('faq');
            }
        }

    }

    public function destroy(Request $request, $id)
    {
        $adminId=$request->deleted_by;
        $updateFaq=([
            "deleted_by"=>$adminId,
        ]);

        Faq::updateFaq($id,$updateFaq);
        $faq=Faq::deleteFaq($id);
        if($faq)
            {
                Session::flash('success', 'FAQ '.trans('messages.deletedSuccessfully'));
                return redirect('faq');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('faq');
            }
    }


    public function updateFAQToggle(Request $request)
    {
        $faqUpdateStatus = Faq::findFaq($request->id);
        $st = $faqUpdateStatus->status==1?0:1;
        $faqUpdateStatus->update(["status"=>$st]);
        return $st;
    }
}

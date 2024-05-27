<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EFFaq;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class EFoodFaqController extends Controller
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
        $this->data['module']='E-Food FAQ '.'List ';
        $this->data['faq']= EFFaq::getFaq();
        return view('admin.efood-faq.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='E-Food FAQ '.'Add ';
        return view('admin.efood-faq.create',$this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{
            $createFaq=([
                "faq_question"=>$request->question,
                "faq_answer"=>$request->answer,
            ]);

            $faq=EFFaq::createFaq($createFaq);

            if(isset($faq))
            {
                Session::flash('success', 'E-Food FAQ '.trans('messages.createdSuccessfully'));
                return redirect()->route('efood-faq.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function edit($id)
    {
        $this->data['module']='E-Food FAQ '.'Edit ';
        $this->data['faq']=EFFaq::findFaq($id);
        return view('admin.efood-faq.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateFaq=([
                "faq_question"=>$request->question,
                "faq_answer"=>$request->answer,
            ]);

            $faq=EFFaq::updateFaq($id,$updateFaq);

            if(isset($faq))
            {
                Session::flash('success', 'E-Food FAQ '.trans('messages.updatedSuccessfully'));
                return redirect()->route('efood-faq.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }

    }

    public function destroy(Request $request, $id)
    {

        $faq=EFFaq::deleteFaq($id);
        if($faq)
            {
                Session::flash('success', 'FAQ '.trans('messages.deletedSuccessfully'));
                return redirect()->route('efood-faq.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
    }

}

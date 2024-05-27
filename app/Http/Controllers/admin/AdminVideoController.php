<?php

namespace App\Http\Controllers\admin;

use App\Models\Notification;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessRecurringPaymentHistory;
use App\Models\FoodOwner;
use App\Models\SiteSetting;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Session;

class AdminVideoController extends Controller
{

    // use StripeWrapperTrait;

    // public $stripe 
    use ImageUploadTrait;

    public function rules()
    {
        return array_merge(
            [
                'title'     =>      'required',
                'description' =>  'required',
                'url' => 'required',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function index($type)
    {
        $this->data['type'] = $type;
        $this->data['module'] = "List Video";
        $this->data['list'] = Video::getVideoByType($type);
        return view('admin.admin-video.index', $this->data);
    }

    public function create($type)
    {
        $this->data['module'] = "Add Video";
        $this->data['type'] = $type;
        return view('admin.admin-video.create', $this->data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $createTutorial = array(
                "title" => $request->title,
                "description" => $request->description,
                "type" => $request->type,
            );

            $file_name = '';
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $file_name = $this->uploadFullUrlImage($file, '/assets/images/video/');
            }
            if ($file_name != '') {
                $createTutorial['video'] = $file_name;
            }
            $createTutorial['url'] = $request->url;

            $subscription = Video::createVideo($createTutorial);

            if ($subscription) {
                Session::flash('success', 'Video ' . trans('messages.createdSuccessfully'));
                return redirect()->route('admin-video-index', $request->type);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function edit($id, $type)
    {
        $this->data['module'] = "Edit Video";
        $this->data['type'] = $type;
        $this->data['video'] = Video::findVideo($id);
        return view('admin.admin-video.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $updateVideo = array(
                "title" => $request->title,
                "description" => $request->description,
                "type" => $request->type,
            );

            $file_name = '';
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $file_name = $this->uploadImage($file, 'assets/images/video/');
            }
            if ($file_name != '') {
                $updateVideo['video'] = $file_name;
            }
            $updateVideo['url'] = $request->url;


            $video = Video::updateVideo($id, $updateVideo);

            if ($video) {
                Session::flash('success', 'Video ' . trans('messages.updatedSuccessfully'));
                return redirect()->route('admin-video-index', $request->type);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function destroy($id, Request $request)
    {
        $video = Video::deleteVideo($id);
        if ($video) {
            Session::flash('success', 'Video ' . trans('messages.deletedSuccessfully'));
            return redirect()->back();
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetting;
use App\Models\Business;
use App\Models\BusinessWeekSchedule;

use Illuminate\Support\Facades\Session;

class BusinessSettingsController extends Controller{

    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }
    public function index()
    {
        $user=Auth::guard('business_user')->user();
        
        $data['days'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        $dayArr=[];
       
            $bussinessDay = BusinessWeekSchedule::where('business_id',$user->id)->get();
            if(count($bussinessDay))
            {
               
                foreach($bussinessDay as $tt)
                {
                    $dayArr[$tt->day][]=$tt;
                }
            }
        $data['dayArr'] = $dayArr;
        $data['time'] = Business::getDetailsById($user->id);

        $data['module']='Settings';
        return view('business.business-settings.index',$data);
    }
    
    public function store(Request $request)
    {
        $input['business_id'] = $request->businessId;
        $input['day'] = $request->day;
        $input['open_time'] = $request->open_time;
        $input['close_time'] = $request->close_time;
       
        $input['created_at'] = now();
        
        // BusinessWeekSchedule::where('business_id',$request->businessId)->delete();
        // $insert = BusinessWeekSchedule::create($input);


        $insert = BusinessWeekSchedule::updateOrCreate(
            [
               'business_id'   => $request->businessId,
               'day'   => $request->day,
            ],
            [
                'open_time'     => date("H:i:s",strtotime($request->open_time)),
                'close_time'     => date("H:i:s",strtotime($request->close_time)),
                'created_at' => now()
            ],
        );

        if($insert)
        {
           // return response()->json(['status'=>1,'data'=>$insert]);
            Session::flash('success', 'Business WeekDay  ' . trans('messages.updatedSuccessfully'));
            return redirect()->back();
        }
        else{
            //return response()->json(['status'=>0]);
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}



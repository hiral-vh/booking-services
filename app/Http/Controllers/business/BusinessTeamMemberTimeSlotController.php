<?php

namespace App\Http\Controllers\business;


use Validator;
use DatePeriod;
use DateInterval;
use App\Models\Business;
use Carbon\CarbonInterval;
use App\Models\SiteSetting;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Session;
use App\Models\BusinessTeamMemberTimeSlot;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class BusinessTeamMemberTimeSlotController extends Controller
{
    use ImageUploadTrait;

    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }
    public function getTimeSlotDetails(Request $request)
    {
        $current = $request->start_time;
        $last = $request->end_time;
        $duration = $request->duration;
        $getSlots = $this->getTimeSlot($duration,$current,$last);

        return $getSlots;
    }
    public function index($teamMemberId)
    {
        $user=Auth::guard('business_user')->user();
        $this->data['teamMemberId']=$teamMemberId;
        $this->data['business']=Business::findBusiness($user->business_id);
        $this->data['businessTeamMemberTimeSlot']=BusinessTeamMemberTimeSlot::listdataByBussinessIdAndTeamMemberId($user->business_id,$teamMemberId);
        $this->data['module'] = 'Team Member Time Slot List';
        $this->data['timeSlots'] = $timeSlots =  BusinessTeamMemberTimeSlot::getTeamMemberTimeSlots($teamMemberId);
        
        $getTeamSlots = array();
        $weekData = array();
        foreach($timeSlots as $data)
        {
            $getTeamSlots[] = $this->getTimeSlot($data->duration,$data->team_start_time,$data->team_end_time);
            $weekData[] = $data->day.'-'.date('H:i',strtotime($data->start_time)).'-'.date('H:i',strtotime($data->end_time));
        }


        $this->data['weekData'] = $weekData;
        $this->data['slots'] = $getTeamSlots;
      
        return view('business.team-member-time-slot.index', $this->data);
    }
    public function getTimeSlot($interval, $start_time, $end_time)
    {
      
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i=0;
        $time = [];
        $weekArray = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        $mainArray = array();
        while(strtotime($startTime) <= strtotime($endTime)){
            $start = $startTime;
            $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $i++;
            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$i]['slot_start_time'] = $start;
                $time[$i]['slot_end_time'] = $end;
            }
        }

        $newArray = array();
        foreach($time as $tkey){
            $mainArray = array();
            foreach($weekArray as $weekname){
                $tkey['day'] = $weekname;
                $mainArray[] = $tkey;
            }
            $newArray[] = $mainArray;
        }

        return array('days'=>$weekArray,'weekData'=>$newArray);
        
    }
    public function store(Request $request)
    {
      
        $business_id = $request->business_id;
        $business_team_member_id = $request->business_team_member_id;
        $duration = $request->duration;
        $timeSlots = $request->timeSlots;
        $team_start_time = $request->team_start_time;
        $team_end_time = $request->team_end_time;

        BusinessTeamMemberTimeSlot::where('business_team_member_id',$request->business_team_member_id)->delete();
       
        if ($timeSlots) {
            foreach($timeSlots as $key=>$trow){
                $times = explode("-",$trow);
                $insertArray = array(
                                    'day'=>$times[0],
                                    'start_time'=>$times[1],
                                    'end_time'=>$times[2],
                                    'business_team_member_id'=>$business_team_member_id,
                                    'business_id'=>$business_id,
                                    'duration'=>$duration,
                                    'team_start_time'=> $team_start_time,
                                    'team_end_time'=>$team_end_time,
                                    'created_at'=>now()
                                );
                                BusinessTeamMemberTimeSlot::create($insertArray);
            }
        }
    
        Session::flash('success', 'Team Member Time Slot ' . trans('messages.updatedSuccessfully'));
        return redirect()->back();
        
    }
   

    
}

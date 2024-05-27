<?php

namespace App\Http\Controllers\business;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\TimeSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BusinessTimeSlotsController extends Controller
{
    public function store(Request $request)
    {

        $input = $request->all();

        $input["created_at"] = now();
        $input["created_by"] = Auth::guard('business_user')->user()->id;
        $checkbox = $request->input('checkbox');

        if (!empty($checkbox)) {
            $getTeamMemberTime = TimeSlots::where('business_id', $request->business_id)->where('team_member_id', $request->team_member_id)->delete();
            for ($i = 0; $i < count($checkbox); $i++) {

                $input['timeslots'] = $checkbox[$i];

                $times = TimeSlots::create($input);
            }
        }


        if ($times) {
            Session::flash('success', 'Business Team Member' . trans('messages.createdSuccessfully'));
            return redirect('/business-team-members');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('/business-team-members');
        }
    }
    public function checkedTeamMemberTime(Request $request)
    {
        $business_id = $request->id;
        $team_member_id = $request->tid;
        $getTimeSlots = TimeSlots::getTimeslotsByTeamId($business_id, $team_member_id);

        return response()->json($getTimeSlots);
    }
}

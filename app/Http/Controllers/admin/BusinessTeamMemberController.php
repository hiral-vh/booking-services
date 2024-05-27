<?php

namespace App\Http\Controllers\admin;

use Validator;
use App\Models\Business;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessTeamMember;
use App\Models\TeamMembers;
use App\Models\TimeSlots;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BusinessTeamMemberController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'team_member' => 'required',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function BusinessTeamMembersIndex($id)
    {
        $this->data['business'] = Business::findBusiness($id);
        $this->data['module'] = ucfirst($this->data['business']->name) . ' Team Members List ';
        $this->data['teamMembers'] = TeamMembers::getTeamMembersList();
        $this->data['businessTeamMembers'] = BusinessTeamMember::getBusinessTeamMembers($id);

        return view('admin.business-team-member.index', $this->data);
    }

    public function BusinessTeamMembersStore(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $checkTeam = BusinessTeamMember::checkTeamMemberRecordExist($request->team_member, $request->business_id);
            if ($checkTeam) {
                Session::flash('error', ' Team member already exist ');
                return redirect('business/team-member/' . $request->business_id);
            }

            $createTeamMember = ([
                "business_id" => $request->business_id,
                "team_member_id" => $request->team_member,
                "created_at" => now(),
                "created_by" => Auth::guard('admin')->user()->id,
            ]);

            $create = BusinessTeamMember::createBusinessTeamMembers($createTeamMember);

            if ($create) {
                Session::flash('success', 'Business Team Member' . trans('messages.createdSuccessfully'));
                return redirect('business/team-member/' . $request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/team-member/' . $request->business_id);
            }
        }
    }


    public function BusinessTeamMemberUpdate(Request $request)
    {
        $checkTeam = BusinessTeamMember::checkTeamMemberRecordExist($request->edit_team_member, $request->edit_business_id);

        $updateTeamMember = ([
            "team_member_id" => $request->edit_team_member,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
        ]);

        if (!empty($checkTeam)) {
            if ($request->previous_team_member_id == $checkTeam->team_member_id) {
                $update = BusinessTeamMember::updateBusinessTeamMember($request->business_team_member_id, $updateTeamMember);
            } elseif ($request->previous_team_member_id != $checkTeam->team_member_id) {
                Session::flash('error', ' Team member already exist ');
                return redirect('business/team-member/' . $request->edit_business_id);
            }
        } else {
            $update = BusinessTeamMember::updateBusinessTeamMember($request->business_team_member_id, $updateTeamMember);
        }

        if ($update) {
            Session::flash('success', 'Business Team Member ' . trans('messages.updatedSuccessfully'));
            return redirect('business/team-member/' . $request->edit_business_id);
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business/team-member/' . $request->edit_business_id);
        }
    }

    public function BusinessTeamMemberDelete(Request $request, $id)
    {

        $deleteArray = ([
            "deleted_by" => Auth::guard('admin')->user()->id,
            "deleted_by_user_type" => 1,
        ]);
        BusinessTeamMember::updateBusinessTeamMember($id, $deleteArray);

        $teamMember = BusinessTeamMember::deleteBusinessTeamMember($id);
        if ($teamMember) {
            Session::flash('success', 'Business Team Member ' . trans('messages.deletedSuccessfully'));
            return redirect('business/team-member/' . $request->business_id);
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business/team-member/' . $request->business_id);
        }
    }

    public function updateBusinessTeamMemberStatus(Request $request)
    {
        $businessTeamMemberUpdateStatus = BusinessTeamMember::findBusinessTeamMember($request->id);
        $st = $businessTeamMemberUpdateStatus->status == 1 ? 0 : 1;
        $businessTeamMemberUpdateStatus->update(["status" => $st]);
        return $st;
    }
    public function insertTime(Request $request)
    {

        $input = $request->all();

        $input["created_at"] = now();
        $input["created_by"] = Auth::guard('admin')->user()->id;
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
            return redirect('business/team-member/' . $request->business_id);
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business/team-member/' . $request->business_id);
        }
    }
    public function checkedTime(Request $request)
    {
        $business_id = $request->id;
        $team_member_id = $request->tid;
        $getTimeSlots = TimeSlots::getTimeslotsByTeamId($business_id, $team_member_id);

        return response()->json($getTimeSlots);
    }
    public function teamMemberCheckEmail(Request $request)
    {
        $check=BusinessTeamMember::checkEmail($request->email);

        if(!empty($check))
        {
            return response()->json(1);
        }
        else
        {
            return response()->json(0);
        }
    }
    public function teamMemberCheckMobile(Request $request)
    {
        $check=BusinessTeamMember::checkMobile($request->mobile);

        if(!empty($check))
        {
            return response()->json(1);
        }
        else
        {
            return response()->json(0);
        }
    }
}

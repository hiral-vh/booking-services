<?php

namespace App\Http\Controllers\business;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TeamMembers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class BusinessUserTeamMembersController extends Controller
{
    public function rules () {
		return array_merge(
			[
                'name'     => 'required|max:255',
				'charge'   => 'required',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['teammembers']=TeamMembers::getTeamMembers();
        $this->data['module']='Team Members '.'List ';
        return view('business.team-members.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='Team Members '.'Add ';
        return view('business.team-members.create',$this->data);
    }

    public function store(Request $request)
    {
        $createTeamMember=([
            "name"=>$request->name,
            "charge"=>$request->charge,
            "created_at"=>now(),
            "created_by"=>Auth::guard('web')->user()->id,
            "created_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business-user-team-member/create')->withErrors($validator,"admin")->withInput();
        }else{

            $teamMember=TeamMembers::createTeamMember($createTeamMember);

            if($teamMember)
            {
                Session::flash('success', 'Team Member '.trans('messages.createdSuccessfully'));
                return redirect('business-user-team-member');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-team-member');
            }
        }
    }

    public function show(Admin $admin)
    {

    }


    public function edit($id)
    {
        $this->data['module']='Team Members '.'Edit ';
        $this->data['teamMember']=TeamMembers::findTeamMember($id);
        return view('business.team-members.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $updateTeamMember=([
            "name"=>$request->name,
            "charge"=>$request->charge,
            "updated_at"=>now(),
            "updated_by"=>Auth::guard('web')->user()->id,
            "updated_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $teamMember=TeamMembers::updateTeamMember($id,$updateTeamMember);

            if($teamMember)
            {
                Session::flash('success', 'Team Member '.trans('messages.updatedSuccessfully'));
                return redirect('business-user-team-member');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-team-member');
            }
        }
    }

    public function destroy($id)
    {
        $deleteArray=([
            "deleted_by"=>Auth::guard('web')->user()->id,
            "deleted_by_user_type"=>2,
        ]);

        TeamMembers::updateTeamMember($id,$deleteArray);

        $teamMember=TeamMembers::deleteTeamMember($id);

        if($teamMember)
            {
                Session::flash('success', 'Team Member '.trans('messages.deletedSuccessfully'));
                return redirect('business-user-team-member');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-team-member');
            }
    }

    public function updateTeamMemberStatus(Request $request)
    {
            $teamMemberUpdateStatus = TeamMembers::findTeamMember($request->id);
            $st = $teamMemberUpdateStatus->status==1?0:1;
            $teamMemberUpdateStatus->update(["status"=>$st]);
            return $st;
    }
}

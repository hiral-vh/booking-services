<?php

namespace App\Http\Controllers\business;

use Illuminate\Support\Facades\Validator;
use App\Models\Business;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessTeamMember;
use App\Models\TeamMembers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BusinessUserBusinessTeamMemberController extends Controller
{
    public function rules() {
		return array_merge(
			[
                'team_member' => 'required|max:30',
                'phone_no' => 'required|numeric',
                'email' => 'required|email|max:100',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['business']=Business::findBusiness($user->business->id);
        $this->data['listBusinessTeamMembers']=BusinessTeamMember::listBusinessTeamMembers($this->data['business']->id);
        $this->data['module']='Team Members List';
        $this->data['teamMember']=$request->team_member;
        $this->data['email']=$request->email;
        $this->data['phone']=$request->phone;

        if(empty($request->email) && empty($request->phone) && empty($request->team_member))
        {
            $this->data['businessTeamMembers']=BusinessTeamMember::getBusinessTeamMembers($this->data['business']->id);
        }else{
            $this->data['businessTeamMembers']=BusinessTeamMember::getBusinessTeamMembersByFilter($this->data['business']->id,$request->team_member,$request->email,$request->phone);
        }
        return view('business.businesses-team-members.index',$this->data);
    }

    public function create(Request $request)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['business']=Business::findBusiness($user->business->id);
        $this->data['module']='Team Members Add ';
        return view('business.businesses-team-members.create',$this->data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $checkTeam = BusinessTeamMember::checkTeamMemberRecordExist($request->team_member,$request->business_id,$request->email);

            if($checkTeam){
                Session::flash('error', ' Team member already exist ');
                return redirect('business-team-members');
            }

            $createTeamMember=([
                "business_id"=>$request->business_id,
                "name"=>$request->team_member,
                "phone_no"=>$request->phone_no,
                "email"=>$request->email,
              //  "price"=>$request->price,
                "created_at"=>now(),
                "created_by"=>Auth::guard('business_user')->user()->id,
            ]);

            $create=BusinessTeamMember::createBusinessTeamMembers($createTeamMember);

            if($create)
            {
                Session::flash('success', 'Business Team Member '.trans('messages.createdSuccessfully'));
                return redirect('business-team-members');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-team-members');
            }
        }
    }

    public function edit($id)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['business']=Business::findBusiness($user->business->id);
        $this->data['module']='Team Members Edit ';
        $this->data['businessTeamMembers']=BusinessTeamMember::findBusinessTeamMember($id);
        return view('business.businesses-team-members.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $checkTeam = BusinessTeamMember::checkTeamMemberRecordExistEdit($request->team_member,$request->business_id,$id,$request->email);

            $updateTeamMember=([
                "name"=>$request->team_member,
                "phone_no"=>$request->phone_no,
                "email"=>$request->email,
               // "price"=>$request->price,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('business_user')->user()->id,
            ]);
            if(!empty($checkTeam))
            {
                if($request->team_member != $checkTeam->name)
                {
                    $update=BusinessTeamMember::updateBusinessTeamMember($id,$updateTeamMember);

                }
                elseif($request->team_member == $checkTeam->name){
                    Session::flash('error', ' Team member already exist ');
                    return redirect('business-team-members');
                }
            }else
            {
                $update=BusinessTeamMember::updateBusinessTeamMember($id,$updateTeamMember);
            }

            if($update)
            {
                Session::flash('success', 'Business Team Member '.trans('messages.updatedSuccessfully'));
                return redirect('business-team-members');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-team-members');
            }
        }
    }

    public function destroy(Request $request,$id)
    {

        $deleteArray=([
            "deleted_by"=>Auth::guard('business_user')->user()->id,
        ]);
        BusinessTeamMember::updateBusinessTeamMember($id,$deleteArray);

        $teamMember=BusinessTeamMember::deleteBusinessTeamMember($id);
        if($teamMember)
        {
            Session::flash('success', 'Business Team Member '.trans('messages.deletedSuccessfully'));
            return redirect('business-team-members');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-team-members');
        }
    }

    public function updateBusinessTeamMemberStatus(Request $request)
    {
            $businessTeamMemberUpdateStatus = BusinessTeamMember::findBusinessTeamMember($request->id);
            $st = $businessTeamMemberUpdateStatus->status==1?0:1;
            $businessTeamMemberUpdateStatus->update(["status"=>$st]);
            return $st;
    }

}

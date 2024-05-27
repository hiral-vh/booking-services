<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ImageUploadTrait;
use App\Models\Admin;
use App\Models\SiteSetting;
use App\Http\Traits\ENVTrait;
use Validator;

class ProfileController extends Controller
{
    use ImageUploadTrait;
    use ENVTrait;

    public function rules($id = 0)
    {
        return array_merge(
            [
                'name'          => 'required|max:255',
                'email'         => 'required|email|unique:admins,email' . ($id ? ",$id,id" : ''),
                'public_key'    => 'required',
                'secret_key'    => 'required',
            ],
        );
    }

    public function List()
    {
        $data['admin'] = Auth::guard('admin')->user();
        $data['sitesetting'] = SiteSetting::getSiteSettings();
        $data['module'] = 'Admin Profile ' . 'Details ';
        return view('admin.admin-profile', $data);
    }

    public function update(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;

        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
            return redirect('admin-profile')->withErrors($validator, "admin")->withInput();
        } else {

            \Stripe\Stripe::setApiKey($request->secret_key);
            $updatedata = '';
            try {
                // create a test customer to see if the provided secret key is valid
                $updatedata = \Stripe\Customer::create(["description" => "Test Customer - Validate Secret Key"]);

            } catch (\Exception $e) {
                Session::flash('error', 'Invalid secret key provided');
                return redirect()->back();
            }

            $updatedata = array(
                'name' => $request->name,
                'email' => $request->email,
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
                'updated_at' => now(),
                'updated_by' => $id,
            );

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = $this->uploadImage($file, 'assets/images/admin/');
            }

            if ($file_name != '') {
                $updatedata['profile_image'] = $file_name;
            }

            $this->setEnv('STRIPE_KEY',$request->public_key);
            $this->setEnv('STRIPE_SECRET',$request->secret_key);


            $update = Admin::updateAdminProfile($id, $updatedata);

            if ($update) {
                Session::flash('success', 'Admin Profile ' . trans('messages.updatedSuccessfully'));
                return redirect()->back();
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }
}

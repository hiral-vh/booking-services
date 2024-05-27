<?php

namespace App\Http\Controllers\admin;

use Validator;
use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\BusinessOffer;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUploadTrait;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BusinessOfferController extends Controller
{
    use ImageUploadTrait;

    public function rules () {
		return array_merge(
			[
                'name'          => 'required|string|max:255',
                'price'         => 'required|numeric',
                'image'         => 'required|mimes:jpeg,jpg,png,svg',
                'coupon_code'   => 'required|max:255',
                'valid_till'    => 'required|max:255'
			],
        );
	}
    public function rules1 () {
		return array_merge(
			[
                'name'          => 'required|string|max:255',
                'price'         => 'required|numeric',
                'image'         => 'mimes:jpeg,jpg,png,svg',
                'coupon_code'   => 'required|max:255',
                'valid_till'    => 'required|max:255'
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index($id)
    {
        $this->data['business']=Business::findBusiness($id);
        $this->data['module']=ucfirst($this->data['business']->name)." Offer List";
        $this->data['businessOffer']=BusinessOffer::getBusinessOffer($id);
        return view('admin.business-offer.index',$this->data);
    }

    public function create($id)
    {
        $this->data['business']=Business::findBusiness($id);
        $this->data['module']=ucfirst($this->data['business']->name)." Offer Add";
        return view('admin.business-offer.create',$this->data);
    }

    public function store(Request $request)
    {
        $validTillFormated=date('Y-m-d',strtotime($request->valid_till));

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business/offer/create/'.$request->business_id)->withErrors($validator,"admin")->withInput();
        }else{
            $createBusinessOffer=([
                "business_id"=>$request->business_id,
                "name"=>$request->name,
                "price"=>$request->price,
                "coupon_code"=>$request->coupon_code,
                "valid_till"=>$validTillFormated,
                "created_at"=>now(),
                "created_by"=>Auth::guard('admin')->user()->id,
                "created_by_user_type"=>1,
            ]);

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadImage($file,'assets/images/business/');
            }

            if($file_name != ''){
                $createBusinessOffer['image'] = $file_name;
            }

             $businessOffer= BusinessOffer::createBusinessOffer($createBusinessOffer);

            if($businessOffer)
            {
                Session::flash('success', 'Offer '.trans('messages.createdSuccessfully'));
                return redirect('business/offer/'.$request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/offer/'.$request->business_id);
            }
         }
    }

    public function getCouponCode(Request $request)
    {
        $couponCode=BusinessOffer::couponCodeList($request->coupon_code);
        if($couponCode)
        {
            return response()->json(['message'=>'exist']);
        }
        else
        {
            return response()->json(['message'=>'not']);
        }
    }

    public function updateOfferToggle(Request $request)
    {
        $offerUpdateStatus = BusinessOffer::findOffer($request->id);
        $st = $offerUpdateStatus->status==1?0:1;
        $offerUpdateStatus->update(["status"=>$st]);
        return $st;
    }


    public function edit($id)
    {
        $this->data['businessOffer']=BusinessOffer::findOffer($id);
        $this->data['business']=Business::findBusiness($this->data['businessOffer']->business_id);
        $this->data['module']=$this->data['business']->name." Offer Edit";
        return view('admin.business-offer.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validTillFormated=date('Y-m-d',strtotime($request->valid_till));

        $validator = Validator::make($request->all(),$this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateBusinessOffer=([
                "name"=>$request->name,
                "price"=>$request->price,
                "coupon_code"=>$request->coupon_code,
                "valid_till"=>$validTillFormated,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('admin')->user()->id,
                "updated_by_user_type"=>1,
            ]);

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadImage($file,'assets/images/business/');
            }

            if($file_name != ''){
                $updateBusinessOffer['image'] = $file_name;
            }

            $update=BusinessOffer::updateOffer($id,$updateBusinessOffer);


            if($update)
            {
                Session::flash('success', 'Offer '.trans('messages.updatedSuccessfully'));
                return redirect('business/offer/'.$request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/offer/'.$request->business_id);
            }
        }
    }

    public function destroy(Request $request,$id)
    {
        $deleteArray=([
            "deleted_by"=>Auth::guard('admin')->user()->id,
            "deleted_by_user_type"=>1,
        ]);

        BusinessOffer::updateOffer($id,$deleteArray);

        $offer=BusinessOffer::deleteOffer($id);

        if($offer)
            {
                Session::flash('success', 'Offer '.trans('messages.deletedSuccessfully'));
                return redirect('business/offer/'.$request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/offer/'.$request->business_id);
            }
    }

}

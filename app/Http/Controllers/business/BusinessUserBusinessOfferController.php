<?php

namespace App\Http\Controllers\business;

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

class BusinessUserBusinessOfferController extends Controller
{
    use ImageUploadTrait;
    public function rules () {
        return array_merge(
			[
                'name'          => 'required|regex:/^[a-zA-Z0-9_ \s-]+$/|max:30',
                'image'         => 'required|mimes:jpg,jpeg,png,bmp,svg',
                'price'         => 'required|numeric',
                'discount'      => 'required|numeric',
                'image'         => 'required|mimes:jpeg,jpg,png,svg',
                'coupon_code'   => 'required|max:50',
                'valid_till'    => 'required|date_format:Y-m-d|after:yesterday',
			],
        );
	}
    public function rules1 () {
		return array_merge(
			[
                'name'          => 'required|string|max:30',
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

    public function index(Request $request)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['business']=Business::findBusiness($user->business->id);
        $this->data['module']="Offers List";
        $this->data['name']=$request->name;
        $this->data['price']=$request->price;
        $this->data['discount']=$request->discount;
        $this->data['couponCode']=$request->coupon_code;

        if(empty($request->name) && empty($request->price) && empty($request->discount) && empty($request->coupon_code)){
            $this->data['businessOffer']=BusinessOffer::getBusinessOffer($this->data['business']->id);
        }else{
            $this->data['businessOffer']=BusinessOffer::getBusinessOfferBySearch($this->data['business']->id,$request->name,$request->price,$request->discount,$request->coupon_code);
        }

        return view('business.businesses-offers.index',$this->data);
    }

    public function create()
    {
        $user=auth()->guard('business_user')->user();
        $this->data['business']=Business::findBusiness($user->business->id);
        $this->data['module']=ucfirst($this->data['business']->name)." Offer Add";
        return view('business.businesses-offers.create',$this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{
            $validTillFormated=date('Y-m-d',strtotime($request->valid_till));

            $createBusinessOffer=([
                "business_id"=>$request->business_id,
                "name"=>$request->name,
                "type"=>$request->type,
                "price"=>$request->price,
                "discount"=>$request->discount,
                "coupon_code"=>$request->coupon_code,
                "valid_till"=>$validTillFormated,
                "created_at"=>now(),
                "created_by"=>Auth::guard('business_user')->user()->id,
                "created_by_user_type"=>2,
            ]);

            $file_name = '';
                if ($request->hasFile('image')) {
                    $file_name=$this->uploadImage($request->image,'business/images/business-offer/');
                }

                if($file_name != ''){
                    $createBusinessOffer['image'] = $file_name;
                }

             $businessOffer= BusinessOffer::createBusinessOffer($createBusinessOffer);

            if($businessOffer)
            {
                Session::flash('success', 'Offer '.trans('messages.createdSuccessfully'));
                return redirect('business-user-offers');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-offers');
            }
         }
    }

    public function getCouponCode(Request $request)
    {
        $couponCode=BusinessOffer::couponCodeList($request->coupon_code,$request->id);
        if(!empty($couponCode))
        {
            return response()->json([1]);
        }
        else
        {
            return response()->json([0]);
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
        $this->data['business']=Business::findBusiness($this->data['businessOffer']->business->id);
        $this->data['module']=$this->data['business']->name." Offer Edit";
        return view('business.businesses-offers.edit',$this->data);
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
                "discount"=>$request->discount,
                "type"=>$request->type,
                "coupon_code"=>$request->coupon_code,
                "valid_till"=>$validTillFormated,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('business_user')->user()->id,
                "updated_by_user_type"=>2,
            ]);

            $file_name='';
            if ($request->hasFile('image') ) {
                $file_name=$this->uploadImage($request->image,'business/images/business-offer/');
            }

            if($file_name != ''){
                $updateBusinessOffer['image'] = $file_name;
            }

            $update=BusinessOffer::updateOffer($id,$updateBusinessOffer);


            if($update)
            {
                Session::flash('success', 'Offer '.trans('messages.updatedSuccessfully'));
                return redirect('business-user-offers');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-offers');
            }
        }
    }

    public function destroy(Request $request,$id)
    {
        $deleteArray=([
            "deleted_by"=>Auth::guard('business_user')->user()->id,
            "deleted_by_user_type"=>2,
        ]);

        BusinessOffer::updateOffer($id,$deleteArray);

        $offer=BusinessOffer::deleteOffer($id);

        if($offer)
            {
                Session::flash('success', 'Offer '.trans('messages.deletedSuccessfully'));
                return redirect('business-user-offers');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-offers');
            }
    }

}

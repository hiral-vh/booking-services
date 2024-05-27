<?php



namespace App\Http\Controllers\admin;



use Validator;

use App\Models\SiteSetting;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Subscription;

use Illuminate\Support\Facades\Session;

use App\Helpers\Payments\Stripe\StripeWrapper;

use Stripe;



class AdminSubscriptionController extends Controller

{



    // use StripeWrapperTrait;



    // public $stripe



    public function rules()

    {

        return array_merge(

            [

                'plan_name'     =>  'required|string|max:255',

                'description'   =>  'required|max:300',

                'allowed_order' =>  'required|numeric',

                'price'         =>  'required|numeric',

            ],

        );

    }

    public function __construct()

    {

        $this->data['sitesetting'] = SiteSetting::getSiteSettings();

    }



    public function index($type)

    {

        $this->data['type']=$type;

        $this->data['module']="List Subscription";

        $this->data['subscription']=Subscription::getSubscriptionByType($type);

        return view('admin.subscription.index',$this->data);

    }



    public function create($type)

    {

        $this->data['module']="Add Subscription";

        $this->data['type']=$type;

        return view('admin.subscription.create',$this->data);

    }



    public function store(Request $request)

    {

     

        $validator = Validator::make($request->all(),$this->rules());



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator,"admin")->withInput();

        }else{

            $createSubscription=array(

                "plan_name"=>$request->plan_name,

                "plan_description"=>$request->description,

                "plan_duration"=>1,

                "allowed_order"=>$request->allowed_order,

                "plan_price"=>$request->price,

                "type"=>$request->type,

            );



            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));



            $stripeProduct=$stripe->products->create([

                'name' => $request->plan_name,

            ]);



            $stripePlan=$stripe->plans->create([

                'amount' => $request->price * 100,

                'currency' => 'gbp',

                'interval' => 'month',

                'product' => $stripeProduct->id,

            ]);



            $createSubscription['stripe_plan_id']=$stripePlan->id;

            $createSubscription['stripe_product_id']=$stripeProduct->id;



            $subscription=Subscription::createSubscription($createSubscription);



            if($subscription)

            {

                Session::flash('success', 'Subscription '.trans('messages.createdSuccessfully'));

                return redirect()->route('admin-subscription-index',$request->type);

            } else {

                Session::flash('error', trans('messages.errormsg'));

                return redirect()->back();

            }

        }



    }



    public function edit($id,$type)

    {

        $this->data['module']="Edit Subscription";

        $this->data['type']=$type;

        $this->data['subscription']=Subscription::findSubscription($id);

        return view('admin.subscription.edit',$this->data);

    }



    public function update(Request $request,$id)

    {

        $validator = Validator::make($request->all(),$this->rules());



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator,"admin")->withInput();

        }else{



            $updateSubscription=array(

                "plan_name"=>$request->plan_name,

                "plan_description"=>$request->description,

                "allowed_order"=>$request->allowed_order,

                "plan_price"=>$request->price,

                "type"=>$request->type,

            );



            $subscription=Subscription::updateSubscription($id,$updateSubscription);



            if($subscription)

            {

                Session::flash('success', 'Subscription '.trans('messages.updatedSuccessfully'));

                return redirect()->route('admin-subscription-index',$request->type);

            } else {

                Session::flash('error', trans('messages.errormsg'));

                return redirect()->back();

            }

        }

    }



    public function destroy($id,Request $request)

    {

        $subscription=Subscription::deleteSubscription($id);

        if($subscription)

        {

            Session::flash('success', 'Subscription '.trans('messages.deletedSuccessfully'));

            return redirect()->route('admin-subscription-index',$request->type);

        } else {

            Session::flash('error', trans('messages.errormsg'));

            return redirect()->back();

        }

    }



}


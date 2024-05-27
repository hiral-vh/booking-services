<?php
namespace App\Http\Traits;
use App\Models\Business;
use App\Models\Subcription;
use App\Models\BusinessPayment;
use Stripe\Stripe;
use App\Models\SiteSetting;


trait StripeFunctionsTrait{
    public function addStripeCustomer($Businessid,$businessPackageId){
        $businessStripe = Business::where('id', $Businessid);
        if($businessStripe->count())
        {
            $businessStripe = $businessStripe->first();
            if($businessStripe->stripe_customer_id)
                return $businessPackageId;
        }
        $business = Business::find($Businessid);
        
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        
        $customer = $stripe->customers->create([
            'description' => $business->restaurant_name,
            'email' => $business->email,
        ]);
        if($customer->object = 'customer')
        {
            $businessPackage = Subcription::find($businessPackageId);
            $data = array();
            $data['stripe_customer_id'] = $customer->id;
            $data['stripe_invoice_prefix'] = $customer->invoice_prefix;
            //$data['stripe_subscription_id'] = $businessPackage->stripe_plan_id;
            
            $businessStripe = Business::where('id',$Businessid)->update($data);
            return $businessPackageId;
        }
        else
            return false;
    }
    public function CreateBusinessPaymentSession($businessId, $businessStripeId){
        $business = Business::find($businessId);
        $businessStripe = Subcription::find($businessStripeId);

        $insertArray = array(
            'plan_id' => $businessStripeId,
            'business_id' => $businessId,
            'payment_type' => 'subscription',
            'created_at' => date('Y-m-d H:i:s')
        );
        $insert = new BusinessPayment($insertArray);
        $insert->save();
        $payment = $insert->id;
        Stripe::setApiKey(env('STRIPE_SECRET'));
        
            $session =  \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $businessStripe->stripe_plan_id,
                    'quantity' => 1,
                ]],
                'metadata'=>[
                    'business_id' => $business->id,
                    'business_stripe_id' => $businessStripeId
                ],
                'mode' => 'subscription',
                'success_url' => route('paymentSuccess', $payment),
                'cancel_url' => route('paymentFailed',$payment),
             ]);

        
        $udpate = BusinessPayment::where('id', $payment)->update(array('payment_request_id' => $session->id));
        return $session->id;
    }

    public function topAmountCustomer($resturentid,$paymentid){
        
        $userData = Business::find($resturentid); 
        $stripePaymentData = BusinessPayment::find($paymentid);
        
        $getTopupAmount = SiteSetting::getSiteSettings();
        $topupAmount =0;
        if($getTopupAmount->top_up_amount !=''){
            $topupAmount = $getTopupAmount->top_up_amount;
        }
        $totalAmount = $stripePaymentData->total_appointment * $topupAmount;
        Stripe::setApiKey('sk_test_51Hf1hEDhoJZw9YjJFxcUePY0oFP5OcE2o5S1JkBWdrdwJc0fq5NeFSf2zfum6GMg6YvVzVPnVJRTem9ROD8HFr0A00PKJasxnA');
        $session =  \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'GBP',
                    'product_data' => [
                        'name' => 'Payment for Topup of extra order ' . $stripePaymentData->total_appointment . ' to total days' . $stripePaymentData->total_days,
                    ],
                    'unit_amount' => $totalAmount * 100,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'First Name' => $userData->name,
                'Contact' => $userData->contact,
                'Email' => $userData->email,
            ],
            'mode' => 'payment',
            'success_url' => route('paymentSuccessTopup', [$paymentid]),
            'cancel_url' => route('paymentFailedTopup', [$paymentid]),
        ]);
        $udpate = BusinessPayment::where('id', $paymentid)->update(array('payment_request_id' => $session->id));
        return $session->id;
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
class PaymentController extends Controller
{
    public function index()
    {
        return view('/payment');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        
        $api = new Api(env('RAZORPAY_KEY') , env('RAZORPAY_SECRET'));

        $api->plan->create(array('period' => 'weekly', 'interval' => 1, 'item' => array('name' => 'Test Weekly 1 plan', 'description' => 'Description for the weekly 1 plan', 'amount' => 100, 'currency' => 'INR'),'notes'=> array('key1'=> 'value3','key2'=> 'value2')));
        $api->subscription->create(array('plan_id' => 'plan_KhN2eI4iFxknkU', 'customer_notify' => 1,'quantity'=>5, 'total_count' => 6, 'start_at' => 1495995837, 'addons' => array(array('item' => array('name' => 'Delivery charges', 'amount' => 100, 'currency' => 'INR'))),'notes'=> array('key1'=> 'value3','key2'=> 'value2')));


        // $api = new Api(env('RAZORPAY_KEY') , env('RAZORPAY_SECRET'));
        // $payment = $api->payment->fetch($input['razorpay_payment_id']);
        // if(count($input) && !empty($input['razorpay_payment_id']) ){
        //     try{
        //         $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
        //     }
        //     catch (Exception $e){
        //         return $e->getMessage();
        //         Session::put('error','$e->getMessage()');
        //         return redirect()->back();
        //     }
        // }
        Session::put('Payment Successfully');
        return redirect()->back();
    }
}

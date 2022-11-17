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
        print_r($request->all());
        $api = new Api(env('RAZORPAY_KEY') , env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input) && !empty($input['razorpay_payment_id']) ){
            try{
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
            }
            catch (Exception $e){
                return $e->getMessage();
                Session::put('error','$e->getMessage()');
                return redirect()->back();
            }
        }
        Session::put('Payment Successfully');
        return redirect()->back();
    }
}

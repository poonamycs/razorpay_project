<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use Monolog\SignalHandler;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Session;
use Hash;
use Auth;
use Date;

class MainController extends Controller
{
    public function getform()
    {
        return view('welcome');
    }
    public function storeform(Request $request)
    {
        if ($request->isMethod('POST')) 
        {
            $email = $request->email;
            $password = $request->password;
            if(Auth::attempt(['email' => $email, 'password' => $password]))
            {
                    return redirect('/');
            }else
            {
                Log::info("Incorrect");
                return redirect('/welcome')->withErrors(['msg' => 'Invalid Login credentials']);
            }
        }
    }
    public function index(){
        return view('index');
    }

    public function success(){
        return view('success');
    }

    //rzp_test_hL4Etd0bXHkmO1
    //Gluvl9s5qfTBfbL1Ar8tCsnG


    public function payment(Request $request){

        $name = $request->input('name');
        $amount = $request->input('amount');

        // $api = new Api('rzp_test_MN6R1553E5RH77', 'gfwZryyZ7Cl0jOuF1hyrwa8y');
        // $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
        // $orderId = $order['id']; 

        $api = new Api('rzp_test_MN6R1553E5RH77', 'gfwZryyZ7Cl0jOuF1hyrwa8y');
        $api->plan->create(array('period' => 'weekly', 'interval' => 1, 'item' => array('name' => 'Test Weekly 1 plan', 'description' => 'Description for the weekly 1 plan', 'amount' => 100, 'currency' => 'INR'),'notes'=> array('key1'=> 'value3','key2'=> 'value2')));
        $order = $api->subscription->create(array('plan_id' => 'plan_KhN2eI4iFxknkU', 'customer_notify' => 1,'quantity'=>5, 'total_count' => 6, 'start_at' => now(), 'addons' => array(array('item' => array('name' => 'Delivery charges', 'amount' => 100, 'currency' => 'INR'))),'notes'=> array('key1'=> 'value3','key2'=> 'value2')));
        $orderId = $order['id']; 
        // echo "<pre>";print_r($orderId);die();
        $user_pay = new Payment();
    
        $user_pay->name = $name;
        $user_pay->amount = $amount;
        $user_pay->payment_id = $orderId;
        $user_pay->save();

        $data = array(
            // 'order_id' => $orderId,
            'amount' => $amount
        );

        return redirect()->route('home')->with('data', $data);
    }
    public function pay(Request $request){
        $data = $request->all();
        $user = Payment::where('payment_id', $data['razorpay_order_id'])->first();
        $user->payment_done = true;
        $user->razorpay_id = $data['razorpay_payment_id'];
        $api = new Api('rzp_test_MN6R1553E5RH77', 'gfwZryyZ7Cl0jOuF1hyrwa8y');
        try{
        $attributes = array(
             'razorpay_signature' => $data['razorpay_signature'],
             'razorpay_payment_id' => $data['razorpay_payment_id'],
             'razorpay_order_id' => $data['razorpay_order_id']
        );
        $order = $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    }catch(SignatureVerificationError $e){
        $succes = false;
    } 
    if($success){
        $user->save();
        return redirect('/success');
    }else{

        return redirect()->route('error');
    }
    }
    public function error(){
        return view('error');
    }

}
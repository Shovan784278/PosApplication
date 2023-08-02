<?php

namespace App\Http\Controllers;

use App\Mail\EmailCampaignMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
class CustomerController extends Controller
{
    
    function CustomerPage():View{
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){
        $user_id=$request->header('id');
        return Customer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'user_id'=>$user_id
        ]);
    }


    function CustomerList(Request $request){
        $user_id=$request->header('id');
        return Customer::where('user_id',$user_id)->get();
    }


    function CustomerDelete(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->delete();
    }


    function CustomerByID(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }


     function CustomerUpdate(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
        ]);
    }


    public function sendEmailToAllCustomers(Request $request)
    {
        // Retrieve the email subject and content from the form data
        $subject = $request->input('subject');
        $content = $request->input('content');

        // Retrieve all customers from the customers table
        $customers = Customer::all();

        // Send the email campaign to all customers
        foreach ($customers as $customer) {
            Mail::to($customer->email)->send(new EmailCampaignMail($customer->email,$subject,$content));
        }

        return response()->json([
    
            "status"=>"success",
            "message"=>"Email has been sent!"

        ],status:200);

    }


    function EmailPage(){
        return view('pages.dashboard.email-page');
    }
}

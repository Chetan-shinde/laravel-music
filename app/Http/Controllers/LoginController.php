<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request){
		
		$customer = Customer::where('cust_email', '=', $request->cust_email)->first();

		$token = Auth::guard('api')->login($customer);
		$customer->saveCustDeviceDetails($token);
		
    	return response()->json(['success'=>true, 'customer'=>$customer, 'token'=>$token], 200);
    }

    public function register(Request $request){
    	
	 	$validator = Validator::make($request->all(), [
            'cust_email' => 'required',
            'password' => 'required',
        ]);

	    if ($validator->fails()) {
	    	$errors = $validator->errors();
	    	return response()->json(["success"=>false, 'error'=>$errors]);
	    }

	    //check if user exists already
	    $customer = Customer::where('cust_email', "=", $request->cust_email)->first();
	    if(!empty($customer)){
			return response()->json(["success"=>false, 'error'=>['email'=>['customer already exists']]]);
	    }

	    //insert customer
		$customer = new Customer();

        $customer->cust_email = $request->cust_email;
        $customer->cust_password = Hash::make($request->password);
        $customer->cust_age = $request->cust_age;
        $customer->cust_country = $request->cust_country;
        $customer->cust_created_at = date('Y-m-d H:i:s');
        $customer->cust_modified_at = date('Y-m-d H:i:s');

		$token = Auth::guard('api')->login($customer);
        $customer->save(['token'=>$token]);

		//insert into customer device details
        return response()->json(["success"=>true, 'customer'=>$customer, 'token'=>$token]);
    }
}


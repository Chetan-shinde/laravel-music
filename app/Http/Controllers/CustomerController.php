<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function getCustomerByToken(Request $request){
    	//get token 
    	$bearerToken = $request->header('Authorization');
    	$bearerToken = str_replace("Bearer ", "", $bearerToken);

		//DB::enableQueryLog(); // Enable query log

		$customer = Customer::join('customer_device_details as cdd', 'cust_id', "=", "cdd.cust_device_cust_id")->where('cdd.cust_device_token', "=", $bearerToken)->first();

		//dd(DB::getQueryLog()); // Show results of log
		    	

    	if(empty($customer)){
    		return response()->json(['success'=>false, 'error'=>'invalid token' ], 200);
    	}

    	return response()->json(['success'=>true, 'customer'=>$customer], 200);
    }
}

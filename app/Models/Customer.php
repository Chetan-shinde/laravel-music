<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const CREATED_AT = 'cust_created_at';
    const UPDATED_AT = 'cust_modified_at';

    protected $primaryKey = 'cust_id';

	protected $table = 'customers';

    protected $fillable = [
        'cust_email',
        'cust_password',
        'cust_age',
        'cust_country',
        'cust_created_at',
        'cust_modified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'cust_password',
    ];


    /**
    * we added getCustomer so we get customer custom
	*/
    public function getCustomer($email){
    	return $this->where('cust_email', $email)->first();
    }

    public function getAuthPassword(){
    	return $this->attributes['cust_password'];
    }

    public function save(array $array=[]){
    	parent::save();

    	//insert customer device details
    	$this->saveCustDeviceDetails($array['token']);

    	return true;
    }

    public function saveCustDeviceDetails($token){
		DB::insert('INSERT INTO customer_device_details(cust_device_cust_id, cust_device_token) 
    		VALUES (?, ?)', [$this->cust_id, $token] );
    }
   
}

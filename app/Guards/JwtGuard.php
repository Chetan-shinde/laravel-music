<?php

namespace App\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
/**
 * 
 */
class JwtGuard implements Guard
{
	private $user;
	private $provider;

	public function __construct(UserProvider $provider){
		$this->provider = $provider;
	}
	
	public function check(){
		return !empty($this->user);
	}

	public function guest(){
		return empty($this->user);
	}

	public function user(){
		if(!empty($this->user)){
			return $this->user;
		}
	}

	public function id(){
		if(!empty($this->user)){
			return $this->user->getAuthIdentifier();
		}
	}

	public function validate(array $credentials = []){
		if(!isset($credentials['email']) || empty($credentials['email']) || !isset($credentials['password']) 
			|| empty($credentials['password'])
		){
			return false;
		}

		$user = $this->provider->retriveById($credentials['email']);

		if(empty($user)){
			return false;
		}

		if($this->provider->validateCredentials($user, $credentials)){
			$this->setUser($user);
			return true;
		}else{
			return false;
		}
	}

	public function setUser(Authenticatable $user){
		$this->user = $user;
	}

	public function login($user){
		$value = $user->cust_id."".time();
		$token = Hash::make($value);
		$this->setUser($user);
		return $token;
	}
}
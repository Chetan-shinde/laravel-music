<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SongController extends Controller
{
    public function getSongs(){
    	return response()->json(["success"=>true, "songs"=>[]]);
    }
}

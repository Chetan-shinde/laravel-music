<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';
    protected $primaryKey = 'song_id';

    const CREATED_AT = 'song_created_at';
    const UPDATED_AT = 'song_modified_at';

    public function getSongs(){
    	return self::all();
    }

}

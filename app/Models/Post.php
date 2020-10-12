<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use Storage;

class Post extends Model
{
    use HasFactory;

    public static function post(Request $request)
    {
    	$message = $request->input('textarea');
    	$tags = $request->input('tags')
    	$time = time();
		$name = $time . "." . Session::get('user')[0]['id'];
		Storage::disk('s3')->put($name, $request->photo, 'public');
		Storage::disk('s3')->setVisibility($name, 'public');
		$filePath = "https://gamingtime.s3.ap-south-1.amazonaws.com/images/".$name;
		DB::table('posts')->insert(
    	['message' => $message, 'tags' => $tags, 'postpath'=> $filePath,'gamerid'=>Session::get('user')[0]['id']]
     	);	
     	return;
    }

}

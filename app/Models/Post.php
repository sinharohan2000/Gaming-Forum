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
    	$tags = $request->input('tags');
    	$time = time();
		$name = $time . "." . Session::get('user')[0]['id'];
		$path = $request->photo->storeAs('images', $name, 's3');
		$filePath = "https://gamingtime.s3.ap-south-1.amazonaws.com/images/".$name;
		DB::table('posts')->insert(
    	['message' => $message, 'gamername' => Session::get('user')[0]['username'],'tags' => $tags, 'postpath'=> $filePath,'gamerid'=>Session::get('user')[0]['id']]
     	);	
     	return;
    }

     public static function fetchpost($postid)
    {
    	$result = DB::table('posts')->where('id' , $postid)->orderby('id','desc')->get();
    	return $result;
    }

    public static function fetchposts($gamerid)
    {
    	$result = DB::table('posts')->where('gamerid' , $gamerid)->orderby('id','desc')->get();
    	return $result;
    }
 	
 	public static function rating(Request $request)
 	{
 		$rating = $request->input('rating');
    	$postid = $request->input('postid');
 		$result = DB::table('ratings')->where('postid' , $postid)->where('gamerid' , Session::get('user')[0]['id'])->get();
 		if(count($result) == 0)
 			DB::table('ratings')->insert(
    		['postid' => $postid, 'gamerid' => Session::get('user')[0]['id'],'rating' => $rating]
     	);
     	else
     		DB::table('ratings')->where(
    		['postid' => $postid, 'gamerid' => Session::get('user')[0]['id']])->update(["rating" => $rating]);
     	return;

 	}
}

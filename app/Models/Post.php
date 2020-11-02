<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use Storage;
use Config;

class Post extends Model
{
    use HasFactory;
     //function to convert array of objects into array of array
    public static function convertToArray($array)
        {
             $result = array();
                foreach ($array as $object)
                {
                    $result[] = (array) $object;
                }

                return $result;
        }
        //adding post to our database and sending post to aws to save in bucket.
    public static function post(Request $request)
    {
    	$message = $request->input('textarea');
    	$tags = $request->input('tags');
    	$time = time();
		$name = $time . "." . Session::get('user')[0]['id'];
		$path = $request->photo->storeAs('images', $name, 's3');
		$filePath = "https://".Config::get('app.AWS_BUCKET').".s3.".Config::get('app.AWS_DEFAULT_REGION').".amazonaws.com/images/".$name;
		DB::table('posts')->insert(
    	['message' => $message, 'gamername' => Session::get('user')[0]['username'],'tags' => $tags, 'postpath'=> $filePath,'gamerid'=>Session::get('user')[0]['id']]
     	);	
     	return;
    }
    //fetching single post data
     public static function fetchpost($postid)
    {
    	$result = DB::table('posts')->where('id' , $postid)->orderby('id','desc')->get();
    	return self::convertToArray($result);
    }
    //fetching all the posts' data for a user
    public static function fetchposts($gamerid)
    {
    	$result = self::convertToArray(DB::table('posts')->where('gamerid' , $gamerid)->orderby('id','desc')->get());
    	return $result;
    }
    //supporting any user by paying money
    public static function support(Request $request)
    {
        $money = DB::table('posts')->where('id',$request->input('postid'))->get();
        $val = $money[0]->money+$request->input('money');
        DB::table('posts')->where('id', $request->input('postid'))->update(['money' => $val]);
    }
    //fetching total money for a post
    public static function fetchmoney($postid)
    {
        $result = self::convertToArray( DB::table('posts')->where('id',$postid)->get());
        return $result[0]['money'];
    }
    //searching relevent post using tags
    public static function fetchpostbytag(Request $request)
    {
        $tags = "'".$request->input('search')."'";
       $sql = "SELECT id,gamername,tags,gamerid FROM posts
        WHERE MATCH tags
        AGAINST ($tags IN NATURAL LANGUAGE MODE)";
        return self::convertToArray(DB::select(DB::raw($sql)));
    }
}

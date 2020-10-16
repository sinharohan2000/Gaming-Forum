<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use Storage;

class Notificationmodel extends Model
{
    use HasFactory;

    public static function convertToArray($array)
    {
         $result = array();
            foreach ($array as $object)
            {
                $result[] = (array) $object;
            }

            return $result;
    }
    public static function post($id)
    {
    	$notification = Session::get('user')[0]['username']." has posted something.";
    	DB::table('notifications')->insert(
    	['notification' => $notification, 'gamerid' => $id]);	
     	return;
    }

    public static function paynotification(Request $request)
    {
    	$money = $request->input('money');
    	$id = self::convertToArray(DB::table('posts')->where('id',$request->input('postid'))->get());
    	$notification = Session::get('user')[0]['username']." has paid you ". $money;
    	DB::table('notifications')->insert(
    	['notification' => $notification, 'gamerid' => Session::get('user')[0]['id']]);	
     	return;
    }

    public static function fetchnotification($id)
    {
    		$sql = "SELECT B.* FROM followers AS A 
            	INNER JOIN notifications AS B 
            	ON A.gamerid = B.gamerid WHERE A.followerid = $id ORDER BY id DESC";
       		$result = DB::select(DB::raw($sql));
        return self::convertToArray($result);
    }

    public static function follownotification($gamerid)
    {
    	$username = Session::get('user')[0]['username'];
    	$notification = $username." has started following you";
    	DB::table('notifications')->insert(['gamerid' => $gamerid, 'notification' => $notification]);
    	return;
    }
}

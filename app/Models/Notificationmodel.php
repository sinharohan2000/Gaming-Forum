<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use Storage;

class Notificationmodel extends Model
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
    //sending notification when user posts something
    public static function post($id)
    {
    	$username = Session::get('user')[0]['username'];
    	$userid = Session::get('user')[0]['id'];
    	$notification = "<a href = '/gamingforum/gamerprofile/".base64_encode(base64_encode($userid))."'>".$username."</a> has posted something.";
    	DB::table('notifications')->insert(
    	['notification' => $notification, 'gamerid' => $userid, 'access' => 0]);
     	return;
    }
        //sending notification when user supports another user by paying some money
    public static function paynotification(Request $request,$gamerid,$gamername)
    {
    	$money = $request->input('money');
    	$username = Session::get('user')[0]['username'];
    	$userid = Session::get('user')[0]['id'];
    	$notification = "<a href = '/gamingforum/gamerprofile/".base64_encode(base64_encode($userid))."'>".$username." </a> has paid you ". $money."₹ for this <a href='/gamingforum/post/".base64_encode(base64_encode($request->input('postid')))."'> post </a>";

    	$notification1 = 'you have paid '.$money."₹ <a href='/gamingforum/gamerprofile/".base64_encode(base64_encode($gamerid))."'>". $gamername."</a> for this <a href='/gamingforum/post/".base64_encode(base64_encode($request->input('postid')))."'> post </a>";

    	DB::table('notifications')->insert(
    	['notification' => $notification, 'gamerid' => $gamerid]);
    	DB::table('notifications')->insert(
    	['notification' => $notification1, 'gamerid' => Session::get('user')[0]['id']]);	
     	return;
    }
    //fetching all the notification for a user
    public static function fetchnotification($id)
    {
    		$result = self::convertToArray(DB::table('notifications')->where('gamerid',$id)->where('access',1)->get());
    		$sql = "SELECT A.* FROM notifications AS A 
            INNER JOIN followers AS B 
            ON A.gamerid = B.gamerid AND A.access = 0  WHERE B.followerid = $id";
            $result1 = self::convertToArray(DB::select(DB::raw($sql)));
            $result = array_merge($result,$result1);
            $collection = collect($result);
             $sorted = self::convertToArray($collection->sortByDesc('id'));   
        return $sorted;
    }
    //sending notification when any user start to follow another user
    public static function follownotification($gamerid)
    {
    	$username = Session::get('user')[0]['username'];
    	$userid = Session::get('user')[0]['id'];
    	$notification = "<a href =/gamingforum/gamerprofile/".base64_encode(base64_encode($userid))."'>".$username." </a> has started following you";
    	DB::table('notifications')->insert(['gamerid' => $gamerid, 'notification' => $notification]);
    	return;
    }
}

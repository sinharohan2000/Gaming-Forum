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

    public static function paynotification(Request $request,$gamerid)
    {
    	$money = $request->input('money');
    	$notification = Session::get('user')[0]['username']." has paid you ". $money;
    	DB::table('notifications')->insert(
    	['notification' => $notification, 'gamerid' => $gamerid]);	
     	return;
    }

    public static function fetchnotification($id)
    {
    		$result = DB::table('notifications')->where('gamerid',$id)->get();
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

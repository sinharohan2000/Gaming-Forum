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

    public static function fetchnotification($id)
    {
    		$sql = "SELECT B.*,C.username FROM followers AS A 
            	INNER JOIN notifications AS B 
            	ON A.gamerid = B.gamerid INNER JOIN gamers AS C ON C.id = A.gamerid WHERE A.followerid = $id";
       		$result = DB::select(DB::raw($sql));
        return self::convertToArray($result);
    }
}

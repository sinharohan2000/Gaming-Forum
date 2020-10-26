<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Message extends Model
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

    public static function fetchMessage($sender_id,$receiver_id)
    {
    	$query = "SELECT * FROM `messages` WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) OR sender_id = $receiver_id AND receiver_id = $sender_id ORDER BY id DESC LIMIT 20";
    	$result = DB::select(DB::raw($query));
    	return array_reverse(self::convertToArray($result));
    }

    public static function fetchChatsUser()
    {

    	$userid = Session::get('user')[0]['id'];
    	$query = "SELECT DISTINCT receiver_id FROM messages where sender_id = $userid ORDER BY id DESC";
    	$result = self::convertToArray(DB::select(DB::raw($query)));
    	$query = "SELECT DISTINCT sender_id FROM messages WHERE receiver_id = $userid ORDER BY id DESC ";
    	$result1 = self::convertToArray(DB::select(DB::raw($query)));
    	$user = array();
    	$count = 0;
    	$i = count($result);
    	$j = count($result1);
    	while($i){
    		$user[$count] = $result[$count]['receiver_id'];
    		$count++;
    		$i--;
    	}
    	$k = 0;
    	while($j){
    		$user[$count] = $result1[$k]['sender_id'];
    		$count++;
    		$k++;
    		$j--;
    	}
    	return array_unique($user);
    }
}

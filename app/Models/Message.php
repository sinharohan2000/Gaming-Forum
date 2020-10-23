<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

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
    	$query = "SELECT * FROM `messages` WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) OR sender_id = $receiver_id AND receiver_id = $sender_id LIMIT 20";
    	$result = DB::select(DB::raw($query));
    	return self::convertToArray($result);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Follower extends Model
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

    public static function fetchfollowers($id)
      {
        $result = self::convertToArray(DB::table('followers')->where('gamerid',$id)->get('followerid'));
        return $result;
      }

      public static function fetchfollowing($id)
      {
        $result = self::convertToArray(DB::table('followers')->where('followerid',$id)->get('gamerid'));
        return $result;
      }

      public static function isFollowing($id)
      {
      	$userid = Session::get('user')[0]['id'];
      	$result = self::convertToArray(DB::table('followers')->where('gamerid',$id)->where('followerid',$userid)->get());
      	return count($result);
      }

}

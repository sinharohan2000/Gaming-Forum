<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use Storage;

class Rating extends Model
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

     public static function fetchavgrating($postid)
    {
        $var = 0;
        $result = DB::table('ratings')->where('postid',$postid)->get();
        $result = self::convertToArray($result);
        for ($i=0; $i < count($result) ; $i++) { 
            $var += $result[$i]['rating'];
        }
        if(count($result) != 0)
        	$var = $var/count($result);
        else
        	$var = 0;
        return $var;
    }
    
    public static function ratingfetch($postid)
    {
    	$result = self::convertToArray(DB::table('ratings')->where(
    		['postid' => $postid, 'gamerid' => Session::get('user')[0]['id']])->get());
    	if(count($result) == 0)
    		return 0;
    	else
    		return $result[0]['rating'];
    }

}

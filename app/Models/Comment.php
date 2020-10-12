<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
class Comment extends Model
{
    use HasFactory;

    public static function fetchcomment($id)
    {
    	$result = DB::table('comments')->where('postid', $id)->get();
    	return $result;
    }

    public static function commentpost(Request $request)
    {
    	DB::table('comments')->insert(
          ['postid' => $request->input('postid'), 'gamerid' => Session::get('user')[0]['id'], 'gamername' => Session::get('user')[0]['username'], 'comment' => $request->input('comment')]
          );
    }
}

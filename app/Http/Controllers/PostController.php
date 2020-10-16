<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamer;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notificationmodel;
use App\Models\Rating;
use Session;
use DB;
use App\Http\Controllers\Storage;

class PostController extends Controller
{
    public function index()
    {
    	echo "bye";
    }
    public static function convertToArray($array)
    {
         $result = array();
            foreach ($array as $object)
            {
                $result[] = (array) $object;
            }

            return $result;
    }

    public function fetchnotification()
    {
        $var = Notificationmodel::fetchnotification(Session::get('user')[0]['id']);
        $var = self::convertToArray($var);
        return view('post.notification',['notifications' => $var]);
    }
    public function post(Request $request)
    {
    	$extension = $request->photo->extension();
          if($extension == "png" || $extension == "jpeg" || $extension == "jpg" || $extension == "mp4")
          {
          	Post::post($request);
            Notificationmodel::post(Session::get('user')[0]['id']);

          	return redirect('/home');
          }
          else
          {
          		$request->session()->flash('fail', 'invalid file format');
     	 	    return back();
          }
    }

    public function comment(Request $request)
    {
    	$postid = base64_decode(base64_decode($request->segment(2)));
    	$comments = Comment::fetchcomment($postid);
    	$post = Post::fetchpost($postid);
    	return view('post.comment',["comments" => $comments, "post" => $post]);
    }

    public function commentpost(Request $request)
    {
    	if(!empty($request->input('comment')))
    	{
    		Comment::commentpost($request);
    		$arr = array();
    		$arr[0] = Session::get('user')[0]['username'];
    		$arr[1] = $request->input('comment');
    		return $arr;
    	}
    	else
    		return NULL;
    }

    public function rating(Request $request)
    {
    	Rating::rating($request);

    	return $request->input('rating');
    	
    }

    public function ratingfetch(Request $req)
    {
    	return Rating::ratingfetch($request->input('postid'));
    }

    public function searchPosts(Request $request)
      {
        $search=$request->input('search');
        $sql = "SELECT * FROM posts WHERE tags like '%".$search."%'";
        $result = DB::select(DB::raw($sql));
        return $result;

      }

      public function support(Request $request)
      {
        $gamer = self::convertToArray(DB::table('posts')->where('id',$request->input('postid'))->get());
        $gamerid = $gamer[0]['gamerid'];
        Notificationmodel::paynotification($request,$gamerid);
        Post::support($request);

        return ;
      }
}
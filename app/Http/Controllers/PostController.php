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
    public function uppost(Request $request)
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

    public function getpost(Request $request)
    {
    	$postid = base64_decode(base64_decode($request->segment(2)));
        $post = Post::fetchpost($postid);
        if(count($post) > 0)
            {
            unset($post[0]['money']);
            $post[0]['avgrating'] = Rating::fetchavgrating($post[0]['id']);
            $userdetail = Gamer::fetchuser($post[0]['gamerid']);
        	$comments = Comment::fetchcomment($postid);
        	return view('post.post',["comments" => $comments, "post" => $post, "userdetail" => $userdetail]);
            }
        else
        {
            return view('error');
        }
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

    public function search(Request $request)
      {
        $search=$request->input('search');
        $gamername = Gamer::fetchuserbyname($request->input('search'));
        
        $posts = Post::fetchpostbytag($request);
        $result = array();
        $result['gamername'] = $gamername;
        $result['posts'] = $posts;
        return $result;

      }

      public function support(Request $request)
      {
        $gamer = self::convertToArray(DB::table('posts')->where('id',$request->input('postid'))->get());
        $gamerid = $gamer[0]['gamerid'];
        $gamername = Gamer::fetchgamername($gamerid);
        Notificationmodel::paynotification($request,$gamerid,$gamername);
        Post::support($request);

        return ;
      }
}
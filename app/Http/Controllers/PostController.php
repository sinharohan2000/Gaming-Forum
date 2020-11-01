<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\Gamer;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notificationmodel;
use App\Models\Rating;
use Session;
use App\Events\Myevent;
use DB;
use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
     // function to convert an array of object to an array of array

    public static function convertToArray($array)
    {
         $result = array();
            foreach ($array as $object)
            {
                $result[] = (array) $object;
            }

            return $result;
    }
    //posting the post 
    public function uppost(Request $request)
    {

        if($request->has('photo'))
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
        else
        {
            $request->session()->flash('fail', 'failed to upload');
            return back();
        }
    }
    //fetching a single post to show
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
            for ($i=0; $i < count($comments); $i++) { 
                $comments[$i]->gamername = Gamer::fetchgamername($comments[$i]->gamerid);
            }
        	return view('post.post',["comments" => $comments, "post" => $post, "userdetail" => $userdetail]);
            }
        else
        {
            return view('error');
        }
    }
    //posting a comment on post
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
    		return 0;
    }
    //rating any post
    public function rating(Request $request)
    {
    	Rating::rating($request);

    	return $request->input('rating');
    	
    }
    // fetch rating given by any(single) user
    public function ratingfetch(Request $req)
    {
    	return Rating::ratingfetch($request->input('postid'));
    }
    //searching users and tags 
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
      //supporting any post by paying money
      public function support(Request $request)
      {
        if($request->input('money') > 0)
        {
            $gamer = self::convertToArray(DB::table('posts')->where('id',$request->input('postid'))->get());
            $gamerid = $gamer[0]['gamerid'];
            $gamername = Gamer::fetchgamername($gamerid);
            Notificationmodel::paynotification($request,$gamerid,$gamername);
            Post::support($request);
            return 1;
        }
        else
        {
            return 2;
        }
      }
}
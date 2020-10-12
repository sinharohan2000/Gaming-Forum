<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamer;
use App\Models\Post;
use App\Models\Comment;
use Session;
use DB;
use App\Http\Controllers\Storage;

class PostController extends Controller
{
    public function index()
    {
    	echo "bye";
    }

    public function test()
    {
    	echo "kal milte hai";
    }
    public function post(Request $request)
    {
    	$extension = $request->photo->extension();
          if($extension == "png" || $extension == "jpeg" || $extension == "jpg" || $extension == "mp4")
          {
          	Post::post($request);
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
    	Post::rating($request);
    	return $request->input('rating');
    	
    }

    public function ratingfetch(Request $req)
    {
    	$postid = $request->input('postid');
    	$result = DB::table('ratings')->where(
    		['postid' => $postid, 'gamerid' => Session::get('user')[0]['id']])->get();
    	if(count($result) == 0)
    		return 0;
    	else
    		return $result[0]->rating;
    }
}
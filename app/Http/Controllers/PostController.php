<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamer;
use App\Models\Post;
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

}
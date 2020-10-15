<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamer;
use App\Models\Post;
use Session;
use DB;
use App\Http\Controllers\Storage;

class UserController extends Controller
{
    public function index()
    {
    	echo "hi";
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

    public function home()
      {
            if(Session::has('user'))
            {
            	$posts = Post::fetchposts(Session::get('user')[0]['id']);
            	$posts = self::convertToArray($posts);
              for ($i=0; $i < count($posts); $i++) { 
                $posts[$i]['rating'] = Post::fetchrating($posts[$i]['id']);
                $posts[$i]['money'] = Post::fetchmoney($posts[$i]['id']);

              }

            	$sql = "SELECT B.* FROM followers AS A 
            	INNER JOIN posts AS B 
            	ON A.gamerid = B.gamerid  WHERE A.followerid = ".Session::get('user')[0]['id'];
            	$result = DB::select(DB::raw($sql));
      			  $result = self::convertToArray($result);
              for ($i=0; $i < count($result); $i++) { 
                $result[$i]['rating'] = Post::fetchrating($result[$i]['id']);
              }
               return view('user.home',["posts" => $result,"sposts" => $posts]);
            }
               else
            return redirect()->to('/');
      }


     public function signup(Request $request)
      {
          $validator = Validator::make($request->all(),[
            'username' => 'required|min:6',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
          ]);
          if($validator->fails()){
            return redirect('/signup')->withErrors($validator)->withInput();
          }

     	     if(Gamer::signup($request))
           {
            $request->session()->flash('success', 'registered successfully. please verify your email to enjoy');
            return redirect()->to('/signin');
     	    } 
          else {
     	  	  $request->session()->flash('fail', 'username or email exist.');
     	 	    return redirect()->to('/signup');
     	         }	
      }

      public function verify(Request $request)
    {
           	if(Gamer::verify($request) == 1)
            {
             	 $request->session()->flash('success', 'verified.');
            	 return redirect()->to('/signin');
            } 
            elseif(Gamer::verify($request) == 3)
        	{
        		 $request->session()->flash('fail', 'link broken. A new link has been sent to you.');
              	 return redirect()->to('/signin');
        	}
        	elseif(Gamer::verify($request) == 2)
        	{
        		 $request->session()->flash('success', 'already verified.');
              	 return redirect()->to('/signin');
        	}
    }

     public static function login(Request $request)
     {
          $validator = Validator::make($request->all(),[
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
          ]);

          if($validator->fails()){
            return redirect('/signin')->withErrors($validator)->withInput();
          }
          if(Gamer::login($request) == 1)
          		return redirect()->to('/home'); 
          else if(Gamer::login($request) == 2)
          {
              $request->session()->flash('fail', 'please verify your email first.');
              return redirect()->to('/signin');
          }
          elseif(Gamer::login($request) == 3)
          {
          		$request->session()->flash('fail', 'email or password is incorrect.');
         	 	return redirect()->to('/signin');
          }
      }

      public function logout()
      {
      	Session::flush();
      	return redirect('signin');
      }

      public static function recover(Request $request)
      {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email:rfc,dns',
          ]);

          if($validator->fails()){
            return back()->withErrors($validator)->withInput();
          }
        if(Gamer::recover($request))
        {
          $request->session()->flash('success', 'a link for password reset has been sent to you.');
          return redirect()->to('/signin');
        }
        else
        {
          $request->session()->flash('fail', 'email not found.');
           return back();
        }
      }

      public static function linkvalidation(Request $request)
      {
        if(Gamer::linkvalidation($request) != -1)
        {
          $id=Gamer::linkvalidation($request);
          return view('user.updatepassword',compact('id'))->with('id',$id);
        }
        else
        {
          $request->session()->flash('fail', 'link expired');
          return redirect('forget');
          
        }
      }

      public function updatepassword(Request $request)
      {
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8',
          ]);

          if($validator->fails()){
            return back()->withErrors($validator)->withInput();
          }
        Gamer::updatepassword($request);
        $request->session()->flash('success', 'password updated successfully. login again');
          return redirect()->to('/signin');
      }

      public function searchGamer(Request $request)
      {
      	$gamername = $request->input('search');
      	$selfname = Session::get('user')[0]['username'];
      	$sql = "SELECT username,id FROM gamers WHERE username ='$gamername' AND username != '$selfname'";
   	 	$result = self::convertToArray(DB::select(DB::raw($sql)));
   	 	if(count($result) > 0)
   	 	{
   	 		$gamerid = $result[0]['id'];
   	 		$followerid = Session::get('user')[0]['id'];
   	 	$sql1 = "SELECT id FROM followers WHERE gamerid = '$gamerid' AND followerid = '$followerid'";
   	 	$result1 = self::convertToArray(DB::select(DB::raw($sql1)));
   	 	if(count($result1) > 0)
   	 		$var = 0;
   	 	else 
   	 		$var = 1;
   	 	$arr = array($gamername,$var);
   	 	return $arr;
   	 	}
   	 	else
   	 	return array("null",0);

      }

      public function follow(Request $request)
      {
      	$gamername = $request->gamername;
      	$followerid = Session::get('user')[0]['id'];
      	$sql = "SELECT id FROM gamers WHERE username ='$gamername'";
   	 	$result = self::convertToArray(DB::select(DB::raw($sql)));
   	 	if(count($result) > 0)
   	 	{
   	 		$gamerid = $result[0]['id'];
   	 		DB::table('followers')->insert(
          ['gamerid' => $gamerid, 'followerid' => $followerid]);
          return back();
   	 	}
   	 	else
   	 	{
   	 		$request->session()->flash('fail', 'broken link');
          return back();
   	 	}
      }



}

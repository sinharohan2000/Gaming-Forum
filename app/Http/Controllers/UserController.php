<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamer;
use App\Models\Post;
use App\Models\Follower;
use App\Models\Notificationmodel;
use App\Models\Rating;
use Session;
use DB;
use App\Http\Controllers\Storage;

class UserController extends Controller
{
    public function index()
      {
    	 echo "hi";
      }
      public function home()
      {
       if(Session::has('user'))
          {
            $userdetail = Gamer::fetchuser(Session::get('user')[0]['id']);
            $sql = "SELECT B.* FROM followers AS A 
            INNER JOIN posts AS B 
            ON A.gamerid = B.gamerid  WHERE A.followerid = ".Session::get('user')[0]['id'];
            $result = DB::select(DB::raw($sql));
             $result = self::convertToArray($result);
            for ($i=0; $i < count($result); $i++) { 
              $result[$i]['avgrating'] = Rating::fetchavgrating($result[$i]['id']);
              $result[$i]['rating'] = Rating::ratingfetch($result[$i]['id']);

            }
              return view('user.home1',["userdetail" => $userdetail,"posts" => $result]);
            }
              else
            return redirect()->to('/');
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

    public function home1()
      {
        if(Session::has('user'))
          {
            $posts = Post::fetchposts(Session::get('user')[0]['id']);
            $posts = self::convertToArray($posts);
            for ($i=0; $i < count($posts); $i++) { 
              $posts[$i]['rating'] = Rating::fetchavgrating($posts[$i]['id']);
              $posts[$i]['money'] = Post::fetchmoney($posts[$i]['id']);
            }
            $sql = "SELECT B.* FROM followers AS A 
            INNER JOIN posts AS B 
            ON A.gamerid = B.gamerid  WHERE A.followerid = ".Session::get('user')[0]['id'];
            $result = DB::select(DB::raw($sql));
      			 $result = self::convertToArray($result);
            for ($i=0; $i < count($result); $i++) { 
              $result[$i]['rating'] = Rating::fetchavgrating($result[$i]['id']);
            }
              return view('user.home',["posts" => $result,"sposts" => $posts]);
            }
              else
            return redirect()->to('/');
      }

    public function profile(Request $request)
      {
        $gamerid = Session::get('user')[0]['id'];
        $userdetail = Gamer::fetchuser($gamerid);

        $posts = Post::fetchposts(Session::get('user')[0]['id']);
        $posts = self::convertToArray($posts);
        for ($i=0; $i < count($posts); $i++) 
        { 
          $posts[$i]['rating'] = Rating::fetchavgrating($posts[$i]['id']);
          $posts[$i]['money'] = Post::fetchmoney($posts[$i]['id']);
        }

        $followers = count(Follower::fetchfollowers(Session::get('user')[0]['id']));

        $following = count(Follower::fetchfollowing(Session::get('user')[0]['id']));

        return view('user.profile',["userdetail" => $userdetail,"posts" => $posts, "followers" => $followers, "followings" => $following]);
    }

      public function gamerprofile(Request $request)
        {
        $gamerid = base64_decode(base64_decode($request->segment(2)));
        if($gamerid == Session::get('user')[0]['id'])
          return redirect()->to('/profile');
        else
        {
          $gamerdetail = Gamer::fetchuser($gamerid);
          $isFollowing = Follower::isFollowing($gamerid);

          $posts = Post::fetchposts($gamerid);
          for ($i=0; $i < count($posts) ; $i++) { 
            unset($posts[$i]['money']);
            $posts[$i]['rating'] = Rating::ratingfetch($posts[$i]['id']);
            $posts[$i]['avgrating'] = Rating::fetchavgrating($posts[$i]['id']);
          }

          $followers = count(Follower::fetchfollowers($gamerid));

          $following = count(Follower::fetchfollowing($gamerid));
            

            return view('user.gamerprofile',["gamerdetail" => $gamerdetail,"posts" => $posts, "followers" => $followers, "followings" => $following, "isFollowing" => $isFollowing]); 
        }
      }

    public function signup(Request $request)
      {
        $validator = Validator::make($request->all(),
          [
            'username' => 'required|min:6',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
          ]);
        if($validator->fails())
          return redirect('/signup')->withErrors($validator)->withInput();

     	  if(Gamer::signup($request))
          {
            $request->session()->flash('success', 'registered successfully. please verify your email to enjoy');
            return redirect()->to('/signin');
     	    } 
          else 
          {
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
        $validator = Validator::make($request->all(),
          [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
          ]);

        if($validator->fails())
          return redirect('/signin')->withErrors($validator)->withInput();
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

      public function follow(Request $request)
      {
         $gamerid = base64_decode(base64_decode($request->input('gamerid')));
         $var = Follower::follow($gamerid);
         if($var)
          Notificationmodel::follownotification($gamerid);
      	return;
      }

      public function update(Request $request)
      {
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8',
          ]);

          if($validator->fails()){
            return back()->withErrors($validator)->withInput();
          }
        Gamer::updatepass($request);
        $request->session()->flash('success', 'password updated successfully.');
        return redirect()->to('/profile');
      }

      public function changeprofile(Request $request)
      {
        $extension = $request->photo->extension();
          if($extension == "png" || $extension == "jpeg" || $extension == "jpg" )
          {
            Gamer::changeprofile($request);

            return back();
          }
          else
          {
              $request->session()->flash('fail', 'invalid file format');
            return back();
          }
      }

      public function updateusername(Request $request)
      {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:6',
          ]);

          if($validator->fails()){
            return back()->withErrors($validator)->withInput();
          }
          if(Gamer::updateusername($request) == 1)
          {
            $request->session()->flash('success', 'username updated');
            return redirect()->to('/profile');
          }
          else
          {
            $request->session()->flash('fail', 'username not available.');
            return back();
          }
      }

}

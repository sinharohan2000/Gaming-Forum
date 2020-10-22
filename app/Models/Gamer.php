<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Mail\Verification;

class Gamer extends Model
{
    use HasFactory;
    protected $fillable=['username','email','password','created_at','updated_at'];

    public static function convertToArray($array)
    {
         $result = array();
            foreach ($array as $object)
            {
                $result[] = (array) $object;
            }

            return $result;
    }

    public static function signup(Request $request)
    {
    	$username = $request->input('username');
    	$email = $request->input('email');
    	$sql = "SELECT username FROM gamers WHERE username='$username' OR email='$email'";
   	 	$result = DB::select(DB::raw($sql));
    	$result = self::convertToArray($result);
      if(count($result) == 0)
      {
          $token = sha1(rand());
          DB::table('gamers')->insert(
          ['username' => $request->input('username'), 'email' => $request->input('email'), 'password' => md5($request->input('password')), 'token' => $token, 'is_active' => 0]
          );
          Verification::verificationmail($request->input('email'),$token);
          return true;
      }
      else 
       	  return false;
    }

    public static function verify(Request $request)
    {	
    	$email = base64_decode($request->segment(2));
    	$token = $request->segment(3);
      	$sql = "SELECT is_active FROM gamers WHERE email='$email' AND token='$token'";
   	 	$result = DB::select(DB::raw($sql));
    	$result = self::convertToArray($result);
            if(count($result) != 0 && $result[0]["is_active"] == 0)
            {
               DB::table("gamers")->where('email',$email)->update(["is_active" => 1]);
               return 1;
            }
            elseif(count($result) != 0 && $result[0]["is_active"] == 1)
            	return 2;
            {	
            	$token = sha1(rand());
            	DB::table("gamers")->where('email',$email)->update(["token" => $token]);
            	Verification::verificationmail($request->input('email'),$token);
              	return 3;
            }
    }

    public static function login(Request $request)
    {
      $email = $request->input('email');
      $password = md5($request->input('password'));
      $sql = "SELECT id,username,email FROM gamers WHERE email = '$email' AND password = '$password'";
      $result = DB::select(DB::raw($sql));
      $result = self::convertToArray($result);
      if(count($result) > 0)
      {
        $sql = "SELECT id,username,email FROM gamers WHERE email = '$email' AND is_active =1 ";
        $result = DB::select(DB::raw($sql));
        $result = self::convertToArray($result);
          if(count($result) > 0)
          {
            Session::put('user',$result);
            $token=sha1(rand());
            DB::table("gamers")->where('username',$result[0]["username"])->update(["token" => $token]);
            return 1;
          } 
          else
          return 2;
      }
        else
        return 3;
    }

    public static function recover(Request $request)
      {
        $email=$request->input('email');
        $sql = "SELECT email FROM gamers WHERE email='$email'";
        $result = DB::select(DB::raw($sql));
        if(empty($result))
        return false;
        else
        {
        $token=sha1(rand());
        DB::table("gamers")->where('email',$email)->update(["token" => $token]);
        Verification::resetpasswordemail($email,$token);
        return true; 
        }
      }

      public static function linkvalidation(Request $request)
      {
        $email = base64_decode($request->segment(2));
        $token = $request->segment(3);
        $sql = "SELECT email,id FROM gamers WHERE email='$email' AND token = '$token'";
        $result = DB::select(DB::raw($sql));
        $result = self::convertToArray($result);
        if(count($result) > 0)
          return $result[0]['id'];
        else
          return -1;
      }

      public static function updatepassword(Request $request)
      {
        $id = $request->input('id');
        $password = md5($request->input('password'));
        DB::table("gamers")->where('id',$id)->update(["password" => $password]);
        Session::flush();
        return;
      }

      public static function fetchgamername($id)
      {
        $result = self::convertToArray(DB::table('gamers')->where('id',$id)->get('username'));
        if(count($result))
          return $result[0]['username'];
        else
          return NULL;
      }

      public static function updatepass(Request $request)
      {
        $newpassword = md5($request->input('password'));
        $id = Session::get('user')[0]['id'];
        DB::table('gamers')->where('id',$id)->update(['password' => $newpassword]);
        return;
      }

      public static function fetchuser($id)
      {
        return self::convertToArray(DB::table('gamers')->where('id',$id)->select('username','profilepath','id')->get());
      }

      public static function fetchuserbyname($name)
      {
        return self::convertToArray(DB::table('gamers')->where('username',$name)->select('username','id')->get());
      }

      public static function changeprofile(Request $request)
      {
        $gamerid = Session::get('user')[0]['id'];
        $time = time();
        $name = $time . "." . Session::get('user')[0]['id'];
        $path = $request->photo->storeAs('images', $name, 's3');
        $profilepath = "https://gamingtime.s3.ap-south-1.amazonaws.com/images/".$name;
        DB::table('gamers')->where('id',$gamerid)->update(['profilepath' => $profilepath]);
        return;
      }

      public static function updateusername(Request $request)
      {
        $username = $request->input('username');
        $checkusername = self::convertToArray(DB::table('gamers')->where('username',$username)->get());
        if(count($checkusername) == 0)
        {
          DB::table('gamers')->where('id',Session::get('user')[0]['id'])->update(['username' => $username]);
          return 1;
        }
        else
          return 0;   
      }

      public static function avail($username)
      {
        return count(self::convertToArray(DB::table('gamers')->where('username',$username)->get()));
      }
}

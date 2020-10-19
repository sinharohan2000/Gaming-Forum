<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Session;
use App\Models\Gamer;
use DB;
use App\Mail\Verification;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
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

    public function callback()
    {
            
        
            $googleUser = Socialite::driver('google')->user();
            $existUser = Gamer::where('email',$googleUser->email)->first();
            

            if($existUser) {
                
            }
            else {
                $user = new Gamer;
                $num = rand()+rand()+rand();
                $user->username = substr(sha1($googleUser->name),0,20);
                $user->email = $googleUser->email;
                $user->password = md5(rand(1,10000));
                $user->token = sha1(rand());
                $user->is_active = 1;
                $user->profilePath = "https://gamingtime.s3.ap-south-1.amazonaws.com/images/kindpng_248253.png";
                $user->save();
                Verification::signupusinggmail($user->email,$user->password,$user->username);
            }
            $sql = "SELECT id,username,email FROM gamers WHERE email = '$googleUser->email' AND is_active =1 ";
        	$result = DB::select(DB::raw($sql));
        	$result = self::convertToArray($result);
        	Session::put('user',$result);
            $token=sha1(rand());
            DB::table("gamers")->where('username',$result[0]["username"])->update(["token" => $token]);
            return redirect()->to('/home');
    }
}

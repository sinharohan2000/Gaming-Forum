<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificationmodel;
use App\Models\Gamer;
use Session;
class Notification extends Controller
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
    //fetch notification for a user and open notification page
    public function fetchnotification()
    {
        $notification = Notificationmodel::fetchnotification(Session::get('user')[0]['id']);
         $userdetail = Gamer::fetchuser(Session::get('user')[0]['id']);
	     return view('post.notifications',['userdetail' => $userdetail, 'notifications' => $notification]);
    }
}

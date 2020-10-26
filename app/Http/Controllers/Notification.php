<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificationmodel;
use App\Models\Gamer;
use Session;
class Notification extends Controller
{
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
        $notification = Notificationmodel::fetchnotification(Session::get('user')[0]['id']);
         $userdetail = Gamer::fetchuser(Session::get('user')[0]['id']);
	     return view('post.notifications',['userdetail' => $userdetail, 'notifications' => $notification]);
    }
}

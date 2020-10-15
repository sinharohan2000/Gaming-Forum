<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificationmodel;
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
        $var = Notificationmodel::fetchnotification(Session::get('user')[0]['id']);
        $var = self::convertToArray($var);
        return view('post.notification',['notifications' => $var]);
    }
}

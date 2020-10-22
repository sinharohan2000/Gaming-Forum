<?php
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\Myevent;
use Session;
 
class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('authorize');
    }
 
    public function index()
    {
        $user_id = Session::get('user')[0]['id'];
        $data = array('user_id' => $user_id);
 
        return view('chat.chat', ["user_id" => $user_id]);
    }
 
    public function send()
    {
        // ...
         
        // message is being sent
        $message = new Message;
        $message->setAttribute('from', 5);
        $message->setAttribute('to', 5);
        $message->setAttribute('message', 'Demo message from user 1 to user 2');
        $message->save();
         
        // want to broadcast NewMessageNotification event
        event(new Myevent($message));
             }
}

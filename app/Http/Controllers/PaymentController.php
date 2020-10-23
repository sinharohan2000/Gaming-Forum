<?php
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gamer;
use App\Models\Message;
use App\Events\Myevent;
use Session;
 
class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('authorize');
    }
 
    public function index(Request $request)
    {
    	$receiver = base64_decode(base64_decode($request->segment(2)));
        $user_id = Session::get('user')[0]['id'];
        $gamerdetail = Gamer::fetchuser($receiver);
        $messages = Message::fetchMessage($user_id,$gamerdetail[0]['id']);
 
        return view('chat.chat', ["user_id" => $user_id,"gamerdetail" => $gamerdetail, "messages" => $messages]);
    }
 
    public function send(Request $request)
    {
        $message = new Message;
        $message->setAttribute('sender_id', Session::get('user')[0]['id']);
        $message->setAttribute('receiver_id', $request->input('receiver_id'));
        $message->setAttribute('message', $request->input('send_message'));
        $message->save();
         
        // want to broadcast NewMessageNotification event
        event(new Myevent($message));
             }
}

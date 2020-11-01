<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gamer;
use App\Models\Message;
use App\Events\Myevent;
use Session;
use DB;
 
class ChatController extends Controller
{
    //to check if user is authenciated.
    public function __construct() {
        $this->middleware('authorize');
    }
    //fetch list of persons where messages has been sent or received
 	public function chats()
 	{
 		$userdetail = Gamer::fetchuser(Session::get('user')[0]['id']);
 		$gamerdetails = Gamer::fetchChatsUser(Message::fetchChatsUser());
 		return view('chat.chats',['userdetail' => $userdetail, 'gamerdetails' => $gamerdetails]);
 	}
    //fetch previous messsages and open a chat window
    public function chat(Request $request)
    {
    	$receiver = base64_decode(base64_decode($request->segment(2)));
        $user_id = Session::get('user')[0]['id'];
        $gamerdetail = Gamer::fetchuser($receiver);
        $messages = Message::fetchMessage($user_id,$gamerdetail[0]['id']);
 
        return view('chat.chat', ["user_id" => $user_id,"gamerdetail" => $gamerdetail, "messages" => $messages]);
    }
    //send a message to a user in real time using pusher library
    public function send(Request $request)
    {
        $message = new Message;
        $message->setAttribute('sender_id', Session::get('user')[0]['id']);
        $message->setAttribute('receiver_id', $request->input('receiver_id'));
        $message->setAttribute('message', $request->input('send_message'));
        $message->save();
        event(new Myevent($message));
        return date('d-m H:i');
    }
}

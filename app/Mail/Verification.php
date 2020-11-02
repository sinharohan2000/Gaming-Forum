<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mail;

class Verification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    //sending verification mail when user sign up
    public static function verificationmail($email,$token)
    {
        Mail::send('emails.mail',['token'=>$token, 'email'=>base64_encode($email)], function($message) use ( $email) {
        $message->to($email)
        ->subject('verify account');
        });
    }
    //sending recovery mail when user forgot password
    public static function resetpasswordemail($email,$token)
    {
        Mail::send('emails.recover',['token'=>$token, 'email'=>base64_encode($email)], function($message) use ( $email) {
        $message->to($email)
        ->subject('recover password');
        });
    }
    //sending username and password when user signup using gmail 
    public static function signupusinggmail($email,$password,$username)
    {
        Mail::send('emails.signup',['password'=>$password, 'username'=>$username], function($message) use ( $email) {
        $message->to($email)
        ->subject('Welcome to Gaming forum');
        });
    }
}

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script type="text/javascript" src="{{asset('/public/js/bootstrap.js')}}"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   <script src = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" ></script>
   <link rel="stylesheet" type="text/css" href="{{ asset('/resources/css/chats.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('/resources/css/styles.css') }}">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="opening-page.html">Pro-Gamers</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Account
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Update Password</a>
            <a class="dropdown-item" href="/gamingforum/updateusername">Update Username</a>
            <a class="dropdown-item" href="/gamingforum/logout">Log Out</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/notification">Notification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/profile">Profile</a>
        </li>
      </ul>
    </div>
  </nav>
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-12">
          <div class="top">
            <div class="content no-gutters content--grey">
              <img class="profile-image" src="{{$gamerdetail[0]['profilepath']}}" alt="">
              <span class="top1 float-right">
               <h5>{{$gamerdetail[0]['username']}}</h5>
              </span>
            </div>
          </div>
          <div class="chat-screen">
          @foreach($messages as $message)
           <div class="row no-gutters">
                @if($message['sender_id'] == Session::get('user')[0]['id'])
                    <div class="col-md-5 offset-md-7">
                      <div class="chat-messages chat-messages--right">
                       <strong>{{$message['message']}}</strong> 
                        <br><small>{{$message['created_at']}}</small>
                      </div>
                    </div>
                  </div>
                @else
                    <div class="col-md-5">
                      <div class="chat-messages chat-messages--left">
                        <strong>{{$message['message']}}</strong>
                        <br><small>{{$message['created_at']}}</small>
                      </div>
                    </div> 
                  </div>
                @endif
              @endforeach
              <div class="row no-gutters" id="chat"></div>
          <div class="row">
            <div class="col-12">
              <div class="message-area">
               <input type="text" id="message" placeholder="Type your message here...">
               <button type="button" class="btn btn-primary" id="submit" onclick="send()">send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom-container">
    <center>
      <a class="footer-link" href="https://www.linkedin.com/"><img class="facebook" src="{{ asset('/resources/images/linkedin.png') }}" alt="linkedin-logo"></a>
      <a class="footer-link" href="https://www.facebook.com/"> <img class="facebook" src="{{ asset('/resources/images/facebook.png') }}" alt="facebook-logo"></a>
      <a class="footer-link" href="https://www.youtube.com/"> <img class="facebook" src="{{ asset('/resources/images/youtube.png') }}" alt="youtube-logo"></a>
    </center>
    <br>
    <p class="end">© 2020 eCode.js</p>
  </div>
  </body>
  <script>
    var input = document.getElementById("message");
    input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("submit").click();
    }
  });
  </script>
  <script>
  var channel = Echo.private('my-channel.{{$user_id}}.{{$gamerdetail[0]['id']}}');
  channel.listen('Myevent', function(data) {
   console.log(data['message']['message']);
   var html = `<div class="col-md-5"><div class="chat-messages chat-messages--left"><strong>${data['message']['message']}</strong></div></div>`;
    $('#chat').append(html);
  });
  </script>
  <script type="text/javascript">
  function send(){
    var send_message = $('#message').val();
    var receiver_id = <?=$gamerdetail[0]['id'] ?>;
    if(send_message.length > 0){
      $.ajax({
         url: "/gamingforum/send",
                type: "post",
                data: {
                "_token": "{{ csrf_token() }}",
                "send_message": send_message,
                "receiver_id":receiver_id,
               },
               success:function(data){
                var html = 
                `<div class="col-md-5 offset-md-7"><div class="chat-messages chat-messages--right"><strong>${send_message}</strong></div></div>`;
                $('#chat').append(html);
                $('#message').val("");
               }

      });
    }
   } 
  </script>
</html>
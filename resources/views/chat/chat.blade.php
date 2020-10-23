<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script type="text/javascript" src="{{asset('/public/js/bootstrap.js')}}"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   <script src = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" ></script>
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
      </ul>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <img src="{{ asset('/resources/images/youtube.png') }}" style="height: 50px;width: 50px;border-radius: 2px;">hiiiiii<br>
        
      </div>
    </div>  
  </div>









  <h1>Pusher Testttttttttt</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
  @foreach($messages as $message)
  @if($message['sender_id'] == $user_id)
  <p align="right"> {{$message['message']}}; <br></p>
  @else
  <p align="left">{{$message['message']}};<br></p>
  @endif
  @endforeach
  <div id="chat"></div>
  <textarea id = "message"></textarea>
  <button type="button" class="btn btn-primary" style= "width: 100px; height: 40px;" onclick="send()">Send</button>
</body>
<script>
	var channel = Echo.private('my-channel.{{$user_id}}.{{$gamerdetail[0]['id']}}');
	channel.listen('Myevent', function(data) {
 	 //alert(JSON.stringify(data));
   console.log(data['message']['message']);
 	 var html = data['message']['message'];
 	 $('#chat').html(html);
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
                var html = send_message;
                document.getElementById('chat').append(html);

               }

      });
    }
   } 
</script>
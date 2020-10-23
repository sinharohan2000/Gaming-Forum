<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script type="text/javascript" src="{{asset('/public/js/bootstrap.js')}}"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
  <textarea id = "message"></textarea>
  <button type="button" class="btn btn-primary" value="Send" style= "width: 60px; height: 20px;" onclick="send()"></button>
  <div id="chat"></div>
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
<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script type="text/javascript" src="{{asset('/public/js/bootstrap.js')}}"></script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
  <div id="chat"></div>
</body>
<script>
	var channel = Echo.private('my-channel.{{$user_id}}');
	channel.listen('Myevent', function(data) {
 	 alert(JSON.stringify(data));
 	 var html = data['message'];
 	 $('#chat').html(html);
	});
</script>
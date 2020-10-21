<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script type="text/javascript" src="{{asset('/public/js/bootstrap.js')}}"></script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
<script>
	var channel = Echo.channel('my-channel');
	channel.listen('.my-event', function(data) {
 	 alert(JSON.stringify(data));
 	 console.log(data);
	});
</script>
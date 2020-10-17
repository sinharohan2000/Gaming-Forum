<!DOCTYPE html>
<html>
<head>
	<title>project</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script type="text/javascript" src="{{ asset('/resources/js/bootstrap-tagsinput.js') }}"></script>
        <link href="{{ asset('/resources/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/gamingforum/home">Gaming Forum</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/gamingforum/home">Home</a></li>
      <li><a href="/gamingforum/notification">Notification</a></li>
      <li><a href="/gamingforum/logout">Log out</a></li>
      
    </ul>
  </div>
</nav>
    <div class="jumbotron">
        <div class="container">
            <h2>{{$post[0]->gamername}}</h2>
            <p>{{$post[0]->message}}</p>
            <h3>{{$post[0]->tags}}</h3>
            <img src="{{$post[0]->postpath}}" class="img-responsive">
                <div id="rating" align="right">
                </div>
                <form id="commentpost" method="post">
				    @csrf
				    <textarea id='comment' name='comment'></textarea>
				    <input type="hidden" value="{{$post[0]->id}}" name="postid">
				    <input value="comment" class="btn btn-primary btn-sm" onclick="comment11()">    
				</form>
				<div id=comments>
					</div>
                @foreach ($comments as $comment)
		            <h2>{{$comment->gamername}}</h2>
		            <p>{{$comment->comment}}</p>
				@endforeach
				
        </div>

    </div>
</body>
<script type="text/javascript">
	function comment11()
	{
		var sendData = $("#commentpost").serialize();
        $.ajax({
                url: "/gamingforum/commentpost",
                type: "post",
                data: sendData,
                success: function(data) {
                   var html = "";
                   html += "<h2>"+data[0]+"</h2>"+"<p>"+data[1]+"</p>";
                   $("#comments").prepend(html);
                   }
        });
	}
</script>
</html>
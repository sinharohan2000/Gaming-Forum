<!DOCTYPE html>
<html>
<head>
	<title>gaming forum</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script type="text/javascript" src="{{ asset('/resources/js/bootstrap-tagsinput.js') }}"></script>
        <link href="{{ asset('/resources/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
		@if(Session::has('fail'))
    <div class="alert alert-danger">
        {{ Session::get('fail') }}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
	</div>
	
<a href="logout"> logout</a>
{{Session::get('user')[0]['username']}}
<div align="center">
<form action="post" method="POST" enctype="multipart/form-data">
    @csrf
Type something:</br>
<textarea name="textarea" rows="2" id="textarea"></textarea>
</br>
Tags:</br>
<input type="text" class="form-control" name="tags" data-role="tagsinput" id="tags"></br>
  Select image to upload:
  <input type="file" name="photo" id="photo">
</br></br>
  <input type="submit" value="Upload Image" name="submit">
</form>
</div>

<div>	
	<form id="searchgamer" method="post">
    @csrf
    <input type="text" id="search" name="search" class="form-control input-sm" maxlength="64" placeholder="Search" />
 <input   value="search" class="btn btn-primary btn-sm" onclick="searchgamer()">
    
</form>
<div id=gamers>
	</div>
</div>
@foreach ($posts as $post)
    <div class="jumbotron">
        <h1>{{$post["gamername"]}}</h1>
            <p>{{$post["message"]}}</p>
            <h3>{{$post['tags']}}</h3>
            <img src="{{$post['postpath']}}" class="img-responsive">
            <a class="btn btn-primary" href="comment/{{base64_encode(base64_encode($post['id']))}}" role="button">Comment</a>
                <div id="rating" align="center">
                	<select name="rating" onchange="rating(this.value, '<?=$post['id'] ?>')">
                		<option value="1">1</option>
                		<option value="2">2</option>
                		<option value="3">3</option>
                		<option value="4">4</option>
                		<option value="5">5</option>
                		
                	</select>
                	<div id="ratingval<?=$post['id'] ?>" style= "float: right;" align='right'>
                		{{$post["rating"]}}
                	</div>

                </div>

        
    </div>
@endforeach
@foreach ($sposts as $post)
    <div class="jumbotron">
        <h1>{{$post["gamername"]}}</h1>
            <p>{{$post["message"]}}</p>
            <h3>{{$post['tags']}}</h3>
            <img src="{{$post['postpath']}}" class="img-responsive">
            <a class="btn btn-primary" href="comment/{{base64_encode(base64_encode($post['id']))}}" role="button">Comment</a>        
    </div>
@endforeach

</body>
<script type="text/javascript">
	$('#tags').tagsinput({
   trimValue: true
    });
    function searchgamer(){
            var sendData = $("#searchgamer").serialize();
        $.ajax({
                url: "/gamingforum/searchGamer",
                type: "post",
                data: sendData,
                success: function(data) {
                   var html = "";
                       if(data[0] == "null") {
                       	html+="<p> No user Found</p>";
                       }  
                       else
                       {
                       	if(data[1] == 0){
                       			html+="<p>"+data[0]+"</p><br>already following<br>";
                       	} else{
                       		var link = "follow/"+data[0];
                       			html+="<br><p>"+data[0]+"</p>"+"<a href='"+link+"'>Follow</a>";
                       	}
                       }
                       $("#gamers").html(html);
                   }
        });
       }
</script>
<script type="text/javascript">
	function rating(val,postid){
        $.ajax({
                url: "/gamingforum/rating",
                type: "post",
                data: {
				        "_token": "{{ csrf_token() }}",
				        "rating": val,
				        "postid": postid
				        },
                success: function(data) {
                	console.log(data,postid);
                    
                       $("#ratingval"+postid).text(data);
                   }
        });
       }
</script>
<script type="text/javascript">
	function ratingfetch($postid){
        $.ajax({
                url: "/gamingforum/ratingfetch",
                type: "post",
                data: {
				        "_token": "{{ csrf_token() }}",
				        "postid": $postid
				        },
                success: function(data) {
                   
                       $("#ratingval"+postid).text(data);
                   }
        });
       }
</script>
</html>
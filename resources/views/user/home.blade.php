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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="{{ asset('/resources/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/resources/css/styles.css') }}">
  <link rel="icon" href="{{ asset('/resources/images/fav.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Monoton&family=Raleway:wght@500&display=swap" rel="stylesheet">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg">
    <a class="navbar-brand" href="welcome">Pro-Gamers</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <strong style="color: white">{{Session::get('user')[0]['username']}}</strong>
      <a class="btn btn-outline-success my-2 my-sm-0 Login" type="submit" href="notification">Notification</a>
      <a class="btn btn-outline-success my-2 my-sm-0 Login" type="submit" href="logout">Logout</a>
    </div>
  </nav>
	<div class="container" class="jumbotron">
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
    <div class="jumbotron">
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
      </div>

<div>	
	<form id="searchgamer" method="post">
    @csrf
    <input style="width: 200px;height: 30px" type="text" id="search" name="search"  maxlength="64" placeholder="Search Gamer"/>
 <input style="width: 100px;height: 30px" value="search" class="btn btn-primary btn-sm" onclick="searchgamer()">
    
</form>
<div id=gamers style="width: 200px;height: 30px">
	</div>
</div>
<div>
<form id="searchTags" method="post">
    @csrf
    <input type="text" id="search" name="search" style="width: 200px;height: 30px" maxlength="64" placeholder="Search Tags" />
 <input style="width: 100px;height: 30px" value="search" class="btn btn-primary btn-sm" onclick="searchPosts()">
    
</form>
</div>
<div id="posts">
    
</div>
@foreach ($posts as $post)
    <div class="jumbotron">
        <h2>{{$post["gamername"]}} has posted</h2>
            <p>{{$post["message"]}}</p>
            <h3>{{$post['tags']}}</h3>
            <div align="right"> <h3>avg rate= {{$post["rating"]}}</h3></div>
            <form id="support" method="post">
              @csrf
              <input type="number" id="money" name="money" style="width: 200px;height: 30px" maxlength="64"/>
           <input style="width: 100px;height: 30px" value="Pay" class="btn btn-primary btn-sm" onclick="support('money','<?=$post['id'] ?>')">              
          </form>
          <div id="paid" align="center"></div>
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
                	<div id="ratingval<?=$post['id'] ?>" style= "float: right; " align='right'>
                		{{$post["rating"]}}
                	</div>

                </div>

        
    </div>
@endforeach
@foreach ($sposts as $post)
    <div class="jumbotron">
        <h2>you posted</h2> 
            <p>{{$post["message"]}}</p>
            <h3>{{$post['tags']}}</h3>
            <div align="center"> <h3>earned money {{$post["money"]}}</h3></div>
            <div align="right"> <h3>avg rate= {{$post["rating"]}}</h3></div>
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
                       if(data[0] == "NULL") {
                       	html+="<h2> No Gamer Found</h2>";
                       }  
                       else
                       {
                        var link = "/gamingforum/gamerprofile/"+btoa(btoa(data[1]));
                        html += "<a href='"+link+"'>"+"<h2>"+data[0]+"</h2>"+"</a>";
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
<script type="text/javascript">
  function searchPosts(){
            var sendData = $("#searchTags").serialize();
        $.ajax({
                url: "/gamingforum/searchPosts",
                type: "post",
                data: sendData,
                success: function(data) {
                   var html = "";
                   for (var i = 0; i < data.length; i++) {
                       html+="<h2>"+data[i]["gamername"]+" has posted </h2><br><p>"+data[i]["message"]+"</p><br><h3>"+data[i]["tags"]+"</h3><br><p><img src='"+data[i]["postpath"]+"' class='img-responsive'></p><br>";
                   }
                   $("#posts").html(html);

                }
            });
        }
</script>
<script type="text/javascript">
  function support(money,postid){
    var money = $('#'+money).val()
        $.ajax({
                url: "/gamingforum/support",
                type: "post",
                data: {
                "_token": "{{ csrf_token() }}",
                "postid": postid,
                "money": money
                },
                success: function(data) {
                    var html = "";
                    html += "<h2>Paid successfully </h2>";
                    $("#paid").html(html);
                   }

        });
       }
</script>
</html>
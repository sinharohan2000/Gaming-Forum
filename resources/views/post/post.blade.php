 <!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Comment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
 <link rel="stylesheet" href="{{ asset('/resources/css/styles.css') }}">
   <link rel="icon" href="{{ asset('/resources/images/fav.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Monoton&family=Raleway:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <div class="fluid-cointainer">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/gamingforum/home">Pro-Gamers</a>
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
            <a class="dropdown-item" href="/gamingforum/update">Update Password</a>
            <a class="dropdown-item" href="/gamingforum/updateusername">Update Username</a>
            <a class="dropdown-item" href="/gamingforum/logout">Log OUt</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/notification">Notification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/chats">Chats</a>
        </li>
      </ul>
    </div>
  </nav>
    <div align="center">
      @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
      </div>
      <div align="center">
      @if(Session::has('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
        @endif
      </div>
  <div class="top-container">
    <div class="row">
      <div class="col-md-4" align="center">
        <br>
        <h3>{{$userdetail[0]['username']}}</h3>
        <img style="height: 250px; width: 250px;" class="rounded-circle" src="{{$userdetail[0]['profilepath']}}" class="card-img-top" alt="Img/vid that the user posted"><br><br>
      </div>
      <div class="col-7" align="center">
        <br>
        <br>
        <h2 align="center">Post</h2>
        <hr class="dotted">
        <br>
          <div class="card post" style="width: 40rem;">
            <div class="card-body">
              <h5 class="card-title" align="left">{{$post[0]['gamername']}} has posted.</h5>
              <p class="card-text">{{$post[0]['message']}}</p>
              <p class="card-text">{{$post[0]['tags']}}</p>
                <p class="card-text">Avrage rating of this post {{$post[0]['avgrating']}}⭐</p>
              <img src="{{$post[0]['postpath']}}" class="card-img-top" alt="Img/vid that the user posted">
            </div>
          </div>
          <form id="commentpost" method="post">
            @csrf
            <div class="card-body" align="center">
            <textarea name="comment" rows="2" cols="40" placeholder="Write A comment"></textarea>
            <input type="hidden" value="{{$post[0]['id']}}" name="postid">
            <input  class="btn btn-primary" type="login" value="Comment" onclick="comment11()">
          </div>   
        </form>
        <div id=comments align="left">
          
                @foreach ($comments as $comment)
                <strong align="left">{{$comment->gamername}}  </strong>
                <p>{{$comment->comment}}</p>
                @endforeach
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
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
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
                  if(data != 0)
                  {
                     var html = "";
                     html += "<strong>"+data[0]+"</strong>"+"<p>"+data[1]+"</p>";
                     $("#comments").prepend(html);
                  }
                  
                   }
        });
  }
</script>
</html>

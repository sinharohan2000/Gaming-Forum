<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('/resources/css/styles.css') }}">
  <link rel="icon" href="{{ asset('/resources/images/fav.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Monoton&family=Raleway:wght@500&display=swap" rel="stylesheet">

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
            <a class="dropdown-item" href="/gamingforum/logout">Log OUt</a>
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
  <div class="container">
    <div class="row">
      <div class="col-3" align="center">
        <br>
        <h3>{{$gamerdetail[0]['username']}}</h3>
        <img src="{{$gamerdetail[0]['profilepath']}}" class="card-img-top" alt="Img/vid that the user posted"><br><br>
        <h4>Followers   {{$followers}}</h4>
        <h4>Following   {{$followings}}</h4>
        @if($isFollowing)
        <h5>You are a follower</h5>
        @else
        <div id="followMessage"></div>
        <button id="follow" onclick="follow(<?= $gamerdetail[0]['id'] ?>)" class="btn btn-primary btn-sm">Follow</button>
        @endif
      </div>
      <div class="col-6" align="center">
        <br>
        <div class="col-md">
        </div>
        <br><br>
        <h2 align="center">Feed</h2>
        <hr class="dotted">
        <br>
        @if (count($posts) > 0)
          @foreach ($posts as $post)
             <div class="card post" style="width: 40rem;">
            
            <div class="card-body">
              <h5 class="card-title" align="left">{{$post['gamername']}} has posted.</h5>
              <p class="card-text">{{$post['message']}}</p>
              <p class="card-text">{{$post['tags']}}</p>
                <p class="card-text">Avgrage rating of this post {{$post['avgrating']}}⭐</p>
                <p class="card-text">You gave him <span id="star">{{$post['rating']}}</span>⭐</p>
                <span >Support</span>
                <input type="number" id="money" name="money" style="width: 100px;height: 30px"/>
                <input style="width: 100px;height: 30px" value="Pay" class="btn btn-primary btn-sm" onclick="support('money','<?=$post['id'] ?>')">
                <span id="paid" align="right" style="float: right"></span>
              <img src="{{$posts[0]['postpath']}}" class="card-img-top" alt="Img/vid that the user posted">
              <a href="comment/{{base64_encode(base64_encode($post['id']))}}" class="btn btn-primary">Comment</a>
              <a class="btn btn-primary dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Rate
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="javascript:void(0)" onclick="rating(1,<?= $post['id'];?>)" >⭐</a>
              <a class="dropdown-item" href="javascript:void(0)" onclick="rating(2,<?= $post['id'];?>)">⭐⭐</a>
              <a class="dropdown-item" href="javascript:void(0)" onclick="rating(3,<?= $post['id'];?>)">⭐⭐⭐</a>
              <a class="dropdown-item" href="javascript:void(0)" onclick="rating(4,<?= $post['id'];?>)">⭐⭐⭐⭐</a>
              <a class="dropdown-item" href="javascript:void(0)" onclick="rating(5,<?= $post['id'];?>)">⭐⭐⭐⭐⭐</a>
            </div>
          </div>
          @endforeach
        @else
            <div class="card-body">
              <p class="card-text">No Post available.</p>
        @endif
      </div>
      <br><br><br><br>
      <div class="col-3">
        <h2></h2>
      </div>
    </div>
  </div>
  <br><br>
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
                	$("#star").html(val);
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
                    html += "<h4>Paid successfully </h4>";
                    $("#paid").html(html);
                   }

        });
       }
</script>

<script type="text/javascript">
  function follow(id){
        $.ajax({
                url: "/gamingforum/follow",
                type: "post",
                data: {
                "_token": "{{ csrf_token() }}",
                "gamerid": btoa(btoa(id))
                },
                success: function(data) {
                	var html = "";
                    var html = "<h5>You are a follower</h5>";
                    $("#followMessage").html(html);
                    document.getElementById("follow").disabled = true;
                   }

        });
       }
</script>

</body>

</html>

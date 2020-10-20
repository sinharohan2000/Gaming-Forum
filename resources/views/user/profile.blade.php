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
          <a class="nav-link" href="/gamingforum/notification">Notification</a>
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
  <div class="container">
    <div class="row">
      <div class="col-3" align="center">
        <br>
        <h3>{{$userdetail[0]['username']}}</h3>
        <img style="height: 250px; width: 250px;" class="rounded-circle" src="{{$userdetail[0]['profilepath']}}" class="card-img-top" alt="Img/vid that the user posted"><br><br>
        <form method="post" action="/gamingforum/changeprofile" enctype="multipart/form-data">
          @csrf
          <strong>Change Profile Picture</strong>
          <input type="file" name="photo" id="photo">
          <input style="width: 100px;height: 30px" value="Upload" class="btn btn-primary btn-sm" type="submit">
        </form>
        <h4>Followers   {{$followers}}</h4>
        <h4>Following   {{$followings}}</h4>
      </div>
      <div class="col-6" align="center">
        <br>
        <br>
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
                 <p class="card-text"> Earned money from this post {{$post['money']}} </p>
                  <p class="card-text">Avrage rating of this post {{$post['rating']}}⭐</p>
                <img src="{{$posts[0]['postpath']}}" class="card-img-top" alt="Img/vid that the user posted">
                <a href="post/{{base64_encode(base64_encode($post['id']))}}" class="btn btn-primary">Comment</a>
              </div>
              <br><br>
              </div>
          
          @endforeach
          <br><br>
        @else
            <div class="card-body">
              <p class="card-text">No Post available.</p>
            </div>
        @endif
        <br><br>
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
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>

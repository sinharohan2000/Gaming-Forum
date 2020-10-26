<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Chats</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('/resources/css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('/resources/css/chats.css') }}">
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
            <a class="dropdown-item" href="/gamingforum/logout">Log Out</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/notification">Notification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/profile">Profile</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-3" align="center">
        <br>
        <h3>{{$userdetail[0]['username']}}</h3>
        <img style="height: 250px; width: 250px;" class="rounded-circle" src="{{$userdetail[0]['profilepath']}}" class="card-img-top" alt="Img/vid that the user posted"><br><br>
      </div>
      <div class="col-6" align="center">
        <br>
        <h2 align="center">Chats</h2>
        <hr class="dotted">
        <br>
          <?php
            if(count($gamerdetails) > 0){
            foreach ($gamerdetails as $gamerdetail){
            ?>
            <div class="card post" style="width: 35rem;">
               <div class="card-body">
                <img class="profile-image" src="{{$gamerdetail['profilepath']}}" alt="profile-img">
                <span align="left" style="margin-bottom:0px"><a style = "color: black;" href="/gamingforum/chat/{{base64_encode(base64_encode($gamerdetail['id']))}}">{{$gamerdetail['username']}}</a></span>
               </div>
            </div>
              <?php }
              } else{ 
              ?>
              <div class="card post" style="width: 35rem;">
                <div class="card-body">
                <p align="left" style="margin-bottom:0px">No Chats available.</p>
                </div>
              </div>
              <?php
              }
            ?>
      </div>
      <div class="col-3">
        <div>
          <input  type="search" placeholder="Search" aria-label="Search" id = "search" style="height: 38px; width: 180px;border: solid;border-radius: 0px;">
          <button type="button" class=" btn-secondary" id = "submit" onclick="search()">Search Chat</button>
        </div>
        <div id = "user"></div>
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
<script>
    var input = document.getElementById("search");
    input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("submit").click();
    }
  });
  </script>
  <script type="text/javascript">

  function search(){
      $("#user").html();
      var html = "";
    var search = $('#search').val();
    if(search.length > 5){
        $.ajax({
                    url: "/gamingforum/search",
                    type: "post",
                    data: {
                    "_token": "{{ csrf_token() }}",
                    "search": search
                    },
                    success: function(data) 
                    {
                      if(data['gamername'].length == 0)
                      {
                        html = "<br><p> No User Found</p>";
                      } 
                      else
                      {
                        var link = btoa(btoa(data['gamername'][0]['id']));
                        html = "<br>"+data['gamername'][0]['username']+" <a style = 'color:black;' href='/gamingforum/chat/"+link+"'>Chat</a><br><br>";
                      }
                    $("#user").html(html);
                           
                   }
            });
      }
  }
</script>
</html>

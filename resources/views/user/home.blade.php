<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script type="text/javascript" src="{ { asset('/resources/js/tagsinput.js') }}"></script>
  <link href="{{ asset('/resources/css/tagsinput.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/resources/css/styles.css') }}">
  <link rel="icon" href="favicon (2).ico">
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
            <a class="dropdown-item" href="/gamingforum/update">Update Password</a>
            <a class="dropdown-item" href="/gamingforum/updateusername">Update Username</a>
            <a class="dropdown-item" href="/gamingforum/logout">Log Out</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/notification">Notification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gamingforum/chats">Chats</a>
        </li>
      </ul>
        <div class="input-group" style="text-align: right; display: inline-block;">
          <input  type="search" placeholder="Search" aria-label="Search" id = "search" style="height: 38px; width: 180px;">
          <button class="btn btn-outline-success my-2 my-sm-0 mr-sm-3 " id = "submit" onclick="search()">Search Gamers/Tags</button>
        </div>
    </div>
  </nav>
  <div class="container" class="container">
    @if(Session::has('fail'))
        <div class="alert alert-danger" align="center">
            {{ Session::get('fail') }}
            @endif
        </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-3" align="center">
        <br>
        <h3>{{$userdetail[0]['username']}}</h3>
        <img style="height: 250px; width: 250px;" class="rounded-circle" src="{{$userdetail[0]['profilepath']}}" class="card-img-top" alt="Img/vid that the user posted"><br><br>
      </div>
      <div class="col-6" align="center">
        <br>
        <div class="col-md">
          <form action="uppost" method="POST" enctype="multipart/form-data">
            @csrf
          <h4>What's on your mind?</h4>
          <textarea name="textarea" placeholder="Write the way you feel" rows="2" id="textarea"></textarea>
          <br>
           Tags:</br>
          <input type="text" name="tags" data-role="tagsinput" id="tags"></br>
            Select image to upload:
            <br>
            <input type="file" name="photo" id="photo">
          </br>
            <input type="submit" value="Upload" name="submit">
          </form>
        </div>
        <br><br>
        <h2 align="center">Feed</h2>
        <hr class="dotted">
        <br>
        @if (count($posts) > 0)
          @foreach ($posts as $post)
             <div class="card post" style="width: 40rem;">
            
            <div class="card-body">
              <h5 class="card-title" align="left">{{$post['gamername']}} has posted. <span style="float: right;">{{$post['created_at']}}</span></h5>
              <p class="card-text">{{$post['message']}}</p>
              <p class="card-text">{{$post['tags']}}</p>
                <p class="card-text">Avgrage rating of this post {{$post['avgrating']}}⭐</p>
                <p class="card-text">You gave him <span id="star<?=$post['id'] ?>">{{$post['rating']}}</span>⭐</p>
                <span >Support</span>
                <input type="number" id="money<?=$post['id'] ?>" name="money" style="width: 100px;height: 30px"/>
                <input style="width: 100px;height: 30px" value="Pay" class="btn btn-primary btn-sm" onclick="support('money','<?=$post['id'] ?>')">
                <span id="paid<?=$post['id'] ?>" align="right" style="float: right"></span>
              <img src="{{$post['postpath']}}" class="card-img-top" alt="Img/vid that the user posted">
              <a href="post/{{base64_encode(base64_encode($post['id']))}}" class="btn btn-primary">Comment</a>
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
        </div>
          @endforeach
        @else
            <div class="card-body">
              <p class="card-text">No Post available.</p>
             </div>  
        @endif
        <br>
        </div>
        <div class="col-3">
          <div id="user"></div>
          <div id="post"></div>
        </div>
      </div>
      <br><br><br><br>
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
  $('#tags').tagsinput({
   trimValue: true
    });
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
                  $("#star"+postid).text(val);
                   }
        });
    }
  </script>
  <script type="text/javascript">
  function support(money,postid){
    var money = $('#'+money+postid).val();
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
                    if(data == 1)
                    {
                      html += "<h4>Paid successfully </h4>";
                    }
                    else
                    {
                      html += "<h4>encountered some error </h4>";
                    }
                    $("#paid"+postid).html(html);
                   }

        });
       }
</script>
<script type="text/javascript">

  function search(){
      $("#user").html();
      $("#post").html();
      var html = "";
      var html1 = "";
    var search = $('#search').val();
    if(search.length > 2)
    {
    $.ajax({
                url: "/gamingforum/search",
                type: "post",
                data: {
                "_token": "{{ csrf_token() }}",
                "search": search
                },
                success: function(data) {
                  if(data['gamername'].length == 0){
                     html = "<br><br><p> No User Found</p>";
                  } else{
                         html = "<br><br><p>User found</p>"
                        var link = btoa(btoa(data['gamername'][0]['id']));
                        html += data['gamername'][0]['username']+" Go to <a href='/gamingforum/gamerprofile/"+link+"'>Profile</a><br><br>";
                }
                  
                  if(data['posts'].length == 0){
                        html1 += "<br><br><p> No Post Found with this tag</p><br>";
                  } else{
                        var i;
                        html1 += "tag "+search+" is found in following posts.<br><br>";
                        for (i = 0; i < data['posts'].length; i++) {
                          var link = btoa(btoa(data['posts'][i]['id']));
                              html1 += "<strong>"+data['posts'][i]['gamername']+"</strong> Go to gamer's <a href='/gamingforum/post/"+link+"'>Post</a><br>";
                          }
                      }

                       $("#user").html(html);
                       $("#post").html(html1);
                       
                   }
        });
    }
  }
</script>
</html>
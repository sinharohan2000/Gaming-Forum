<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Sign-up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
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
        <li class="nav-item active">
          <a class="nav-link" href="opening-page.html">Home <span class="sr-only">(current)</span></a>
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
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a><!-- TODO: Add Link -->
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <div class="input-group">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0 " type="submit">Search</button>
        </div>
      </form>
      <!--<button class="btn btn-outline-success my-2 my-sm-0 Login" type="submit"><a href="login.html">login </a></button></button> -->
    </div>
  </nav>

  <div class="top-container">
    <center>
      <h1>Sign-Up</h1><br>
    </center>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
      </div>
      <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1"><img class="username" src="images\user.png" alt="user-logo"></span>
      </div>
      <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1"><img class="username" src="images\key.png" alt="key-logo"></span>
      </div>
      <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
    </div>

    <center>
      <input  class="btn btn-primary" type="submit" value="Submit">
      <br>
      Already have an accout? <a href="login.html">Login</a>
    </center>

  </div>


  <div class="bottom-container">
    <center>
      <a class="footer-link" href="https://www.linkedin.com/"><img class="facebook" src="images\linkedin.png" alt="linkedin-logo"></a>
      <a class="footer-link" href="https://www.facebook.com/"> <img class="facebook" src="images\facebook.png" alt="facebook-logo"></a>
      <a class="footer-link" href="https://www.youtube.com/"> <img class="facebook" src="images\youtube.png" alt="youtube-logo"></a>
    </center>
    <br>
    <p class="end">© 2020 eCode.js</p>
  </div>



  <!-- Optional JavaScript -->
  <!-- TODO:  -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- TODO:  -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>

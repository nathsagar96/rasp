<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">RaSP</a>
      </div>
      <div class="collapse navbar-collapse" id="Navbar">
        <ul class="nav navbar-nav">
          <li><a>Welcome <strong><?php echo $_SESSION['username'];?></strong></a></li>
          <li class="active"><a href="home.php">Home</a></li>
          <li><a href="sessions.php">Login Sessions</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container">
    <div class="filemanager">
      <div class="search">
        <input type="search" placeholder="Find a file.." />
      </div>
      <div class="breadcrumbs"></div>
      <ul class="data"></ul>
      <div class="nothingfound">
        <div class="nofiles"></div>
        <span>No files here.</span>
      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>

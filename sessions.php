<?php
//All Users Page

require_once 'config.php';
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sessions</title>

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
          <?php
          if ($_SESSION['role']==1) {
            echo '<li><a href="dashboard.php">Dashboard</a></li>';
            echo '<li><a href="users.php">All Users</a></li>';
          }else {
            echo '<li><a>Welcome <strong>'.$_SESSION['username'].'</strong></a></li>';
            echo '<li><a href="home.php">Home</a></li>';
          }
          ?>
          <li class="active"><a href="sessions.php">Login Sessions</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="session table-responsive">
    <table class="table table-hover">
    <?php
    $i=1;
    if($_SESSION['role'] != 1){
      echo "<thead><th>#</th><th>Date & Time</th><th>IP Address</th></thead><tbody>";
      $sql = "SELECT time,ip_add FROM sessions WHERE username = :username ORDER BY time DESC";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
      $param_username = trim($_SESSION["username"]);
      $stmt->execute();

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $datetime = $row['time'];
        $ipadd = $row['ip_add'];

        echo "<tr>";
        echo "<td>";echo $i; echo "</td>";
        echo "<td>";echo $datetime;echo "</td>";
        echo "<td>";echo $ipadd;echo "</td>";
        echo "</tr>";

        $i++;
      }
      echo "</tbody>";
      unset($stmt);
      unset($pdo);
    }else{
      echo "<thead><th>#</th><th>Username</th><th>Date & Time</th><th>IP Address</th></thead><tbody>";
      $sql = "SELECT username,time,ip_add FROM sessions WHERE username <> :username ORDER BY time DESC";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
      $param_username = $_SESSION["username"];
      $stmt->execute();

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $datetime = $row['time'];
        $ipadd = $row['ip_add'];

        echo "<tr>";
        echo "<td>";echo $i; echo "</td>";
        echo "<td>";echo $username; echo "</td>";
        echo "<td>";echo $datetime;echo "</td>";
        echo "<td>";echo $ipadd;echo "</td>";
        echo "</tr>";

        $i++;
      }
      echo "</tbody>";
      unset($result);
      unset($link);
    }
    ?>
    </table>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>

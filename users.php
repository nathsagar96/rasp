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

  <title>All Users</title>

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
          <li><a href="dashboard.php">Dashboard</a></li>
          <li class="active"><a href="users.php">All Users</a></li>
          <li><a href="sessions.php">Login Sessions</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="user table-responsive">
    <table class="table table-hover">
      <thead>
        <th>#</th>
        <th>Username</th>
        <th>Role</th>
        <th>Status</th>
        <th>Actions</th>
      </thead>
      <tbody>
        <?php
        $i=1;
        $sql = "SELECT id,username,role,status FROM users";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $username = $row['username'];
          $id = $row['id'];
          if ($row['status']==1) {
            $status = 'activated';
          }else{
            $status = 'not activated';
          }
          if ($row['role']==1) {
            $role = 'Admin';
          }else{
            $role = 'User';
          }
          echo "<tr>";echo "<td>";echo $i; echo "</td>";
          echo "<td>";echo $username;echo "</td>";
          echo "<td>";echo $role;echo "</td>";
          echo "<td>";echo $status;echo "</td>";
          echo "<td>";
          echo "<a href='activate.php?id=". $row['id'] ."'>";
          echo '<span class="glyphicon glyphicon-ok"></span>  </a>';
          echo "<a href='block.php?id=". $row['id'] ."'>";
          echo '<span class="glyphicon glyphicon-remove"></span>  </a>';
          echo "<a href='delete.php?id=". $row['id'] ."'>";
          echo '<span class="glyphicon glyphicon-trash"></span> </a>';
          $i++;
        }
        unset($stmt);
        unset($pdo);
        ?>
      </tbody>
    </table>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>

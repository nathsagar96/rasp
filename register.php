<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate username
  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
  } else{
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = :username";

    if($stmt = $pdo->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);

      // Set parameters
      $param_username = trim($_POST["username"]);

      // Attempt to execute the prepared statement
      if($stmt->execute()){
        if($stmt->rowCount() == 1){
          $username_err = "This username is already taken.";
        } else{
          $username = trim($_POST["username"]);
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    unset($stmt);
  }

  // Validate password
  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
  } elseif(strlen(trim($_POST['password'])) < 6){
    $password_err = "Password must have atleast 6 characters.";
  } else{
    $password = trim($_POST['password']);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = 'Please confirm password.';
  } else{
    $confirm_password = trim($_POST['confirm_password']);
    if($password != $confirm_password){
      $confirm_password_err = 'Password did not match.';
    }
  }

  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

    if($stmt = $pdo->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
      $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);

      // Set parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

      // Attempt to execute the prepared statement
      if($stmt->execute()){
        // Redirect to login page
        header("location: index.php");
      } else{
        echo "Something went wrong. Please try again later.";
      }
    }

    // Close statement
    unset($stmt);
  }

  // Close connection
  unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>RaSP</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row register">
      <div class="col-sm-6">
        <center><img src="images/logo.png" class="img-responsive" alt="logo"></center>
      </div>
      <div class="col-sm-6">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username:<sup>*</sup></label>
            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password:<sup>*</sup></label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password:<sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
          </div>
          <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
      </div>
    </div>
  </div>
  
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
       //ip from share internet
       $ip = $_SERVER['HTTP_CLIENT_IP'];
   }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
       //ip pass from proxy
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
   }else{
       $ip = $_SERVER['REMOTE_ADDR'];
   }

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                    if($row = $stmt->fetch()){
                        $hashed_password = $row['password'];
                        $role = $row['role'];
                        $status = $row['status'];
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            $sql = "INSERT INTO sessions (username, ip_add) VALUES (:username, :ipaddress)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
                            $stmt->bindParam(':ipaddress', $param_ip, PDO::PARAM_STR);
                            $param_username = $username;
                            $param_ip = $ip;
                            $stmt->execute();

                            if ($role == 0) {

                              if ($status !=0) {
                                session_start();
                                $_SESSION['username'] = $username;
                                header("location: home.php");
                              }else {
                                $username_err = "Ask Admin to activate Account";
                              }

                            }else {
                              session_start();
                              $_SESSION['username'] = $username;
                              header("location: dashboard.php");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                 else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>

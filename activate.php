<?php
//Activate User Account

if(!empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';
    // Prepare a delete statement
    $sql = "UPDATE users SET status = 1 WHERE id = :id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id',$param_id,PDO::PARAM_STR);
        // Set parameters
        $param_id = trim($_GET["id"]);
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: users.php");
            exit();
        } else{
            echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
        }

    }
    // Close statement
    unset($stmt);
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter.
        //Show Error
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
        exit();
    }
}
?>

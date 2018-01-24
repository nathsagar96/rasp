<?php
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("sqlite:C:\\sqlite\\rasp.db");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

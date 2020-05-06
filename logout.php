<?php
session_start();
  
require_once 'DBConnect.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);
$userName =  $_SESSION['username']; 

$dateTime = date("Y-m-d h:i:sa");
$query  = "update logtracking set logouttime = '$dateTime' WHERE username='$userName'";

    $result1 = $connection->query($query);
    if (!$result1) die ("Database access failed: " . $connection->error);
    else
    echo $userName." logged out succesfully!";
    session_unset();
    session_destroy();
    ob_start();
    //header("location:login.php");
    ob_end_flush(); 
    //include 'home.php';
    exit();    
?>
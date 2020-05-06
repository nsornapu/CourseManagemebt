<?php //setupusers.php
  require_once 'DBConnect.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connection->connect_error) die($connection->connect_error);

  $query = "CREATE TABLE users (
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(150) NOT NULL,
    createdDate datetime not null
  )";
  $result = $connection->query($query);
  if (!$result) die($connection->error);

  $salt1    = "qm&h*";
  $salt2    = "pg!@";

  $username = 'Naresh';
  $password = 'user';
  $d=mktime(11, 14, 54, 8, 12, 2014); 

  $dateTime = date("Y-m-d h:i:sa", $d);
  $token    = hash('sha512', "$salt1$password$salt2");
  //echo $token."<br>";

  add_user($username, $token, $dateTime);

  $username = 'user2';
  $password = 'user';
  $dateTime = date("Y-m-d h:i:sa", $d);
  $token    = hash('sha512', "$salt1$password$salt2");
  //echo $token."<br>";

  add_user($username, $token, $dateTime);

  function add_user( $un, $pw, $tm)
  {
    global $connection;

    $query  = "INSERT INTO users VALUES('$un', '$pw', '$tm')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>
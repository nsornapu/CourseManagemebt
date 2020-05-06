<?php // authenticate.php
session_start();
  
  require_once 'DBConnect.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connection->connect_error) die($connection->connect_error);

  if (isset($_SERVER['PHP_AUTH_USER']) &&
      isset($_SERVER['PHP_AUTH_PW']))
  {
    
    $un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
    $password = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);
    $_SESSION['username'] = $un_temp;
    $query  = "SELECT * FROM users WHERE username='$un_temp'";

    $result1 = $connection->query($query);

  
    if (!$result1) die ("Database access failed: " . $connection->error);

    elseif ($result1->num_rows)
    {
        $row1 = $result1->fetch_array(MYSQLI_NUM);
        
        $result1->close();
      if(isset($row1[0])){
        $salt1 = "qm&h*";
        $salt2 = "pg!@";
        //$token = hash('sha512', "$salt1$pw_temp$salt2");
        $token    = hash('sha512', "$salt1$password$salt2");
        //echo $row1[1]."<br>";
        //echo $token."<br>";

        if ($token == $row1[1]){ 
          $dateTime = date("Y-m-d h:i:sa");
          $queryLogIN  = "INSERT INTO logtracking(userName,loginTime) values ('$un_temp','$dateTime');";
          $result1 = $connection->query($queryLogIN);
          echo "$row1[0] : 
          Hi $row1[0], you are now logged in ";
          header('Location: index.php');
          exit;

        }
        else die("Invalid username/password combination");
    }
  }
    else die("Invalid username/password combination");
  }
  else
  {
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Please enter your username and password");
  }

  $connection->close();

  function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }
?>
<?php

// Inialize session

session_start();

?>
<html>
 
 
 
<head>
 
   <!--<title>Live Search using AJAX</title>-->
 
   <!-- Including jQuery is required. -->
 
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 
   <!-- Including our scripting file. -->
 
   <script type="text/javascript" src="script.js"></script>
 
   <!-- Including CSS file. -->
 
   <!--<link rel="stylesheet" type="text/css" href="style.css">-->

   
 
</head>
 
 
 
<body>
 
<h2> 
        This is secured page with session: <b>
        <?php 
        
        echo $_SESSION['username']; 
        ?>
        </b>
         </h2>
         
        <div>
        <form action="logout.php"  method="post">	
            <input type="submit" style=" background-color:rgb(76, 199, 178); float: right;" value="logout">
        </form>
<!-- Search box. -->
 
   <input type="text" id="search" placeholder="Search" />

 
   <!-- Suggestions will be displayed in below div. -->
 
   <div id="display"></div>
 
 
 
</body>
 
 
 
</html>

<?php // mysqlitest.php
  require_once 'DBConnect.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connection->connect_error) die($connection->connect_error);

 //--------------------------------------------------------------suggestion-----------------------------------------------------
    //Including Database configuration file.

    //Getting value of "search" variable from "script.js".
     
    if (isset($_POST['search'])) {
     
    //Search box value assigning to $Name variable.
     
       $Name = $_POST['search'];
     
    //Search query.
     
       $query = "SELECT coursename,courses.courseaddress,coursehours,coursedescription, courseprereqs FROM courses, prereqs WHERE (coursename LIKE '%$Name%' OR courses.courseaddress LIKE '%$Name%' OR courseprereqs like '%$Name%') and (courses.courseaddress = prereqs.courseaddress) LIMIT 5 ";
     
    //Query execution
     
    $result = $connection->query($query);
    $rows = $result->num_rows;

    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);
     echo  $row[0];
      echo <<<_END
    <pre>
    <table style="border-collapse: collapse;width: 100%;border: 1px solid black;">
    <th style="border: 1px solid black;">
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course name  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course title  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course hours  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course description  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course prereqs  </td>
    </th>
    <tr>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $j  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[0]  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[1]  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[2]  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[3]  </td>
    <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[4]  </td>

    </tr>
    </table>
    </pre>
  
  
_END;
   
    }
  } 

    //---------------------------------------------------------------delete---------------------------------------------------------
  if (isset($_POST['delete']) && isset($_POST['courseAddress']))
  {
    $courseAddress   = get_post($connection, 'courseAddress');
    $query  = "DELETE FROM courses WHERE courseaddress ='$courseAddress'";
    $result = $connection->query($query);

  	if (!$result) echo "DELETE failed: $query<br>" .
      $connection->error . "<br><br>";
  }

  //---------------------------------------------------------------update---------------------------------------------------------
  if (
    isset($_POST['courseaddress']) &&
      isset($_POST['coursename']) &&
      isset($_POST['coursehours']) &&
      isset($_POST['courseDescription'])     &&
      isset($_POST['update'])
      )
  {
    $coursename = get_post($connection,'coursename');
    $courseaddress = get_post($connection,'courseaddress');
    $coursehours   = get_post($connection, 'coursehours');
    $courseDescription   = get_post($connection, 'courseDescription');
    $dateTime = date("Y-m-d h:i:sa");
    $query  = "UPDATE courses SET coursename='".$coursename."', coursehours = '".$coursehours."',courseDescription = '".$courseDescription."', updated_at = '".$dateTime."' where courseaddress = '".$courseaddress."'";
    //echo $query;
    $result = $connection->query($query);
  	if (!$result) echo "UPDATE failed: $query<br>" .
      $connection->error . "<br><br>";
  }

  //---------------------------------------------------------------insert---------------------------------------------------------
  if (isset($_POST['courseaddress'])    &&
      isset($_POST['coursename']) &&
      isset($_POST['coursehours'])     &&
      isset($_POST['courseDescription'])     &&
      isset($_POST['add'])
      )
  {
    $query  = "select count(*) from courses";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    $id = 0;
    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);
      $id = $row[0]+1;
    }
    //echo $id;
    $coursename = get_post($connection,'coursename');
    $courseaddress = get_post($connection,'courseaddress');
    $coursehours   = get_post($connection, 'coursehours');
    $courseDescription   = get_post($connection, 'courseDescription');
    $dateTime = date("Y-m-d h:i:sa");
    $query    = "INSERT INTO courses (id,coursename,courseaddress,coursehours,courseDescription,created_at, updated_at) VALUES" .
      "('$id','$coursename', '$courseaddress', '$coursehours','$courseDescription', '$dateTime', '$dateTime')";
    $result   = mysqli_query($connection,$query);

  	if (!$result) echo "INSERT failed: $query<br>" .
      $connection->error . "<br><br>";
  }

  echo <<<_END
  <form action="part2.php" method="post"><pre>
    Course Name <input type="text" name="coursename">
    Course Title <input type="text" name="courseaddress">
    Course Hours <input type="text" name="coursehours">
    Course Description <input type="text" name="courseDescription">
    <input type="submit" name="add" value="ADD RECORD">
    <input type="submit" name="update" value="UPDATE RECORD">
  </pre></form>

_END;


//---------------------------------------------------------------show all---------------------------------------------------------

  $query  = "SELECT * FROM courses";
  $result = $connection->query($query);

  if (!$result) die ("Database access failed: " . $connection->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
  <pre>
  <table style="border-collapse: collapse;width: 100%;border: 1px solid black;">
  <th style="border: 1px solid black;">
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course name  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course title  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course hours  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course description  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course creation time  </td>
  </th>
  <tr>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[0]  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[1]  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[2]  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[3]  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[4]  </td>
  <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $row[5]  </td>
  </tr>
  </table>
  </pre>
  <form action="part2.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="courseAddress" value="$row[1]">
  <input type="submit" value="DELETE RECORD">
  </form>


_END;
  }
  
  
  $result->close();
  $connection->close();
  
  function get_post($connection, $var)
  {
    return $connection->real_escape_string($_POST[$var]);
  }
?>

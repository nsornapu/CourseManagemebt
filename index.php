<?php

// Inialize session

session_start();

?>
<html>
    <head lang="en">
        <meta charset="utf-8">
        <title>Home Page</title>
        <link rel="stylesheet" href="main.css" />
    </head>
    <body style="margin: black">
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
        <br>
        <form action="convertToHtml.php"  method="post">	
            <input type="submit" style=" background-color:rgb(76, 199, 178);" value="ConvertToHtml">
        </form>
        <br>
        <form action="convertToXml.php"  method="post">	
            <input type="submit" style=" background-color:rgb(76, 199, 178);" value="convertToXml">
        </form>
        <br>
        <form action="convertToSql.php"  method="post">	
            <input type="submit" style="background-color:rgb(76, 199, 178);" value="convertToSql">
        </form>
        <br>
        <form action="convertToPhp.php"  method="post">	
            <input type="submit" style="background-color:rgb(76, 199, 178);" value="convertToPhp">
        </form>
        <br>
        <form action="convertToJson.php"  method="post">	
            <input type="submit" style="background-color:rgb(76, 199, 178);" value="convertToJson">
        </form>
        <br>
    </div>
    <div>
        <form action="part2.php"  method="post">	
            <input type="submit" style="background-color:rgb(76, 199, 178);" value="part2">
        </form>
        <br>
    </div>
    <div>
        <form action="part3.php"  method="post">	
            <input type="submit" style="background-color:rgb(76, 199, 178);" value="part3">
        </form>
        <br>
    </div>
        <br>
        <br>
        <br>
        <br>
    </body>
</html>
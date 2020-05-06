<?php
    include "scraper_CSDEPT.php";
    $myfile = fopen(".\data\course1.sql", "w");
    $packtPage = scrape_CSCatalog("file:///C:/xampp/htdocs/assignment3/utd%20cs%20course%202018%20catalog.html");
    //print_r( $packtPage);
    $sqlData = 'CREATE TABLE courses (
        id int(11) NOT NULL AUTO_INCREMENT,
        CourseAddress varchar(255)  DEFAULT NULL,
        CourseName varchar(255)  DEFAULT NULL,
        CourseHours varchar(50)  DEFAULT NULL,
        CourseDescription text ,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY (id)
      ); 
      CREATE TABLE prereqs (
        CourseAddress varchar(255)  DEFAULT NULL,
        CoursePrereqs varchar(255)  DEFAULT NULL
      ); 
      ';
    fwrite($myfile, $sqlData); 
    for  ($i = 0; $i < count($packtPage); $i++)
    {
        $sqlData2 = "INSERT INTO courses VALUES (";
        fwrite($myfile, $sqlData2);
        fwrite($myfile, $i+1);
        fwrite($myfile, ",'");
        fwrite($myfile, $packtPage[$i]["course_address"]);
        fwrite($myfile, "','");
        fwrite($myfile, $packtPage[$i]["course_title"]);
        fwrite($myfile, "','");
        fwrite($myfile, $packtPage[$i]["course_hours"]);
        fwrite($myfile, "','");
        $packtPage[$i]["course_des"] = str_replace("'"," ",$packtPage[$i]["course_des"]);
        $packtPage[$i]["course_des"] = str_replace('"',' ',$packtPage[$i]["course_des"]);
        fwrite($myfile, $packtPage[$i]["course_des"]);
        fwrite($myfile, "','");
        $dateTime = date("Y-m-d h:i:sa");
        fwrite($myfile, $dateTime);
        fwrite($myfile, "','");
        fwrite($myfile, $dateTime);
        fwrite($myfile, "');
        ");
        $sqlData2 = "INSERT INTO prereqs VALUES ('";
        fwrite($myfile, $sqlData2);
        fwrite($myfile, $packtPage[$i]["course_address"]);
        fwrite($myfile, "','");
        fwrite($myfile, $packtPage[$i]["course_prereq"]);
        fwrite($myfile, "');
        ");
        }
    fclose($myfile);    
?>

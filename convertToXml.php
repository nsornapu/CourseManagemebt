<?php
    include "scraper_CSDEPT.php";
    $myfile = fopen(".\data\course1.xml", "w");
    $packtPage = scrape_CSCatalog("file:///C:/xampp/htdocs/assignment3/utd%20cs%20course%202018%20catalog.html");
    //print_r( $packtPage);
    $xmlData = '<?xml version="1.0" encoding="UTF-8"?>
        <courses>';
    fwrite($myfile, $xmlData); 
    echo count($packtPage);
    for  ($i = 0; $i < count($packtPage); $i++)
    {

        fwrite($myfile, '<course>');
        fwrite($myfile, '<CourseAddress>');
        fwrite($myfile, $packtPage[$i]["course_address"]);
        //echo $row[0];
        fwrite($myfile, '</CourseAddress>');
        fwrite($myfile, '<CourseName>');
        fwrite($myfile, $packtPage[$i]["course_title"]);
        fwrite($myfile, '</CourseName>');
        fwrite($myfile, '<CourseHours>');
        fwrite($myfile, $packtPage[$i]["course_hours"]);
        fwrite($myfile, '</CourseHours>');
        fwrite($myfile, '<CourseDescription>');
        fwrite($myfile, $packtPage[$i]["course_des"]);
        fwrite($myfile, '</CourseDescription>');
        fwrite($myfile, '<CoursePrereqs>');
        fwrite($myfile, $packtPage[$i]["course_prereq"]);
        fwrite($myfile, '</CoursePrereqs>');
        fwrite($myfile, '</course>');
        }
        

    $xmlEndData = '</courses>';
    fwrite($myfile, $xmlEndData);
    fclose($myfile);    
?>

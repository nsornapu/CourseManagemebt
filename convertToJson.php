<?php
    include "scraper_CSDEPT.php";
    $myfile = fopen(".\data\course1.json", "w");
    $packtPage = scrape_CSCatalog("file:///C:/xampp/htdocs/assignment3/utd%20cs%20course%202018%20catalog.html");
    //print_r( $packtPage);
    //echo count($packtPage);
    fwrite($myfile, '[');
    for  ($i = 0; $i < count($packtPage); $i++)
    {

        fwrite($myfile, '{');
        fwrite($myfile, '"CourseAddress":"');
        fwrite($myfile, $packtPage[$i]["course_address"]);
        fwrite($myfile, '",');
        fwrite($myfile, '"CourseName":"');
        fwrite($myfile, $packtPage[$i]["course_title"]);
        fwrite($myfile, '",');
        fwrite($myfile, '"CourseHours":"');
        fwrite($myfile, $packtPage[$i]["course_hours"]);
        fwrite($myfile, '",');
        fwrite($myfile, '"CourseDescription":"');
        //fwrite($myfile, $packtPage[$i]["course_des"]);
        fwrite($myfile, '",');
        fwrite($myfile, '"CoursePrereqs":"');
        fwrite($myfile, $packtPage[$i]["course_prereq"]);
        if ($i == count($packtPage)-1){
            fwrite($myfile, '"}');
        }
        else {
            fwrite($myfile, '"},');
        }
        }
        


    fwrite($myfile, ']');
    fclose($myfile);    
?>

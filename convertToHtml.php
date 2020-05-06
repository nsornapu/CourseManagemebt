<?php
    include "scraper_CSDEPT.php";
    $myfile = fopen(".\data\course1.html", "w");
    //$packtPage = scrape_CSCatalog("https://catalog.utdallas.edu/2018/graduate/courses/cs");
    $packtPage = scrape_CSCatalog('file:///C:/xampp/htdocs/assignment3/utd%20cs%20course%202018%20catalog.html');
    //print_r( $packtPage);
    $htmlData = '<!doctype html>
    <html>
        <head lang="en">
            <meta charset="utf-8">
            <title>Home Page</title>
            <link rel="stylesheet" href="main.css" />
        </head>
        <body>
                <input type="button" class="convertClass" style="float: right; background-color:rgb(76, 199, 178);" value="LOGOUT">
            <br>
            <br>
            <br>
            <br>
            <table style =" border: 1px solid black;">
            <th>
                <tr>Course Address</tr>
                <tr>Course Name</tr>
                <tr>Course hours</tr>
                <tr>Course description</tr>
                <tr>Course prereqs</tr>
                
            </th>'
            ;
    fwrite($myfile, $htmlData); 
    foreach ($packtPage as $row){
        fwrite($myfile, '<tr>');
        foreach ($row as $column){
            fwrite($myfile, '<td>');
            fwrite($myfile, $column);
            fwrite($myfile, '</td>');
        }
        fwrite($myfile, '</tr>');
    }
    $htmlEndData = '    </body>
    </html>';
    fwrite($myfile, $htmlEndData);
    fclose($myfile);    
?>

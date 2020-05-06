<?php
    include "scraper_CSDEPT.php";
    $myfile = fopen(".\data\course1.php", "w");
    $packtPage = scrape_CSCatalog("file:///C:/xampp/htdocs/assignment3/utd%20cs%20course%202018%20catalog.html");
    //print_r( $packtPage);
    $phpData = '<?php
    ';
    
    fwrite($myfile, $phpData); 
   
    fwrite($myfile, print_r($packtPage, TRUE));
    $phpEndData = '
    ?>';
    fwrite($myfile, $phpEndData);
    fclose($myfile);    
?>

<?php

// Inialize session

session_start();

?>
<html>
<head>
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","part3.php?q="+str,true);
  xmlhttp.send();
}
</script>
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
<form>
<input type="text" size="30" onkeyup="showResult(this.value)">
<div id="livesearch"></div>
</form>

</body>
</html>


<?php
libxml_disable_entity_loader(false);
require_once 'DBConnect.php';


if (file_exists('data/course1.xml')) {
    $xml = new DomDocument("1.0","UTF-8");
    $xml->load('data/course1.xml');  
    }
    //print_r($xml);
   // echo count($xml[2]);
    else {
    exit('Failed to open data/course1.xml.');
}

//=====================================================AJAX LIVE SEARCH======================================



$x=$xml->getElementsByTagName('course');

//get the q parameter from URL
//$q=$_GET["q"];
$q = $_GET['q'];
$hint="";
//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('CourseName');
    $z=$x->item($i)->getElementsByTagName('CourseAddress');
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='" . 
          $z->item(0)->childNodes->item(0)->nodeValue . 
          "' target='_blank'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<br /><a href='" . 
          $z->item(0)->childNodes->item(0)->nodeValue . 
          "' target='_blank'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//output the response
echo $response;


//-------------------------------------ADD RECORDS----------------------------------------------------------------
echo <<<_END
<form action="part3.php" method="post"><pre>
  Course Name <input type="text" name="coursename">
  Course Title <input type="text" name="courseaddress">
  Course Hours <input type="text" name="coursehours">
  Course Description <input type="text" name="courseDescription">
  Course Prereqs <input type="text" name="coursePrereqs">
  <input type="submit" name="add" value="ADD RECORD">
  <input type="submit" name="update" value="UPDATE RECORD">
</pre></form>

_END;

if (isset($_POST['courseaddress'])    &&
      isset($_POST['coursename']) &&
      isset($_POST['coursehours'])     &&
      isset($_POST['courseDescription'])     &&
      isset($_POST['coursePrereqs'])     &&
      isset($_POST['add'])
      )
  {
    $coursename = $_POST['coursename'];
    $courseaddress = $_POST['courseaddress'];
    $coursehours   = $_POST[ 'coursehours'];
    $courseDescription   = $_POST[ 'courseDescription'];
    $coursePrereqs = $_POST['coursePrereqs'];


    $courseElement = $xml->getElementsByTagName("courses")->item(0);
    $content = $xml->createElement("course");
    $courseNameElement = $xml->createElement("CourseAddress",$coursename);
    $courseaddressElement = $xml->createElement("CourseName",$courseaddress);
    $coursehoursElement = $xml->createElement("CourseHours",$coursehours);
    $courseDescriptionElement = $xml->createElement("CourseDescription",$courseDescription);
    $coursePrereqsElement = $xml->createElement("CoursePrereqs",$coursePrereqs);

    $content->appendChild($courseNameElement);
    $content->appendChild($courseaddressElement);
    $content->appendChild($coursehoursElement);
    $content->appendChild($courseDescriptionElement);
    $content->appendChild($coursePrereqsElement);

    $courseElement->appendChild($content);

    $xml->save('data/course1.xml');
  }

//=============================================SHOW RECORDS=================================================================
$i = 0;
while(is_object($courseNode = $xml->getElementsByTagName("course")->item($i)))
{
    $CourseAddress = null;
    $CourseName = null;
    $CourseHours = null;
    $CoursePrereqs = null;
    $CourseDescription = null;

    foreach($courseNode->childNodes as $nodename)
    {
        if($nodename->nodeName=='CourseAddress')
        {
            foreach($nodename->childNodes as $subNodes)
            {
                $CourseAddress = $subNodes->nodeValue."<br>";
            }
        }
        if($nodename->nodeName=='CourseName')
        {
            foreach($nodename->childNodes as $subNodes)
            {
                $CourseName = $subNodes->nodeValue."<br>";
            }
        }
        if($nodename->nodeName=='CourseHours')
        {
            foreach($nodename->childNodes as $subNodes)
            {
                $CourseHours = $subNodes->nodeValue."<br>";
            }
        }
        if($nodename->nodeName=='CoursePrereqs')
        {
            foreach($nodename->childNodes as $subNodes)
            {
                $CoursePrereqs = $subNodes->nodeValue."<br>";
            }
        }
        if($nodename->nodeName=='CourseDescription')
        {
            foreach($nodename->childNodes as $subNodes)
            {
                $CourseDescription = $subNodes->nodeValue."<br>";
            }
        }
                            
    }
      $i++;
      echo <<<_END
      <pre>
      <table style="border-collapse: collapse;width: 100%;border: 1px solid black;">
      <th style="border: 1px solid black;">
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course name  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course title  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course hours  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course prereqs  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> course description  </td>
      </th>
      <tr>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;">  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $CourseAddress   </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $CourseName  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $CourseHours  </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $CoursePrereqs </td>
      <td style = "height: 50px;vertical-align: bottom;border: 1px solid black;"> $CourseDescription  </td>
      </tr>
      </table>
      <form action="part3.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="courseAddress" value="$CourseAddress">
<input type="submit" value="DELETE RECORD">
</form>
</pre>
_END;
}
//---------------------------------------------DELETE RECORD----------------------------------------------------------------

if (isset($_POST['courseAddress'])    &&
      isset($_POST['delete']))
  {
    $coursename = $_POST['courseAddress'];
    $coursename = substr( $coursename,0,7);
    $xpath = new DOMXpath($xml);
    //echo $coursename;
    
    //echo print_r($xpath);
    $path = "/courses/course[CourseAddress='$coursename']";
    //echo trim($path);
    $match = $xpath->query($path);
    //echo count($match);
    foreach($match as $node)
    {
        //echo "sht";
        //echo $node;
        $node->parentNode->removeChild($node);
    }

    $xml->formatoutput = true;
    $xml->save('data/course1.xml');
  }

//==-=-=-=-=-=-=-=-=-=-=-------------------------UPDATE RECORD---------------------===================--------------=============

if (isset($_POST['coursename'])    &&
      isset($_POST['update']))
  {
    $coursename = $_POST['coursename'];
    $courseaddress = $_POST['courseaddress'];
    $coursehours   = $_POST[ 'coursehours'];
    $courseDescription   = $_POST[ 'courseDescription'];
    $coursePrereqs = $_POST['coursePrereqs'];

    $content = $xml->createElement("course");
    $courseNameElement = $xml->createElement("CourseAddress",$coursename);
    $courseaddressElement = $xml->createElement("CourseName",$courseaddress);
    $coursehoursElement = $xml->createElement("CourseHours",$coursehours);
    $courseDescriptionElement = $xml->createElement("CourseDescription",$courseDescription);
    $coursePrereqsElement = $xml->createElement("CoursePrereqs",$coursePrereqs);

    $content->appendChild($courseNameElement);
    $content->appendChild($courseaddressElement);
    $content->appendChild($coursehoursElement);
    $content->appendChild($courseDescriptionElement);
    $content->appendChild($coursePrereqsElement);

    $coursename = substr( $coursename,0,7);
    $xpath = new DOMXpath($xml);
    //echo $coursename;
    
    //echo print_r($xpath);
    $path = "/courses/course[CourseAddress='$coursename']";
    //echo trim($path);
    $match = $xpath->query($path);
    //echo count($match);
    foreach($match as $node)
    {
        //echo "sht";
        //echo $node;
        $node->parentNode->replaceChild($content,$node);
    }

    $xml->formatoutput = true;
    $xml->save('data/course1.xml');
  }

?>
<?php

function scrape_CSCatalog($url){

$curl = curl_init(); 
$all_data = array();

for ($page = 1; $page <= 1; $page++){

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);

$courses = array();

preg_match_all("!<p id=.*?>(.*?)<\/p>!",$result, $match);
//echo count($match[1]);
//echo '<br>';
for ($i=0;$i<count($match[1]);$i++) {

    if (preg_match('!<span class="course_address"><a href=.*?>(.*)<\/a><\/span>!',$match[1][$i],$course_address)){
        $courses['course_address'][$i] = $course_address[1];
        /*echo "course address: ";
        echo $courses['course_address'][$i];
        echo '<br>';*/
    }
    else {
        $courses['course_address'][$i] = '';
    }
    if (preg_match('!<span class="course_title">(.*)<\/span> <span.*>!',$match[1][$i],$course_title)){
        $courses['course_title'][$i] = $course_title[1];
        /*echo "course title: ";
        echo $courses['course_title'][$i];
        echo '<br>';*/
    }
    else {
        $courses['course_title'][$i] = '';
    }
    if (preg_match('!<span class="course_hours">\((.*)\)\<\/span>!',$match[1][$i],$course_hours)){
        $courses['course_hours'][$i] = $course_hours[1];
        /*echo "course hours: ";
        echo $courses['course_hours'][$i];
        echo '<br>';*/
    }
    else {
        $courses['course_hours'][$i] = '';
    }
    if (preg_match('!<span class="course_hours">.*?<\/span>(.*?)Prerequisite|\([0-9]\)!',$match[1][$i],$course_des)){
        $courses['course_des'][$i] = $course_des[1];
        //echo $courses['course_des'][$i];
    }
    else {
        $courses['course_des'][$i] = '';
        //echo "no match";
    }
    if (preg_match('!Prerequisite: <a href=.*?>(.*?)<\/a>.*!',$match[1][$i],$course_prereq)){
        $courses['course_prereq'][$i] = $course_prereq[1];
        /*echo "course prereq: ";
        echo $courses['course_prereq'][$i];
        echo '<br>';
        echo '<br>';
        echo '<br>';*/
    }
    else {
        $courses['course_prereq'][$i] = '';
        /*echo "course prereq: ";
        echo $courses['course_prereq'][$i];
        echo '<br>';
        echo '<br>';
        echo '<br>';*/
    }
}
$data = array();
foreach($courses as $key => $value) {
    for ($i = 0; $i < count ($courses[$key]);$i++){
        $data[$i][$key] = $courses[$key][$i];
    }
}

$all_data = array_merge($data,$all_data);

} //end main loop

return $all_data;
}

$packtPage = scrape_CSCatalog("https://catalog.utdallas.edu/2018/graduate/courses/cs");

print_r( $packtPage);

?>
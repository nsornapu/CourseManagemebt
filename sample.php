<?php
  
  // Function to make GET request using cURL
  function curlGet($url) {
    
    $ch = curl_init();	// Initialising cURL session
      
    // Setting cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    
    $results = curl_exec($ch);  // Executing cURL session
    
    curl_close($ch);  // Closing cURL session
    
    return $results;  // Return the results
  }
  
  $packtPage = curlGet('https://catalog.utdallas.edu/2018/graduate/courses/cs');
  
  echo $packtPage;

?>
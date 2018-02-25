<?php

function call_url($url) {
    $ch = curl_init($url);
    $http_headers = array(
        'User-Agent: Junk', // Any User-Agent will do here
    );
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

?>
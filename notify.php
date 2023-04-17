<?php

function sentNotify($Token, $Message) {
    $uri = 'https://notify-api.line.me/api/notify'; // Replace with your API endpoint URL

    // Data to be sent in the request body
    $data = array(
        'message' => $Message
    );

    // Create HTTP headers
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'Content-Length: ' . strlen(http_build_query($data)),
        'Authorization: Bearer ' . $Token
    );

    // Create a stream context with the headers and request body
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);

    try {
        // Send the request using file_get_contents()
        $response = file_get_contents($uri, false, $context);

        // get HTTp Code
        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $http_code = $match[1];

        if ($http_code == "200") {
            return $response;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo '<script>console.log("' . $e . '")</script>';
        return false;
    }
    return false;
}
<?php

header('Content-Type: application/json');
include 'notify.php';

$current_time = time();
$formatted_time = date('Y-m-d H:i:s', $current_time);

$l_token = "";
$l_msg = 'Hello from PHP!' . "\n" . 'Sent From: ' . $formatted_time;

if($res = sentNotify($l_token, $l_msg)){
    $data = array(
        'status' => 1,
        'msg' => 'Line Notify Sent Successful!',
    );
    http_response_code(200);
    echo json_encode($data);
} else {
    $data = array(
        'status' => 0,
        'msg' => 'Line Notify Sent Not Successful!',
    );
    http_response_code(401);
    echo json_encode($data);
}

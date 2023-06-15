<?php session_start();
header('Content-Type: application/json');

$json_array = array(
    'status' => 'hello',
    'message' => 'Juan<br>',
    'token' => '$_token_$',
);

echo json_encode($json_array, JSON_FORCE_OBJECT);
exit;
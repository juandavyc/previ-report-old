 

<?php

require_once "controllers/get.controller.php";

// $table = explode("?", $routesArray[1])[0];
$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$startAt = $_GET["startAt"] ?? null;
$endAt = $_GET["endAt"] ?? null;
$orderMode = $_GET["orderMode"] ?? null;

$response = new GetController();


if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
    
    $response->getDataFilter($table, $select, $_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode, $startAt, $endAt);
} else {
    $response->getData($table, $select,$orderBy,$orderMode, $startAt, $endAt);
}

// $json = array(
//     'statusCode' => 200,
//     'result' => 'Solicitud GET',

// );
// echo json_encode($json, http_response_code($json["statusCode"]));

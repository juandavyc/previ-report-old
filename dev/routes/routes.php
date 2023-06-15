<?php

$routesArray = explode("/", str_replace('dev/', '',$_SERVER['REQUEST_URI']));
$routesArray = array_filter($routesArray);

// var_dump($routesArray);

/* SIN PETICIONES */

if (count($routesArray) == 0) {

    $json = array(
        'statusCode' => 404,
        'result' => 'Not found',

    );
    echo json_encode($json, http_response_code($json["statusCode"]));
    return;
}

/* CON PETICIONES */
if (count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD'])) {
    $table = explode("?", $routesArray[1])[0];
    // ruta para el base 64
    if (strcmp($table, "base_64") == 0) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'servicios/base_64.php';
        } else {
            $json = array(
                'statusCode' => 400,
                'result' => 'Bad Request',

            );
            echo json_encode($json, http_response_code($json["statusCode"]));
        }
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $json = array(
                'statusCode' => 400,
                'result' => 'Bad Request',

            );
            echo json_encode($json, http_response_code($json["statusCode"]));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'servicios/post.php';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            include 'servicios/put.php';
        }
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $json = array(
                'statusCode' => 400,
                'result' => 'Bad Request',
            );
            echo json_encode($json, http_response_code($json["statusCode"]));
        }
    }
}

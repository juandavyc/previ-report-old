<?php

require_once 'controllers/PutController.php';
require_once 'models/PutModel.php';

$datos = array();
parse_str(file_get_contents('php://input'), $datos);

//con datos
if (!empty($datos)) {
    //confirmar que venga el token y sea correcto
    if (isset($datos['token']) && !empty($datos['token'])) {

        $putModel = new PutModel($database);
        $putController = new PutController($putModel);
        $tokenResponse = $putModel->database->validateToken($datos['token']);

        if ($tokenResponse['comment'] === "bien") {
            $putController->getData($table, $datos);
        } else if ($tokenResponse['comment'] === "expired") {

            $json = array(
                'statusCode' => 303,
                'result' => 'Token Expirado',

            );
            echo json_encode($json, http_response_code($json["statusCode"]));
            return;
        } else {
            $json = array(
                'statusCode' => 303,
                'result' => 'Token invalido',

            );
            echo json_encode($json, http_response_code($json["statusCode"]));
            return;
        }
    } else {
        $json = array(
            'statusCode' => 303,
            'result' => 'Token no suministrado',
        );
        echo json_encode($json, http_response_code($json["statusCode"]));
        return;
    }
} else {
    $json = array(
        'statusCode' => 404,
        'result' => 'Not Found',
    );
    echo json_encode($json, http_response_code($json["statusCode"]));
    return;
}

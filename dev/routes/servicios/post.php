<?php

require_once 'controllers/PostController.php';
require_once 'models/PostModel.php';

if (isset($_POST)) {

    $postModel = new PostModel($database);
    $postController = new PostController($postModel);

    if (isset($_POST['login']) && $_POST['login'] == true) {

        $UserResponse = $postController->iniciarSesion($table, $_POST);
    } else if (isset($_POST['query']) && $_POST['query'] == true) {
        if (isset($_POST['token']) && !empty($_POST['token'])) {
            $tokenResponse = $postModel->database->validateToken($_POST['token']);
            if ($tokenResponse['comment'] === "bien") {
                if (count($_POST) >= 2) {

                    $select = $_POST["select"] ?? "*";
                    $orderBy = $_POST["orderBy"] ?? null;
                    $startAt = $_POST["startAt"] ?? null;
                    $endAt = $_POST["endAt"] ?? null;
                    $orderMode = $_POST["orderMode"] ?? null;

                    if (isset($_POST["linkTo"]) && isset($_POST["equalTo"]) && isset($_POST["tblJoin"]) && isset($_POST["idJoin"]) && isset($_POST["colsJoin"])) {
                        $postController->fncResponse(
                            $postModel->sqlMaker->getDataFilterJoin(
                                $table,
                                $select,
                                $_POST["linkTo"],
                                $_POST["equalTo"],
                                $orderBy,
                                $orderMode,
                                $startAt,
                                $endAt,
                                $_POST["tblJoin"],
                                $_POST["idJoin"],
                                $_POST["colsJoin"]
                            )
                        );
                    } else if (isset($_POST["tblJoin"]) && isset($_POST["idJoin"]) && isset($_POST["colsJoin"])) {
                        $postController->fncResponse(
                            $postModel->sqlMaker->getDataFilterJoin2(
                                $table,
                                $select,
                                $orderBy,
                                $orderMode,
                                $startAt,
                                $endAt,
                                $_POST["tblJoin"],
                                $_POST["idJoin"],
                                $_POST["colsJoin"]
                            )
                        );
                    } else if (isset($_POST["linkTo"]) && isset($_POST["equalTo"])) {
                        $postController->fncResponse(
                            $postModel->sqlMaker->getDataFilter(
                                $table,
                                $select,
                                $_POST["linkTo"],
                                $_POST["equalTo"],
                                $orderBy,
                                $orderMode,
                                $startAt,
                                $endAt
                            )
                        );
                    } else {

                        $postController->fncResponse(
                            $postModel->sqlMaker->getData(
                                $table,
                                $select,
                                $orderBy,
                                $orderMode,
                                $startAt,
                                $endAt
                            )
                        );
                    }
                } else {

                    $json = array(
                        'statusCode' => 303,
                        'result' => 'Parametros no cumplidos',
                    );
                    echo json_encode($json, http_response_code($json["statusCode"]));
                    return;
                }
            } else {
                $tokenResponse['statusCode'] = 303;
                echo json_encode($tokenResponse, http_response_code(303));
                return;
            }
        } else {
            if ($table === 'empresa') {
                if (count($_POST) == 1 && $table === 'empresa') {
                    $select = $_POST["select"] ?? "id_empresa,nit,nombre_empresa,id_estado";
                    $orderBy = $_POST["orderBy"] ?? null;
                    $startAt = $_POST["startAt"] ?? null;
                    $endAt = $_POST["endAt"] ?? null;
                    $orderMode = $_POST["orderMode"] ?? null;
                    $postController->fncResponse(
                        $postModel->sqlMaker->getData(
                            $table,
                            $select,
                            $orderBy,
                            $orderMode,
                            $startAt,
                            $endAt
                        )
                    );
                } else {
                    $json = array(
                        'statusCode' => 400,
                        'result' => 'Suministre un token para obtener más detalles de una empresa.',
                    );
                    echo json_encode($json, http_response_code($json["statusCode"]));
                    return;
                }
            } else {
                $json = array(
                    'statusCode' => 400,
                    'result' => 'Bad Request',
                );
                echo json_encode($json, http_response_code($json["statusCode"]));
                return;
            }
        }
        // tilin
    } else if (isset($_POST['create']) && $_POST['create'] == true) {
        if (isset($_POST['token']) && !empty($_POST['token'])) {
            $tokenResponse = $postModel->database->validateToken($_POST['token']);
            if ($tokenResponse['comment'] === "bien") {
                // manera de agregar los datos
                unset($_POST["token"]);
                unset($_POST["create"]);

                $postController->fncResponse(
                    $postModel->postData(
                        $table,
                        $_POST
                    )
                );
            } else {
                $tokenResponse['statusCode'] = 303;
                echo json_encode($tokenResponse, http_response_code(303));
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
            'statusCode' => 400,
            'result' => 'Bad Request',

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

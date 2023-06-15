<?php
require_once 'models/MakeSQL.php';

class PostController 
{
    private $model;
    function __construct($model)
    {
        $this->model = $model;
    }

    public function validatePostToken($token)
    {
       
        //$response_token = Connection::validateToken($token);
        

       // return $database->;
    }

    public function iniciarSesion($table, $data)
    {

        if (
            isset($data['usuario']) &&
            isset($data['contrasenia']) &&
            isset($data['empresa'])
        ) {

            $response = $this->model->iniciarSesion(
                $data['usuario'],
                $data['contrasenia'],
                $data['empresa']
            );

            if (isset($response['statusCode']) && $response['statusCode'] == 200) {
                $temp_data = json_decode($response['results'], true);

                $token = $this->model->database->getToken($temp_data[2], $table);
                if ($token == "OK, Query were succesfull") {
                    $response_user = $this->model->getDatosUsuario($temp_data[2]);
                    $this->apiResponse($response_user, null);
                }
            } else {

                $this->apiResponse(null, $response['results']);
            }
        } else {
            $this->apiResponse(null, 'Usuario Incorrecto');
        }
    }
    
    public function fncResponse($response)
    {

        if (is_array($response)) {
            $json = array(
                'statusCode' => 200,
                'total' => count($response),
                'results' => $response
            );
        } else {
            $json = array(
                'statusCode' => 404,
                'results' => $response
            );
        }

        echo json_encode($json, http_response_code($json["statusCode"]));
    }
    public function apiResponse($response, $error)
    {

        // return;
        if (!empty($response)) {

            if (isset($response[0]->{"contrasenia_usuario"})) {

                unset($response[0]->{"contrasenia_usuario"});
            }

            $json = array(
                'statusCode' => 200,
                'total' => count($response),
                'results' => $response
            );
        } else {

            if ($error != null) {
                $json = array(
                    'statusCode' => 400,
                    'results' =>  $error
                );
            } else {

                $json = array(
                    'statusCode' => 404,
                    'results' =>  $error
                );
            }
        }

        echo json_encode($json, http_response_code($json["statusCode"]));
    }
/*
    public function postData($table, $data)
    {
 
        $response = PostModel::postData($table, $data);
        $return = new PostController();

        // var_dump($response['comment'] == "column_name_error");

        if($response['comment'] == "column_name_error"){

            $return->fncResponse(null, "Los nombres de columna no coinciden en la base de datos", null);
        } else{

            $return->fncResponse($response, null, null);

        }

        // return;


        return $response;
    }  */ 
}
    /*
    static public function validatePostToken($token)
    {
       
        //$response_token = Connection::validateToken($token);
        

       // return $database->;
    }
 
/*
    

    
}
*/
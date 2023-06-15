<?php

class PutController
{
    
    private $putModel = null;

    function __construct($putModel)
    {
        $this->putModel = $putModel;
    }

    public function getData($table, $data)
    {
        $response = $this->putModel->putData($table, $data);
        return $this->fncResponse($response);
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
}

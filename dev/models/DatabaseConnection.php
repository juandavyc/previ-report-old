<?php
/*
require_once 'models/put.model.php';
require_once 'models/post.model.php';
*/
class DatabaseConnection
{
    public $response = array();

    private $conexion = null;

    private $servername = "localhost";
    private $username = "u508857687_previreport";
    private $password = "Previ2022**report";
    public $databaseName = "u508857687_hoja_de_vida";
    private $fixTime = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '-05:00'");

    public function setConexion()
    {

        try {

            $this->conexion = new PDO(
                "mysql:host=$this->servername;dbname=$this->databaseName",
                $this->username,
                $this->password,
                $this->fixTime
            );

            $this->response = array(
                'statusCode' => 200,
                'results' => 'Conexion establecida',
            );
        } catch (Exception $e) {
            $this->response = array(
                'statusCode' => 300,
                'results' => 'Error al al conectar : ' . $e->getMessage()
            );
            // die("Error: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        if ($this->conexion instanceof PDO) {
            return $this->conexion;
        }
    }

    public function getEstadoConexion()
    {
        return $this->response;
    }




    //Validar existencia de una tabla en la base de datos

    public function getToken($id, $table)
    {
        //falta sumarle a el tiempo lo que le doy al token para ser usado
        $time = time() + (60 * 60 * 24); // un dia de expiracion
        $token = bin2hex(random_bytes(32));
        $update = $this->putDataToken($id, $table, $token, $time);
        return $update['comment'];
    }



    public function validateToken($token)
    {

        $response = $this->getCurrentToken($token);

        if ($response['comment'] === "bien") {

            $exp_token = $response['results'][0]->{"token_exp_user"};

            if ($exp_token < time()) {
                // valida el tiempo de el token 12 horas
                $response['comment'] = "expired";
            }
        } else {
            $response['comment'] = "error";
        }

        return $response;
    }

    public function putDataToken($id, $table, $token, $exp)
    {
        $this->response = array();

        $sql =  " UPDATE usuario SET token_user = :token,token_exp_user = :token_exp WHERE id_usuario = :id_usuario ;";
        $stmt = $this->getConexion()->prepare($sql);

        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->bindParam(":token_exp", $exp, PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->response = array(
                "comment" => "OK, Query were succesfull"
            );
        } else {
            $this->response = array(
                "comment" => $stmt->errorInfo()
            );
        }

        return $this->response;
    }

    public function getCurrentToken($token)
    {
        $this->response = array();

        $sql =  "SELECT token_exp_user FROM usuario WHERE token_user = :token_user";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bindParam(":token_user", $token, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $this->response = array(
                    "comment" => "bien",
                    "results" => $stmt->fetchAll(PDO::FETCH_CLASS)
                );
            } else {
                $this->response = array(
                    "comment" => "error",
                    "results" => "Token invalido"
                );
            }
        } else {
            $this->response = array(
                "comment" => "error",
                "results" =>  $stmt->errorInfo()
            );
        }

        return $this->response;
    }
    


    public function getColumnsDataPost($table, $columns)
    {

        $columns_array = explode(",", $columns);
        $validate = $this->getConexion()
            ->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$this->databaseName' AND table_name = '$table'")
            ->fetchAll(PDO::FETCH_OBJ);

           // var_dump($validate);
        if (empty($validate)) {
            return null;
        } else {
            $sum = 0;
            foreach ($validate as $key => $value) {
                $sum += in_array($value->item, $columns_array);
            }
            return $sum == count($columns_array) ? $validate : null;
        }
    }
}

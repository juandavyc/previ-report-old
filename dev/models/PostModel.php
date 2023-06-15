<?php
require_once 'MakeSQL.php';
class PostModel
{
    public $database;
    private $response = array();
    public $sqlMaker = null;

    function __construct($database)
    {
        $this->database = $database;
        $this->sqlMaker = new MakeSQL($database);
    }

    public function getToken($token)
    {
        try {
            $sql =  "SELECT token_exp_user FROM usuario WHERE token_user = :token_user";
            $stmt = $this->database->getConexion()->prepare($sql);
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
                    "results" => "Error de sintaxis"
                );
            }
        } catch (Exception $e) {
            $this->response = array(
                "comment" => "error",
                "results" => "Error de sintaxis" . $e->getMessage(),
            );
        }
        return $this->response;
    }

    public function iniciarSesion($cedula, $contrasenia, $empresa)
    {
        $this->response = array();
        try {
            $rows = array();
            $sql = "CALL proc_iniciar_sesion_webservice ( :empresa , :usuario , :contrasenia , @respuesta); ";


            $stmt = $this->database->getConexion()->prepare($sql);

            $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $cedula, PDO::PARAM_STR);
            $stmt->bindParam(":contrasenia", $contrasenia, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $stmt->closeCursor();
                $sql = "SELECT @respuesta As JSON_PROC";
                $stmt = $this->database->getConexion()->prepare($sql);
                if ($stmt->execute()) {
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->response = array(
                        'statusCode' => 200,
                        'results' => $rows[0]['JSON_PROC']
                    );
                    $stmt->closeCursor();
                } else {
                    $this->response = array(
                        'statusCode' => 400,
                        'results' => json_encode($stmt->errorInfo())
                    );
                }
            } else {
                $this->response = array(
                    'statusCode' => 400,
                    'results' => json_encode($stmt->errorInfo())
                );
            }
        } catch (Throwable $th) {
            $this->response = array(
                'statusCode' => 300,
                'results' => 'Error al al conectar : ' . $th->getMessage()
            );
        }
        return $this->response;
    }

    public function getDatosUsuario($id)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario ;";
        $stmt = $this->database->getConexion()->prepare($sql);
        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $th) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }



    public function validatePostToken($token)
    {

        //$response_token = Connection::validateToken($token);


        // return $database->;
    }
    public function getColumnsData($table, $columns)
    {
        $columns_array = explode(",", $columns);
        $sql = "SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '" . $this->database->databaseName . "' AND table_name = '$table'";
        $stmt = $this->database->getConexion()->prepare($sql);
        $validate = null;
        if ($stmt->execute()) {

            $validate = $stmt->fetchAll(PDO::FETCH_OBJ);
            if ($columns[0] == "*") {
                array_shift($columns);
            }
            $sum = 0;
            foreach ($validate as $key => $value) {
                $sum += in_array($value->item, $columns_array);
            }
            return $sum == count($columns_array) ? $validate : null;

        } else {
            return null;
        }
    }

    public function postData($table, $data)
    {


        $columns = "";
        $params = "";

        foreach ($data as $key => $value) {
            $columns .= $key . ',';
            $params .= ':' . $key . ',';
        }

        $columns = substr($columns, 0, -1);
        $params = substr($params, 0, -1);


        if (empty($this->getColumnsData($table, $columns))) {
            $response = array(
                "comment" => "column_name_error",
            );
            return $response;
        }

        $sql =  " INSERT INTO $table ($columns) VALUES ($params)";       
        $stmt = $this->database->getConexion()->prepare($sql);
        foreach ($data as $key => $value) {
             $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $response = array(
                "comment" => "Agregrado Correctamente",
                "id" => $this->database->getConexion()->lastInsertId()
            );
        } else {
            return json_encode($stmt->errorInfo());
        }
        return $response;
        
    }
}



    /*
     


    
}
 */
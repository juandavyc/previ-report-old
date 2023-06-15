<?php


class PutModel
{
    public $database;
    private $response = array();
    function __construct($database)
    {
        $this->database = $database;
    }

    public function putData($table, $data)
    {
        $this->response = array();

        //validar las columnas a las que se va a hacer update
        if (isset($data['id']) && isset($data['idValue'])) {

            $tempid_update = $data['id'];
            $tempidvalue_update = $data['idValue'];
            // eliminar
            unset($data['id']);
            unset($data['idValue']);
            if (isset($data['token'])) {
                unset($data['token']);
            }

            $columns = "";
            $params = "";
            //cofirmar los nombres de las columnas
            foreach ($data as $key => $value) {
                $columns .= $key . ',';
                $params .= ':' . $key . ',';
            }
            $columns = substr($columns, 0, -1);
            $params = substr($params, 0, -1);

            //confirma los datos de las columnas antes de hacer el update

            $column_confirm = $this->database->getColumnsDataPost($table, $columns);

            if (empty($column_confirm)) {

                return array(
                    "comment" => "column_name_error",
                );
            }


            $column_update = "";

            foreach ($data as $key => $value) {

                $column_update .= $key . ' = :' . $key . ',';
            }

            $column_update = substr($column_update, 0, -1);

            $sql =  "UPDATE $table SET $column_update WHERE $tempid_update = $tempidvalue_update";

            $stmt = $this->database->getConexion()->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $this->response = array(
                        "comment" => "Actualizado correctamente",
                    );
                } else {
                    $this->response = array(
                        "comment" => "La columna no sufrió cambios",
                    );
                }
            } else {
                return json_encode($stmt->errorInfo());
            }

            return $this->response;
        } else {

            return array(
                "comment" => "id no suministrado",
            );
        }
    }
}

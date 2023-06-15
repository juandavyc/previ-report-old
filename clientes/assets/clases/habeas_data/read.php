<?php
class HabeasData
{

    public $array_habeas_data = array();

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getHabeasData()
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "nombre_habeas_data ";
        $mysql_query .= "FROM habeas_data";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($this->array_habeas_data, array(

                    'habeas' => $row['nombre_habeas_data'],

                ));
            }

        }
        return $this->array_habeas_data;
    }

}
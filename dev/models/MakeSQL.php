<?php

class MakeSQL
{

    private $database = null;

    function __construct($database)
    {
        $this->database = $database;
    }


    public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt)
    {

        //var_dump($table, $select, $orderBy, $orderMode, $startAt, $endAt);

        $selectArray = explode(",", $select);

        // Si el numero de columnas que se solicitan en la consulta coinciden con las de la tabla No entra aqui
        if (empty($this->getColumnsData($table, $selectArray))) {
            return null;
        } else {
        }
        $sql = "SELECT $select FROM $table ";

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode ";
        }
        if ($startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table LIMIT $startAt,$endAt ";
        }
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt ";
        }

        $stmt = $this->database->getConexion()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    public function getColumnsData($table, $columns)
    {

        $databaseName = $this->database->databaseName;

        $sql =  "SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$databaseName' AND table_name = '$table'";
        $stmt = $this->database->getConexion()->prepare($sql);

        if ($stmt->execute()) {

            $response = $stmt->fetchAll(PDO::FETCH_OBJ);
            if ($columns[0] == "*") {
                array_shift($columns);
            }
            $sum = 0;
            foreach ($response as $key => $value) {
                $sum += in_array($value->item, $columns);
            }

            return $sum == count($columns) ? $response : null;
        } else {
            return null;
        }
    }

    public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
    {

        $selectArray = explode(",", $select);
        if (empty($this->getColumnsData($table, $selectArray))) {
            return null;
        }

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode(",", $equalTo);
        $linkToText = "";


        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {

                    $linkToText .= "AND " . $value . "= :" . $value . " ";
                }
            }
        }

        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";

        //  Order
        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode ";
        }
        // limitar datos sin ordenar
        if ($startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt ";
        }
        // order and limit
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt ";
        }
        // echo $sql;
        $stmt = $this->database->getConexion()->prepare($sql);

        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        try {
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_CLASS);
            } else {
                return json_encode($stmt->errorInfo());
            }
        } catch (PDOException $th) {
            return null;
        }
    }

    public function getDataFilterjoin($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin)
    {
        $tblArray = explode(",", $tblJoin);
        $colsArray = explode(",", $colsJoin);



        $table_suff = substr($table, 0, 3);

        $texJoin = '';
        $queryText = '';
        $selectcc = '';




        // var_dump($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin);
        // si hay mas d euna tabla se hacen los otros arreglos
        if (count($tblArray) > 0) {
            $idArray = explode(",", $idJoin);
            $i = 0;
            //  si viene mas de una tabla en la variable se hace el foreach para generar los joins 
            foreach ($tblArray as $key => $value) {
                $suff = substr($value, 0, 3);

                if ($value === 'usuario' && $table === 'preoperacional') {
                    $selectcc .= ', usua.nombre_usuario As nombre_usuario_autoriza';
                    $selectcc .= ', usur.nombre_usuario As nombre_usuario_realiza';
                    $texJoin .= "LEFT JOIN usuario usua ON usua.id_usuario = pre.id_usuario_autoriza ";
                    $texJoin .= "LEFT JOIN usuario usur ON usur.id_usuario = pre.id_usuario_realiza ";
                } else if ($value === 'usuario' && $table === 'mantenimiento') {
                    $selectcc .= ', usu.nombre_usuario As nombre_usuario';
                    $selectcc .= ', usuf.nombre_usuario As nombre_usuario_formulario';
                    $texJoin .= "LEFT JOIN usuario usu ON usu.id_usuario = man.id_usuario ";
                    $texJoin .= "LEFT JOIN usuario usuf ON usuf.id_usuario = man.id_usuario_formulario ";
                } else if ($value === 'empresa' && $table === 'mantenimiento') {
                    $selectcc .= ',empr.nit As nit_empresa ';
                    $texJoin .= "LEFT JOIN empresa empr ON veh.id_empresa = empr.id_empresa ";
                    $linkTo = "empresa_fix";
                } else if ($value === 'estado_empresa') {
                    $selectcc .= ', est.nombre_estado_empresa';
                    $texJoin .= "LEFT JOIN estado_empresa est ON est.id_estado_empresa = emp.id_estado ";
                } else {

                    if (count(explode("$", $colsArray[$i])) > 0) {
                        $tempExplode = explode("$", $colsArray[$i]);
                        foreach ($tempExplode as $skey => $svalue) {
                            $selectcc .= ',' . $suff . '.' . str_replace(["(", ")"], "", $svalue);
                        }
                    } else {
                        $selectcc .= ',' . $suff . '.' . $colsArray[$i];
                    }

                    $texJoin .= "LEFT JOIN $tblArray[$i] $suff ON $suff" . "." . $idArray[$key] . " = $table_suff" . "." . $idArray[$key] . " ";
                }

                $i++;
            }
        } else {
            $suff = substr($tblArray[0], 0, 3);
            $texJoin .= "LEFT JOIN $tblJoin $suff ON $suff" . "." . $idJoin . " = $table_suff" . "." . $idJoin . " ";
        }

        //Validar existencia de la tabla y de las columnas
        //$selectArray = explode(",", $select);
        //if (empty($this->getColumnsData($table, $selectArray))) {
        //    return null;
        //}

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode(",", $equalTo);
        $linkToText = "";

        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToText .= "AND " . $value . "= :" . $value . " ";
                }
            }
        }
        $sql = "SELECT $table_suff.$select $selectcc FROM $table $table_suff $texJoin WHERE ";
        if ($linkTo == "empresa_fix") {
            $linkToArray = array("empresaxd");
            $sql .= "empr.id_empresa LIKE :empresaxd";
        } else {
            $sql .= "$table_suff.$linkToArray[0] = :$linkToArray[0]";
        }

        //  Order   
        if ($orderBy != null && $orderMode != null) {
            $sql .= " $linkToText ORDER BY $table_suff.$orderBy $orderMode ";
        }
        // limitar datos sin ordenar
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt ";
        }
        // order and limit
        else if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql .= " ORDER BY $table_suff.$orderBy $orderMode LIMIT $startAt, $endAt";
        }

        $stmt = $this->database->getConexion()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }
        try {
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_CLASS);
                } else {
                    return "Sin resultados";
                }
            } else {
                return json_encode($stmt->errorInfo());
            }
        } catch (PDOException $th) {
            return null;
        }
    }
    public function getDataFilterjoin2($table, $select, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin)
    {

        $tblArray = explode(",", $tblJoin);
        $colsArray = explode(",", $colsJoin);
        //echo "sadassadsad";
        //var_dump($colsArray);
        $table_suff = substr($table, 0, 3);

        $texJoin = '';
        $queryText = '';
        $selectcc = '';

        // si hay mas d euna tabla se hacen los otros arreglos
        if (count($tblArray) > 0) {
            $idArray = explode(",", $idJoin);
            $i = 0;
            //  si viene mas de una tabla en la variable se hace el foreach para generar los joins 
            foreach ($tblArray as $key => $value) {
                $suff = substr($value, 0, 3);


                if ($value === 'usuario' && $table === 'preoperacional') {
                    $selectcc .= ', usua.nombre_usuario As nombre_usuario_autoriza';
                    $selectcc .= ', usur.nombre_usuario As nombre_usuario_realiza';
                    $texJoin .= "LEFT JOIN usuario usua ON usua.id_usuario = pre.id_usuario_autoriza ";
                    $texJoin .= "LEFT JOIN usuario usur ON usur.id_usuario = pre.id_usuario_realiza ";
                } else if ($value === 'usuario' && $table === 'mantenimiento') {
                    $selectcc .= ', usu.nombre_usuario As nombre_usuario';
                    $selectcc .= ', usuf.nombre_usuario As nombre_usuario_formulario';
                    $texJoin .= "LEFT JOIN usuario usu ON usu.id_usuario = man.id_usuario ";
                    $texJoin .= "LEFT JOIN usuario usuf ON usuf.id_usuario = man.id_usuario_formulario ";
                } else if ($value === 'empresa' && $table === 'mantenimiento') {
                    $selectcc .= ',empr.nit As nit_empresa ';
                    $texJoin .= "LEFT JOIN vehiculo vehi ON vehi.id_vehiculo = man.id_vehiculo ";
                    $texJoin .= "LEFT JOIN empresa empr ON vehi.id_empresa = empr.id_empresa ";
                    $linkTo = "empresa_fix";
                } else if ($value === 'estado_empresa') {
                    $selectcc .= ', est.nombre_estado_empresa';
                    $texJoin .= "LEFT JOIN estado_empresa est ON est.id_estado_empresa = emp.id_estado ";
                } else {

                    if (count(explode("$", $colsArray[$i])) > 0) {
                        $tempExplode = explode("$", $colsArray[$i]);
                        foreach ($tempExplode as $skey => $svalue) {
                            $selectcc .= ',' . $suff . '.' . str_replace(["(", ")"], "", $svalue);
                        }
                    } else {
                        $selectcc .= ',' . $suff . '.' . $colsArray[$i];
                    }


                    // $selectcc .= ',' . $suff . '.' . $colsArray[$i];
                    $texJoin .= "LEFT JOIN $tblArray[$i] $suff ON $suff" . "." . $idArray[$key] . " = $table_suff" . "." . $idArray[$key] . " ";
                }



                $i++;
            }
        } else {

            $suff = substr($tblArray[0], 0, 3);
            $selectcc .= ", $suff." . $colsJoin;
            $texJoin .= "LEFT JOIN $tblJoin $suff ON $suff" . "." . $idJoin . " = $table_suff" . "." . $idJoin . " ";
        }

        //Validar existencia de la tabla y de las columnas
        $selectArray = explode(",", $select);
        if (empty($this->getColumnsData($table, $selectArray))) {
            return null;
        }


        $sql = "SELECT $table_suff.$select $selectcc FROM $table $table_suff $texJoin";


        //  Order
        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $table_suff.$select $selectcc FROM $table $table_suff $texJoin  ORDER BY $orderBy $orderMode ";
        }
        // limitar datos sin ordenar
        if ($startAt != null && $endAt != null) {
            $sql = "SELECT $table_suff.$select $selectcc FROM $table $table_suff $texJoin  LIMIT $startAt, $endAt ";
        }
        // order and limit
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $table_suff.$select $selectcc FROM $table $table_suff $texJoin  ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt ";
        }
        //  echo $sql;
        //echo $sql;
        // var_dump($sql);

        $stmt = $this->database->getConexion()->prepare($sql);
        try {
            $stmt->execute();
            // echo "bien";
        } catch (PDOException $th) {
            // echo "mal mal";
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
    /*
    static public function validarToken($token)
    {

        // consulta en base a el token
        // devolvemos respuestas dependiendo
        // tomamos el tiempo de expiracion
        $response = PostModel::getToken($token);

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

*/
    /*
    static public function getData($database, $table, $select, $orderBy, $orderMode, $startAt, $endAt)
    {

        // var_dump($table, $select, $orderBy, $orderMode, $startAt, $endAt);

        $selectArray = explode(",", $select);


        // Si el numero de columnas que se solicitan en la consulta coinciden con las de la tabla No entra aqui
        //if (empty($database,::getColumnsData($table, $selectArray))) {
       //    return null;
       // }

        //Validar existencia de la tabla

        $sql = "SELECT $select FROM $table ";

        // echo $sql;

        // Solo ordenar
        if ($orderBy != null && $orderMode != null) {

            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode ";
        }
        //Solo limitar sin ordenar
        if ($startAt != null && $endAt != null) {

            $sql = "SELECT $select FROM $table LIMIT $startAt,$endAt ";
        }
        // ordenar y limitar
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {

            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt ";
        }

       // $stmt = Connection::connect()->prepare($sql);

        $stmt->execute();

        // var_dump($stmt->fetchAll(PDO::FETCH_CLASS));


        return $stmt->fetchAll(PDO::FETCH_CLASS);
        
    }

    static 

    static 




    static public function getUserData($id)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario ;";

        $stmt = Connection::connect()->prepare($sql);

        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);


        try {
            $stmt->execute();
        } catch (PDOException $th) {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
*/

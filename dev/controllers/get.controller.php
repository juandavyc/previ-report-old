 <?php

    // require_once "models/get.model.php";

    class GetController
    {
        /*
        static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt)
        {

            $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);


            // return;

            $return = new GetController();
            $return->fncResponse($response);

            return $response;
        }

        static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
        {

            $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response);

            return $response;
        }


        static public function getDataFilterJoin($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin)
        {

            // var_dump($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin);
            $response = GetModel::getDataFilterjoin($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin);

            $return = new GetController();
            $return->fncResponse($response);


            return $response;
        }
        static public function getDataFilterJoin2($table, $select, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin)
        {
            $response = GetModel::getDataFilterJoin2($table, $select, $orderBy, $orderMode, $startAt, $endAt, $tblJoin, $idJoin, $colsJoin);

            $return = new GetController();
            $return->fncResponse($response);

            return $response;
        }

        /*respuestas del controlador */
        /*
        public function fncResponse($response)
        {

            if (!empty($response)) {
                $json = array(
                    'statusCode' => 200,
                    'total' => count($response),
                    'results' => $response
                );
            } else {

                $json = array(
                    'statusCode' => 404,
                    'results' => 'Not Found'
                );
            }

            echo json_encode($json, http_response_code($json["statusCode"]));
        }
        */
    }

<?php
define('CHARSET', 'UTF-8');
date_default_timezone_set('America/Bogota');
class dbconnection
{

     public $host = 'localhost';
    public $user = 'u508857687_previreport';
    public $pass = 'Previ2022**report';
    public $db = 'u508857687_hoja_de_vida';
    public $myconn;
    public $status = "error";
    
    public function connect()
    {
        @$con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (!$con) {
            $this->status = "error";
        } else {
            $this->status = "bien";
            $this->myconn = $con;
        }
        return $this->myconn;
    }

    public function status()
    {
        return $this->status;
    }
    public function close()
    {
        mysqli_close($this->myconn);
    }

}
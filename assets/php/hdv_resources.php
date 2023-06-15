<?php
include "hdv.php";
function encrypt($value, $type)
{
    $secret_key = skeyy;
    $secret_iv = pkey;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $hashnum = "";
    if ($type == 1) {
        $hashnum = base64_encode(openssl_encrypt($value, $encrypt_method, $key, 0, $iv));
    }
    if ($type == 2) {
        $hashnum = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);
    }
    return $hashnum;
}

function getposturl($url_form)
{

    //$php_json_status = "no";
    //$php_json_message = "Sin iniciar";

    $php_json_status = "ok";
    $php_json_message = "Las urls son identicas.";
    $php_json_datos = array(
        'status' => $php_json_status,
        'message' => $php_json_message,
    );
    return $php_json_datos;
}

function getsafenumber($page, $totalpages)
{
    $php_return = 1;
    if (is_numeric($page)) {
        if ($page >= $totalpages) {
            $php_return = $totalpages;
        } else if ($page <= 0) {
            $php_return = 1;
        } else {
            $php_return = $page;
        }
    }
    return $php_return;
}

//funcion para acortar caracterres y puntos suspensivos
function puntos($p1){

    $lngth = strlen($p1);
    $a = "";
    if($lngth > 28){
    $a = substr($p1, 0, 28).'...';
    
    } 
    else {
        $a = $p1;
}
    return $a;

}

function puntos_smart($p1,$max,$num){   // 

    $lngth = strlen($p1);
    $a = "";
    if($lngth > $max){
    $a = substr($p1, 0, $num).'...';
    
    } 
    else {
        $a = $p1;
}
    return $a;

}

?>

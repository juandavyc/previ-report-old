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

function clean_file_name($string)
{
    $string = preg_replace("/[^a-z0-9\_\-\.]/i", '_', $string);
    return $string;
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

function getsafearray($array, $content, $value)
{
    $php_arrayreturn = key($array);
    foreach ($array as $clave => $valor) {
        if (strcasecmp($clave, $content) == 0) {
            if ($value == 1) {
                $php_arrayreturn = $clave;
            } else if ($value == 2) {
                $php_arrayreturn = $valor;
            }
            break;
        }
    }
    return $php_arrayreturn;
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

function getSRCImage64($image_base64, $folder, $name)
{

    $php_imagen = $image_base64;
    $php_carpeta = $folder;
    $php_placa = $name;

    $json_image_src = "";
    //Elimina data:image/png;base64
    $php_imagen = str_replace('data:image/png;base64,', '', $php_imagen);
    //Remplaza los espacios por un +
    $php_imagen = str_replace(' ', '+', $php_imagen);
    //Decodifica el base64
    $php_data = base64_decode($php_imagen);
    // Donde va a guardar el archivo
    $php_nombre = $php_placa;
    // Ruta y nombre
    $php_archivo = DOCUMENT_ROOT . '/images/' . $folder . '/' . $php_nombre . '.png';
    // Subir la foto
    $php_success = file_put_contents($php_archivo, $php_data);
    // La imagen subio al seridor
    if ($php_success) {
        $json_image_src = '/images/' . $php_carpeta . '/' . $name . '.png';
    }
    // La imagen NO subio al seridor
    else {
        $json_image_src = '/images/image_error.png';
    }
    return $json_image_src;
}

function getspecialdate($_fecha)
{
    return date('Y-m-d', strtotime(str_replace('/', '-', $_fecha)));
}

function setSpecialDate($_fecha)
{
    return date('d/m/Y', strtotime(str_replace('-', '/', $_fecha)));
}
function getSpecialDateTime($_fecha)
{
    return date('d/m/Y H:i:s', strtotime(str_replace('-', '/', $_fecha)));
}
function adddaysdate($_fecha, $_dias)
{
    return date('Y-m-d', strtotime($_fecha . ' + ' . $_dias . ' days'));
}
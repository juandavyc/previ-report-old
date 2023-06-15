
<?php
if (isset($_POST)) {
    if (
        isset($_POST['base_64'])
        && isset($_POST['folder'])
    ) {
        $document_root = '/home/u508857687/domains/previreport.com/public_html/';
       // $document_root = 'C:/xampp/htdocs/';
        $data = $_POST['base_64'];
        $folder = $_POST['folder'];
        $type = array(".jpg", ".png", ".gif");

        // coincidencia con el base 64
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {

            //toma el string que sale despues de : data:image/png;base64,
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            //coincidencias con el tipo de imqagen
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            $filename = 'spartanggs' . "_" . time() . '.'.$type;
            $folder_to = $document_root . "/" . $folder;
            $path = $folder_to . $filename;
            // server C:/xampp/htdocs/webservice/+folder+/filename
            // confirmar antes que el path de la carpeta esta correcto
            if (is_dir($folder_to)) {
                file_put_contents($path, $data);
            } else {
                $json = array(
                    'statusCode' => 400,
                    'message' => 'Nombre de la carpeta de destino inexistente',

                );
                echo json_encode($json, http_response_code($json["statusCode"]));
                return;
            }

            // si el archivo esta en la ruta
            if (file_exists($path)) {

                $json = array(
                    'statusCode' => 200,
                    'message' => 'Archivo creado',
                    'path' => 'https://previreport.com/'.$folder.$filename,

                );
                echo json_encode($json, http_response_code($json["statusCode"]));
                return;
            } else {
                $json = array(
                    'statusCode' => 200,
                    'result' => 'Archivo no creado, Nombre de la carpeta errado o tipo de archivo invalido',

                );
                echo json_encode($json, http_response_code($json["statusCode"]));
                return;
            }
        } else {

            throw new \Exception('did not match data URI with image data');
        }
    } else {
        $json = array(
            'statusCode' => 400,
            'message' => 'Parametros incorrectos',
        );
        echo json_encode($json, http_response_code($json["statusCode"]));
        return;
    }
}

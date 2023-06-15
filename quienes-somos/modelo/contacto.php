<?php  session_start();
header('Content-Type: application/json');
include $_SERVER["DOCUMENT_ROOT"] . "/assets/php/hoja_public_config.php";
$headers = apache_request_headers();
if(isset($_POST["asunto"]) &&
	isset($_POST["nombre_completo"]) &&
	isset($_POST["celular"]) &&
	isset($_POST["correo"]) &&
	isset($_POST["mensaje"]) &&
	count($_POST) == 5)
{
	
    include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';

	$json_status = "error";
	$json_message = "sin iniciar";
		// inicio verifica que el token sea identico
		if(isset($headers['csrf-token']) && hash_equals($headers['csrf-token'],$_SESSION['csrf_token']))
		{
			$database = new dbconnection();
			// conecta a la base de datos
			$database->connect();
			// envia a la base de datos en mayuscula
			$asunto = htmlspecialchars($_POST["asunto"]);
			$nombre = htmlspecialchars($_POST["nombre_completo"]);
			$celular = htmlspecialchars($_POST["celular"]);
			$correo = htmlspecialchars($_POST["correo"]);
			$mensaje = htmlspecialchars($_POST["mensaje"]);
			

			// llama el procedimiento
			$mysql_query = "call proc_contacto_cliente(?,?,?,?,?,@response_p); ";

			$mysql_stmt = mysqli_prepare($database->myconn,$mysql_query);
			$mysql_stmt->bind_param('sssss',$asunto,$nombre,$celular,$correo,$mensaje);
			// si la consulta se ejecuto bien
			if($mysql_stmt->execute()){

				// lipia el statement
				$mysql_stmt->close();
				// envia que se guardo
				$json_status = "bien";
				// busca el resultado del procedimiento
				$mysql_query = "SELECT @response_p As json_proc;";
				$mysql_stmt = mysqli_prepare($database->myconn,$mysql_query);
				// si la consulta se ejecuto bien
				if($mysql_stmt->execute()){
					// guarda todo en un arreglo
					$mysql_result = $mysql_stmt->get_result();					
					$row = $mysql_result->fetch_assoc();
					$array_decode = json_decode($row['json_proc']);
					// pos 0 para status -> bien,error
					$json_status = $array_decode[1];
					$json_message = $array_decode[0]." ".$array_decode[1]." ".$array_decode[2]." ".$array_decode[3];
					// limpia el statement
					$mysql_stmt->close();
				}
				// la consulta no se ejecuto
				else{
					$json_status = "error";
					$json_message =  "Error al consultar 2 ".htmlspecialchars($mysql_stmt->error);
				}
			}
			// la consulta no se ejecuto procedimiento
			else{
				$json_status = "error";
				$json_message =  "Error al consultar 1 ".htmlspecialchars($mysql_stmt->error);
			}

			$database->close();	
		}
		// fin verifica que el token sea identico
		// inicio el token no es identico
		else
		{
			$json_status = "error";
			$json_message = htmlspecialchars("Wrong CSRF token.");
		}
	// fin el token no es identico


	// envia los datos en un array JSON
	$json_array = array(
		'status' => $json_status,		
		'message' => $json_message,
	);

	echo json_encode($json_array, JSON_FORCE_OBJECT);
	exit;
}

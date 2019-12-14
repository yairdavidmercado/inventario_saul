<?php
ob_start();
?>
<?php session_start(); 

if (!isset($_SESSION['usuario']))
{
    $response["session"] = true;
    echo json_encode($response);
    
}else{

 include 'conexion.php';
 
			$idusuario 		= $_SESSION["usuario"];
			$asunto			= $_POST["asunto"];
			$tipo 			= $_POST["tipo"];
			$descripcion 	= $_POST["descripcion"];
			$modulo 		= $_POST["modulo"];
			$caracter 		= $_POST["caracter"];
			$contacto 		= $_POST["contacto"];
			$telefono 		= $_POST["telefono"];
			$email 			= $_POST["email"];
			$lat 			= $_POST["lat"];
			$lng 			= $_POST["lng"];
			$licencia 		= $_POST["licencia"];
			$perfil 		= $_POST["perfil"];
 
 $conn = pg_connect("user=".DB_USER." password=".DB_PASS." port=".DB_PORT." dbname=".DB_NAME." host=".DB_HOST);

	try{
		if($conn){
		$result = pg_query($conn, "SELECT guardar_solicitudes('".$idusuario."', '".$asunto."', '".$tipo."', '".$descripcion."', '".$caracter."', '".$contacto."', '".$telefono."', '".$email."', '".$lat."', '".$lng."', '".$licencia."', '".$perfil."', '".$modulo."');");
		$fch = pg_fetch_row($result);

		$response["success"] = true;
		$response["message"] = "Su caso ha sido registrado con el numero: ".$fch[0];
		$response["numero"] = $fch[0];
		echo json_encode($response);
		}
		else{
			$response["success"] = false;
			$response["message"] = "Ocurrio un error en la conexion";
			echo json_encode($response);
		}
	}catch(Exception $e){
		$response["success"] = false;
		$response["message"] = $e->getMessage();
		echo json_encode($response);
	}
	pg_close($conn);

	}

?>

<?php
ob_end_flush();
?>
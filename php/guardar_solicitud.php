<?php

$ftp_server = "190.121.135.236";
$ftp_username   = "anonymous";
$ftp_password   =  "anonymous@example.com";

// setup of connection
$conn_id = ftp_connect($ftp_server) or die("could not connect to $ftp_server");

// login
if (@ftp_login($conn_id, $ftp_username, $ftp_password))
{
	$id = $_POST["id_comtext"];
	$file = $_FILES["soporte_adjunto"]["name"]; // right
	$remote_file_path = "";
	if ($file !== "") {
		ftp_pasv($conn_id, true);
		$name_file = pathinfo($file, PATHINFO_EXTENSION);
		$nuevo_nombre = uniqid().$id.".".$name_file;
		$remote_file_path = "/imagenes/pqrsdf/documents/".$nuevo_nombre;
		ftp_put($conn_id, $remote_file_path, $_FILES["soporte_adjunto"]["tmp_name"], FTP_BINARY); // right
		//$response["message"] = "Se ha guardado el archivo en ftp correctamente";
	}
	
	include 'conexion.php';
	$url 						= $remote_file_path;

$conn = pg_connect("user=".DB_USER." password=".DB_PASS." port=".DB_PORT." dbname=".DB_NAME." host=".DB_HOST) or die ("Could not connect to server\n");

try{
	pg_query("BEGIN") or die("Could not start transaction\n");
	$result = pg_query($conn, "SELECT actualizar_comunicado_ext( '$id', '$url' );");
	$fch = pg_fetch_row($result);
	$res1 = true;

	if ($fch[0] > 0) {
		$response["success"] = true;
		$response["message"] = "Commiting transaction.";
		echo json_encode($response);
		pg_query("COMMIT") or die("Transaction commit failed\n");
	} else {
		$response["success"] = true;
		$response["message"] = "Rolling back transaction.";
		echo json_encode($response);
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");;
	}
}catch(Exception $e){
	$response["success"] = false;
	$response["message"] = $e->getMessage();
	echo json_encode($response);
}
pg_close($conn); 

}else{
	$response["success"] = false;
	$response["message"] = "could not connect as $ftp_username\n";
	echo json_encode($response);
}

?>
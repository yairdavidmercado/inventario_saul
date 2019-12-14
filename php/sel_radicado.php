<?php
include 'conexion.php';
$conn = new PDO("pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASS);
$cod = $_POST["cod"];
$parametro1 = $_POST["id"];
try {
	// begin transaction, this is all one process
	$conn->beginTransaction();
	// call the function
	$stmt = $conn->prepare("select f_busqueda_radicados(:cod, :parametro1)");
	$stmt->bindParam('cod', $cod, PDO::PARAM_STR);
	$stmt->bindParam('parametro1', $parametro1, PDO::PARAM_STR);
	$stmt->execute();
	$cursors = $stmt->fetchAll();
	$stmt->closeCursor();
	// get each result set
	$results = array();
	foreach($cursors as $k=>$v){
		$stmt = $conn->query('FETCH ALL IN "'. $v[0] .'";');
		$results[$k] = $stmt->fetchAll();
		$stmt->closeCursor();
	}
	$conn->commit();
	unset($stmt);
	echo json_encode($results);
	//print_r($results);// all record sets
	$stmt = null; // obligado para cerrar la conexión

} catch (\Throwable $th) {
	print $e->getMessage();
}

?>
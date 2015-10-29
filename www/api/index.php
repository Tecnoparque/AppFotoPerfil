<?php
/*
	Author - Diego Alejandro Ramirez
	Contact - darasat@gmail.com
*/
require 'Slim/Slim.php';

use Slim\Slim;
Slim::registerAutoloader();

$app = new Slim();

$app->get('/session', 'getSession');
$app->get('/getPhotos', 'getPhotos');
$app->get('/getPhoto/:id', 'getPhoto');
$app->post('/addPhoto', 'addPhoto');
$app->put('/updatePhoto/:id', 'updatePhoto');
$app->delete('/deletePhoto/:id', 'deletePhoto');

$app->run();

// Get Database Connection
function getSession ()
{
    $db = new DB_Connection();
}


function DB_Connection() {	
	$dbhost = "127.0.0.1";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "ino";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

//Add new photo
function addPhoto() {
	$request = Slim::getInstance()->request();
	$cus = json_decode($request->getBody());

    $nombre_usuario = 'Bavarian';
    $nombre_mascota = "Firulai";
    $nombre_foto = "ionic";
    $path_foto = "img/cat.jpg";

    
    $sql = "INSERT INTO usuario_ino(nombre_usuario,
            nombre_mascota,
            nombre_foto, path_foto) VALUES (
            :nombre_usuario, 
            :nombre_mascota, 
            :nombre_foto, :path_foto)";
    
    
    //validar si hay un registro y si existe usuario, no se inserta 
                            
	try {
		$db = DB_Connection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(":nombre_usuario", $nombre_usuario);
		$stmt->bindParam(":nombre_mascota", $nombre_mascota);
		$stmt->bindParam(":nombre_foto", $nombre_foto);
        $stmt->bindParam(":path_foto", $path_foto);
		$stmt->execute();
		//$cus->id = $db->lastInsertId();
		$db = null;
		echo json_encode($cus); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

// GET One Customer Details
function getPhotos() {
	$sql = "select id,nombre_usuario,nombre_mascota, nombre_foto, path_foto FROM usuario_ino";
	try {
		$db = DB_Connection();
		$stmt = $db->query($sql);  
		$list = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($list);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
// GET One Customer Details
function getPhoto($id) {
	$sql = "SELECT path_foto FROM ino.usuario_ino WHERE id=".$id." ORDER BY id";
	try {
		$db = DB_Connection();
		$stmt = $db->query($sql);  
		$list = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($list);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
//Update Cutomer Details
function updatePhoto($id) {
	$request = Slim::getInstance()->request();
	$cus = json_decode($request->getBody());

	$sql = "UPDATE usuario_ino SET =:nombre_usuario,:nombre_mascota,:nombre:foto, path_foto WHERE id=:id";
	try {
		$db = DB_Connection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(":nombre_usuario", $nombre_usuario);
		$stmt->bindParam(":nombre_mascota", $nombre_mascota);
		$stmt->bindParam(":foto_mascota", $foto_mascota);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($cus); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
//DELETE Customer From the Database
function deletePhoto($id) {
	$sql = "DELETE FROM usuario_ino WHERE id=".$id;
	try {
		$db = DB_Connection();
		$stmt = $db->query($sql);  
		$list = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($list);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

?>
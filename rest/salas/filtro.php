<?php


include "config.php";
include "utilidades.php";


$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['nombre'])){
      //Mostrar lista de experiencias filtreado por salas
      $sql = $dbConn->prepare("SELECT * FROM experiencias where nombre_sala=:nombre");
      $sql->bindValue(':nombre', $_GET['nombre']);
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}


//Error
header("HTTP/1.1 400 Error de petición");


 ?>

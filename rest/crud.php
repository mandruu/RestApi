<?php
include "salas/config.php";
include "salas/utilidades.php";


$dbConn =  connect($db);


if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un registro especifico
      $sql = $dbConn->prepare("SELECT * FROM experiencias where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }else{
      $sql = $dbConn->prepare("SELECT * FROM experiencias");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
    }
}

// Crear
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $imagen_p = $_FILES['imagen']['tmp_name'];
    $imgContenido = file_get_contents($imagen_p);
    $imgContenido = base64_encode($imgContenido);
    $title = $_POST['titulo'];
    $imagen_int = file_get_contents('https://app.zenserp.com/api/v2/search?apikey=caa369d0-dc0d-11ea-9bd3-d76d57e7de52&q='.$title.'&tbm=isch&device=desktop&location=Medellin,Antioquia,Colombia');
    $imagen_intc = json_decode($imagen_int, true);
    $imagen_busqueda = $imagen_intc['image_results'][0]['sourceUrl'];
    $imagen_busquedaR = file_get_contents($imagen_busqueda);
    $imagen_busquedaR = base64_encode($imagen_busquedaR);
    $sql = "INSERT INTO experiencias
          (titulo, descripcion, nombre_sala, imagen_rel, imagen)
          VALUES
          (:titulo, :descripcion, :nombre, ";
    $sql .= "'" .$imagen_busquedaR."', ";
    $sql .= "'" .$imgContenido."')";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$id = $_GET['id'];
  $statement = $dbConn->prepare("DELETE FROM experiencias where id=:id");
  $statement->bindValue(':id', $id);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postId = $input['id'];
    $fields = getParams($input);

    $sql = "
          UPDATE experiencias
          SET $fields
          WHERE id='$postId'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


//Error
header("HTTP/1.1 400 Error de petición");

?>

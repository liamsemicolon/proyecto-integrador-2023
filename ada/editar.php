<?php
include "conexion.php";
$titulo = $_POST["titulo"];
$desc = $_POST["desc"];
$id = $_POST["id-a-editar"];
$fechahora = date("Y-m-d H:i:s", strtotime($_POST["fechahora"]));
$conn = conectar();
$query = "UPDATE `eventos` SET `titulo_evento` = '" . $titulo . "', `descripcion_evento` = '" . $desc . "', `fechahora_evento` = '" . $fechahora . "'  WHERE `eventos`.`id_evento` =" . $id; 
$result = mysqli_query($conn, $query);
header("Location: main.php");
desconectar();
?>
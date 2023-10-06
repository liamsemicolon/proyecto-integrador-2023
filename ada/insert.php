<?php
include "conexion.php";
$titulo = $_POST["titulo"];
$desc = $_POST["desc"];
$fechahora = date("Y-m-d H:i:s", strtotime($_POST["fechahora"]));
$conn = conectar();
$result = mysqli_query($conn, "INSERT INTO `eventos` (`titulo_evento`, `descripcion_evento`, `fechahora_evento`) VALUES ('" . $titulo . "','" . $desc . "','" . $fechahora . "');");
header("Location: main.php");
desconectar();
?>
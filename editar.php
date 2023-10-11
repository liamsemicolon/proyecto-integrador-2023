<?php
include "conexion.php";
#Volvemos a pasar los datos para el query update
$id = $_POST["id-a-editar"];
$opcionSeleccionada = $_POST["opciones"];
$conn = conectar();
$query = "UPDATE `vacaciones` SET `autorizadas_vacaciones` = '" . $opcionSeleccionada . "' WHERE `vacaciones`.`id_vacaciones` =" . $id; 
$result = mysqli_query($conn, $query);
header("Location: admin.php");
desconectar();
?>
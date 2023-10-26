<?php
include "conexion.php";
session_start();
$id = $_POST["id-a-editar"];
$opcionSeleccionada = $_POST["opciones"];
$fechaInicio = date("Y-m-d", strtotime($_POST["fechaInicio"]));
$fechaFinal = date("Y-m-d", strtotime($_POST["fechaFinal"]));
$_SESSION["alerta"] = 0;
$conn = conectar();

if ($fechaInicio > $fechaFinal) {
    $_SESSION['alerta'] = 1;
    
} else if ($fechaInicio <= $fechaFinal) {  
    $_SESSION['alerta'] = 2;  
    $query = "UPDATE `vacaciones` SET `inicio_vacaciones`='" . $fechaInicio . "', `fin_vacaciones`='" . $fechaFinal . "', `autorizadas_vacaciones` = '" . $opcionSeleccionada . "' WHERE `vacaciones`.`id_vacaciones` =" . $id; 
    $result = mysqli_query($conn, $query);
}


header("Location: admin.php");
desconectar($conn);
?>
<?php
session_start();
include "conexion.php";
$id = $_SESSION["id"];
$duracion = $_POST["duracion"];
$fecha = date("Y-m-d", strtotime($_POST["fecha"]));
$conn = conectar();
$_SESSION['exito'] = 0;
$query =  "INSERT INTO `vacaciones` (`inicio_vacaciones`, `fin_vacaciones`, `autorizadas_vacaciones`, `id_empleado`) VALUES ('" . $fecha . "', DATE_ADD('" . $fecha . "', INTERVAL " . $duracion . " DAY), 0, " . $id . ")";
# confirma que la fecha no esté a menos de 21 días del inicio o fin de cualquier otra vacación
# no encontré manera de acortar este choclo. pero funciona
$prueba = "SELECT ABS(DATEDIFF(inicio_vacaciones, '" . $fecha . "')), ABS(DATEDIFF(fin_vacaciones, '" . $fecha . "')) FROM vacaciones WHERE id_empleado = " . $id . " AND ABS(DATEDIFF(inicio_vacaciones, '" . $fecha . "')) < 21 AND ABS(DATEDIFF(fin_vacaciones, '" . $fecha . "')) < 21";
$resultPrueba = mysqli_query($conn, $prueba);
# el código de insert solo se ejecuta si el resultado es nulo, es decir, si la fecha no tiene esa distancia con otras fechas
$row = mysqli_fetch_array($resultPrueba, MYSQLI_ASSOC);
if(is_null($row)){
    echo $query;
    $result = mysqli_query($conn, $query);
    $_SESSION['exito'] = 1;
} else {
    $_SESSION['exito'] = 0; 
}
header("Location: main.php");
desconectar($conn);
?>
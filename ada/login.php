<?php
include "conexion.php";
session_start();
$user = $_POST["user"];
$pass = $_POST["pass"];
$conn = conectar();
$query = "SELECT a.`id_empleado`, a.`nombre_user`, a.`esgerente_user` FROM `users` a INNER JOIN `empleados` b ON a.`id_empleado` = b.`id_empleado` WHERE a.`nombre_user` = '" . $user . "' AND b.`dni_empleado` = '" . $pass . "'";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);
$cant_filas = mysqli_num_rows($result);
if($cant_filas == 1) {
    $_SESSION["incorrecto"] = 0;
    $_SESSION["id"] = $row["id_empleado"];
    if($row['esgerente_user'] == 0){
        $_SESSION["admin"] = 0;
        header("Location: main.php");
    } else {
        $_SESSION["admin"] = 1;
        header("Location: admin.php");
    }
} else {    
    $_SESSION["incorrecto"] = 1;
    header("Location: index.php");
}
desconectar($conn);
?>

<?php
include "conexion.php";
$user = $_POST["user"];
$pass = $_POST["pass"];
$conn = conectar();
$result = mysqli_query($conn, "SELECT COUNT(*) FROM `users` WHERE `nombre_user` = '" . $user . "' AND `dni_user` = '" . $pass . "' ");
$row = mysqli_fetch_array($result);
if($row['COUNT(*)'] == 1) {
    header("Location: main.php");
} else {
    header("Location: index.html");
}
desconectar();
?>
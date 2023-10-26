<?php
include 'conexion.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = $_POST["dni"];
    $apellido = trim($_POST["apellido"]);
    $nombre = trim($_POST["nombre"]);
    $username = trim($_POST["username"]);
    $fecha = date("Y-m-d", strtotime($_POST["fecha"]));
    if(isset($_POST["gerente"])){
        $esGerente = 1;
    } else {
        $esGerente = 0;
    }
    $query1 = "INSERT INTO `empleados` (`dni_empleado`, `apellido_empleado`, `nombre_empleado`, `ingreso_empleado`, `esgerente_empleado`) VALUES ('" . $dni . "', '" . $apellido . "', '" . $nombre . "', '" . $fecha. "', '" . $esGerente . "')";
    $query2 = "SELECT `id_empleado` FROM `empleados` ORDER BY `id_empleado` DESC LIMIT 1";
    $conn = conectar();
    try{
        $result1 = mysqli_query($conn, $query1);
        $_SESSION['error'] = "";

        $result2 = mysqli_query($conn, $query2);
        $row = mysqli_fetch_array($result2);
        $id = $row["id_empleado"];

        $query3 = "INSERT INTO `users` (`nombre_user`, `id_empleado`) VALUES ('" . $username . "', '" . $id . "')";
        $result3 = mysqli_query($conn, $query3);

    } catch(mysqli_sql_exception $e){
        $_SESSION['error'] = "Verifique que el DNI ingresado sea correcto.";
    }
    
    if($_SESSION["admin"] == 1){
        header("Location: admin.php");
    } else{
        header("Location: main.php");
    }

    desconectar($conn);
    
}
?>

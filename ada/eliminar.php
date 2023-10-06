<?php
include 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM `eventos` WHERE `id_evento` = " . $_POST['id-a-eliminar'];
    $conn = conectar();
    if (isset($_POST['id-a-eliminar'])) {
        $eventId = $_POST['id-a-eliminar'];
        $result = mysqli_query($conn, $query);
        desconectar($conn);
    }
    header("Location: main.php");
}
?>

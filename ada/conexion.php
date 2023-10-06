<?php
function conectar()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "ada";

    $conn = mysqli_connect($servername, $username, $password,$db);

    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function desconectar($conn){
    $conn -> close();
}
?>
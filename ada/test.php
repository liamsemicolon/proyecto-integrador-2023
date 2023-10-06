<?php
include 'conexion.php';
$conn = OpenCon();
echo "Connected Successfully";
CloseCon($conn);
?>
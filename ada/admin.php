<?php
session_start();
$_SESSION["exito"] = 1;
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img/favicon.png">
    <title>ADV - Administrador de Vacaciones    
    </title>
</head>

<!--Barra de Navegacion-->
<body>
    <nav class="navbar navbar-expand-lg navbar-dark text-uppercase">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/favicon.png" id="icono"><?php
            include "conexion.php";
            include 'interaccion.php';
            $conn = conectar();
            echo devolverNombre($conn, $_SESSION["id"]) ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="main.php">Enviar solicitudes de vacaciones</a>
            </li>
            </ul>
        </div>
    </nav>
    <div class="titulo">
        <h1 c>Lista de Vacaciones</h1>
        <hr>
    </div>

    <h2>Vacaciones Proximas:
    </h2>
    <!-- Query para las vacaciones futuras-->
    <?php
        $query = "SELECT `vacaciones`.*, `nombre_empleado`, `apellido_empleado` FROM `vacaciones` INNER JOIN `empleados` WHERE vacaciones.id_empleado = empleados.id_empleado AND `inicio_vacaciones` > NOW() AND `fin_vacaciones` > NOW() ORDER BY `fin_vacaciones` ASC;";

        construirEventosAdmin($conn, $query);
    ?>
    <h2>Vacaciones vigentes:
    </h2>
    <!-- Query para las vacaciones presentes-->
    <?php
        $query = "SELECT `vacaciones`.*, `nombre_empleado`, `apellido_empleado` FROM `vacaciones` INNER JOIN `empleados` WHERE vacaciones.id_empleado = empleados.id_empleado AND `inicio_vacaciones` < NOW() AND `fin_vacaciones` > NOW() ORDER BY `fin_vacaciones` ASC;";
        construirEventosAdmin($conn, $query);
        ?>

    <h2>Vacaciones Pasadas:
    </h2>
    <!-- Query para las vacaciones pasadas no hace mas de un mes-->
    <?php
        $query = "SELECT `vacaciones`.*, `nombre_empleado`, `apellido_empleado` FROM `vacaciones` INNER JOIN `empleados` WHERE vacaciones.id_empleado = empleados.id_empleado AND `inicio_vacaciones` < NOW() AND `fin_vacaciones` < NOW() AND MONTH(`fin_vacaciones`) = MONTH(NOW()) ORDER BY `fin_vacaciones` ASC;";
        construirEventosAdmin($conn, $query);
    ?>
</body>
</html>

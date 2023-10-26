<?php
session_start();
$_SESSION["exito"] = 1;
if (!isset($_SESSION["incorrecto"])){
    header("Location: login.php");
}
if ($_SESSION["admin"] != 1){
    header("Location: main.php");
}
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
    <?php
        if (isset($_SESSION['error']) && $_SESSION['error'] != ""){
            echo '<div class="alert dark" role="alert">
            <strong>Error:</strong> ' . $_SESSION['error'] . '
          </div>';
        }
    ?>
    <?php
    if (isset($_SESSION["alerta"]) ) {
        if ( $_SESSION["alerta"] == 1) {
            echo '<script>alert("La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, selecciona fechas válidas.");</script>';
            $_SESSION["alerta"] = 0;
            
        } elseif ($_SESSION['alerta'] == 2) {
            echo '<script>alert("Se ha modificado los datos correctamente");</script>';
            $_SESSION["alerta"] = 0;
        }
    }
    ?>
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
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalEmpleados">Registrar empleado</a>
            </li>
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
        $query = "SELECT `vacaciones`.*, `nombre_empleado`, `apellido_empleado` FROM `vacaciones` INNER JOIN `empleados` WHERE vacaciones.id_empleado = empleados.id_empleado AND `inicio_vacaciones` < NOW() AND `fin_vacaciones` < NOW() ORDER BY `fin_vacaciones` ASC;";
        construirEventosAdmin($conn, $query);
    ?>

    <!-- Form que permite registrar empleados-->
    <div class="modal fade" id="modalEmpleados" tabindex="-1" aria-labelledby="modalEmpleados" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="etiq-modalEmp">Registrar empleado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form>
                    <label for="apellido">Apellido:</label><br>
                    <input type="text" name="apellido" required> <br>
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" name="nombre" required> <br>
                    <label for="dni">DNI:</label><br>
                    <input type="number" name="dni" required><br>
                    <label for="fecha">Fecha de ingreso a la compañía:</label><br>
                    <input type="date" name="fecha" required><br>
                    <label for="gerente">¿Es gerente?:</label><br>
                    <input type="checkbox" name="gerente"><br>
                    <label for="username">Nombre de usuario:</label><br>
                    <input type="text" name="username" required><br><br>
                    <button type="submit" formmethod="post" formaction="nuevo.php" name="btn-subir" class="btn btn-dark mb-3">Enviar</button>
                    </form>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                    </div>
        </div>
</body>
</html>

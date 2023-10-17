<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/favicon.png">
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script>
    <title>ADV - Administrador de Vacaciones</title>
</head>
<body>
    <?php
    if (isset($_SESSION["exito"]) && $_SESSION["exito"] == 0){
        echo '<script>alert("Inserte una fecha válida")</script>';
    };
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
            <?php
                if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1){
                    
                    echo '<ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Volver a menú de gestión</a>
                    </li>
                    </ul>';
                }
            ?>
        </div>
    </nav>
<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse">Nuevo período de vacaciones</a>
                </div>
                <div id="collapse" class="panel-collapse collapse">
                    <div class="panel-body">
                    <form>
                        <p>
                        <?php
                        $id = $_SESSION["id"];
                        $diasVacaciones = diasVacaciones($conn, $id);
                        $periodo = periodoVacaciones($diasVacaciones);
                        $restantes = diasRestantes($conn, $id, $diasVacaciones);
                        $botonDeshabilitado = "";
                        if($restantes <= 0){
                            $botonDeshabilitado = "disabled";
                        }
                        echo "Período de vacaciones: ". $periodo . " días<br>Días restantes: " . $restantes . " de " . $diasVacaciones;
                        echo '
                        </p>
                        Fecha de comienzo de vacaciones:<br>
                        <div class="d-flex justify-content-center">
                        <input type="date" id="fecha" name="fecha" ' . minimoFecha($conn, $id) . $botonDeshabilitado . '>
                        <input type="hidden" id="duracion" name="duracion" value="' . $periodo . '">
                        <input type="hidden" id="id" name="id" value="' . $id . '">
                        </div>
                        </div>
                        <div class="d-flex justify-content-center">
                        <button type="submit" formmethod="post" formaction="insert.php" class="btn btn-dark mb-3" ' . $botonDeshabilitado . '>Enviar</button>
                        </div>
                        </div>
                        </form>
                        ';
                        desconectar($conn);
                        ?> 
                </div>
            </div>
        </div>
        </p>
    <h2>Vacaciones:
    </h2>
    <?php

        $conn = conectar();
        $query = "SELECT * FROM `vacaciones` WHERE `id_empleado` = " . $_SESSION["id"] . " ORDER BY `autorizadas_vacaciones` ASC";
        construirEventos($conn, $query);
        desconectar($conn);
    ?>
</body>
</html>

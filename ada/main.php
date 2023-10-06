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
    <title>ADA - Administrador de Actividades</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark text-uppercase">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/favicon.png" id="icono">Administrador de Actividades</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>
        </div>
    </nav>
<body>
<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse"> Nuevo evento </a>
                </div>
                <div id="collapse" class="panel-collapse collapse">
                    <div class="panel-body">
                    <form>
                        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Nombre de evento"/>
                        <input type="text" id="desc "name="desc" class="form-control" placeholder="Descripción de evento"/>
                        <div class="d-flex justify-content-center">
                        <input type="datetime-local" id="fechahora" name="fechahora">
                        </div>
                      </div>
                      <div class="d-flex justify-content-center">
                        <button type="submit" formmethod="post" formaction="insert.php" class="btn btn-dark mb-3">Enviar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </p>
    <h2>Eventos futuros:
    </h2>
    <?php
        include "conexion.php";
        include "interaccion.php";
        $conn = conectar();
        $query = "SELECT * FROM `eventos` WHERE `fechahora_evento` >= NOW() ORDER BY `fechahora_evento` ASC";
        construirEventos($conn, $query);
    ?>
    <h2>Eventos pasados:
    </h2>
    <?php
        $query = "SELECT * FROM `eventos` WHERE `fechahora_evento` < NOW() AND MONTH(`fechahora_evento`) = MONTH(NOW()) ORDER BY `fechahora_evento` ASC";
        construirEventos($conn, $query);
    ?>
</body>
</html>
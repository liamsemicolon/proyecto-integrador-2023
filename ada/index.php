<?php
session_start();
if (!isset($_SESSION["incorrecto"])){
    $_SESSION["incorrecto"] = 0;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="img/favicon.png">
        <title>ADA - Login</title>
    </head>
    <body>
        <?php
        if($_SESSION["incorrecto"] == 1){
            echo "<script>alert('Credenciales incorrectas, intente de nuevo.');</script>"; 
        }
        ?>
        <main class="container">
            <div class="caja-form container">
                <img src="img/ada-splash.png">
                <h5>Ingrese sus credenciales</h5>
                <hr>
                <form>
                    <div class="form-floating mb-4">
                        <input type="text" name="user" class="form-control" placeholder=""/>
                        <label for="user">Nombre de usuario</label>
                      </div>
                      <div class="form-floating mb-4">
                        <input type="password" name="pass" class="form-control" placeholder=""/>
                        <label for="pass">DNI</label>
                      </div>
                      <button type="submit" formmethod="post" formaction="login.php" class="btn btn-dark mb-3">Enviar</button>
                    </form>
                </div>
            </main>
        </body>
        </html>

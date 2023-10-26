<?php
function construirEventos($conn, $query){
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {    
        $id = $row['id_vacaciones'];
        $fIBD = $row['inicio_vacaciones'];
        $fITime = strtotime($fIBD);
        $fIUI = date("j/m/Y", $fITime);
        $fFBD =$row['fin_vacaciones'];
        $fFTime = strtotime($fFBD);
        $fFUI = date("j/m/Y", $fFTime);
        $estadoNum = $row['autorizadas_vacaciones'];
        echo '<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse' . $id . '">' . $fIUI . ' a ' . $fFUI . '</a>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse">
                    <div class="panel-body">' . estadoVacaciones($estadoNum) . '</div>
                    <div class="panel-footer">
                    <div>';
                    if($estadoNum != 1){
                        echo (botones($id));
                    }
                    echo '</div>
                    <p id="id-tag">' . $id . '</p>
                    </div>
                </div>
            </div>
        </div>
        </p>
        <div class="modal fade" id="modal' . $id . '" tabindex="-1" aria-labelledby="etiq-modal' . $id . '" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="etiq-modal' . $id . '">Editar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form>
                    <input type="hidden" name="id-a-editar" value="' . $id . '">     
                    <input type="text" id="titulo" name="titulo" class="form-control"  placeholder="Título de evento" value=""/><br>
                        <textarea id="desc" name="desc" class="form-control" placeholder="Descripción de evento"></textarea><br>
                        <div class="d-flex justify-content-center">
                        <input type="datetime-local" id="fechahora" name="fechahora" value="">
                        </div>
                        <div class="d-flex justify-content-center">
                        <button type="submit" formmethod="post" formaction="editar.php" name="btn-edit' . $id . '" class="btn btn-dark mb-3">Guardar cambios</button>
                        </div>
                        </form>
                      </div>
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}

function botones($id){
   return '<div class="container d-flex justify-content-center">
  <div class="row">
    <div class="col-sm">
    <form>
    <input type="hidden" name="id-a-eliminar" value="' . $id . '"> 
    <button type="submit" formmethod="post" formaction="eliminar.php" class="btn btn-dark" name="btn-elim' . $id . '">Eliminar</button>
    </form>
    </div>
  </div>
</div>';
}

function construirEventosAdmin($conn, $query){
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {    
        #Declarar variables del select sql
        $id = $row['id_vacaciones'];
        $nombre = $row['nombre_empleado'];
        $apellido = $row['apellido_empleado'];
        $evaluacion = $row['autorizadas_vacaciones'];
        $fhInicio =$row['inicio_vacaciones'];
        $fhFinal =$row['fin_vacaciones'];
        $fhInicioParse = strtotime($fhInicio);
        $fhFinalParse = strtotime($fhFinal);
        $fhI =  date("Y-m-d", $fhInicioParse);
        $fhF = date("Y-m-d", $fhFinalParse);
        $puedeEvaluar = false;
        $localDate = getLocalDate();

        $estado = estadoVacaciones($evaluacion);
        if ($estado == "A evaluar") {
            $puedeEvaluar = true;
        }

        #Cuerpo del objeto vacaciones
        echo '<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse' . $id . '">' . $apellido . " " . $nombre . '</a>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse">
                    <div class="panel-body"> Estado Vacaciones: ' . $estado . '</div>
                    <div class="panel-footer"> Fecha inicio: ' . $fhI . ' <br> Fecha Final: ' . $fhF. '
                    <div>' . botonesAdmin($id, $puedeEvaluar) . '</div>
                    <p id="id-tag">' . $id . '</p>
                    </div>
                </div>
            </div>
        </div>
        </p>

        <div class="modal fade" id="modal' . $id . '" tabindex="-1" aria-labelledby="etiq-modal' . $id . '" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="etiq-modal' . $id . '">Evaluar vacaciones</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form>
                    <input type="hidden" name="id-a-editar" value="' . $id . '"> 
                        <label for="aprobado">Autorizar</label>
                        <input type="radio" id="aprobado" name="opciones" value="1"><br>
                        <label for="denegado">Rechazar</label>
                        <input type="radio" id="denegado" name="opciones" value="2">
                        <br><br>
                        <button type="submit" formmethod="post" formaction="evaluar.php" name="btn-edit' . $id . '" class="btn btn-dark mb-3">Guardar cambios</button>
                    </form>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                    </div>
            </div>
        </div>
        
        <div class="modal fade" id="editar' . $id . '" tabindex="-1" aria-labelledby="etiq-modal' . $id . '" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="etiq-modal' . $id . '">Editar vacaciones</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form>
                    <input type="hidden" name="id-a-editar" value="' . $id . '"> 
                        ' . estadoEvaluacion($evaluacion) . '
                        <br>
                        <label for="fechaInicio">Fecha Inicio: </label><br>
                        <input type="date" id="fechaInicio" name="fechaInicio" min="' . $localDate . '">
                        <br><br>
                        <label for="fechaFinal">Fecha Final: </label><br>
                        <input type="date" id="fechaFinal" name="fechaFinal" min="' . $localDate . '">
                        <br><br>
                        <button type="submit" formmethod="post" formaction="editar.php" name="btn-edit' . $id . '" class="btn btn-dark mb-3">Guardar cambios</button>
                    </form>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                    </div>
            </div>
        </div>

        ';
    }
}
#Funcion que posibilita la evaluacion del periodo de vacaciones
function botonesAdmin($id, $puedeEvaluar){
    if ($puedeEvaluar) {
        return '<div class="container d-flex justify-content-center">
       <div class="row">
         <div class="col-sm">
         <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">
       Evaluar
     </button>
        </div>
        <div class="col-sm">
         <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editar' . $id . '">
         Editar
         </button>
         </div>
         <div class="col-sm">
         <form>
         <input type="hidden" name="id-a-eliminar" value="' . $id . '"> 
         <button type="submit" formmethod="post" formaction="eliminar.php" class="btn btn-dark" name="btn-elim' . $id . '">Eliminar</button>
         </form>
         </div>
       </div>
     </div>';
    } else {
        return '<div class="container d-flex justify-content-center">
        <div class="row">
         <div class="col-sm">
         <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editar' . $id . '">
         Editar
         </button>
         </div>
          <div class="col-sm">
          <form>
          <input type="hidden" name="id-a-eliminar" value="' . $id . '"> 
          <button type="submit" formmethod="post" formaction="eliminar.php" class="btn btn-dark" name="btn-elim' . $id . '">Eliminar</button>
          </form>
          </div>
        </div>
      </div>';
    }
}

function estadoVacaciones($int){
    $estado = "";
    if($int == 0){
        $estado = "A evaluar";
    } elseif ($int == 1){
        $estado = "Autorizadas";
    } elseif($int == 2){
        $estado = "Rechazadas";
    }
    return $estado;
}

function estadoEvaluacion($int) {
    if($int == 0){
        
    } elseif ($int == 1) {
        return '<label for="aprobado">Autorizar</label>
        <input type="radio" id="aprobado" name="opciones" checked="checked" value="1"><br>
        <label for="denegado">Rechazar</label>
        <input type="radio" id="denegado" name="opciones" value="2">
        <br>';
    } elseif($int == 2){
        return '<label for="aprobado">Autorizar</label>
        <input type="radio" id="aprobado" name="opciones" value="1"><br>
        <label for="denegado">Rechazar</label>
        <input type="radio" id="denegado" name="opciones" checked="checked" value="2">
        <br>';
    }
    
}

function diasVacaciones($conn, $id){
    $query = "SELECT DATEDIFF(CURDATE(), ingreso_empleado) AS 'dias' FROM empleados WHERE id_empleado =" . $id;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row['dias'];
    $dias = 0;
    if($total >= 28 && $total<= 55){
        $dias = 1;
    }elseif($total >= 56 && $total <= 83) {
        $dias = 2;
    }elseif($total >= 84 && $total <= 111) {
        $dias = 3;
    }elseif($total >= 112 && $total <= 139) {
        $dias = 4;
    }elseif($total >= 140 && $total <= 179) {
        $dias = 5;
    }elseif($total >= 180 && $total <= 1825) {
        $dias = 14;
    }elseif($total >= 1826 && $total <= 3650) {
        $dias = 21;
    }elseif($total >= 3651 && $total <= 7300) {
        $dias = 28;
    }elseif($total >= 7301) {
        $dias = 35;
    }
    return $dias;
}

function periodoVacaciones($dias){
    $periodo = 0;
    if($dias <=5){
        $periodo = $dias;
    } elseif($dias > 5){
        $periodo = 7;
    }
    return $periodo;
}

function diasRestantes($conn, $id, $dias){
    $query = "SELECT SUM(DATEDIFF(a.fin_vacaciones, a.inicio_vacaciones)) AS 'dias' FROM vacaciones a INNER JOIN empleados b ON a.id_empleado = b.id_empleado WHERE a.id_empleado = " . $id . " AND a.autorizadas_vacaciones = 1 AND a.fin_vacaciones > NOW()";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row['dias'];
    $resultado = $dias - $total;    
    return $resultado;
}

function minimoFecha($conn, $id){
    $query ="SELECT DATE_ADD(CURDATE(), INTERVAL 14 DAY) as 'min'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $minimo = $fFBD = $row['min'];
    $fFTime = strtotime($fFBD);
    $fF =  date("Y-m-d", $fFTime);
    $minimo = 'min = "'. $fF. '"';
    return $minimo;
}

function devolverNombre($conn, $id){
    $query ="SELECT apellido_empleado, nombre_empleado FROM empleados WHERE id_empleado =" . $id;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $ape = $fFBD = $row['apellido_empleado'];
    $nom = $fFBD = $row['nombre_empleado'];
    return $ape . ", " . $nom;
}

function getLocalDate() {
    $localDate = date('Y-m-d');
    return $localDate;
}
?>
<?php
function construirEventos($conn, $query){
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

        
        if ($evaluacion == 1) {
            $estado = "Aprobada";
        } elseif ($evaluacion == 2) {
            $estado = "Denegada";
        } else {
            $estado = "Por evaluar";
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
                    <div>' . botones($id, $puedeEvaluar) . '</div>
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
                        <label for="aprobado">Aprobar</label>
                        <input type="radio" id="aprobado" name="opciones" value="1"><br>
                        <label for="denegado">Denegar</label>
                        <input type="radio" id="denegado" name="opciones" value="2">
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
function botones($id, $puedeEvaluar){
    if ($puedeEvaluar) {
        return '<div class="container d-flex justify-content-center">
       <div class="row">
         <div class="col-sm">
         <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">
       Evaluar
     </button>
         </div>
         <div class="col-sm">
         <form>
         <input type="hidden" name="id-a-eliminar" value="' . $id . '"> 
         <button type="submit" formmethod="post" formaction="eliminar.php" class="btn btn-dark" name="btn-elim' . $id . '">Eliminar evento</button>
         </form>
         </div>
       </div>
     </div>';
    } else {
        return '<div class="container d-flex justify-content-center">
        <div class="row">
          <div class="col-sm">
          <form>
          <input type="hidden" name="id-a-eliminar" value="' . $id . '"> 
          <button type="submit" formmethod="post" formaction="eliminar.php" class="btn btn-dark" name="btn-elim' . $id . '">Eliminar evento</button>
          </form>
          </div>
        </div>
      </div>';
    }
}
?>


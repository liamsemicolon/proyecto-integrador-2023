<?php
function construirEventos($conn, $query){
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {    
        $id = $row['id_evento'];
        $titulo = $row['titulo_evento'];
        $desc = $row['descripcion_evento'];
        $fhBD =$row['fechahora_evento'];
        $fhTime = strtotime($fhBD);
        $fh =  date("Y-m-d\TH:i", $fhTime);
        $fhUI = date("j/m/Y H:i \h\s\.", $fhTime);
        echo '<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse' . $id . '">' . $titulo . '</a>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse">
                    <div class="panel-body">' . $fhUI . '</div>
                    <div class="panel-footer">' . $desc . '
                    <div>' . botones($id) . '</div>
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
                    <input type="text" id="titulo" name="titulo" class="form-control"  placeholder="Título de evento" value="' . $titulo . '"/><br>
                        <textarea id="desc" name="desc" class="form-control" placeholder="Descripción de evento">' . $desc . '</textarea><br>
                        <div class="d-flex justify-content-center">
                        <input type="datetime-local" id="fechahora" name="fechahora" value="' . $fh . '">
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
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">
  Editar evento
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
}
?>
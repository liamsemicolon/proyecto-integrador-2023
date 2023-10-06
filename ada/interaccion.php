<?php
function construirEventos($conn, $query){
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {    
        $id = $row['id_evento'];
        $titulo = $row['titulo_evento'];
        $desc = $row['descripcion_evento'];
        $fh = $row['fechahora_evento'];
        echo '<p>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-bs-toggle="collapse" href="#collapse' . $id . '">' . $titulo . '</a>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse">
                    <div class="panel-body">' . $fh . '</div>
                    <div class="panel-footer">' . $desc . '
                    <div>' . botones($id) . '</div>
                    <p id="id-tag">' . $id . '</p>
                    </div>
                </div>
            </div>
        </div>
        </p>';
    }
}

function botones($id){
   return '<div class="container d-flex justify-content-center">
  <div class="row">
    <div class="col-sm">
    <form>
    <input type="hidden" name="id-a-editar" value="' . $id . '"> 
    <button type="submit" formmethod="post" formaction="editar.php" class="btn btn-dark">
    </form>
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
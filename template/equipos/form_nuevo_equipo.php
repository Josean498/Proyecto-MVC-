<form method="POST" action="<?= URL ?>equipos/registrar" enctype="multipart/form-data">

    <div class="form-group">
        <label for="inputdescrip">Nombre</label>
        <input type="text" value="<?= $this->equipo['nombre'] ?>" class="form-control" name="nombre" placeholder=""
            required>
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['nombre']))? $this->errores['nombre']:null?></small>
    </div>
    <div class="form-group">
        <label for="inputprec">Nºpilotos</label>
        <input type="number" value="<?= $this->equipo['numPiloto'] ?>"  class="form-control"
            name="numPiloto" required>
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['numPiloto']))? $this->errores['numPiloto']:null?></small>
    </div>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
    <div class="form-group">
        <label for="inputFile">Imagen</label>
        <input type="file" class="form-control-file" name="imagen">
    </div>
    <small id="nameHelp"
        class="form-text text-danger"><?= (isset($this->errores['imagen']))? $this->errores['imagen']:null?></small>

    <div class="form-group">
        <label for="inputprev">Nacionalidad</label>
        <input type="text" value="<?= $this->equipo['nacionalidad'] ?>"  class="form-control"
            name="nacionalidad" required>
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['nacionalidad']))? $this->errores['nacionalidad']:null?></small>
    </div>
    

    <!-- botones acción -->
    <hr>
    <a href="<?= URL ?>equipos" class="btn btn-secondary" role="button" aria-pressed="true">Cancelar</a>
    <button type="reset" class="btn btn-secondary">Reset</button>
    <button type="submit" class="btn btn-primary">Añadir</button>

</form>
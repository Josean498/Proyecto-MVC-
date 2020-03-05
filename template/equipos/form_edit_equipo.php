<form method="POST" action="<?= URL ?>equipos/actualizar" enctype="multipart/form-data">
<div class="form-group">
        <label hidden for="inputid">Id</label>
        <input hidden type="number" value="<?= $this->equipo['id'] ?>" min="0" step="0.01" class="form-control"
            name="id">
        <small hidden id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['id']))? $this->errores['id']:null?></small>
    </div>
    <div class="form-group">
        <label for="inputdescrip">Nombre</label>
        <input type="text" value="<?= $this->equipo['nombre'] ?>" class="form-control" name="nombre" placeholder=""
        >
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['nombre']))? $this->errores['nombre']:null?></small>
    </div>
    <div class="form-group">
        <label for="inputprec">Nºpilotos</label>
        <input type="number" value="<?= $this->equipo['numPiloto'] ?>"  class="form-control"
            name="numPiloto">
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['numPiloto']))? $this->errores['numPiloto']:null?></small>
    </div>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
    <div class="form-group">
        <label for="inputFile">Imagen</label>
        <input type="file" value="<?= $this->equipo['imagen'] ?>" name="imagen" class="form-control-file">
    </div>
        <img src="<?= URL ?>imagenes/<?=$this->equipo['imagen']?>" value="<?= $this->equipo['imagen'] ?>" width="120px" height="120px">
    <small id="nameHelp"
        class="form-text text-danger"><?= (isset($this->errores['imagen']))? $this->errores['imagen']:null?></small>

    <div class="form-group">
        <label for="inputprev">Nacionalidad</label>
        <input type="text" value="<?= $this->equipo['nacionalidad'] ?>"  class="form-control"
            name="nacionalidad">
        <small id="nameHelp"
            class="form-text text-danger"><?= (isset($this->errores['nacionalidad']))? $this->errores['nacionalidad']:null?></small>
    </div>
    

    <!-- botones acción -->
    <hr>
    <a href="<?= URL ?>equipos" class="btn btn-secondary" role="button" aria-pressed="true">Volver</a>
    <button type="reset" class="btn btn-secondary">Reset</button>
    <button type="submit" class="btn btn-primary">Editar</button>
</form>
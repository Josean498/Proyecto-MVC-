<form action="<?= URL ?>user/validar_registro" method="post">
  <legend class="border-bottom">Registrarse</legend>
  <fieldset>
      <div class="form-group">
        <label for="">Nombre</label>
        <input type="text"
          class="form-control" name="nombre" id="" aria-describedby="helpId" placeholder=""
          value="<?= (isset($_POST['nombre'])) ? $_POST['nombre'] : null ?>">
          
          <small id="helpId" class="form-text text-muted">Nombre de usuario entre 5 y 50 caracteres</small>

      </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="">Correo Electronico</label>
      <input type="email" class="form-control" name="email" id="" aria-describedby="emailHelpId" placeholder=""
      value="<?= (isset($_POST['email'])) ? $_POST['email'] : null ?>">
      <small id="helpId" class="form-text text-muted">Introduce un correo electronico válido</small>
      <small id="helpId" class="form-text text-danger">
        <?= (isset($this->errores['email'])) ? $this->errores['email'] : null ?>
      </small>
      
    </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="">Contraseña</label>
      <input type="password" class="form-control" name="password" id="" placeholder=""
      value="<?= (isset($_POST['password'])) ? $_POST['password'] : null ?>">
      <small id="helpId" class="form-text text-muted">Introduce una contraseña entre 5 y 60 caracteres</small>
      <small id="helpId" class="form-text text-danger">
        <?= (isset($this->errores['password'])) ? $this->errores['password'] : null ?>
      </small>
    </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="">Repetir Contraseña</label>
      <input type="password" class="form-control" name="password2" id="" placeholder="">
      <small id="helpId" class="form-text text-muted">Repetir contraseña</small>
    </div>
  </fieldset>

  <button type="submit" class="btn btn-primary">Registrarse</button>
  <a name="" id="" class="btn btn-secondary" href="<?= URL ?>user" role="button">Iniciar Sesión</a>
</form>

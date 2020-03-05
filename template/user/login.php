<form action="<?= URL ?>user/validar_acceso" method="post">
  <legend class="border-bottom">Iniciar Sesión</legend>
  <fieldset>
    <div class="form-group">
      <label for="">Correo Electronico</label>
      <input type="email" class="form-control" name="email" id="" aria-describedby="emailHelpId" placeholder=""
      value="<?= (isset($_POST['email'])) ? $_POST['email'] : null ?>">
      <small id="helpId" class="form-text text-danger">
        <?= (isset($_SESSION['errores']['email'])) ? $_SESSION['errores']['email'] : null ?>
      </small>
    </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="">Contraseña</label>
      <input type="password" class="form-control" name="password" id="" placeholder=""
      value="<?= (isset($_POST['password'])) ? $_POST['password'] : null ?>">
      <small id="helpId" class="form-text text-danger">
        <?= (isset($_SESSION['errores']['password'])) ? $_SESSION['errores']['password'] : null ?>
      </small>
    </div>
  </fieldset>
  <fieldset>
    <div class="form-check">
      <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="" id="" >
        Recuérdame
      </label>
    </div>
  </fieldset>
  <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
  <a name="" id="" class="btn btn-secondary" href="<?= URL ?>user/register" role="button">Registrarse</a>
</form>

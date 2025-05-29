<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">Registro de Usuario</h2>
    <?php if (! empty($validation->getErrors())): ?>
      <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
      </div>
    <?php endif; ?>

    <form id="registerForm" action="<?= base_url('registro-usuario') ?>" method="post" novalidate>
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="nombre_completo" class="form-label">Nombre completo</label>
        <input value="<?= set_value('nombre_completo') ?>"
          type="text"
          class="form-control <?= isset($validation) && $validation->hasError('nombre_completo') ? 'is-invalid' : '' ?>"
          id="nombre_completo"
          name="nombre_completo"
          required>
        <div class="invalid-feedback">
          <?= $validation->getError('nombre_completo') ?? 'Por favor ingresa tu nombre.' ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono (opcional)</label>
        <input value="<?= set_value('telefono') ?>"
          type="text"
          class="form-control <?= isset($validation) && $validation->hasError('telefono') ? 'is-invalid' : '' ?>"
          id="telefono"
          name="telefono">
        <div class="invalid-feedback">
          <?= $validation->getError('telefono') ?>
        </div>
      </div>


      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input value="<?= set_value('email') ?>" type="email" class="form-control <?php if (isset($validation) && $validation->hasError('email')) echo 'is-invalid'; ?>" id="email" name="email" required>
        <div class="invalid-feedback">
          <?= $validation->getError('email') ?? 'Por favor ingresa un email válido.' ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control <?php if (isset($validation) && $validation->hasError('password')) echo 'is-invalid'; ?>" id="password" name="password" required minlength="6">
        <div class="invalid-feedback">
          <?= $validation->getError('password') ?? 'La contraseña debe tener al menos 6 caracteres.' ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="pass_confirm" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control <?php if (isset($validation) && $validation->hasError('pass_confirm')) echo 'is-invalid'; ?>" id="pass_confirm" name="pass_confirm" required minlength="6">
        <div class="invalid-feedback">
          <?= $validation->getError('pass_confirm') ?? 'Las contraseñas deben coincidir.' ?>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
  </div>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function() {
      'use strict';
      const form = document.getElementById('registerForm');
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        const pwd = document.getElementById('password').value;
        const confirm = document.getElementById('pass_confirm').value;
        if (pwd !== confirm) {
          event.preventDefault();
          event.stopPropagation();
          document.getElementById('pass_confirm').classList.add('is-invalid');
        }
        form.classList.add('was-validated');
      }, false);
    })();
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

    <?php if(isset($validation)): ?>
      <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post" novalidate>
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-control <?php if(isset($validation) && $validation->hasError('email')) echo 'is-invalid'; ?>"
          id="email"
          name="email"
          value="<?= set_value('email') ?>"
          required
        >
        <div class="invalid-feedback">
          <?= $validation->getError('email') ?? 'Por favor ingresa un email válido.' ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input
          type="password"
          class="form-control <?php if(isset($validation) && $validation->hasError('password')) echo 'is-invalid'; ?>"
          id="password"
          name="password"
          required
        >
        <div class="invalid-feedback">
          <?= $validation->getError('password') ?? 'Por favor ingresa tu contraseña.' ?>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
  </div>

  <!-- Bootstrap 5 JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      'use strict';
      const form = document.querySelector('form');
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    })();
  </script>
</body>
</html>
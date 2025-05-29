<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'App Citas') ?></title>
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php
$role = (int) session('user_role');
$home = match ($role) {
    1       => base_url('/admin/dashboard'),
    2       => base_url('/tecnico/dashboard'),
    default => base_url('/dashboard'),   // cliente u otros
};
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <!-- Logo que redirige según rol -->
    <a class="navbar-brand" href="<?= $home ?>">AC Citas</a>

    <div class="ms-auto">
      <a class="btn btn-sm btn-outline-light" href="<?= base_url('/logout') ?>">
        Cerrar sesión
      </a>
    </div>
  </div>
</nav>

<?= $this->renderSection('content') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

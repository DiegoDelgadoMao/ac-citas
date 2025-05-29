<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Usuarios</h2>
  <a href="<?= base_url('/usuarios/create') ?>" class="btn btn-primary mb-3">Nuevo Usuario</a>

  <?php if($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

  <table class="table table-hover">
    <thead class="table-light">
      <tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach($usuarios as $u): ?>
        <tr>
          <td><?= esc($u['nombre_completo']) ?></td>
          <td><?= esc($u['email']) ?></td>
          <td><?= esc($u['telefono']) ?></td>
          <td><?= esc($u['nombre_rol']) ?></td>
          <td>
            <a href="<?= base_url('/usuarios/edit/'.$u['id_usuario']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
            <a href="<?= base_url('/usuarios/delete/'.$u['id_usuario']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">Borrar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>

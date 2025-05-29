<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Servicios</h2>
  <a href="<?= base_url('admin/servicios/create') ?>" class="btn btn-primary mb-3">Nuevo Servicio</a>

  <?php if($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

  <table class="table table-hover">
    <thead class="table-light">
      <tr><th>ID</th><th>Tipo</th><th>Descripción</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach($servicios as $s): ?>
        <tr>
          <td><?= $s['id_servicio'] ?></td>
          <td><?= esc($s['tipo_servicio']) ?></td>
          <td><?= esc($s['descripcion']) ?></td>
          <td>
            <a href="<?= base_url('admin/servicios/edit/'.$s['id_servicio']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
            <a href="<?= base_url('admin/servicios/delete/'.$s['id_servicio']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">Borrar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($servicios)): ?>
        <tr><td colspan="4" class="text-center p-4">Sin servicios registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>

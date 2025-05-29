<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Técnicos</h2>
  <a href="<?= base_url('/tecnicos/create') ?>" class="btn btn-primary mb-3">Nuevo Técnico</a>

  <?php if(session('msg')): ?>
    <div class="alert alert-success"><?= session('msg') ?></div>
  <?php endif; ?>

  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>Nombre</th><th>Email</th><th>Especialidad</th><th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tecnicos as $t): ?>
        <tr>
          <td><?= esc($t['nombre_completo']) ?></td>
          <td><?= esc($t['email']) ?></td>
          <td><?= esc($t['especialidad']) ?></td>
          <td>
            <a href="<?= base_url('/tecnicos/edit/'.$t['id_tecnico']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
            <a href="<?= base_url('/tecnicos/delete/'.$t['id_tecnico']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar?')">Borrar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($tecnicos)): ?>
        <tr><td colspan="4" class="text-center p-4">Sin técnicos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>

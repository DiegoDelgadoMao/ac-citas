<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Todas las Citas</h2>

  <?php if($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>Fecha</th><th>Hora</th><th>Cliente</th><th>Técnico</th>
        <th>Servicio</th><th>Estado</th><th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($citas as $c): ?>
        <tr>
          <td><?= esc($c['fecha']) ?></td>
          <td><?= esc(substr($c['hora'],0,5)) ?></td>
          <td><?= esc($c['cliente']) ?></td>
          <td><?= esc($c['tecnico']) ?></td>
          <td><?= esc($c['tipo_servicio']) ?></td>
          <td><span class="badge bg-secondary"><?= esc($c['estado']) ?></span></td>
          <td class="text-nowrap">
            <?php if($c['estado']=='Programada'): ?>
              <a class="btn btn-sm btn-success"
                 href="<?= base_url("admin/citas/cambiar/{$c['id_cita']}/Realizada") ?>">
                 Realizar
              </a>
              <a class="btn btn-sm btn-warning"
                 href="<?= base_url("admin/citas/cambiar/{$c['id_cita']}/Cancelada") ?>"
                 onclick="return confirm('¿Cancelar cita?')">
                 Cancelar
              </a>
            <?php endif; ?>
            <a class="btn btn-sm btn-outline-danger"
               href="<?= base_url("admin/citas/delete/{$c['id_cita']}") ?>"
               onclick="return confirm('¿Eliminar definitivamente?')">
               Borrar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Paginación -->
  <div class="d-flex justify-content-center">
    <?= $pager->links('citas', 'default_full') ?>
  </div>
</div>

<?= $this->endSection() ?>

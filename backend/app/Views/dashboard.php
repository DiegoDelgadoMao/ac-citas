<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Bienvenido, <?= esc($userName) ?></h2>

  <!-- Resumen -->
  <div class="row g-3 mb-4">
    <?php foreach (['programadas'=>'Programadas','realizadas'=>'Realizadas','canceladas'=>'Canceladas','total'=>'Total'] as $k=>$label): ?>
      <div class="col-6 col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title"><?= $label ?></h5>
            <p class="fs-3 mb-0"><?= $stats[$k] ?? 0 ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Próximas citas -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span>Próximas citas</span>
      <a href="<?= base_url('/citas/crear') ?>" class="btn btn-sm btn-primary">Programar nueva cita</a>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Fecha</th><th>Hora</th><th>Servicio</th><th>Técnico</th><th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($citas as $c): ?>
            <tr>
              <td><?= esc($c['fecha']) ?></td>
              <td><?= esc(substr($c['hora'],0,5)) ?></td>
              <td><?= esc($c['tipo_servicio']) ?></td>
              <td><?= esc($c['tecnico']) ?></td>
              <td><span class="badge bg-secondary"><?= esc($c['estado']) ?></span></td>
            </tr>
          <?php endforeach; ?>
          <?php if(empty($citas)): ?>
            <tr><td colspan="5" class="text-center p-4">Sin citas próximas.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

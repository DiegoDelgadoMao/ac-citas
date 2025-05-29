<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <?php if (session('msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
  <h2 class="mb-3">Citas de hoy – <?= esc($userName) ?></h2>

  <div class="row g-3 mb-4">
    <?php foreach (['programadas' => 'Programadas', 'realizadas' => 'Realizadas', 'canceladas' => 'Canceladas', 'total' => 'Total'] as $k => $lbl): ?>
      <div class="col-6 col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <h6 class="card-title"><?= $lbl ?></h6>
            <p class="fs-3 mb-0"><?= $stats[$k] ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="card">
    <div class="card-header">Detalle de citas</div>
    <form class="d-flex mb-2" method="get">
      <label class="me-2 fw-bold" for="f">Fecha:</label>
      <input type="date" id="f" name="f" value="<?= esc($selected) ?>" class="form-control"
        min="<?= date('Y-m-d', strtotime('-30 days')) ?>"
        max="<?= date('Y-m-d', strtotime('+30 days')) ?>" onchange="this.form.submit()">
    </form>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th>Hora</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Estado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($citas as $c): ?>
            <tr>
              <td><?= esc(substr($c['hora'], 0, 5)) ?></td>
              <td><?= esc($c['cliente']) ?></td>
              <td><?= esc($c['tipo_servicio']) ?></td>
              <td><span class="badge bg-secondary"><?= esc($c['estado']) ?></span></td>
              <td>
                <?php if ($c['estado'] == 'Programada'): ?>
                  <a class="btn btn-sm btn-success"
                    href="<?= base_url('/tecnico/completar/' . $c['id_cita']) ?>">
                    Marcar realizada
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($citas)): ?>
            <tr>
              <td colspan="5" class="text-center p-4">Sin citas para hoy.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
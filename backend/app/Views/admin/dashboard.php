<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-3">Panel de Administración</h2>

  <p class="lead">Bienvenido, <?= esc($userName) ?>.</p>

  <div class="row g-3">
    <div class="col-md-4">
      <a href="<?= base_url('/tecnicos') ?>" class="card text-center text-decoration-none">
        <div class="card-body">
          <h5 class="card-title">Gestionar Técnicos</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="<?= base_url('/usuarios') ?>" class="card text-center text-decoration-none">
        <div class="card-body">
          <h5 class="card-title">Gestionar Usuarios</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="<?= base_url('admin/citas') ?>" class="card text-center text-decoration-none">
        <div class="card-body">
          <h5 class="card-title">Ver Todas las Citas</h5>
        </div>
      </a>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

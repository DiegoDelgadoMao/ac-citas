<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4" style="max-width:600px;">
  <h2 class="mb-3">Programar nueva cita</h2>

  <?php if(session('msg')): ?>
    <div class="alert alert-warning"><?= session('msg') ?></div>
  <?php endif; ?>
  <?php if($validation->getErrors()): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
  <?php endif; ?>

  <form action="<?= base_url('/citas/store') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">Servicio</label>
      <select name="id_servicio" class="form-select" required>
        <option value="">-- Seleccione --</option>
        <?php foreach($servicios as $s): ?>
          <option value="<?= $s['id_servicio'] ?>" <?= set_select('id_servicio',$s['id_servicio']) ?>>
            <?= esc($s['tipo_servicio']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Técnico</label>
      <select name="id_tecnico" class="form-select" required>
        <option value="">-- Seleccione --</option>
        <?php foreach($tecnicos as $t): ?>
          <option value="<?= $t['id_tecnico'] ?>" <?= set_select('id_tecnico',$t['id_tecnico']) ?>>
            <?= esc($t['nombre_completo']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" class="form-control"
               min="<?= date('Y-m-d') ?>"
               value="<?= set_value('fecha') ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Hora</label>
        <input type="time" name="hora" class="form-control"
               value="<?= set_value('hora') ?>" required>
      </div>
    </div>

    <button class="btn btn-primary">Guardar cita</button>
    <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $this->endSection() ?>

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4" style="max-width:600px;">
  <h2 class="mb-3"><?= esc($title) ?></h2>

  <?php if($validation->getErrors()): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
  <?php endif; ?>

  <form action="<?= $action ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <?php $current = $servicio['tipo_servicio'] ?? set_value('tipo_servicio'); ?>
      <select name="tipo_servicio" class="form-select" required>
        <option value="">-- Seleccione --</option>
        <?php foreach(['MANT_PREV'=>'Mantenimiento Preventivo','MANT_CORR'=>'Mantenimiento Correctivo','INST'=>'Instalación'] as $k=>$label): ?>
          <option value="<?= $k ?>" <?= $k==$current?'selected':'' ?>><?= $label ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" rows="3" required><?= set_value('descripcion', $servicio['descripcion'] ?? '') ?></textarea>
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="<?= base_url('admin/servicios') ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $this->endSection() ?>

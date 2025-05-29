<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4" style="max-width: 500px;">
  <h2 class="mb-3"><?= esc($title) ?></h2>

  <?php if($validation->hasError('especialidad')||$validation->hasError('id_usuario')): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
  <?php endif; ?>

  <form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>

    <?php if(!isset($tecnico)): ?>
      <div class="mb-3">
        <label class="form-label">Usuario</label>
        <select name="id_usuario" class="form-select" required>
          <option value="">-- Seleccione --</option>
          <?php foreach($usuarios as $u): ?>
            <option value="<?= $u['id_usuario'] ?>"><?= esc($u['nombre_completo'].' ('.$u['email'].')') ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    <?php else: ?>
      <p><strong>Usuario:</strong> <?= esc($tecnico['id_usuario']) ?></p>
    <?php endif; ?>

    <div class="mb-3">
      <label class="form-label">Especialidad</label>
      <input type="text" name="especialidad" class="form-control"
             value="<?= set_value('especialidad', $tecnico['especialidad'] ?? '') ?>" required>
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="<?= base_url('/tecnicos') ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $this->endSection() ?>

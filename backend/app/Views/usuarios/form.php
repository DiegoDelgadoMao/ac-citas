<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4" style="max-width:520px;">
  <h2 class="mb-3"><?= esc($title) ?></h2>

  <?php if($validation->getErrors()): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
  <?php endif; ?>

  <form action="<?= $action ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label>Nombre completo</label>
      <input type="text" name="nombre_completo" class="form-control"
             value="<?= set_value('nombre_completo', $usuario['nombre_completo'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control"
             value="<?= set_value('telefono', $usuario['telefono'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control"
             value="<?= set_value('email', $usuario['email'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label>Contraseña <?= isset($usuario)?'<small>(dejar en blanco para no cambiar)</small>':'' ?></label>
      <input type="password" name="password" class="form-control" <?= isset($usuario)?'':'required' ?>>
    </div>

    <div class="mb-3">
      <label>Rol</label>
      <select name="id_rol" class="form-select" required>
        <?php foreach($roles as $r): ?>
          <option value="<?= $r['id_rol'] ?>"
            <?= set_select('id_rol', $r['id_rol'], isset($usuario) && $usuario['id_rol']==$r['id_rol']) ?>>
            <?= esc($r['nombre_rol']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="<?= base_url('/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $this->endSection() ?>

<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Nuevo Docente<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Nuevo Docente<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Registrar Docente</h3>
    </div>
    <div class="admin-card-body">
        <?php if (session('error')): ?>
            <div class="admin-alert admin-alert-error mb-4">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= base_url('admin/docentes/store') ?>">

            <div class="admin-form-group">
                <label for="ci" class="admin-label">Cédula</label>
                <input type="text" name="ci" id="ci" class="admin-input" value="<?= old('ci') ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="name" class="admin-label">Nombre</label>
                <input type="text" name="name" id="name" class="admin-input" value="<?= old('name') ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="surname" class="admin-label">Apellido</label>
                <input type="text" name="surname" id="surname" class="admin-input" value="<?= old('surname') ?>"
                    required>
            </div>
            <div class="admin-form-group">
                <label for="email" class="admin-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="admin-input" value="<?= old('email') ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="password" class="admin-label">Contraseña</label>
                <input type="password" name="password" id="password" class="admin-input" required>
            </div>
            <div class="flex justify-end mt-6">
                <a href="<?= base_url('admin/docentes') ?>" class="admin-btn-secondary mr-2">Cancelar</a>
                <button type="submit" class="admin-btn-primary">Crear Docente</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
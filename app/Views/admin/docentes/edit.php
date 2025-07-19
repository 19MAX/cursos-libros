<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Editar Docente<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Editar Docente<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Editar Docente</h3>
    </div>
    <div class="admin-card-body">
        <?php if (session('error')): ?>
            <div class="admin-alert admin-alert-error mb-4">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= base_url('admin/docentes/update/' . $docente['id']) ?>">

            <div class="admin-form-group">
                <label for="ci" class="admin-label">Cédula</label>
                <input type="text" name="ci" id="ci" class="admin-input" value="<?= esc($docente['ci']) ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="name" class="admin-label">Nombre</label>
                <input type="text" name="name" id="name" class="admin-input" value="<?= esc($docente['name']) ?>"
                    required>
            </div>
            <div class="admin-form-group">
                <label for="surname" class="admin-label">Apellido</label>
                <input type="text" name="surname" id="surname" class="admin-input"
                    value="<?= esc($docente['surname']) ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="email" class="admin-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="admin-input" value="<?= esc($docente['email']) ?>"
                    required>
            </div>
            <div class="flex justify-end mt-6">
                <a href="<?= base_url('admin/docentes') ?>" class="admin-btn-secondary mr-2">Cancelar</a>
                <button type="submit" class="admin-btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
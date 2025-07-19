<?= $this->extend('layouts/docente_layout'); ?>
<?= $this->section('title') ?>Mi Perfil<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Mi Perfil<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Editar Información de Perfil</h3>
    </div>
    <div class="admin-card-body">
        <?php if (session('success')): ?>
            <div class="admin-alert admin-alert-success mb-4">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= base_url('docente/perfil') ?>">
            <div class="admin-form-group">
                <label for="name" class="admin-label">Nombre</label>
                <input type="text" name="name" id="name" class="admin-input" value="<?= esc($docente['name']) ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="surname" class="admin-label">Apellido</label>
                <input type="text" name="surname" id="surname" class="admin-input" value="<?= esc($docente['surname']) ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="username" class="admin-label">Usuario</label>
                <input type="text" name="username" id="username" class="admin-input" value="<?= esc($docente['username']) ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="email" class="admin-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="admin-input" value="<?= esc($docente['email']) ?>" required>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="admin-btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?> 
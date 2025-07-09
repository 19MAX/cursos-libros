<?= $this->extend('layouts/auth_layout'); ?>

<?= $this->section('title') ?>
Recuperar Contraseña
<?= $this->endSection() ?>

<?= $this->section('titleSection') ?>
Te olvidaste la contraseña ?
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-card-transparent p-5">

    <form action="<?= base_url('auth/recover') ?>" method="post">
        <h2 class="text-2xl font-bold mb-6 text-center admin-text-primary">Recuperar Contraseña</h2>

        <!-- Cedula -->
        <div class="admin-form-group">
            <label for="ci" class="admin-label admin-label-required">Cédula</label>
            <input type="text" name="ci" id="ci" class="admin-input" placeholder="Tu cédula" required>
        </div>

        <!-- Forgot password -->
        <div class="flex justify-end mb-6">
            <a href="<?=base_url('auth/login')?>" class="admin-link text-sm">Ingresar al sistema</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="admin-btn-primary w-full">Entrar</button>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/auth_layout'); ?>

<?= $this->section('title') ?>
Iniciar sesión
<?= $this->endSection() ?>

<?= $this->section('titleSection') ?>
Bienvenido de nuevo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form method="post" action="<?= site_url('login') ?>">
    <!-- Campos de usuario y contraseña -->
    <input type="text" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>
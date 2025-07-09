<?= $this->extend('layouts/auth_layout'); ?>

<?= $this->section('title') ?>
Iniciar sesión
<?= $this->endSection() ?>

<?= $this->section('titleSection') ?>
Bienvenido de nuevo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-card-transparent p-5">

    <form action="<?= base_url('auth/login') ?>" method="post">
        <h2 class="text-2xl font-bold mb-6 text-center admin-text-primary">Iniciar sesión</h2>

        <!-- Cedula -->
        <div class="admin-form-group">
            <label for="ci" class="admin-label admin-label-required">Cédula</label>
            <input type="text" name="ci" id="ci" class="admin-input" placeholder="Tu cédula" required>
        </div>

        <!-- Password -->
        <div class="admin-form-group">
            <label for="password" class="admin-label admin-label-required">Contraseña</label>
            <div class="relative">
                <input type="password" name="password" id="password" class="admin-input-with-icon"
                    placeholder="••••••••" required>
                <button type="button" id="togglePassword" tabindex="-1"
                    class="admin-btn-icon absolute inset-y-0 end-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                    <ion-icon id="eyeIcon" class="w-5 h-5" name="eye-outline"></ion-icon>
                </button>
            </div>
        </div>

        <!-- Forgot password -->
        <div class="flex justify-end mb-6">
            <a href="<?=base_url('auth/recover')?>" class="admin-link text-sm">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="admin-btn-primary w-full">Entrar</button>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.setAttribute('name', 'eye-off-outline');
        } else {
            password.type = 'password';
            eyeIcon.setAttribute('name', 'eye-outline');
        }
    });
</script>
<?= $this->endSection() ?>
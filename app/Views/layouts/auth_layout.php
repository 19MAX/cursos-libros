<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <?= $this->include('partials/global/head') ?>
</head>

<body class="admin-container">

    <!-- Botón de cambio de tema mejorado -->
    <button id="theme-toggle" type="button" class="admin-btn-icon fixed top-4 right-4 z-50" aria-label="Cambiar tema">
        <ion-icon id="theme-toggle-dark-icon" class="w-5 h-5 hidden text-gray-600 dark:text-gray-300"
            name="moon-outline"></ion-icon>
        <ion-icon id="theme-toggle-light-icon" class="w-5 h-5 hidden text-yellow-500" name="sunny-outline"></ion-icon>
    </button>

    <main class="flex flex-1 flex-col justify-center items-center py-8">
        <div class="w-full max-w-md mx-auto">
            <div class="flex flex-col items-center mb-6">
                <div class="mb-2">
                    <img src="<?= base_url('assets/images/imagen-login.png') ?>" alt="Logo"
                        class="w-20 h-20 rounded-full admin-shadow object-cover bg-white border admin-divider transition-colors">
                </div>
                <h4 class="text-2xl font-semibold admin-text-primary text-center">
                    <?= $this->renderSection('titleSection'); ?>
                </h4>
            </div>
            <?= $this->renderSection('content'); ?>
        </div>
    </main>

    <footer
        class="w-full py-4 border-t admin-divider text-center mt-auto admin-transition-colors">
        <div class="flex items-center justify-center gap-2 admin-text-muted text-sm">
            <i class="ion-locked me-1"></i> Conexión segura SSL | © <?= date('Y') ?> Todos los derechos reservados
        </div>
    </footer>

    <?= $this->include('partials/global/scripts') ?>
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
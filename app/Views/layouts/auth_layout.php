<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <?= $this->include('partials/auth/head-css') ?>

    <script src="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"></script>

</head>

<body>
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <img src="<?= base_url('assets/images/imagen-login.png') ?>" alt="Logo">
                </div>
                <h4 class=""><?= $this->renderSection('titleSection'); ?></h4>
            </div>

            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <footer>

        <div class="">
            <i class="ion-locked me-1"></i> Conexión segura SSL | © <?= date('Y') ?> Todos los derechos reservados
        </div>
    </footer>

    <?= $this->include('partials/auth/scripts') ?>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>
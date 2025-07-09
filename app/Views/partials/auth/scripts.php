<!-- ICONOS -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!-- Flowbite JavaScript -->
<script src="<?= base_url('js/flowbite.min.js') ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> -->

<!-- JAVASCRIPT -->
<script>
    const base_url = "<?= base_url() ?>";
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/js/sweetalert2.js') ?>"></script>
<script>
    // Verificar si hay mensajes de éxito, advertencia o error
    <?php if (session()->has('flashMessages')): ?>
        <?php foreach (session('flashMessages') as $message): ?>
            <?php
            $type = $message[1];
            $msg = $message[0];
            ?>
            showAlert('<?= $type ?>', '<?= $msg ?>');
        <?php endforeach; ?>
    <?php endif; ?>
</script>
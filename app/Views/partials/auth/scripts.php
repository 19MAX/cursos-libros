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
            $type = $message[1]; // Tipo de notificación
            $msg = $message[0];  // Mensaje
            $position = $message[2] ?? 'top-end'; // Posición (por defecto: top-end)
            ?>
            showAlert('<?= $type ?>', '<?= $msg ?>', '<?= $position ?>');
        <?php endforeach; ?>
    <?php endif; ?>
</script>
<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Vista general del sistema de libros y cursos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Cards de estadísticas -->
<div class="admin-dashboard-grid mb-6">
    <!-- Total de Libros -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalLibros) ?></div>
                <div class="admin-dashboard-label">Mis Libros</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                <ion-icon name="book-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Total de Artículos -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalArticulos) ?></div>
                <div class="admin-dashboard-label">Mis Artículos</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                <ion-icon name="document-text-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Total de Capacitaciones -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalCapacitaciones) ?></div>
                <div class="admin-dashboard-label">Mis Capacitaciones</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                <ion-icon name="school-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Total de Documentos -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalDocumentos) ?></div>
                <div class="admin-dashboard-label">Mis Documentos</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400">
                <ion-icon name="folder-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Puntaje Total -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc(number_format($puntajeTotal, 2)) ?></div>
                <div class="admin-dashboard-label">Puntaje Total</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                <ion-icon name="star-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
</div>
<!-- Gráfica de barras de producción mensual -->
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Mi producción en el mes actual (<?= sprintf('%02d', $mes) ?>/<?= $anio ?>)</h3>
    </div>
    <div class="admin-card-body">
        <canvas id="grafica-docente" height="120"></canvas>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafica-docente').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Libros', 'Artículos', 'Capacitaciones', 'Documentos'],
            datasets: [{
                label: 'Cantidad',
                data: [<?= $librosMes ?>, <?= $articulosMes ?>, <?= $capacitacionesMes ?>, <?= $documentosMes ?>],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) { return Number.isInteger(value) ? value : null; }
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>
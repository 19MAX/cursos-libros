<?= $this->extend('layouts/admin_layout'); ?>

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
    <!-- Total de Docentes -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalDocentes) ?></div>
                <div class="admin-dashboard-label">Docentes</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                <ion-icon name="people-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Total de Libros -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalLibros) ?></div>
                <div class="admin-dashboard-label">Libros</div>
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
                <div class="admin-dashboard-label">Artículos</div>
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
                <div class="admin-dashboard-label">Capacitaciones</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                <ion-icon name="school-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <!-- Total de Documentos -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= esc($totalDocumentos) ?></div>
                <div class="admin-dashboard-label">Documentos</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400">
                <ion-icon name="folder-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
</div>

<!-- Gráfica de barras por docente -->
<div class="admin-card mb-6">
    <div class="admin-card-header flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <div>
            <h3 class="text-lg font-semibold admin-text-primary mb-1 md:mb-0">Producción del docente en el mes actual</h3>
            <div class="text-sm text-gray-500">Mes actual: <?= sprintf('%02d', $mes) ?>/<?= $anio ?></div>
        </div>
        <form method="get" class="flex flex-row items-center gap-2">
            <label for="docente_id" class="font-semibold mr-1">Docente:</label>
            <select name="docente_id" id="docente_id" class="admin-input py-1 px-2 text-sm h-8">
                <?php foreach ($docentes as $doc): ?>
                    <option value="<?= esc($doc['id']) ?>" <?= $docenteId == $doc['id'] ? 'selected' : '' ?>><?= esc($doc['name'].' '.$doc['surname']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="admin-btn-primary admin-btn-sm h-8 px-3 text-sm">Filtrar</button>
        </form>
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
                data: [<?= $librosDocente ?>, <?= $articulosDocente ?>, <?= $capacitacionesDocente ?>, <?= $documentosDocente ?>],
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
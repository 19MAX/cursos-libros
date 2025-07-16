<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Mis Artículos
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Mis Artículos
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Gestiona tus artículos científicos y académicos
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Mensajes de alerta -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="admin-alert admin-alert-success mb-4">
        <ion-icon name="checkmark-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="admin-alert admin-alert-error mb-4">
        <ion-icon name="close-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Cards de estadísticas -->
<div class="admin-dashboard-grid mb-6">
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['total'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Total Artículos</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                <ion-icon name="document-text-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['aprobados'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Aprobados</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                <ion-icon name="checkmark-circle-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['pendientes'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Pendientes</div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                <ion-icon name="time-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">
                    <?php
                    $puntajeTotal = 0;
                    if (!empty($articulos)) {
                        foreach ($articulos as $art) {
                            $puntajeTotal += $art['puntaje_asignado'] ?? 0;
                        }
                    }
                    echo number_format($puntajeTotal, 2);
                    ?>
                </div>
                <div class="admin-dashboard-label">Puntaje Total</div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                <ion-icon name="star-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de artículos -->
<div class="admin-card">
    <div class="admin-card-header">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold admin-text-primary">Lista de Artículos</h3>
                <p class="admin-text-secondary text-sm">Todos tus artículos registrados</p>
            </div>
            <a href="<?= base_url('docente/articulos/create') ?>" class="admin-btn-primary">
                <ion-icon name="add-outline" class="w-5 h-5 mr-2"></ion-icon>
                Nuevo Artículo
            </a>
        </div>
    </div>
    <div class="admin-card-body">
        <table id="export-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Revista</th>
                    <th>Tipo de Revisión</th>
                    <th>Tipo de Artículo</th>
                    <th>Fecha Publicación</th>
                    <th>Puntaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($articulos)): ?>
                    <?php foreach ($articulos as $articulo): ?>
                        <tr>
                            <td>
                                <div class="admin-text-primary font-medium">
                                    <?= esc($articulo['titulo_articulo']) ?>
                                </div>
                                <div class="admin-text-secondary text-xs">
                                    <?= esc($articulo['autores']) ?>
                                </div>
                            </td>
                            <td><?= esc($articulo['revista']) ?></td>
                            <td><?= esc($articulo['tipo_revision']) ?></td>
                            <td><?= esc($articulo['tipo_articulo']) ?></td>
                            <td><?= date('Y/m/d', timestamp: strtotime($articulo['fecha_publicacion'])) ?></td>
                            <td>1000</td>
                            <td>
                                <?php
                                $estadoClass = '';
                                $estadoText = '';
                                switch ($articulo['estado']) {
                                    case 'aprobado':
                                        $estadoClass = 'admin-badge-success';
                                        $estadoText = 'Aprobado';
                                        break;
                                    case 'pendiente':
                                        $estadoClass = 'admin-badge-warning';
                                        $estadoText = 'Pendiente';
                                        break;
                                    case 'rechazado':
                                        $estadoClass = 'admin-badge-danger';
                                        $estadoText = 'Rechazado';
                                        break;
                                }
                                ?>
                                <span class="admin-badge <?= $estadoClass ?>"><?= $estadoText ?></span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <?php if ($articulo['estado'] === 'pendiente'): ?>
                                        <a href="<?= base_url('docente/articulos/edit/' . $articulo['id']) ?>"
                                            class="admin-btn-icon" title="Editar">
                                            <ion-icon name="create-outline" class="w-4 h-4"></ion-icon>
                                        </a>
                                        <button type="button" class="admin-btn-icon text-red-600 hover:text-red-700"
                                            onclick="confirmarEliminar(<?= $articulo['id'] ?>)" title="Eliminar">
                                            <ion-icon name="trash-outline" class="w-4 h-4"></ion-icon>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php if ($articulo['estado'] === 'aprobado'): ?>
                                                <ion-icon name="checkmark-circle-outline" class="w-4 h-4 text-green-500"
                                                    title="Aprobado"></ion-icon>
                                            <?php elseif ($articulo['estado'] === 'rechazado'): ?>
                                                <ion-icon name="close-circle-outline" class="w-4 h-4 text-red-500"
                                                    title="Rechazado"></ion-icon>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($articulo['archivo_articulo'])): ?>
                                        <a href="<?= base_url('uploads/' . $articulo['archivo_articulo']) ?>" target="_blank"
                                            class="admin-btn-icon text-blue-600 hover:text-blue-700" title="Ver Archivo">
                                            <ion-icon name="eye-outline" class="w-4 h-4"></ion-icon>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="delete-form" method="POST" style="display: none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    if (document.getElementById("export-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const table = new simpleDatatables.DataTable("#export-table", {
            classes: {
                table: "admin-table datatable-table w-full text-sm text-left",
                top: "admin-table-topbar datatable-top",
                container: "datatable-container",
                bottom: "admin-table-bottombar datatable-bottom",
                pagination: "admin-pagination datatable-pagination",
                info: "datatable-info",
                input: "datatable-search-input",
                search: "datatable-search",
                dropdown: "datatable-dropdown",
                selector: "datatable-select",
                empty: "datatable-empty",
                export: "datatable-export"
            },
            labels: {
                placeholder: "Buscar artículos...",
                perPage: "Mostrar resultados",
                noRows: "No hay artículos para mostrar",
                info: "Mostrando {start} a {end} de {rows} resultados",
                noResults: "No se encontraron artículos",
                loading: "Cargando...",
                pagination: {
                    previous: "Anterior",
                    next: "Siguiente",
                    first: "Primero",
                    last: "Último"
                }
            }
        });
    }
    // Función para confirmar eliminación
    function confirmarEliminar(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este artículo? Esta acción no se puede deshacer.')) {
            const form = document.getElementById('delete-form');
            form.action = `<?= base_url('docente/articulos/delete/') ?>/${id}`;
            form.submit();
        }
    }
</script>
<?= $this->endSection() ?>
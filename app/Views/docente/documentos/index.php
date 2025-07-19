<?= $this->extend('layouts/docente_layout') ?>
<?= $this->section('title') ?>Mis Documentos<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Mis Documentos<?= $this->endSection() ?>
<?= $this->section('page_description') ?>Gestiona tus documentos y guías<?= $this->endSection() ?>
<?= $this->section('breadcrumb') ?>Documentos<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php helper(['files']); ?>

<!-- Mensajes de éxito -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="admin-alert admin-alert-success mb-4">
        <ion-icon name="checkmark-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Mensajes de error -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="admin-alert admin-alert-error mb-4">
        <ion-icon name="close-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold admin-text-primary">Documentos</h3>
                <p class="admin-text-secondary text-sm">Gestiona tus documentos y guías</p>
            </div>
            <a href="<?= base_url('docente/documentos/create') ?>" class="admin-btn-primary">
                <ion-icon name="add-outline" class="w-5 h-5 mr-2"></ion-icon>
                Agregar Documento
            </a>
        </div>
    </div>
    <div class="admin-card-body">
        <?php if (empty($documentos)): ?>
            <div class="admin-empty-state">
                <ion-icon name="document-outline" class="w-16 h-16 admin-text-secondary"></ion-icon>
                <h3 class="text-lg font-medium admin-text-primary mt-4">No hay documentos</h3>
                <p class="admin-text-secondary mt-2">Comienza agregando tu primer documento</p>
                <a href="<?= base_url('docente/documentos/create') ?>" class="admin-btn-primary mt-4">
                    <ion-icon name="add-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Agregar Documento
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="admin-table" id="documentos-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Guía</th>
                            <th>Puntaje</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documentos as $documento): ?>
                            <tr>
                                <td>
                                    <div class="admin-table-cell">
                                        <div class="font-medium admin-text-primary"><?= esc($documento['nombre']) ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <?php if (!empty($documento['descripcion'])): ?>
                                            <div class="admin-text-secondary text-sm">
                                                <?= esc(substr($documento['descripcion'], 0, 100)) ?>
                                                <?= strlen($documento['descripcion']) > 100 ? '...' : '' ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="admin-text-secondary text-sm">Sin descripción</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <?php if (!empty($documento['guia'])): ?>
                                            <a href="<?= base_url($documento['guia']) ?>" target="_blank" 
                                               class="admin-btn-secondary text-xs">
                                                <ion-icon name="document-outline" class="w-4 h-4 mr-1"></ion-icon>
                                                Ver PDF
                                            </a>
                                        <?php else: ?>
                                            <span class="admin-text-secondary text-sm">Sin archivo</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <span class="admin-badge admin-badge-primary">
                                            <?= number_format($documento['puntaje_asignado'], 2) ?> pts
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <?php
                                        $estadoClass = '';
                                        $estadoText = '';
                                        switch ($documento['estado']) {
                                            case 'pendiente':
                                                $estadoClass = 'admin-badge-warning';
                                                $estadoText = 'Pendiente';
                                                break;
                                            case 'aprobado':
                                                $estadoClass = 'admin-badge-success';
                                                $estadoText = 'Aprobado';
                                                break;
                                            case 'rechazado':
                                                $estadoClass = 'admin-badge-error';
                                                $estadoText = 'Rechazado';
                                                break;
                                        }
                                        ?>
                                        <span class="admin-badge <?= $estadoClass ?>">
                                            <?= $estadoText ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <span class="admin-text-secondary text-sm">
                                            <?= date('d/m/Y', strtotime($documento['created_at'])) ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-cell">
                                        <div class="admin-table-actions">
                                            <?php if ($documento['estado'] === 'pendiente'): ?>
                                                <a href="<?= base_url('docente/documentos/edit/' . $documento['id']) ?>" 
                                                   class="admin-btn-icon" title="Editar">
                                                    <ion-icon name="create-outline" class="w-4 h-4"></ion-icon>
                                                </a>
                                                <form action="<?= base_url('docente/documentos/delete/' . $documento['id']) ?>" 
                                                      method="post" class="inline" 
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este documento?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="admin-btn-icon text-red-600" title="Eliminar">
                                                        <ion-icon name="trash-outline" class="w-4 h-4"></ion-icon>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="admin-text-secondary text-sm">No editable</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    // Inicializar DataTable
    const table = new simpleDatatables.DataTable("#documentos-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar documentos...",
            perPage: "documentos por página",
            noRows: "No se encontraron documentos",
            info: "Mostrando {start} a {end} de {rows} documentos",
            noResults: "No se encontraron resultados para '{query}'"
        }
    });
</script>
<?= $this->endSection() ?>
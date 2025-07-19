<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Detalle de Libro<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Detalle de Libro<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-xl font-bold admin-text-primary">Detalle de Libro</h3>
    </div>
    <div class="admin-card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mb-6">
            <div>
                <span class="font-semibold">Título:</span>
                <div class="admin-text-secondary mb-2"><?= esc($libro['titulo_libro']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Docente:</span>
                <div class="admin-text-secondary mb-2"><span class="font-bold text-primary-700"><?= esc($libro['docente_nombre']) ?></span></div>
            </div>
            <div>
                <span class="font-semibold">Editorial:</span>
                <div class="admin-text-secondary mb-2"><?= esc($libro['editorial']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Tipo:</span>
                <div class="admin-text-secondary mb-2"><?= esc($libro['tipo_libro']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Estado:</span>
                <div class="mb-2">
                    <?php if ($libro['estado'] === 'pendiente'): ?>
                        <span class="admin-badge admin-badge-warning">Pendiente</span>
                    <?php elseif ($libro['estado'] === 'aprobado'): ?>
                        <span class="admin-badge admin-badge-success">Aprobado</span>
                    <?php else: ?>
                        <span class="admin-badge admin-badge-danger">Rechazado</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <span class="font-semibold">Fecha Publicación:</span>
                <div class="admin-text-secondary mb-2"><?= esc($libro['fecha_publicacion']) ?></div>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Archivo del libro:</span>
            <?php if (!empty($libro['archivo_libro'])): ?>
                <a href="<?= base_url($libro['archivo_libro']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver libro</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Portada del libro:</span>
            <?php if (!empty($libro['portada_libro'])): ?>
                <a href="<?= base_url($libro['portada_libro']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver portada</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Evidencia de revisión por pares:</span>
            <?php if (!empty($libro['proceso_pares'])): ?>
                <a href="<?= base_url($libro['proceso_pares']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver evidencia</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <?php if ($libro['estado'] === 'aprobado'): ?>
            <div class="mb-4">
                <span class="font-semibold">Puntaje Asignado:</span>
                <span class="admin-badge admin-badge-success ml-2"><?= esc($libro['puntaje_asignado']) ?></span>
            </div>
        <?php endif; ?>
        <?php if ($libro['estado'] === 'pendiente'): ?>
            <div class="flex flex-row gap-4 justify-start mb-4">
                <form method="post" action="<?= base_url('admin/libros/aprobar/' . $libro['id']) ?>">
                    <div class="admin-form-group mb-0">
                        <label for="puntaje_asignado" class="admin-label">Puntaje a asignar</label>
                        <input type="number" step="0.01" min="0" name="puntaje_asignado" id="puntaje_asignado" class="admin-input" required>
                    </div>
                    <button type="submit" class="admin-btn-success mt-2">Aprobar</button>
                </form>
                <form method="post" action="<?= base_url('admin/libros/rechazar/' . $libro['id']) ?>">
                    <!-- <button type="submit" class="admin-btn-danger mt-7">Rechazar</button> -->
                </form>
            </div>
        <?php endif; ?>
        <div class="flex justify-end">
            <a href="<?= base_url('admin/libros') ?>" class="admin-btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 
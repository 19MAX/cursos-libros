<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Detalle de Artículo<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Detalle de Artículo<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-xl font-bold admin-text-primary">Detalle de Artículo</h3>
    </div>
    <div class="admin-card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mb-6">
            <div>
                <span class="font-semibold">Título:</span>
                <div class="admin-text-secondary mb-2"><?= esc($articulo['titulo_articulo']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Docente:</span>
                <div class="admin-text-secondary mb-2"><span class="font-bold text-primary-700"><?= esc($articulo['docente_nombre']) ?></span></div>
            </div>
            <div>
                <span class="font-semibold">Revista:</span>
                <div class="admin-text-secondary mb-2"><?= esc($articulo['revista']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Tipo:</span>
                <div class="admin-text-secondary mb-2"><?= esc($articulo['tipo_articulo']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Estado:</span>
                <div class="mb-2">
                    <?php if ($articulo['estado'] === 'pendiente'): ?>
                        <span class="admin-badge admin-badge-warning">Pendiente</span>
                    <?php elseif ($articulo['estado'] === 'aprobado'): ?>
                        <span class="admin-badge admin-badge-success">Aprobado</span>
                    <?php else: ?>
                        <span class="admin-badge admin-badge-danger">Rechazado</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <span class="font-semibold">Fecha Publicación:</span>
                <div class="admin-text-secondary mb-2"><?= esc($articulo['fecha_publicacion']) ?></div>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Archivo del artículo:</span>
            <?php if (!empty($articulo['archivo_articulo'])): ?>
                <a href="<?= base_url($articulo['archivo_articulo']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver artículo</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Portada / Certificado:</span>
            <?php if (!empty($articulo['portada_articulo'])): ?>
                <a href="<?= base_url($articulo['portada_articulo']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver portada</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <?php if ($articulo['estado'] === 'aprobado'): ?>
            <div class="mb-4">
                <span class="font-semibold">Puntaje Asignado:</span>
                <span class="admin-badge admin-badge-success ml-2"><?= esc($articulo['puntaje_asignado']) ?></span>
            </div>
        <?php endif; ?>
        <?php if ($articulo['estado'] === 'pendiente'): ?>
            <div class="flex flex-row gap-4 justify-start mb-4">
                <form method="post" action="<?= base_url('admin/articulos/aprobar/' . $articulo['id']) ?>">
                    <div class="admin-form-group mb-0">
                        <label for="puntaje_asignado" class="admin-label">Puntaje a asignar</label>
                        <input type="number" step="0.01" min="0" name="puntaje_asignado" id="puntaje_asignado" class="admin-input" required>
                    </div>
                    <button type="submit" class="admin-btn-success mt-2">Aprobar</button>
                </form>
                <form method="post" action="<?= base_url('admin/articulos/rechazar/' . $articulo['id']) ?>">
                    <!-- <button type="submit" class="admin-btn-danger mt-7">Rechazar</button> -->
                </form>
            </div>
        <?php endif; ?>
        <div class="flex justify-end">
            <a href="<?= base_url('admin/articulos') ?>" class="admin-btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 
<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Detalle de Capacitación<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Detalle de Capacitación<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-xl font-bold admin-text-primary">Detalle de Capacitación</h3>
    </div>
    <div class="admin-card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mb-6">
            <div>
                <span class="font-semibold">Nombre:</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['nombre_capacitacion']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Docente:</span>
                <div class="admin-text-secondary mb-2"><span
                        class="font-bold text-primary-700"><?= esc($capacitacion['docente_nombre']) ?></span></div>
            </div>
            <div>
                <span class="font-semibold">Institución:</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['institucion_organizadora']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Modalidad:</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['modalidad']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Estado:</span>
                <div class="mb-2">
                    <?php if ($capacitacion['estado'] === 'pendiente'): ?>
                        <span class="admin-badge admin-badge-warning">Pendiente</span>
                    <?php elseif ($capacitacion['estado'] === 'aprobado'): ?>
                        <span class="admin-badge admin-badge-success">Aprobado</span>
                    <?php else: ?>
                        <span class="admin-badge admin-badge-danger">Rechazado</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <span class="font-semibold">Fecha Inicio:</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['fecha_inicio']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Fecha Fin:</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['fecha_fin']) ?></div>
            </div>
            <div>
                <span class="font-semibold">Duración (horas):</span>
                <div class="admin-text-secondary mb-2"><?= esc($capacitacion['duracion_horas']) ?></div>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Descripción:</span>
            <div class="admin-text-secondary"><?= esc($capacitacion['descripcion']) ?></div>
        </div>
        <?php if ($capacitacion['estado'] === 'aprobado'): ?>
            <div class="mb-4">
                <span class="font-semibold">Puntaje Asignado:</span>
                <span class="admin-badge admin-badge-success ml-2"><?= esc($capacitacion['puntaje_asignado']) ?></span>
            </div>
        <?php endif; ?>
        <?php if ($capacitacion['estado'] === 'pendiente'): ?>
            <div class="flex flex-row gap-4 justify-start mb-4">
                <form method="post" action="<?= base_url('admin/capacitaciones/aprobar/' . $capacitacion['id']) ?>">
                    <div class="admin-form-group mb-0">
                        <label for="puntaje_asignado" class="admin-label">Puntaje a asignar</label>
                        <input type="number" step="0.01" min="0" name="puntaje_asignado" id="puntaje_asignado" class="admin-input" required>
                    </div>
                    <button type="submit" class="admin-btn-success mt-2">Aprobar</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="mb-4">
            <span class="font-semibold">Documento adjunto:</span>
            <?php if (!empty($capacitacion['certificado'])): ?>
                <a href="<?= base_url($capacitacion['certificado']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm ml-2">Ver documento</a>
            <?php else: ?>
                <span class="admin-badge admin-badge-gray ml-2">Sin archivo</span>
            <?php endif; ?>
        </div>
        <div class="flex justify-end">
            <a href="<?= base_url('admin/capacitaciones') ?>" class="admin-btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
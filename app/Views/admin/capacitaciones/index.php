<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Capacitaciones<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Capacitaciones<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Revisión de Capacitaciones</h3>
    </div>
    <div class="admin-card-body">
        <table id="capacitaciones-table" class="admin-table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Nombre</th>
                    <th>Institución</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Puntaje</th>
                    <th>Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($capacitaciones as $c): ?>
                <tr>
                    <td><?= esc($c['id']) ?></td>
                    <td><?= esc($c['docente_nombre']) ?></td>
                    <td><?= esc($c['nombre_capacitacion']) ?></td>
                    <td><?= esc($c['institucion_organizadora']) ?></td>
                    <td><?= esc($c['modalidad']) ?></td>
                    <td>
                        <?php if ($c['estado'] === 'pendiente'): ?>
                            <span class="admin-badge admin-badge-warning">Pendiente</span>
                        <?php elseif ($c['estado'] === 'aprobado'): ?>
                            <span class="admin-badge admin-badge-success">Aprobado</span>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-danger">Rechazado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($c['puntaje_asignado']) ?></td>
                    <td>
                        <?php if (!empty($c['certificado'])): ?>
                            <a href="<?= base_url($c['certificado']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm">Ver documento</a>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-gray">Sin archivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/capacitaciones/show/'.$c['id']) ?>" class="admin-btn-primary admin-btn-sm">Ver</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    const table = new simpleDatatables.DataTable("#capacitaciones-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar capacitaciones...",
            perPage: "capacitaciones por página",
            noRows: "No se encontraron capacitaciones",
            info: "Mostrando {start} a {end} de {rows} capacitaciones",
            noResults: "No se encontraron resultados para '{query}'"
        }
    });
</script>
<?= $this->endSection() ?> 
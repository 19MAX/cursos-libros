<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Documentos<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Documentos<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Revisión de Documentos</h3>
    </div>
    <div class="admin-card-body">
        <table id="documentos-table" class="admin-table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Puntaje</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos as $d): ?>
                <tr>
                    <td><?= esc($d['id']) ?></td>
                    <td><?= esc($d['docente_nombre']) ?></td>
                    <td><?= esc($d['nombre']) ?></td>
                    <td><?= esc($d['descripcion']) ?></td>
                    <td>
                        <?php if ($d['estado'] === 'pendiente'): ?>
                            <span class="admin-badge admin-badge-warning">Pendiente</span>
                        <?php elseif ($d['estado'] === 'aprobado'): ?>
                            <span class="admin-badge admin-badge-success">Aprobado</span>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-danger">Rechazado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($d['puntaje_asignado']) ?></td>
                    <td>
                        <?php if (!empty($d['guia'])): ?>
                            <a href="<?= base_url($d['guia']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm">Ver documento</a>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-gray">Sin archivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/documentos/show/'.$d['id']) ?>" class="admin-btn-primary admin-btn-sm">Ver</a>
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
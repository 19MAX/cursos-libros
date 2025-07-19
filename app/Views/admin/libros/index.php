<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Libros<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Libros<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Revisión de Libros</h3>
    </div>
    <div class="admin-card-body">
        <table id="libros-table" class="admin-table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Título</th>
                    <th>Editorial</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Puntaje</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $l): ?>
                <tr>
                    <td><?= esc($l['id']) ?></td>
                    <td><?= esc($l['docente_nombre']) ?></td>
                    <td><?= esc($l['titulo_libro']) ?></td>
                    <td><?= esc($l['editorial']) ?></td>
                    <td><?= esc($l['tipo_libro']) ?></td>
                    <td>
                        <?php if ($l['estado'] === 'pendiente'): ?>
                            <span class="admin-badge admin-badge-warning">Pendiente</span>
                        <?php elseif ($l['estado'] === 'aprobado'): ?>
                            <span class="admin-badge admin-badge-success">Aprobado</span>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-danger">Rechazado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($l['puntaje_asignado']) ?></td>
                    <td>
                        <?php if (!empty($l['archivo_libro'])): ?>
                            <a href="<?= base_url($l['archivo_libro']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm">Ver libro</a>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-gray">Sin archivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/libros/show/'.$l['id']) ?>" class="admin-btn-primary admin-btn-sm">Ver</a>
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
    const table = new simpleDatatables.DataTable("#libros-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar libros...",
            perPage: "libros por página",
            noRows: "No se encontraron libros",
            info: "Mostrando {start} a {end} de {rows} libros",
            noResults: "No se encontraron resultados para '{query}'"
        }
    });
</script>
<?= $this->endSection() ?> 
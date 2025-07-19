<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Artículos<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Artículos<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Revisión de Artículos</h3>
    </div>
    <div class="admin-card-body">
        <table id="articulos-table" class="admin-table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Título</th>
                    <th>Revista</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Puntaje</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articulos as $a): ?>
                <tr>
                    <td><?= esc($a['id']) ?></td>
                    <td><?= esc($a['docente_nombre']) ?></td>
                    <td><?= esc($a['titulo_articulo']) ?></td>
                    <td><?= esc($a['revista']) ?></td>
                    <td><?= esc($a['tipo_articulo']) ?></td>
                    <td>
                        <?php if ($a['estado'] === 'pendiente'): ?>
                            <span class="admin-badge admin-badge-warning">Pendiente</span>
                        <?php elseif ($a['estado'] === 'aprobado'): ?>
                            <span class="admin-badge admin-badge-success">Aprobado</span>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-danger">Rechazado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($a['puntaje_asignado']) ?></td>
                    <td>
                        <?php if (!empty($a['archivo_articulo'])): ?>
                            <a href="<?= base_url($a['archivo_articulo']) ?>" target="_blank" class="admin-btn-secondary admin-btn-sm">Ver artículo</a>
                        <?php else: ?>
                            <span class="admin-badge admin-badge-gray">Sin archivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/articulos/show/'.$a['id']) ?>" class="admin-btn-primary admin-btn-sm">Ver</a>
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
    const table = new simpleDatatables.DataTable("#articulos-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar artículos...",
            perPage: "artículos por página",
            noRows: "No se encontraron artículos",
            info: "Mostrando {start} a {end} de {rows} artículos",
            noResults: "No se encontraron resultados para '{query}'"
        }
    });
</script>
<?= $this->endSection() ?> 
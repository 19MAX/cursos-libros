<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Docentes<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Docentes<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="admin-card">
    <div class="admin-card-header flex flex-row items-center justify-between">
        <h3 class="text-lg font-semibold admin-text-primary">Gestión de Docentes</h3>
        <a href="<?= base_url('admin/docentes/create') ?>" class="admin-btn-primary">Nuevo Docente</a>
    </div>
    <div class="admin-card-body">
        <?php if (session('success')): ?>
            <div class="admin-alert admin-alert-success mb-4">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="admin-alert admin-alert-error mb-4">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>
        <table id="docentes-table" class="admin-table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>CI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docentes as $d): ?>
                <tr>
                    <td><?= esc($d['id']) ?></td>
                    <td><?= esc($d['name']) ?></td>
                    <td><?= esc($d['surname']) ?></td>
                    <td><?= esc($d['email']) ?></td>
                    <td><?= esc($d['ci']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/docentes/edit/'.$d['id']) ?>" class="admin-btn-secondary admin-btn-sm">Editar</a>
                        <a href="<?= base_url('admin/docentes/delete/'.$d['id']) ?>" class="admin-btn-danger admin-btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este docente?')">Eliminar</a>
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
    const table = new simpleDatatables.DataTable("#docentes-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar docentes...",
            perPage: "docentes por página",
            noRows: "No se encontraron docentes",
            info: "Mostrando {start} a {end} de {rows} docentes",
            noResults: "No se encontraron resultados para '{query}'"
        }
    });
</script>
<?= $this->endSection() ?> 
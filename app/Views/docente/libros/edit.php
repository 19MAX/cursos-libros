<?= $this->extend('layouts/docente_layout') ?>
<?= $this->section('title') ?>Editar Libro<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Editar Libro<?= $this->endSection() ?>
<?= $this->section('page_description') ?>Modifica la información de tu libro<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- Mensajes de error -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="admin-alert admin-alert-error mb-4">
        <ion-icon name="close-circle-outline" class="w-5 h-5"></ion-icon>
        <div>
            <span class="font-medium">Errores de validación:</span>
            <ul class="mt-1 list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Editar Libro</h3>
        <p class="admin-text-secondary text-sm">Modifica la información de tu libro</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/libros/update/' . $libro['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="titulo_libro" class="admin-label admin-label-required">
                        <ion-icon name="book-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Título del Libro
                    </label>
                    <input type="text" id="titulo_libro" name="titulo_libro" value="<?= old('titulo_libro', $libro['titulo_libro']) ?>" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="subtitulo" class="admin-label">
                        <ion-icon name="book-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Subtítulo
                    </label>
                    <input type="text" id="subtitulo" name="subtitulo" value="<?= old('subtitulo', $libro['subtitulo']) ?>" class="admin-input">
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="autores" class="admin-label admin-label-required">
                        <ion-icon name="people-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Autores
                    </label>
                    <input type="text" id="autores" name="autores" value="<?= old('autores', $libro['autores']) ?>" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="editorial" class="admin-label admin-label-required">
                        <ion-icon name="business-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Editorial
                    </label>
                    <input type="text" id="editorial" name="editorial" value="<?= old('editorial', $libro['editorial']) ?>" class="admin-input" required>
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="tipo_libro" class="admin-label admin-label-required">
                        <ion-icon name="layers-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Tipo de Libro
                    </label>
                    <select id="tipo_libro" name="tipo_libro" class="admin-select" required>
                        <option value="">Selecciona el tipo de libro</option>
                        <option value="libro_completo" <?= old('tipo_libro', $libro['tipo_libro']) == 'libro_completo' ? 'selected' : '' ?>>Libro completo</option>
                        <option value="capitulo_libro" <?= old('tipo_libro', $libro['tipo_libro']) == 'capitulo_libro' ? 'selected' : '' ?>>Capítulo de libro</option>
                        <option value="libro_texto" <?= old('tipo_libro', $libro['tipo_libro']) == 'libro_texto' ? 'selected' : '' ?>>Libro de texto</option>
                        <option value="libro_cientifico" <?= old('tipo_libro', $libro['tipo_libro']) == 'libro_cientifico' ? 'selected' : '' ?>>Libro científico</option>
                        <option value="libro_tecnico" <?= old('tipo_libro', $libro['tipo_libro']) == 'libro_tecnico' ? 'selected' : '' ?>>Libro técnico</option>
                        <option value="otros" <?= old('tipo_libro', $libro['tipo_libro']) == 'otros' ? 'selected' : '' ?>>Otros</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="isbn" class="admin-label">
                        <ion-icon name="barcode-outline" class="w-4 h-4 mr-2"></ion-icon>
                        ISBN
                    </label>
                    <input type="text" id="isbn" name="isbn" value="<?= old('isbn', $libro['isbn']) ?>" class="admin-input">
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="citas_referenciadas" class="admin-label admin-label-required">
                        <ion-icon name="bookmarks-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Citas Referenciadas
                    </label>
                    <input type="number" id="citas_referenciadas" name="citas_referenciadas" value="<?= old('citas_referenciadas', $libro['citas_referenciadas'] ?? 0) ?>" class="admin-input" min="0" required>
                    <p class="admin-text-secondary text-sm mt-1">Número de veces que el libro ha sido citado (0 si no aplica).</p>
                </div>
                <div class="admin-form-group">
                    <label for="fecha_publicacion" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Publicación
                    </label>
                    <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?= old('fecha_publicacion', $libro['fecha_publicacion']) ?>" class="admin-input" required>
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="archivo_libro" class="admin-label">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Archivo del Libro (PDF)
                    </label>
                    <?php if (!empty($libro['archivo_libro'])): ?>
                        <a href="<?= base_url($libro['archivo_libro']) ?>" target="_blank" class="admin-btn-secondary text-xs mb-2">
                            <ion-icon name="eye-outline" class="w-4 h-4 mr-1"></ion-icon>
                            Ver PDF actual
                        </a>
                    <?php endif; ?>
                    <input type="file" id="archivo_libro" name="archivo_libro" accept="application/pdf" class="admin-file-input mt-1">
                    <p class="admin-text-secondary text-sm mt-1">Dejar vacío para no cambiar el archivo. Solo PDF. Máx. 20MB.</p>
                </div>
                <div class="admin-form-group">
                    <label for="portada_libro" class="admin-label">
                        <ion-icon name="image-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Portada del Libro (JPG, PNG, GIF, WEBP)
                    </label>
                    <?php if (!empty($libro['portada_libro'])): ?>
                        <img src="<?= base_url($libro['portada_libro']) ?>" alt="Portada actual" class="h-16 w-12 object-cover rounded shadow mb-2" />
                    <?php endif; ?>
                    <input type="file" id="portada_libro" name="portada_libro" accept="image/*" class="admin-file-input mt-1">
                    <p class="admin-text-secondary text-sm mt-1">Dejar vacío para no cambiar la portada. Solo imágenes. Máx. 5MB.</p>
                </div>
            </div>
            <div class="admin-form-actions">
                <a href="<?= base_url('docente/libros') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    // Validación de fecha de publicación (no futura)
    document.getElementById('fecha_publicacion').addEventListener('change', function () {
        const fecha = this.value;
        const hoy = new Date().toISOString().split('T')[0];
        if (fecha > hoy) {
            alert('La fecha de publicación no puede ser futura.');
            this.value = '';
        }
    });
    // Validación de citas referenciadas
    document.getElementById('citas_referenciadas').addEventListener('input', function () {
        if (this.value < 0) {
            this.setCustomValidity('El número de citas no puede ser negativo');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<?= $this->endSection() ?> 
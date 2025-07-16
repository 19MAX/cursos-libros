<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Nuevo Artículo
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nuevo Artículo
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Registra un nuevo artículo científico o académico
<?= $this->endSection() ?>

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

<div class="admin-card max-w-3xl mx-auto">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Información del Artículo</h3>
        <p class="admin-text-secondary text-sm">Completa todos los campos requeridos</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/articulos/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="titulo_articulo" class="admin-label admin-label-required">
                        <ion-icon name="document-text-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Título del Artículo
                    </label>
                    <input type="text" name="titulo_articulo" id="titulo_articulo" class="admin-input"
                        value="<?= old('titulo_articulo') ?>" required>
                    <p class="admin-text-secondary text-sm mt-1">Título principal del artículo</p>
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="autores" class="admin-label admin-label-required">
                        <ion-icon name="people-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Autores
                    </label>
                    <textarea name="autores" id="autores" class="admin-textarea"
                        required><?= old('autores') ?></textarea>
                    <p class="admin-text-secondary text-sm mt-1">Lista de autores separados por coma</p>
                </div>
                <div class="admin-form-group">
                    <label for="revista" class="admin-label admin-label-required">
                        <ion-icon name="book-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Revista
                    </label>
                    <input type="text" name="revista" id="revista" class="admin-input" value="<?= old('revista') ?>"
                        required>
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="issn" class="admin-label">
                        <ion-icon name="barcode-outline" class="w-4 h-4 mr-2"></ion-icon>
                        ISSN
                    </label>
                    <input type="text" name="issn" id="issn" class="admin-input" value="<?= old('issn') ?>">
                </div>
                <div class="admin-form-group">
                    <label for="volumen" class="admin-label">
                        <ion-icon name="layers-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Volumen
                    </label>
                    <input type="text" name="volumen" id="volumen" class="admin-input" value="<?= old('volumen') ?>">
                </div>
                <div class="admin-form-group">
                    <label for="numero" class="admin-label">
                        <ion-icon name="list-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Número
                    </label>
                    <input type="text" name="numero" id="numero" class="admin-input" value="<?= old('numero') ?>">
                </div>
                <div class="admin-form-group">
                    <label for="paginas" class="admin-label">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Páginas
                    </label>
                    <input type="text" name="paginas" id="paginas" class="admin-input" value="<?= old('paginas') ?>">
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="fecha_publicacion" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Publicación
                    </label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="admin-input"
                        value="<?= old('fecha_publicacion') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label for="pais_publicacion" class="admin-label">
                        <ion-icon name="flag-outline" class="w-4 h-4 mr-2"></ion-icon>
                        País de Publicación
                    </label>
                    <input type="text" name="pais_publicacion" id="pais_publicacion" class="admin-input"
                        value="<?= old('pais_publicacion') ?>">
                </div>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="tipo_revision" class="admin-label admin-label-required">
                        <ion-icon name="eye-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Tipo de Revisión
                    </label>
                    <select name="tipo_revision" id="tipo_revision" class="admin-select" required>
                        <option value="">Selecciona el tipo de revisión</option>
                        <option value="Revisión doble ciego (Double-blind review)" <?= old('tipo_revision') == 'Revisión doble ciego (Double-blind review)' ? 'selected' : '' ?>>Revisión doble ciego (Double-blind
                            review)</option>
                        <option value="Revisión simple ciego (Single-blind review)" <?= old('tipo_revision') == 'Revisión simple ciego (Single-blind review)' ? 'selected' : '' ?>>Revisión simple ciego (Single-blind
                            review)</option>
                        <option value="Revisión abierta (Open review)" <?= old('tipo_revision') == 'Revisión abierta (Open review)' ? 'selected' : '' ?>>Revisión abierta (Open review)</option>
                        <option value="Revisión colaborativa (Collaborative review)" <?= old('tipo_revision') == 'Revisión colaborativa (Collaborative review)' ? 'selected' : '' ?>>Revisión colaborativa
                            (Collaborative review)</option>
                        <option value="Revisión por la comunidad o post-publicación (Public/Community review)"
                            <?= old('tipo_revision') == 'Revisión por la comunidad o post-publicación (Public/Community review)' ? 'selected' : '' ?>>Revisión por la comunidad o post-publicación (Public/Community
                            review)</option>
                        <option value="Revisión editorial (Editorial review)" <?= old('tipo_revision') == 'Revisión editorial (Editorial review)' ? 'selected' : '' ?>>Revisión editorial (Editorial review)
                        </option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="tipo_articulo" class="admin-label admin-label-required">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Tipo de Artículo
                    </label>
                    <select name="tipo_articulo" id="tipo_articulo" class="admin-select" required>
                        <option value="">Selecciona el tipo de artículo</option>
                        <option value="Artículo de investigación" <?= old('tipo_articulo') == 'Artículo de investigación' ? 'selected' : '' ?>>Artículo de investigación</option>
                        <option value="Artículo de revisión" <?= old('tipo_articulo') == 'Artículo de revisión' ? 'selected' : '' ?>>Artículo de revisión</option>
                        <option value="Preprint" <?= old('tipo_articulo') == 'Preprint' ? 'selected' : '' ?>>Preprint
                        </option>
                        <option value="Artículo técnico" <?= old('tipo_articulo') == 'Artículo técnico' ? 'selected' : '' ?>>Artículo técnico</option>
                        <option value="Artículo de opinión / ensayo" <?= old('tipo_articulo') == 'Artículo de opinión / ensayo' ? 'selected' : '' ?>>Artículo de opinión / ensayo</option>
                        <option value="Estudio de caso" <?= old('tipo_articulo') == 'Estudio de caso' ? 'selected' : '' ?>>
                            Estudio de caso</option>
                        <option value="Meta-análisis" <?= old('tipo_articulo') == 'Meta-análisis' ? 'selected' : '' ?>>
                            Meta-análisis</option>
                    </select>
                </div>

            </div>



            <div class="admin-form-row-3">

                <div class="admin-form-group admin-form-group-1">
                    <label for="cuartil" class="admin-label admin-label-required">
                        <ion-icon name="podium-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Cuartil
                    </label>
                    <select name="cuartil" id="cuartil" class="admin-select" required>
                        <option value="">Selecciona el cuartil</option>
                        <option value="Q1" <?= old('cuartil') == 'Q1' ? 'selected' : '' ?>>Q1</option>
                        <option value="Q2" <?= old('cuartil') == 'Q2' ? 'selected' : '' ?>>Q2</option>
                        <option value="Q3" <?= old('cuartil') == 'Q3' ? 'selected' : '' ?>>Q3</option>
                        <option value="Q4" <?= old('cuartil') == 'Q4' ? 'selected' : '' ?>>Q4</option>
                    </select>
                </div>

                <div class="admin-form-group admin-form-group-1">
                    <label for="factor_impacto" class="admin-label">
                        <ion-icon name="trending-up-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Factor de impacto
                    </label>
                    <input type="text" name="factor_impacto" id="factor_impacto" class="admin-input"
                        value="<?= old('factor_impacto') ?>">

                </div>

                <div class="admin-form-group admin-form-group-1">
                    <label for="doi" class="admin-label">
                        <ion-icon name="link-outline" class="w-4 h-4 mr-2"></ion-icon>
                        DOI
                    </label>
                    <input type="text" name="doi" id="doi" class="admin-input" value="<?= old('doi') ?>">
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="area_conocimiento" class="admin-label">
                        <ion-icon name="school-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Área de Conocimiento
                    </label>
                    <select name="area_conocimiento" id="area_conocimiento" class="admin-select">
                        <option value="">Selecciona el área de conocimiento</option>
                        <option value="CIENCIAS NATURALES" <?= old('area_conocimiento') == 'CIENCIAS NATURALES' ? 'selected' : '' ?>>CIENCIAS NATURALES</option>
                        <option value="CIENCIAS FORMALES Y APLICADAS" <?= old('area_conocimiento') == 'CIENCIAS FORMALES Y APLICADAS' ? 'selected' : '' ?>>CIENCIAS FORMALES Y APLICADAS</option>
                        <option value="INGENIERÍA Y TECNOLOGÍA" <?= old('area_conocimiento') == 'INGENIERÍA Y TECNOLOGÍA' ? 'selected' : '' ?>>INGENIERÍA Y TECNOLOGÍA</option>
                        <option value="CIENCIAS SOCIALES" <?= old('area_conocimiento') == 'CIENCIAS SOCIALES' ? 'selected' : '' ?>>CIENCIAS SOCIALES</option>
                        <option value="CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS" <?= old('area_conocimiento') == 'CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS' ? 'selected' : '' ?>>CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS</option>
                        <option value="CIENCIAS DE LA SALUD Y MEDICINA" <?= old('area_conocimiento') == 'CIENCIAS DE LA SALUD Y MEDICINA' ? 'selected' : '' ?>>CIENCIAS DE LA SALUD Y MEDICINA</option>
                        <option value="HUMANIDADES" <?= old('area_conocimiento') == 'HUMANIDADES' ? 'selected' : '' ?>>HUMANIDADES</option>
                        <option value="ARTES Y COMUNICACIÓN" <?= old('area_conocimiento') == 'ARTES Y COMUNICACIÓN' ? 'selected' : '' ?>>ARTES Y COMUNICACIÓN</option>
                        <option value="INTERDISCIPLINARIAS Y EMERGENTES" <?= old('area_conocimiento') == 'INTERDISCIPLINARIAS Y EMERGENTES' ? 'selected' : '' ?>>INTERDISCIPLINARIAS Y EMERGENTES</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="disciplina" class="admin-label">
                        <ion-icon name="git-branch-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Disciplina
                    </label>
                    <select name="disciplina" id="disciplina" class="admin-select">
                        <option value="">Selecciona la disciplina</option>
                        <option value="CIENCIAS NATURALES" <?= old('disciplina') == 'CIENCIAS NATURALES' ? 'selected' : '' ?>>CIENCIAS NATURALES</option>
                        <option value="CIENCIAS FORMALES Y APLICADAS" <?= old('disciplina') == 'CIENCIAS FORMALES Y APLICADAS' ? 'selected' : '' ?>>CIENCIAS FORMALES Y APLICADAS</option>
                        <option value="INGENIERÍA Y TECNOLOGÍA" <?= old('disciplina') == 'INGENIERÍA Y TECNOLOGÍA' ? 'selected' : '' ?>>INGENIERÍA Y TECNOLOGÍA</option>
                        <option value="CIENCIAS SOCIALES" <?= old('disciplina') == 'CIENCIAS SOCIALES' ? 'selected' : '' ?>>CIENCIAS SOCIALES</option>
                        <option value="CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS" <?= old('disciplina') == 'CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS' ? 'selected' : '' ?>>CIENCIAS ECONÓMICAS Y ADMINISTRATIVAS</option>
                        <option value="CIENCIAS DE LA SALUD Y MEDICINA" <?= old('disciplina') == 'CIENCIAS DE LA SALUD Y MEDICINA' ? 'selected' : '' ?>>CIENCIAS DE LA SALUD Y MEDICINA</option>
                        <option value="HUMANIDADES" <?= old('disciplina') == 'HUMANIDADES' ? 'selected' : '' ?>>HUMANIDADES</option>
                        <option value="ARTES Y COMUNICACIÓN" <?= old('disciplina') == 'ARTES Y COMUNICACIÓN' ? 'selected' : '' ?>>ARTES Y COMUNICACIÓN</option>
                        <option value="INTERDISCIPLINARIAS Y EMERGENTES" <?= old('disciplina') == 'INTERDISCIPLINARIAS Y EMERGENTES' ? 'selected' : '' ?>>INTERDISCIPLINARIAS Y EMERGENTES</option>
                    </select>
                </div>
            </div>
            <div class="admin-form-group">
                <label for="resumen" class="admin-label">
                    <ion-icon name="reader-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Resumen
                </label>
                <textarea name="resumen" id="resumen" class="admin-textarea" rows="8"><?= old('resumen') ?></textarea>
            </div>
            <div class="admin-form-group">
                <label for="palabras_clave" class="admin-label">
                    <ion-icon name="pricetags-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Palabras Clave
                </label>
                <textarea name="palabras_clave" id="palabras_clave" class="admin-textarea"
                    placeholder="Separadas por comas"><?= old('palabras_clave') ?></textarea>
            </div>
            <div class="admin-form-group">
                <label for="enlace_revista" class="admin-label">
                    <ion-icon name="link-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Enlace de la Revista
                </label>
                <input type="url" name="enlace_revista" id="enlace_revista" class="admin-input"
                    value="<?= old('enlace_revista') ?>">
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="archivo_articulo" class="admin-label">
                        <ion-icon name="cloud-upload-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Archivo del Artículo
                    </label>
                    <input type="file" name="archivo_articulo" id="archivo_articulo" class="admin-file-input">
                    <p class="admin-text-secondary text-sm mt-1">PDF, DOCX, JPG, PNG (máx. 10MB)</p>
                </div>
                <div class="admin-form-group">
                    <label for="portada_articulo" class="admin-label">
                        <ion-icon name="image-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Certificado de publicación / Aceptación
                    </label>
                    <input type="file" name="portada_articulo" id="portada_articulo" class="admin-file-input">
                    <p class="admin-text-secondary text-sm mt-1">(opcional)</p>
                </div>
            </div>
            <div class="admin-form-group">
                <label for="descripcion_articulo" class="admin-label">
                    <ion-icon name="information-circle-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Descripción/Observaciones
                </label>
                <textarea name="descripcion_articulo" id="descripcion_articulo"
                    class="admin-textarea"><?= old('descripcion_articulo') ?></textarea>
            </div>
            <div class="admin-form-actions">
                <a href="<?= base_url('docente/articulos') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Guardar Artículo
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Validación de fechas
    document.getElementById('fecha_publicacion').addEventListener('change', function () {
        const fecha = this.value;
        if (fecha && new Date(fecha) > new Date()) {
            alert('La fecha de publicación no puede ser futura');
            this.value = '';
        }
    });
    // Validación de archivo
    document.getElementById('archivo_articulo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('El archivo excede el tamaño máximo de 10MB');
                this.value = '';
                return;
            }
        }
    });
    document.getElementById('portada_articulo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('La imagen excede el tamaño máximo de 10MB');
                this.value = '';
                return;
            }
        }
    });
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Editar Artículo
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Editar Artículo
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Modifica la información de tu artículo
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

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Editar Artículo</h3>
        <p class="admin-text-secondary text-sm">Modifica la información de tu artículo</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/articulos/update/' . $articulo['id']) ?>" method="post"
            enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="titulo_articulo" class="admin-label admin-label-required">
                        <ion-icon name="document-text-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Título del Artículo
                    </label>
                    <input type="text" name="titulo_articulo" id="titulo_articulo" class="admin-input"
                        value="<?= old('titulo_articulo', $articulo['titulo_articulo']) ?>" required>
                    <p class="admin-text-secondary text-sm mt-1">Título principal del artículo</p>
                </div>
                <div class="admin-form-group">
                    <label for="autores" class="admin-label admin-label-required">
                        <ion-icon name="people-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Autores
                    </label>
                    <textarea name="autores" id="autores" class="admin-textarea" rows="1"
                        required><?= old('autores', $articulo['autores']) ?></textarea>
                    <p class="admin-text-secondary text-sm mt-1">Lista de autores separados por coma</p>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="revista" class="admin-label admin-label-required">
                        <ion-icon name="book-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Nombre de revista
                    </label>
                    <input type="text" name="revista" id="revista" class="admin-input"
                        value="<?= old('revista', $articulo['revista']) ?>" required>
                </div>
                <div class="admin-form-group">
                    <label for="issn" class="admin-label">
                        <ion-icon name="barcode-outline" class="w-4 h-4 mr-2"></ion-icon>
                        ISSN
                    </label>
                    <input type="text" name="issn" id="issn" class="admin-input"
                        value="<?= old('issn', $articulo['issn']) ?>">
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="volumen" class="admin-label">
                        <ion-icon name="layers-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Volumen
                    </label>
                    <input type="text" name="volumen" id="volumen" class="admin-input"
                        value="<?= old('volumen', $articulo['volumen']) ?>">
                </div>
                <div class="admin-form-group">
                    <label for="numero" class="admin-label">
                        <ion-icon name="list-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Número
                    </label>
                    <input type="text" name="numero" id="numero" class="admin-input"
                        value="<?= old('numero', $articulo['numero']) ?>">
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="paginas" class="admin-label">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Páginas
                    </label>
                    <input type="text" name="paginas" id="paginas" class="admin-input"
                        value="<?= old('paginas', $articulo['paginas']) ?>">
                </div>
                <div class="admin-form-group">
                    <label for="fecha_publicacion" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Publicación
                    </label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="admin-input"
                        value="<?= old('fecha_publicacion', $articulo['fecha_publicacion']) ?>" required>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="pais_publicacion" class="admin-label">
                        <ion-icon name="flag-outline" class="w-4 h-4 mr-2"></ion-icon>
                        País de Publicación
                    </label>
                    <input type="text" name="pais_publicacion" id="pais_publicacion" class="admin-input"
                        value="<?= old('pais_publicacion', $articulo['pais_publicacion']) ?>">
                </div>
                <div class="admin-form-group">
                    <label for="tipo_revision" class="admin-label admin-label-required">
                        <ion-icon name="eye-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Tipo de Revisión
                    </label>
                    <select name="tipo_revision" id="tipo_revision" class="admin-select" required>
                        <option value="">Selecciona el tipo de revisión</option>
                        <option value="Revisión doble ciego (Double-blind review)" <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión doble ciego (Double-blind review)' ? 'selected' : '' ?>>Revisión doble ciego (Double-blind review)</option>
                        <option value="Revisión simple ciego (Single-blind review)" <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión simple ciego (Single-blind review)' ? 'selected' : '' ?>>Revisión simple ciego (Single-blind review)</option>
                        <option value="Revisión abierta (Open review)" <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión abierta (Open review)' ? 'selected' : '' ?>>Revisión
                            abierta (Open review)</option>
                        <option value="Revisión colaborativa (Collaborative review)" <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión colaborativa (Collaborative review)' ? 'selected' : '' ?>>Revisión colaborativa (Collaborative review)</option>
                        <option value="Revisión por la comunidad o post-publicación (Public/Community review)"
                            <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión por la comunidad o post-publicación (Public/Community review)' ? 'selected' : '' ?>>Revisión por la comunidad o
                            post-publicación (Public/Community review)</option>
                        <option value="Revisión editorial (Editorial review)" <?= old('tipo_revision', $articulo['tipo_revision']) == 'Revisión editorial (Editorial review)' ? 'selected' : '' ?>>
                            Revisión editorial (Editorial review)</option>
                    </select>
                </div>
            </div>

            <div class="admin-form-group">
                <label for="tipo_articulo" class="admin-label admin-label-required">
                    <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Tipo de Artículo
                </label>
                <select name="tipo_articulo" id="tipo_articulo" class="admin-select" required>
                    <option value="">Selecciona el tipo de artículo</option>
                    <option value="Artículo de investigación" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Artículo de investigación' ? 'selected' : '' ?>>Artículo de
                        investigación</option>
                    <option value="Artículo de revisión" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Artículo de revisión' ? 'selected' : '' ?>>Artículo de
                        revisión</option>
                    <option value="Preprint" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Preprint' ? 'selected' : '' ?>>Preprint</option>
                    <option value="Artículo técnico" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Artículo técnico' ? 'selected' : '' ?>>Artículo técnico</option>
                    <option value="Artículo de opinión / ensayo" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Artículo de opinión / ensayo' ? 'selected' : '' ?>>Artículo de
                        opinión / ensayo</option>
                    <option value="Estudio de caso" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Estudio de caso' ? 'selected' : '' ?>>Estudio de caso</option>
                    <option value="Meta-análisis" <?= old('tipo_articulo', $articulo['tipo_articulo']) == 'Meta-análisis' ? 'selected' : '' ?>>Meta-análisis</option>
                </select>
            </div>

            <div class="admin-form-row-3">
                <div class="admin-form-group admin-form-group-1">
                    <label for="cuartil" class="admin-label admin-label-required">
                        <ion-icon name="podium-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Cuartil
                    </label>
                    <select name="cuartil" id="cuartil" class="admin-select" required>
                        <option value="">Selecciona el cuartil</option>
                        <option value="Q1" <?= old('cuartil', $articulo['cuartil']) == 'Q1' ? 'selected' : '' ?>>Q1
                        </option>
                        <option value="Q2" <?= old('cuartil', $articulo['cuartil']) == 'Q2' ? 'selected' : '' ?>>Q2
                        </option>
                        <option value="Q3" <?= old('cuartil', $articulo['cuartil']) == 'Q3' ? 'selected' : '' ?>>Q3
                        </option>
                        <option value="Q4" <?= old('cuartil', $articulo['cuartil']) == 'Q4' ? 'selected' : '' ?>>Q4
                        </option>
                    </select>
                </div>
                <div class="admin-form-group admin-form-group-1">
                    <label for="factor_impacto" class="admin-label">
                        <ion-icon name="trending-up-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Factor de Impacto
                    </label>

                    <input type="text" name="factor_impacto" id="factor_impacto" class="admin-input"
                        value="<?= old('factor_impacto', $articulo['factor_impacto']) ?>">

                </div>
                <div class="admin-form-group admin-form-group-1">
                    <label for="doi" class="admin-label">
                        <ion-icon name="link-outline" class="w-4 h-4 mr-2"></ion-icon>
                        DOI
                    </label>
                    <input type="text" name="doi" id="doi" class="admin-input"
                        value="<?= old('doi', $articulo['doi']) ?>">
                </div>
            </div>

            <div class="admin-form-row-3">
                <div class="admin-form-group admin-form-group-1">
                    <label for="campo_amplio" class="admin-label">
                        <ion-icon name="school-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Campo Amplio
                    </label>
                    <select name="campo_amplio" id="campo_amplio" class="admin-select">
                        <option value="">Selecciona el campo amplio</option>
                        <option value="Educación">Educación</option>
                        <option value="Artes y humanidades">Artes y humanidades</option>
                        <option value="Ciencias sociales, periodismo, información y derecho">Ciencias sociales,
                            periodismo, información y derecho</option>
                        <option value="Administración">Administración</option>
                        <option value="Ciencias naturales, matemáticas y estadísticas">Ciencias naturales, matemáticas y
                            estadísticas</option>
                        <option value="Tecnologías de la información y la comunicación (TIC)">Tecnologías de la
                            información y la comunicación (TIC)</option>
                        <option value="Ingeniería, industria y construcción">Ingeniería, industria y construcción
                        </option>
                        <option value="Agricultura, silvicultura, pesca y veterinaria">Agricultura, silvicultura, pesca
                            y veterinaria</option>
                        <option value="Salud y Bienestar">Salud y Bienestar</option>
                        <option value="Servicios">Servicios</option>
                    </select>
                </div>
                <div class="admin-form-group admin-form-group-1">
                    <label for="campo_especifico" class="admin-label">
                        <ion-icon name="git-branch-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Campo Específico
                    </label>
                    <select name="campo_especifico" id="campo_especifico" class="admin-select" disabled>
                        <option value="">Selecciona el campo específico</option>
                    </select>
                </div>
                <div class="admin-form-group admin-form-group-1">
                    <label for="campo_detallado" class="admin-label">
                        <ion-icon name="list-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Campo Detallado
                    </label>
                    <select name="campo_detallado" id="campo_detallado" class="admin-select" disabled>
                        <option value="">Selecciona el campo detallado</option>
                    </select>
                </div>
            </div>

            <div class="admin-form-group">
                <label for="resumen" class="admin-label">
                    <ion-icon name="reader-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Resumen
                </label>
                <textarea name="resumen" id="resumen" class="admin-textarea"
                    rows="8"><?= old('resumen', $articulo['resumen']) ?></textarea>
            </div>

            <div class="admin-form-group">
                <label for="palabras_clave" class="admin-label">
                    <ion-icon name="pricetags-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Palabras Clave
                </label>
                <textarea name="palabras_clave" id="palabras_clave" class="admin-textarea"
                    placeholder="Separadas por comas"><?= old('palabras_clave', $articulo['palabras_clave']) ?></textarea>
            </div>

            <div class="admin-form-group">
                <label for="enlace_revista" class="admin-label">
                    <ion-icon name="link-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Enlace de la Revista
                </label>
                <input type="url" name="enlace_revista" id="enlace_revista" class="admin-input"
                    value="<?= old('enlace_revista', $articulo['enlace_revista']) ?>">
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="archivo_articulo" class="admin-label">
                        <ion-icon name="cloud-upload-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Archivo del Artículo
                    </label>
                    <input type="file" name="archivo_articulo" id="archivo_articulo" class="admin-file-input">
                    <?php if (!empty($articulo['archivo_articulo'])): ?>
                        <div class="mt-1 text-xs">Actual: <a
                                href="<?= base_url( $articulo['archivo_articulo']) ?>" target="_blank">Ver
                                archivo</a></div>
                    <?php endif; ?>
                    <p class="admin-text-secondary text-sm mt-1">PDF, DOCX, JPG, PNG (máx. 10MB)</p>
                </div>
                <div class="admin-form-group">
                    <label for="portada_articulo" class="admin-label">
                        <ion-icon name="image-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Certificado de publicación / Aceptación
                    </label>
                    <input type="file" name="portada_articulo" id="portada_articulo" class="admin-file-input">
                    <?php if (!empty($articulo['portada_articulo'])): ?>
                        <div class="mt-1 text-xs">Actual: <img
                                src="<?= base_url( $articulo['portada_articulo']) ?>" alt="Portada"
                                class="h-12 inline"></div>
                    <?php endif; ?>
                    <p class="admin-text-secondary text-sm mt-1">(opcional)</p>
                </div>
            </div>

            <div class="admin-form-group">
                <label for="descripcion_articulo" class="admin-label">
                    <ion-icon name="information-circle-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Descripción/Observaciones
                </label>
                <textarea name="descripcion_articulo" id="descripcion_articulo"
                    class="admin-textarea"><?= old('descripcion_articulo', $articulo['descripcion_articulo']) ?></textarea>
            </div>

            <div class="admin-form-actions">
                <a href="<?= base_url('docente/articulos') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Actualizar Artículo
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

    // Estructura de datos jerárquica basada en las tablas proporcionadas
    const camposData = {
        "Educación": {
            "Educación": [
                "Educación",
                "Psicopedagogía",
                "Formación para docentes de educación preprimaria",
                "Formación para docentes sin asignaturas de especialización",
                "Formación para docentes con asignaturas de especialización"
            ]
        },
        "Artes y humanidades": {
            "Artes": [
                "Técnicas audiovisuales y producción para medios de comunicación",
                "Diseño",
                "Artes",
                "Música y artes escénicas"
            ],
            "Humanidades": [
                "Religión y Teología",
                "Historia y Arqueología",
                "Filosofía"
            ],
            "Idiomas": [
                "Idiomas",
                "Literatura y lingüística"
            ]
        },
        "Ciencias sociales, periodismo, información y derecho": {
            "Ciencias sociales y del comportamiento": [
                "Economía",
                "Economía Matemática",
                "Ciencias políticas",
                "Psicología",
                "Estudios Sociales y Culturales",
                "Estudios de Género",
                "Geografía y territorio"
            ],
            "Periodismo e información": [
                "Periodismo y comunicación",
                "Bibliotecología, documentación y archivología"
            ],
            "Derecho": [
                "Derecho"
            ]
        },
        "Administración": {
            "Educación comercial y administración": [
                "Contabilidad y auditoría",
                "Gestión financiera",
                "Administración",
                "Mercadotecnia y publicidad",
                "Información gerencial",
                "Comercio",
                "Competencias laborales"
            ]
        },
        "Ciencias naturales, matemáticas y estadísticas": {
            "Ciencias biológicas y afines": [
                "Biología",
                "Biofísica",
                "Biofarmacéutica",
                "Biomedicina",
                "Bioquímica",
                "Genética",
                "Biodiversidad",
                "Neurociencias"
            ],
            "Medio ambiente": [
                "Medio ambiente",
                "Recursos Naturales Renovables"
            ],
            "Ciencias físicas": [
                "Química",
                "Ciencias de la Tierra",
                "Física"
            ],
            "Matemáticas y estadística": [
                "Matemáticas",
                "Estadísticas",
                "Logística y transporte"
            ]
        },
        "Tecnologías de la información y la comunicación (TIC)": {
            "Tecnologías de la información y la comunicación (TIC)": [
                "Computación",
                "Diseño y administración de redes y bases de datos",
                "Desarrollo y análisis de software y aplicaciones",
                "Sistemas de Información"
            ]
        },
        "Ingeniería, industria y construcción": {
            "Ingeniaría y profesiones afines": [
                "Química aplicada",
                "Tecnología de protección del medio ambiente",
                "Electricidad y energía",
                "Electrónica, automatización y sonido",
                "Mecánica y profesiones afines a la metalistería",
                "Diseño y construcción de vehículos, barcos y aeronaves motorizadas",
                "Tecnologías Nucleares y Energéticas",
                "Mecatrónica",
                "Hidráulica",
                "Telecomunicaciones",
                "Nanotecnología"
            ],
            "Industria y producción": [
                "Procesamiento de alimentos",
                "Materiales",
                "Productos textiles",
                "Minería y extracción",
                "Producción industrial",
                "Seguridad industrial",
                "Diseño industrial y de procesos",
                "Mantenimiento industrial"
            ],
            "Arquitectura y construcción": [
                "Arquitectura, urbanismo y restauración",
                "Construcción e ingeniería civil"
            ]
        },
        "Agricultura, silvicultura, pesca y veterinaria": {
            "Agricultura": [
                "Producción agrícola y ganadera"
            ],
            "Silvicultura": [
                "Silvicultura"
            ],
            "Pesca": [
                "Pesca"
            ],
            "Veterinaria": [
                "Veterinaria"
            ]
        },
        "Salud y Bienestar": {
            "Salud": [
                "Odontología",
                "Medicina",
                "Enfermería y obstetricia",
                "Tecnología de diagnóstico y tratamiento médico",
                "Terapia y rehabilitación",
                "Farmacia",
                "Terapias alternativas y complementarias",
                "Salud Pública"
            ],
            "Bienestar": [
                "Asistencia a adultos mayores y discapacitados",
                "Asistencia a la infancia y servicios para jóvenes"
            ]
        },
        "Servicios": {
            "Servicios personales": [
                "Peluquería y tratamiento de belleza",
                "Hotelería y gastronomía",
                "Actividad física",
                "Turismo"
            ],
            "Servicios de protección": [
                "Prevención y gestión de riesgos",
                "Salud y seguridad ocupacional"
            ],
            "Servicios de seguridad": [
                "Educación policial, militar y defensa",
                "Seguridad ciudadana"
            ],
            "Servicio de transporte": [
                "Gestión del transporte"
            ]
        }
    };

    // Referencias a los elementos del DOM
    const campoAmplio = document.getElementById('campo_amplio');
    const campoEspecifico = document.getElementById('campo_especifico');
    const campoDetallado = document.getElementById('campo_detallado');

    // Función para limpiar y llenar un select
    function llenarSelect(selectElement, opciones, placeholder) {
        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        opciones.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion;
            option.textContent = opcion;
            selectElement.appendChild(option);
        });
    }

    // Función para limpiar y deshabilitar un select
    function limpiarSelect(selectElement, placeholder) {
        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        selectElement.disabled = true;
    }

    // Evento para campo amplio
    campoAmplio.addEventListener('change', function () {
        const valorAmplio = this.value;

        // Limpiar campos dependientes
        limpiarSelect(campoEspecifico, 'Selecciona el campo específico');
        limpiarSelect(campoDetallado, 'Selecciona el campo detallado');

        if (valorAmplio && camposData[valorAmplio]) {
            // Llenar campo específico
            const camposEspecificos = Object.keys(camposData[valorAmplio]);
            llenarSelect(campoEspecifico, camposEspecificos, 'Selecciona el campo específico');
            campoEspecifico.disabled = false;
        }
    });

    // Evento para campo específico
    campoEspecifico.addEventListener('change', function () {
        const valorAmplio = campoAmplio.value;
        const valorEspecifico = this.value;

        // Limpiar campo detallado
        limpiarSelect(campoDetallado, 'Selecciona el campo detallado');

        if (valorAmplio && valorEspecifico && camposData[valorAmplio][valorEspecifico]) {
            // Llenar campo detallado
            const camposDetallados = camposData[valorAmplio][valorEspecifico];
            llenarSelect(campoDetallado, camposDetallados, 'Selecciona el campo detallado');
            campoDetallado.disabled = false;
        }
    });

    // Función para obtener los valores seleccionados (útil para formularios)
    function obtenerValores() {
        return {
            campo_amplio: campoAmplio.value,
            campo_especifico: campoEspecifico.value,
            campo_detallado: campoDetallado.value
        };
    }

    // Función para establecer valores (útil para edición)
    function establecerValores(amplio, especifico, detallado) {
        if (amplio) {
            campoAmplio.value = amplio;
            campoAmplio.dispatchEvent(new Event('change'));

            setTimeout(() => {
                if (especifico) {
                    campoEspecifico.value = especifico;
                    campoEspecifico.dispatchEvent(new Event('change'));

                    setTimeout(() => {
                        if (detallado) {
                            campoDetallado.value = detallado;
                        }
                    }, 10);
                }
            }, 10);
        }
    }

    // Hacer las funciones disponibles globalmente
    window.obtenerValores = obtenerValores;
    window.establecerValores = establecerValores;

    // Evento para mostrar valores seleccionados (demo)
    document.addEventListener('change', function (e) {
        if (e.target.matches('#campo_amplio, #campo_especifico, #campo_detallado')) {
            const valores = obtenerValores();
            console.log('Valores seleccionados:', valores);
        }
    });

    // Inicializar selects con los valores del artículo en edición
    window.addEventListener('DOMContentLoaded', function () {
        establecerValores(
            "<?= addslashes($articulo['campo_amplio'] ?? '') ?>",
            "<?= addslashes($articulo['campo_especifico'] ?? '') ?>",
            "<?= addslashes($articulo['campo_detallado'] ?? '') ?>"
        );
    });
</script>
<?= $this->endSection() ?>
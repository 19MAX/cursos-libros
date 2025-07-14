<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Nueva Capacitación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nueva Capacitación
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Registra una nueva capacitación o formación continua
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
        <h3 class="text-lg font-semibold admin-text-primary">Información de la Capacitación</h3>
        <p class="admin-text-secondary text-sm">Completa todos los campos requeridos</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/capacitaciones/store') ?>" method="POST"  enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Nombre de la Capacitación -->
            <div class="admin-form-row">

                <div class="admin-form-group">
                    <label for="nombre_capacitacion" class="admin-label admin-label-required">
                        <ion-icon name="library-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Nombre de la Capacitación
                    </label>
                    <input type="text" id="nombre_capacitacion" name="nombre_capacitacion"
                        value="<?= old('nombre_capacitacion') ?>" class="admin-input"
                        placeholder="Ej: Programación Web Avanzada" required>
                    <p class="admin-text-secondary text-sm mt-1">Ingresa el nombre completo de la capacitación o curso
                    </p>
                </div>

                <!-- Institución Organizadora -->
                <div class="admin-form-group">
                    <label for="institucion_organizadora" class="admin-label admin-label-required">
                        <ion-icon name="business-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Institución Organizadora
                    </label>
                    <input type="text" id="institucion_organizadora" name="institucion_organizadora"
                        value="<?= old('institucion_organizadora') ?>" class="admin-input"
                        placeholder="Ej: Universidad Nacional" required>
                    <p class="admin-text-secondary text-sm mt-1">Nombre de la institución que organizó la capacitación
                    </p>
                </div>

            </div>

            <div class="admin-form-row">
                <!-- Tipo de Participación -->
                <div class="admin-form-group">
                    <label for="tipo_participacion" class="admin-label admin-label-required">
                        <ion-icon name="person-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Tipo de Participación
                    </label>
                    <select id="tipo_participacion" name="tipo_participacion" class="admin-select" required>
                        <option value="">Selecciona el tipo de participación</option>
                        <option value="asistente" <?= old('tipo_participacion') == 'asistente' ? 'selected' : '' ?>>
                            Asistente
                        </option>
                        <option value="facilitador" <?= old('tipo_participacion') == 'facilitador' ? 'selected' : '' ?>>
                            Facilitador</option>
                        <option value="organizador" <?= old('tipo_participacion') == 'organizador' ? 'selected' : '' ?>>
                            Organizador</option>
                        <option value="ponente" <?= old('tipo_participacion') == 'ponente' ? 'selected' : '' ?>>Ponente
                        </option>
                    </select>
                    <p class="admin-text-secondary text-sm mt-1">Define tu rol en la capacitación</p>
                </div>
                <!-- Modalidad -->
                <div class="admin-form-group">
                    <label for="modalidad" class="admin-label admin-label-required">
                        <ion-icon name="desktop-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Modalidad
                    </label>
                    <select id="modalidad" name="modalidad" class="admin-select" required>
                        <option value="">Selecciona la modalidad</option>
                        <option value="presencial" <?= old('modalidad') == 'presencial' ? 'selected' : '' ?>>Presencial
                        </option>
                        <option value="virtual" <?= old('modalidad') == 'virtual' ? 'selected' : '' ?>>Virtual</option>
                        <option value="hibrida" <?= old('modalidad') == 'hibrida' ? 'selected' : '' ?>>Híbrida</option>
                    </select>
                    <p class="admin-text-secondary text-sm mt-1">Tipo de modalidad de la capacitación</p>
                </div>
            </div>


            <!-- Fechas -->
            <div class="admin-form-row">
                <!-- Fecha de Inicio -->
                <div class="admin-form-group">
                    <label for="fecha_inicio" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Inicio
                    </label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= old('fecha_inicio') ?>"
                        class="admin-input" required>
                    <p class="admin-text-secondary text-sm mt-1">Fecha de inicio de la capacitación</p>
                </div>

                <!-- Fecha de Fin -->
                <div class="admin-form-group">
                    <label for="fecha_fin" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Fin
                    </label>
                    <input type="date" id="fecha_fin" name="fecha_fin" value="<?= old('fecha_fin') ?>"
                        class="admin-input" required>
                    <p class="admin-text-secondary text-sm mt-1">Fecha de finalización de la capacitación</p>
                </div>
            </div>


            <div class="admin-form-row">

                <!-- Duración en Horas -->
                <div class="admin-form-group">
                    <label for="duracion_horas" class="admin-label admin-label-required">
                        <ion-icon name="time-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Duración en Horas
                    </label>
                    <input type="number" id="duracion_horas" name="duracion_horas" value="<?= old('duracion_horas') ?>"
                        class="admin-input" placeholder="Ej: 40" min="1" required>
                    <p class="admin-text-secondary text-sm mt-1">Número total de horas de la capacitación</p>
                </div>
                <div class="admin-form-group">

                    <label for="file" class="admin-label admin-label-required">
                        <ion-icon name="time-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Subir archivo
                    </label>
                    <input
                        class="admin-file-input"
                        aria-describedby="file_input_help" id="file" type="file" name="file">
                    <p class="admin-text-secondary text-sm mt-1" id="file_input">SVG, PNG, JPG or GIF
                        (MAX. 800x400px).</p>


                </div>
            </div>

            <!-- Descripción -->
            <div class="admin-form-group">
                <label for="descripcion" class="admin-label admin-label-optional">
                    <ion-icon name="document-text-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4" class="admin-textarea"
                    placeholder="Describe brevemente el contenido y objetivos de la capacitación..."><?= old('descripcion') ?></textarea>
                <p class="admin-text-secondary text-sm mt-1">Descripción opcional de la capacitación (máximo 1000
                    caracteres)</p>
            </div>

            <!-- Botones de acción -->
            <div class="admin-form-actions">
                <a href="<?= base_url('docente/capacitaciones') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Guardar Capacitación
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Validación de fechas
    document.getElementById('fecha_inicio').addEventListener('change', function () {
        const fechaInicio = this.value;
        const fechaFin = document.getElementById('fecha_fin').value;

        if (fechaFin && fechaInicio > fechaFin) {
            alert('La fecha de inicio no puede ser posterior a la fecha de fin');
            this.value = '';
        }
    });

    document.getElementById('fecha_fin').addEventListener('change', function () {
        const fechaFin = this.value;
        const fechaInicio = document.getElementById('fecha_inicio').value;

        if (fechaInicio && fechaFin < fechaInicio) {
            alert('La fecha de fin no puede ser anterior a la fecha de inicio');
            this.value = '';
        }
    });

    // Validación de duración
    document.getElementById('duracion_horas').addEventListener('input', function () {
        if (this.value < 1) {
            this.setCustomValidity('La duración debe ser al menos 1 hora');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<?= $this->endSection() ?>
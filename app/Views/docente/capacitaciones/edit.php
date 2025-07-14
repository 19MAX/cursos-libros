<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Editar Capacitación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Editar Capacitación
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Modifica la información de tu capacitación
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
        <h3 class="text-lg font-semibold admin-text-primary">Editar Capacitación</h3>
        <p class="admin-text-secondary text-sm">Modifica la información de tu capacitación</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/capacitaciones/update/' . $capacitacion['id']) ?>" method="POST"
            class="space-y-6" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Nombre de la Capacitación -->
            <div class="admin-form-group">
                <label for="nombre_capacitacion" class="admin-label admin-label-required">
                    <ion-icon name="library-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Nombre de la Capacitación
                </label>
                <input type="text" id="nombre_capacitacion" name="nombre_capacitacion"
                    value="<?= old('nombre_capacitacion', $capacitacion['nombre_capacitacion']) ?>" class="admin-input"
                    placeholder="Ej: Programación Web Avanzada" required>
                <p class="admin-text-secondary text-sm mt-1">Ingresa el nombre completo de la capacitación o curso</p>
            </div>

            <!-- Institución Organizadora -->
            <div class="admin-form-group">
                <label for="institucion_organizadora" class="admin-label admin-label-required">
                    <ion-icon name="business-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Institución Organizadora
                </label>
                <input type="text" id="institucion_organizadora" name="institucion_organizadora"
                    value="<?= old('institucion_organizadora', $capacitacion['institucion_organizadora']) ?>"
                    class="admin-input" placeholder="Ej: Universidad Nacional" required>
                <p class="admin-text-secondary text-sm mt-1">Nombre de la institución que organizó la capacitación</p>
            </div>

            <!-- Tipo de Participación -->
            <div class="admin-form-group">
                <label for="tipo_participacion" class="admin-label admin-label-required">
                    <ion-icon name="person-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Tipo de Participación
                </label>
                <select id="tipo_participacion" name="tipo_participacion" class="admin-select" required>
                    <option value="">Selecciona el tipo de participación</option>
                    <option value="asistente" <?= (old('tipo_participacion', $capacitacion['tipo_participacion']) == 'asistente') ? 'selected' : '' ?>>Asistente</option>
                    <option value="facilitador" <?= (old('tipo_participacion', $capacitacion['tipo_participacion']) == 'facilitador') ? 'selected' : '' ?>>Facilitador</option>
                    <option value="organizador" <?= (old('tipo_participacion', $capacitacion['tipo_participacion']) == 'organizador') ? 'selected' : '' ?>>Organizador</option>
                    <option value="ponente" <?= (old('tipo_participacion', $capacitacion['tipo_participacion']) == 'ponente') ? 'selected' : '' ?>>Ponente</option>
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
                    <option value="presencial" <?= (old('modalidad', $capacitacion['modalidad']) == 'presencial') ? 'selected' : '' ?>>Presencial</option>
                    <option value="virtual" <?= (old('modalidad', $capacitacion['modalidad']) == 'virtual') ? 'selected' : '' ?>>Virtual</option>
                    <option value="hibrida" <?= (old('modalidad', $capacitacion['modalidad']) == 'hibrida') ? 'selected' : '' ?>>Híbrida</option>
                </select>
                <p class="admin-text-secondary text-sm mt-1">Tipo de modalidad de la capacitación</p>
            </div>

            <!-- Duración en Horas -->
            <div class="admin-form-group">
                <label for="duracion_horas" class="admin-label admin-label-required">
                    <ion-icon name="time-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Duración en Horas
                </label>
                <input type="number" id="duracion_horas" name="duracion_horas"
                    value="<?= old('duracion_horas', $capacitacion['duracion_horas']) ?>" class="admin-input"
                    placeholder="Ej: 40" min="1" required>
                <p class="admin-text-secondary text-sm mt-1">Número total de horas de la capacitación</p>
            </div>

            <!-- Fechas -->
            <div class="admin-form-row">
                <!-- Fecha de Inicio -->
                <div class="admin-form-group">
                    <label for="fecha_inicio" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Inicio
                    </label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                        value="<?= old('fecha_inicio', $capacitacion['fecha_inicio']) ?>" class="admin-input" required>
                    <p class="admin-text-secondary text-sm mt-1">Fecha de inicio de la capacitación</p>
                </div>

                <!-- Fecha de Fin -->
                <div class="admin-form-group">
                    <label for="fecha_fin" class="admin-label admin-label-required">
                        <ion-icon name="calendar-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Fecha de Fin
                    </label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                        value="<?= old('fecha_fin', $capacitacion['fecha_fin']) ?>" class="admin-input" required>
                    <p class="admin-text-secondary text-sm mt-1">Fecha de finalización de la capacitación</p>
                </div>
            </div>

            <!-- Descripción -->
            <div class="admin-form-group">
                <label for="descripcion" class="admin-label admin-label-optional">
                    <ion-icon name="document-text-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4" class="admin-textarea"
                    placeholder="Describe brevemente el contenido y objetivos de la capacitación..."><?= old('descripcion', $capacitacion['descripcion']) ?></textarea>
                <p class="admin-text-secondary text-sm mt-1">Descripción opcional de la capacitación (máximo 1000
                    caracteres)</p>
            </div>

            <!-- Archivo de Certificado -->
            <div class="admin-form-group">
                <label for="file" class="admin-label admin-label-optional">
                    <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Certificado (Opcional)
                </label>
                
                <!-- Mostrar archivo actual si existe -->
                <?php if (!empty($capacitacion['certificado'])): ?>
                    <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="<?= getFileIcon($capacitacion['certificado']) ?> text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    Archivo actual
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <?= basename($capacitacion['certificado']) ?>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="<?= getCapacitacionFile($capacitacion['certificado']) ?>" 
                                   target="_blank" 
                                   class="admin-btn-secondary text-xs">
                                    <ion-icon name="eye-outline" class="w-3 h-3 mr-1"></ion-icon>
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <input type="file" id="file" name="file" class="admin-input" 
                       accept=".pdf,.jpg,.jpeg,.png,.gif,.webp">
                <p class="admin-text-secondary text-sm mt-1">
                    Sube un nuevo certificado para reemplazar el actual. 
                    Formatos permitidos: PDF, JPG, JPEG, PNG, GIF, WEBP (máximo 10MB)
                </p>
            </div>

            <!-- Información de Estado (solo lectura) -->
            <div class="admin-form-group">
                <label class="admin-label">
                    <ion-icon name="checkmark-circle-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Estado Actual
                </label>
                <div class="admin-input admin-form-readonly">
                    <?php
                    $estadoClass = '';
                    $estadoText = '';
                    switch ($capacitacion['estado']) {
                        case 'aprobado':
                            $estadoClass = 'text-green-600 dark:text-green-400';
                            $estadoText = 'Aprobado';
                            break;
                        case 'pendiente':
                            $estadoClass = 'text-yellow-600 dark:text-yellow-400';
                            $estadoText = 'Pendiente de Revisión';
                            break;
                        case 'rechazado':
                            $estadoClass = 'text-red-600 dark:text-red-400';
                            $estadoText = 'Rechazado';
                            break;
                    }
                    ?>
                    <span class="<?= $estadoClass ?> font-medium"><?= $estadoText ?></span>
                </div>
                <p class="admin-text-secondary text-sm mt-1">El estado es gestionado por el administrador</p>
            </div>

            <!-- Puntaje Asignado (solo lectura) -->
            <div class="admin-form-group">
                <label class="admin-label">
                    <ion-icon name="star-outline" class="w-4 h-4 mr-2"></ion-icon>
                    Puntaje Asignado
                </label>
                <div class="admin-input admin-form-readonly">
                    <span class="font-medium"><?= number_format($capacitacion['puntaje_asignado'], 2) ?> puntos</span>
                </div>
                <p class="admin-text-secondary text-sm mt-1">El puntaje es asignado por el administrador</p>
            </div>

            <!-- Botones de acción -->
            <div class="admin-form-actions">
                <a href="<?= base_url('docente/capacitaciones') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Actualizar Capacitación
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

    // Validación de archivo
    document.getElementById('file').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            // Validar tamaño (10MB)
            const maxSize = 10 * 1024 * 1024; // 10MB en bytes
            if (file.size > maxSize) {
                alert('El archivo excede el tamaño máximo de 10MB');
                this.value = '';
                return;
            }

            // Validar tipo de archivo
            const allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
            const fileName = file.name.toLowerCase();
            const fileExtension = fileName.split('.').pop();

            if (!allowedTypes.includes(fileExtension)) {
                alert('Tipo de archivo no permitido. Solo se permiten: PDF, JPG, JPEG, PNG, GIF, WEBP');
                this.value = '';
                return;
            }
        }
    });
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/docente_layout') ?>
<?= $this->section('title') ?>Agregar Documento<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Agregar Documento<?= $this->endSection() ?>
<?= $this->section('page_description') ?>Crea un nuevo documento o guía<?= $this->endSection() ?>
<?= $this->section('breadcrumb') ?>Documentos / Agregar<?= $this->endSection() ?>
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

<!-- Mensajes de error general -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="admin-alert admin-alert-error mb-4">
        <ion-icon name="close-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Agregar Documento</h3>
        <p class="admin-text-secondary text-sm">Completa la información del documento</p>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('docente/documentos/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="nombre" class="admin-label admin-label-required">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Nombre del Documento
                    </label>
                    <input type="text" id="nombre" name="nombre" 
                           value="<?= old('nombre') ?>" class="admin-input" 
                           placeholder="Ej: Guía de Investigación" required>
                    <p class="admin-text-secondary text-sm mt-1">Nombre descriptivo del documento o guía</p>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="descripcion" class="admin-label">
                        <ion-icon name="text-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Descripción
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="admin-textarea" 
                              placeholder="Describe el contenido y propósito del documento..."><?= old('descripcion') ?></textarea>
                    <p class="admin-text-secondary text-sm mt-1">Descripción opcional del documento (máximo 1000 caracteres)</p>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="guia" class="admin-label admin-label-required">
                        <ion-icon name="document-outline" class="w-4 h-4 mr-2"></ion-icon>
                        Archivo PDF de la Guía
                    </label>
                    <input type="file" id="guia" name="guia" accept="application/pdf" 
                           class="admin-file-input" required>
                    <p class="admin-text-secondary text-sm mt-1">Solo archivos PDF. Máximo 20MB.</p>
                </div>
            </div>

            <div class="admin-form-actions">
                <a href="<?= base_url('docente/documentos') ?>" class="admin-btn-secondary">
                    <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="admin-btn-primary">
                    <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                    Crear Documento
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    // Validación del archivo
    document.getElementById('guia').addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 20 * 1024 * 1024; // 20MB
        
        if (file) {
            // Validar tipo de archivo
            if (file.type !== 'application/pdf') {
                alert('Solo se permiten archivos PDF.');
                this.value = '';
                return;
            }
            
            // Validar tamaño
            if (file.size > maxSize) {
                alert('El archivo no debe exceder 20MB.');
                this.value = '';
                return;
            }
        }
    });

    // Validación de descripción
    document.getElementById('descripcion').addEventListener('input', function() {
        const maxLength = 1000;
        if (this.value.length > maxLength) {
            this.setCustomValidity(`La descripción no puede exceder ${maxLength} caracteres`);
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/auth_layout'); ?>

<?= $this->section('title') ?>
Ejemplo de Clases Admin
<?= $this->endSection() ?>

<?= $this->section('titleSection') ?>
Panel de Administración
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-card-transparent">
    <h2 class="text-2xl font-bold mb-6 text-center admin-text-primary">Ejemplo de Clases del Panel de Administración</h2>

    <!-- Sección de Formularios -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Formularios</h3>
        </div>
        <div class="admin-card-body">
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="nombre" class="admin-label admin-label-required">Nombre</label>
                    <input type="text" id="nombre" class="admin-input" placeholder="Tu nombre">
                </div>
                <div class="admin-form-group">
                    <label for="email" class="admin-label admin-label-required">Email</label>
                    <input type="email" id="email" class="admin-input" placeholder="tu@email.com">
                </div>
            </div>
            
            <div class="admin-form-group">
                <label for="rol" class="admin-label">Rol</label>
                <select id="rol" class="admin-select">
                    <option value="">Seleccionar rol</option>
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                </select>
            </div>
            
            <div class="admin-form-group">
                <label for="descripcion" class="admin-label">Descripción</label>
                <textarea id="descripcion" class="admin-textarea" rows="3" placeholder="Descripción..."></textarea>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-label">Estado</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="estado" value="activo" class="admin-radio">
                        <span class="ml-2 admin-text-secondary">Activo</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="estado" value="inactivo" class="admin-radio">
                        <span class="ml-2 admin-text-secondary">Inactivo</span>
                    </label>
                </div>
            </div>
            
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-secondary">Cancelar</button>
                <button type="button" class="admin-btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <!-- Sección de Botones -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Botones</h3>
        </div>
        <div class="admin-card-body">
            <div class="flex flex-wrap gap-2 mb-4">
                <button class="admin-btn-primary">Primario</button>
                <button class="admin-btn-secondary">Secundario</button>
                <button class="admin-btn-success">Éxito</button>
                <button class="admin-btn-danger">Peligro</button>
                <button class="admin-btn-warning">Advertencia</button>
                <button class="admin-btn-info">Info</button>
            </div>
            
            <div class="flex flex-wrap gap-2 mb-4">
                <button class="admin-btn-primary admin-btn-sm">Pequeño</button>
                <button class="admin-btn-primary">Normal</button>
                <button class="admin-btn-primary admin-btn-lg">Grande</button>
                <button class="admin-btn-primary admin-btn-xl">Extra Grande</button>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <button class="admin-btn-outline-primary">Outline Primario</button>
                <button class="admin-btn-outline-secondary">Outline Secundario</button>
                <button class="admin-btn-icon">
                    <ion-icon name="add-outline" class="w-5 h-5"></ion-icon>
                </button>
            </div>
        </div>
    </div>

    <!-- Sección de Alertas -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Alertas</h3>
        </div>
        <div class="admin-card-body space-y-4">
            <div class="admin-alert admin-alert-success">
                <strong>Éxito!</strong> La operación se completó correctamente.
            </div>
            <div class="admin-alert admin-alert-error">
                <strong>Error!</strong> Algo salió mal. Inténtalo de nuevo.
            </div>
            <div class="admin-alert admin-alert-warning">
                <strong>Advertencia!</strong> Ten cuidado con esta acción.
            </div>
            <div class="admin-alert admin-alert-info">
                <strong>Información!</strong> Aquí tienes información importante.
            </div>
        </div>
    </div>

    <!-- Sección de Badges -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Badges</h3>
        </div>
        <div class="admin-card-body">
            <div class="flex flex-wrap gap-2">
                <span class="admin-badge admin-badge-primary">Primario</span>
                <span class="admin-badge admin-badge-success">Éxito</span>
                <span class="admin-badge admin-badge-warning">Advertencia</span>
                <span class="admin-badge admin-badge-danger">Peligro</span>
                <span class="admin-badge admin-badge-info">Info</span>
                <span class="admin-badge admin-badge-gray">Gris</span>
            </div>
        </div>
    </div>

    <!-- Sección de Cards -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Cards</h3>
        </div>
        <div class="admin-card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="admin-card-hover p-4">
                    <h4 class="font-semibold admin-text-primary mb-2">Card con Hover</h4>
                    <p class="admin-text-secondary">Esta card tiene efectos de hover.</p>
                </div>
                <div class="admin-card-stats-primary p-4">
                    <h4 class="font-semibold text-white mb-2">Card de Estadísticas</h4>
                    <p class="text-white/90">Card con gradiente primario.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Inputs con Estados -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Estados de Inputs</h3>
        </div>
        <div class="admin-card-body space-y-4">
            <div class="admin-form-group">
                <label class="admin-label">Input Normal</label>
                <input type="text" class="admin-input" placeholder="Input normal">
            </div>
            <div class="admin-form-group">
                <label class="admin-label">Input con Error</label>
                <input type="text" class="admin-input-error" placeholder="Input con error" value="Valor inválido">
            </div>
            <div class="admin-form-group">
                <label class="admin-label">Input con Éxito</label>
                <input type="text" class="admin-input-success" placeholder="Input con éxito" value="Valor válido">
            </div>
            <div class="admin-form-group">
                <label class="admin-label">Input con Icono</label>
                <div class="relative">
                    <input type="text" class="admin-input-with-icon" placeholder="Buscar...">
                    <div class="admin-search-icon">
                        <ion-icon name="search-outline" class="w-5 h-5"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Navegación -->
    <div class="admin-card mb-6">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Navegación</h3>
        </div>
        <div class="admin-card-body">
            <nav class="space-y-2">
                <a href="#" class="admin-nav-item admin-nav-item-active">
                    <ion-icon name="home-outline" class="admin-nav-item-icon"></ion-icon>
                    Dashboard
                </a>
                <a href="#" class="admin-nav-item">
                    <ion-icon name="people-outline" class="admin-nav-item-icon"></ion-icon>
                    Usuarios
                </a>
                <a href="#" class="admin-nav-item">
                    <ion-icon name="settings-outline" class="admin-nav-item-icon"></ion-icon>
                    Configuración
                </a>
            </nav>
        </div>
    </div>

    <!-- Sección de Textos -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Tipografía</h3>
        </div>
        <div class="admin-card-body space-y-2">
            <h1 class="text-3xl font-bold admin-text-primary">Título Principal</h1>
            <h2 class="text-2xl font-semibold admin-text-primary">Subtítulo</h2>
            <p class="admin-text-secondary">Texto secundario para descripciones.</p>
            <p class="admin-text-muted">Texto muted para información menos importante.</p>
            <a href="#" class="admin-link">Enlace con estilo personalizado</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 
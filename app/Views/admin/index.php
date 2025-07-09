<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Vista general del sistema de libros y cursos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Cards de estadísticas -->
<div class="admin-dashboard-grid mb-6">
    <!-- Total de Usuarios -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">1,234</div>
                <div class="admin-dashboard-label">Cursos</div>
                <div class="admin-dashboard-change admin-dashboard-change-positive">
                    +12% este mes
                </div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                <ion-icon name="people-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Total de Cursos -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">56</div>
                <div class="admin-dashboard-label">Docentes</div>
                <div class="admin-dashboard-change admin-dashboard-change-positive">
                    +5% este mes
                </div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                <ion-icon name="library-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Total de Libros -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">789</div>
                <div class="admin-dashboard-label">Libros Disponibles</div>
                <div class="admin-dashboard-change admin-dashboard-change-positive">
                    +8% este mes
                </div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                <ion-icon name="book-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Ingresos -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">$45,678</div>
                <div class="admin-dashboard-label">Ingresos Totales</div>
                <div class="admin-dashboard-change admin-dashboard-change-negative">
                    -3% este mes
                </div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                <ion-icon name="cash-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de barras -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-lg font-semibold admin-text-primary">Actividad Reciente</h3>
        <p class="admin-text-secondary text-sm">Estadísticas de los últimos 7 días</p>
    </div>
    <div class="admin-card-body">
        <div class="h-80">
            <!-- Gráfico de barras simple con CSS -->
            <div class="flex items-end justify-between h-64 mb-4">
                <!-- Lunes -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 60px;"></div>
                    <span class="admin-text-secondary text-xs">Lun</span>
                </div>

                <!-- Martes -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 80px;"></div>
                    <span class="admin-text-secondary text-xs">Mar</span>
                </div>

                <!-- Miércoles -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 45px;"></div>
                    <span class="admin-text-secondary text-xs">Mié</span>
                </div>

                <!-- Jueves -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 95px;"></div>
                    <span class="admin-text-secondary text-xs">Jue</span>
                </div>

                <!-- Viernes -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 70px;"></div>
                    <span class="admin-text-secondary text-xs">Vie</span>
                </div>

                <!-- Sábado -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 55px;"></div>
                    <span class="admin-text-secondary text-xs">Sáb</span>
                </div>

                <!-- Domingo -->
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t-lg mb-2" style="height: 40px;"></div>
                    <span class="admin-text-secondary text-xs">Dom</span>
                </div>
            </div>

            <!-- Leyenda -->
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded mr-2"></div>
                    <span class="admin-text-secondary text-sm">Usuarios Activos</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividad reciente -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Últimos usuarios registrados -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Últimos Usuarios</h3>
        </div>
        <div class="admin-card-body">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="admin-avatar">JP</div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">Juan Pérez</p>
                        <p class="admin-text-secondary text-sm">juan@email.com</p>
                    </div>
                    <span class="admin-badge admin-badge-success">Activo</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="admin-avatar">ML</div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">María López</p>
                        <p class="admin-text-secondary text-sm">maria@email.com</p>
                    </div>
                    <span class="admin-badge admin-badge-success">Activo</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="admin-avatar">CR</div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">Carlos Ruiz</p>
                        <p class="admin-text-secondary text-sm">carlos@email.com</p>
                    </div>
                    <span class="admin-badge admin-badge-warning">Pendiente</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos cursos creados -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-lg font-semibold admin-text-primary">Últimos Cursos</h3>
        </div>
        <div class="admin-card-body">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="admin-avatar bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                        <ion-icon name="library-outline" class="w-4 h-4"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">Programación Web</p>
                        <p class="admin-text-secondary text-sm">25 estudiantes</p>
                    </div>
                    <span class="admin-badge admin-badge-primary">Activo</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="admin-avatar bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                        <ion-icon name="library-outline" class="w-4 h-4"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">Diseño UX/UI</p>
                        <p class="admin-text-secondary text-sm">18 estudiantes</p>
                    </div>
                    <span class="admin-badge admin-badge-primary">Activo</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="admin-avatar bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                        <ion-icon name="library-outline" class="w-4 h-4"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="admin-text-primary font-medium">Marketing Digital</p>
                        <p class="admin-text-secondary text-sm">32 estudiantes</p>
                    </div>
                    <span class="admin-badge admin-badge-primary">Activo</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Aquí puedes agregar scripts adicionales para el dashboard
    // Por ejemplo, para hacer el gráfico interactivo o cargar datos reales
</script>
<?= $this->endSection() ?>
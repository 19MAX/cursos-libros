<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> - Panel de Administración</title>

    <?= $this->include('partials/global/head') ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('css/datatables/style.css') ?>">

</head>

<body class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar fixed top-0 left-0 z-40 w-64 h-screen transition-all duration-300 rounded-r-xl"
        id="sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <!-- Logo y botón de cerrar -->
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center">
                    <img src="<?= base_url('assets/images/imagen-login.png') ?>" class="h-8 w-8 me-3" alt="Logo" />
                    <span class="self-center text-xl font-semibold admin-text-primary sidebar-text">Admin Panel</span>
                </div>
                <!-- Botón de cerrar sidebar en móvil -->
                <button type="button" class="admin-btn-icon md:hidden" data-drawer-hide="sidebar"
                    aria-controls="sidebar">
                    <ion-icon name="close-outline" class="w-5 h-5"></ion-icon>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <div class="admin-sidebar-group sidebar-text">General</div>

                <!-- Dashboard - Sin subniveles -->
                <a href="<?= base_url('admin') ?>"
                    class="admin-sidebar-item <?= current_url() == base_url('admin') ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Dashboard">
                    <ion-icon name="home-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <!-- Capacitaciones - Sin subniveles -->
                <a href="<?= base_url('admin/capacitaciones') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'capacitaciones') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Capacitaciones">
                    <ion-icon name="school-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Capacitaciones</span>
                </a>
                <!-- Libros - Sin subniveles -->
                <a href="<?= base_url('admin/libros') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'libros') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Libros">
                    <ion-icon name="book-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Libros</span>
                </a>
                <!-- Artículos - Sin subniveles -->
                <a href="<?= base_url('admin/articulos') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'articulos') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Artículos">
                    <ion-icon name="document-text-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Artículos</span>
                </a>
                <!-- Documentos - Sin subniveles -->
                <a href="<?= base_url('admin/documentos') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'documentos') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Documentos">
                    <ion-icon name="folder-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Documentos</span>
                </a>
                <!-- Docentes - Sin subniveles -->
                <a href="<?= base_url('admin/docentes') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'docentes') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Docentes">
                    <ion-icon name="people-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Docentes</span>
                </a>

                <div class="admin-sidebar-divider sidebar-text"></div>

                <div class="admin-sidebar-group sidebar-text">Configuración</div>


                <!-- Perfil - Sin subniveles -->
                <!-- <a href="<?= base_url('admin/profile') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'profile') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Perfil">
                    <ion-icon name="person-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Perfil</span>
                </a> -->
            </nav>
        </div>
    </aside>

    <!-- Overlay para móvil -->
    <div class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 hidden md:hidden" id="sidebar-backdrop"></div>

    <!-- Main content -->
    <div class="p-4 md:ml-64 transition-all duration-300" id="main-content">
        <!-- Header -->
        <header class="admin-header sticky top-0 z-30 mb-4 rounded-xl">
            <div class="flex items-center justify-between p-4">
                <!-- Mobile menu button y Toggle sidebar -->
                <div class="flex items-center gap-2">
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                        type="button" class="admin-btn-icon md:hidden">
                        <ion-icon name="menu-outline" class="w-6 h-6"></ion-icon>
                    </button>

                    <!-- Toggle sidebar button (solo desktop) -->
                    <button type="button" class="admin-btn-icon hidden md:flex" id="sidebar-toggle"
                        aria-label="Toggle sidebar">
                        <ion-icon name="menu-outline" class="w-5 h-5"></ion-icon>
                    </button>
                </div>

                <!-- Breadcrumb -->
                <nav class="admin-breadcrumb">
                    <a href="<?= base_url('admin') ?>" class="admin-breadcrumb-item">Dashboard</a>
                    <?php if ($this->renderSection('breadcrumb')): ?>
                        <span class="admin-breadcrumb-separator">/</span>
                        <span class="admin-breadcrumb-item"><?= $this->renderSection('breadcrumb') ?></span>
                    <?php endif; ?>
                </nav>

                <!-- Right side -->
                <div class="flex items-center gap-4">
                    <!-- Theme toggle -->
                    <button id="theme-toggle" type="button" class="admin-btn-icon" aria-label="Cambiar tema">
                        <ion-icon id="theme-toggle-dark-icon" class="w-5 h-5 hidden text-gray-600 dark:text-gray-300"
                            name="moon-outline"></ion-icon>
                        <ion-icon id="theme-toggle-light-icon" class="w-5 h-5 hidden text-yellow-500"
                            name="sunny-outline"></ion-icon>
                    </button>

                    <!-- Notifications -->
                    <!-- <button type="button" class="admin-btn-icon relative" aria-label="Notificaciones">
                        <ion-icon name="notifications-outline" class="w-5 h-5"></ion-icon>
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                            3</div>
                    </button> -->

                    <!-- User menu -->
                    <div class="relative">
                        <button type="button" class="admin-btn-icon" aria-expanded="false"
                            data-dropdown-toggle="user-dropdown">
                            <div class="admin-avatar">AD</div>
                        </button>
                        <div class="admin-dropdown hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg"
                            id="user-dropdown">
                            <!-- <a href="<?= base_url('admin/profile') ?>" class="admin-dropdown-item">
                                <ion-icon name="person-outline" class="w-4 h-4 mr-2"></ion-icon>
                                Mi Perfil
                            </a>
                            <a href="<?= base_url('admin/settings') ?>" class="admin-dropdown-item">
                                <ion-icon name="settings-outline" class="w-4 h-4 mr-2"></ion-icon>
                                Configuración
                            </a> -->
                            <div class="admin-divider"></div>
                            <a href="<?= base_url('auth/logout') ?>"
                                class="admin-dropdown-item text-red-600 dark:text-red-400">
                                <ion-icon name="log-out-outline" class="w-4 h-4 mr-2"></ion-icon>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="admin-main-content">
            <!-- Page header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold admin-text-primary mb-2"><?= $this->renderSection('page_title'); ?></h1>
                <?php if ($this->renderSection('page_description')): ?>
                    <p class="admin-text-secondary"><?= $this->renderSection('page_description'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <?= $this->renderSection('content'); ?>
        </main>
    </div>

    <!-- Scripts -->
    <?= $this->include('partials/global/scripts') ?>
    <!-- DataTables Js -->
    <script src="<?= base_url('js/datatables/simple-datatables.js') ?>"></script>

    <!-- Additional scripts -->
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> - Panel de Administración</title>

    <!-- Script inline para evitar FOUC -->
    <script>
        (function () {
            const theme = localStorage.getItem('color-theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (theme === 'dark' || (!theme && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- CSS -->
    <link href="<?= base_url('css/output.css') ?>" rel="stylesheet">

    <!-- Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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

                <!-- Usuarios - Con subniveles -->
                <div class="admin-sidebar-group-item" data-title="Usuarios">
                    <button type="button"
                        class="admin-sidebar-item w-full text-left <?= strpos(current_url(), 'users') !== false ? 'admin-sidebar-item-active' : '' ?>"
                        onclick="toggleSubmenu('users-submenu')" data-title="Usuarios">
                        <ion-icon name="people-outline" class="admin-nav-item-icon"></ion-icon>
                        <span class="sidebar-text">Usuarios</span>
                        <ion-icon name="chevron-down-outline"
                            class="admin-nav-item-icon ml-auto submenu-arrow"></ion-icon>
                    </button>
                    <div id="users-submenu"
                        class="admin-submenu <?= strpos(current_url(), 'users') !== false ? 'admin-submenu-open' : '' ?>">
                        <a href="<?= base_url('admin/users') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/users') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Lista de Usuarios">
                            <ion-icon name="list-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Lista</span>
                        </a>
                        <a href="<?= base_url('admin/users/create') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/users/create') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Crear Usuario">
                            <ion-icon name="add-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Crear</span>
                        </a>
                        <a href="<?= base_url('admin/users/roles') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/users/roles') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Roles">
                            <ion-icon name="shield-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Roles</span>
                        </a>
                    </div>
                </div>

                <!-- Cursos - Con subniveles -->
                <div class="admin-sidebar-group-item" data-title="Cursos">
                    <button type="button"
                        class="admin-sidebar-item w-full text-left <?= strpos(current_url(), 'courses') !== false ? 'admin-sidebar-item-active' : '' ?>"
                        onclick="toggleSubmenu('courses-submenu')" data-title="Cursos">
                        <ion-icon name="library-outline" class="admin-nav-item-icon"></ion-icon>
                        <span class="sidebar-text">Cursos</span>
                        <ion-icon name="chevron-down-outline"
                            class="admin-nav-item-icon ml-auto submenu-arrow"></ion-icon>
                    </button>
                    <div id="courses-submenu"
                        class="admin-submenu <?= strpos(current_url(), 'courses') !== false ? 'admin-submenu-open' : '' ?>">
                        <a href="<?= base_url('admin/courses') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/courses') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Lista de Cursos">
                            <ion-icon name="list-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Lista</span>
                        </a>
                        <a href="<?= base_url('admin/courses/create') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/courses/create') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Crear Curso">
                            <ion-icon name="add-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Crear</span>
                        </a>
                        <a href="<?= base_url('admin/courses/categories') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/courses/categories') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Categorías">
                            <ion-icon name="folder-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Categorías</span>
                        </a>
                    </div>
                </div>

                <!-- Libros - Con subniveles -->
                <div class="admin-sidebar-group-item" data-title="Libros">
                    <button type="button"
                        class="admin-sidebar-item w-full text-left <?= strpos(current_url(), 'books') !== false ? 'admin-sidebar-item-active' : '' ?>"
                        onclick="toggleSubmenu('books-submenu')" data-title="Libros">
                        <ion-icon name="book-outline" class="admin-nav-item-icon"></ion-icon>
                        <span class="sidebar-text">Libros</span>
                        <ion-icon name="chevron-down-outline"
                            class="admin-nav-item-icon ml-auto submenu-arrow"></ion-icon>
                    </button>
                    <div id="books-submenu"
                        class="admin-submenu <?= strpos(current_url(), 'books') !== false ? 'admin-submenu-open' : '' ?>">
                        <a href="<?= base_url('admin/books') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/books') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Lista de Libros">
                            <ion-icon name="list-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Lista</span>
                        </a>
                        <a href="<?= base_url('admin/books/create') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/books/create') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Agregar Libro">
                            <ion-icon name="add-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Agregar</span>
                        </a>
                        <a href="<?= base_url('admin/books/categories') ?>"
                            class="admin-submenu-item <?= current_url() == base_url('admin/books/categories') ? 'admin-submenu-item-active' : '' ?>"
                            data-title="Categorías">
                            <ion-icon name="folder-outline" class="admin-nav-item-icon-sm"></ion-icon>
                            <span class="sidebar-text">Categorías</span>
                        </a>
                    </div>
                </div>

                <div class="admin-sidebar-divider sidebar-text"></div>

                <div class="admin-sidebar-group sidebar-text">Configuración</div>

                <!-- Configuración - Sin subniveles -->
                <a href="<?= base_url('admin/settings') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'settings') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Configuración">
                    <ion-icon name="settings-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Configuración</span>
                </a>

                <!-- Perfil - Sin subniveles -->
                <a href="<?= base_url('admin/profile') ?>"
                    class="admin-sidebar-item <?= strpos(current_url(), 'profile') !== false ? 'admin-sidebar-item-active' : '' ?>"
                    data-title="Perfil">
                    <ion-icon name="person-outline" class="admin-nav-item-icon"></ion-icon>
                    <span class="sidebar-text">Perfil</span>
                </a>
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
                    <button type="button" class="admin-btn-icon relative" aria-label="Notificaciones">
                        <ion-icon name="notifications-outline" class="w-5 h-5"></ion-icon>
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                            3</div>
                    </button>

                    <!-- User menu -->
                    <div class="relative">
                        <button type="button" class="admin-btn-icon" aria-expanded="false"
                            data-dropdown-toggle="user-dropdown">
                            <div class="admin-avatar">AD</div>
                        </button>
                        <div class="admin-dropdown hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg"
                            id="user-dropdown">
                            <a href="<?= base_url('admin/profile') ?>" class="admin-dropdown-item">
                                <ion-icon name="person-outline" class="w-4 h-4 mr-2"></ion-icon>
                                Mi Perfil
                            </a>
                            <a href="<?= base_url('admin/settings') ?>" class="admin-dropdown-item">
                                <ion-icon name="settings-outline" class="w-4 h-4 mr-2"></ion-icon>
                                Configuración
                            </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="<?= base_url('js/theme.js') ?>"></script>

    <!-- Script para el sidebar móvil y toggle -->
    <script>
        // Estado del sidebar (colapsado o expandido)
        let sidebarCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

        // Función para alternar submenús
        function toggleSubmenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            const parentItem = submenu.closest('.admin-sidebar-group-item');
            const arrow = parentItem.querySelector('.submenu-arrow');

            // Cerrar todos los otros submenús
            document.querySelectorAll('.admin-submenu').forEach(menu => {
                if (menu.id !== submenuId) {
                    menu.classList.remove('admin-submenu-open');
                    menu.closest('.admin-sidebar-group-item')?.classList.remove('active');
                }
            });

            // Alternar el submenú actual
            submenu.classList.toggle('admin-submenu-open');
            parentItem.classList.toggle('active');

            // Rotar flecha
            if (arrow) {
                arrow.style.transform = submenu.classList.contains('admin-submenu-open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        // Función para aplicar el estado del sidebar
        function applySidebarState() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            if (sidebarCollapsed) {
                // Sidebar colapsado
                sidebar.classList.add('w-16', 'collapsed');
                sidebar.classList.remove('w-64');
                mainContent.classList.add('md:ml-16', 'main-content-collapsed');
                mainContent.classList.remove('md:ml-64');

                // Ocultar textos
                sidebarTexts.forEach(text => {
                    text.classList.add('hidden');
                });

                // Centrar iconos principales (no los de submenú)
                document.querySelectorAll('.admin-sidebar-item > .admin-nav-item-icon').forEach(icon => {
                    icon.classList.add('mx-auto');
                    icon.classList.remove('mr-3');
                });

                // Centrar logo
                const logoContainer = sidebar.querySelector('.flex.items-center');
                if (logoContainer) {
                    logoContainer.classList.add('justify-center');
                    logoContainer.classList.remove('justify-between');
                }

                // Ocultar logo en colapsado
                const logoText = sidebar.querySelector('.sidebar-text');
                if (logoText) {
                    logoText.classList.add('hidden');
                }

                // Ocultar botón de cerrar en móvil cuando está colapsado
                const closeButton = sidebar.querySelector('[data-drawer-hide="sidebar"]');
                if (closeButton) {
                    closeButton.classList.add('hidden');
                }

                // Cerrar todos los submenús en modo colapsado
                document.querySelectorAll('.admin-submenu').forEach(menu => {
                    menu.classList.remove('admin-submenu-open');
                    menu.closest('.admin-sidebar-group-item')?.classList.remove('active');
                });
            } else {
                // Sidebar expandido
                sidebar.classList.remove('w-16', 'collapsed');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('md:ml-16', 'main-content-collapsed');
                mainContent.classList.add('md:ml-64');

                // Mostrar textos
                sidebarTexts.forEach(text => {
                    text.classList.remove('hidden');
                });

                // Restaurar iconos principales
                document.querySelectorAll('.admin-sidebar-item > .admin-nav-item-icon').forEach(icon => {
                    icon.classList.remove('mx-auto');
                    icon.classList.add('mr-3');
                });

                // Restaurar logo
                const logoContainer = sidebar.querySelector('.flex.items-center');
                if (logoContainer) {
                    logoContainer.classList.remove('justify-center');
                    logoContainer.classList.add('justify-between');
                }

                // Mostrar logo en expandido
                const logoText = sidebar.querySelector('.sidebar-text');
                if (logoText) {
                    logoText.classList.remove('hidden');
                }

                // Mostrar botón de cerrar en móvil cuando está expandido
                const closeButton = sidebar.querySelector('[data-drawer-hide="sidebar"]');
                if (closeButton) {
                    closeButton.classList.remove('hidden');
                }
            }
        }

        // Aplicar estado inicial
        applySidebarState();

        // Toggle del sidebar
        document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
            sidebarCollapsed = !sidebarCollapsed;
            localStorage.setItem('sidebar-collapsed', sidebarCollapsed);
            applySidebarState();
        });

        // Cerrar sidebar al hacer clic en el overlay
        document.getElementById('sidebar-backdrop')?.addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            if (sidebar && backdrop) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        });

        // Cerrar sidebar al hacer clic en enlaces (móvil)
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    const sidebar = document.getElementById('sidebar');
                    const backdrop = document.getElementById('sidebar-backdrop');

                    if (sidebar && backdrop) {
                        sidebar.classList.add('-translate-x-full');
                        backdrop.classList.add('hidden');
                    }
                }
            });
        });

        // Detectar cambios de tamaño de ventana
        window.addEventListener('resize', function () {
            if (window.innerWidth < 768) {
                // En móvil, asegurar que el sidebar esté expandido
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.remove('w-16', 'collapsed');
                    sidebar.classList.add('w-64');
                }
            }
        });

        // Cerrar submenús al hacer clic fuera (solo en desktop)
        document.addEventListener('click', function (event) {
            if (window.innerWidth >= 768 && !sidebarCollapsed) {
                const sidebar = event.target.closest('#sidebar');
                if (!sidebar) {
                    document.querySelectorAll('.admin-submenu').forEach(menu => {
                        menu.classList.remove('admin-submenu-open');
                        menu.closest('.admin-sidebar-group-item')?.classList.remove('active');
                    });
                }
            }
        });
    </script>

    <!-- Additional scripts -->
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
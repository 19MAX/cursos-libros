// Estado del sidebar (colapsado o expandido)
let sidebarCollapsed = localStorage.getItem("sidebar-collapsed") === "true";

// Función para alternar submenús
function toggleSubmenu(submenuId) {
  const submenu = document.getElementById(submenuId);
  const parentItem = submenu.closest(".admin-sidebar-group-item");
  const arrow = parentItem.querySelector(".submenu-arrow");

  // Cerrar todos los otros submenús
  document.querySelectorAll(".admin-submenu").forEach((menu) => {
    if (menu.id !== submenuId) {
      menu.classList.remove("admin-submenu-open");
      menu.closest(".admin-sidebar-group-item")?.classList.remove("active");
    }
  });

  // Alternar el submenú actual
  submenu.classList.toggle("admin-submenu-open");
  parentItem.classList.toggle("active");

  // Rotar flecha
  if (arrow) {
    arrow.style.transform = submenu.classList.contains("admin-submenu-open")
      ? "rotate(180deg)"
      : "rotate(0deg)";
  }
}

// Función para aplicar el estado del sidebar
function applySidebarState() {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");
  const sidebarTexts = document.querySelectorAll(".sidebar-text");

  if (sidebarCollapsed) {
    // Sidebar colapsado
    sidebar.classList.add("w-16", "collapsed");
    sidebar.classList.remove("w-64");
    mainContent.classList.add("md:ml-16", "main-content-collapsed");
    mainContent.classList.remove("md:ml-64");

    // Ocultar textos
    sidebarTexts.forEach((text) => {
      text.classList.add("hidden");
    });

    // Centrar iconos principales (no los de submenú)
    document
      .querySelectorAll(".admin-sidebar-item > .admin-nav-item-icon")
      .forEach((icon) => {
        icon.classList.add("mx-auto");
        icon.classList.remove("mr-3");
      });

    // Centrar logo
    const logoContainer = sidebar.querySelector(".flex.items-center");
    if (logoContainer) {
      logoContainer.classList.add("justify-center");
      logoContainer.classList.remove("justify-between");
    }

    // Ocultar logo en colapsado
    const logoText = sidebar.querySelector(".sidebar-text");
    if (logoText) {
      logoText.classList.add("hidden");
    }

    // Ocultar botón de cerrar en móvil cuando está colapsado
    const closeButton = sidebar.querySelector('[data-drawer-hide="sidebar"]');
    if (closeButton) {
      closeButton.classList.add("hidden");
    }

    // Cerrar todos los submenús en modo colapsado
    document.querySelectorAll(".admin-submenu").forEach((menu) => {
      menu.classList.remove("admin-submenu-open");
      menu.closest(".admin-sidebar-group-item")?.classList.remove("active");
    });
  } else {
    // Sidebar expandido
    sidebar.classList.remove("w-16", "collapsed");
    sidebar.classList.add("w-64");
    mainContent.classList.remove("md:ml-16", "main-content-collapsed");
    mainContent.classList.add("md:ml-64");

    // Mostrar textos
    sidebarTexts.forEach((text) => {
      text.classList.remove("hidden");
    });

    // Restaurar iconos principales
    document
      .querySelectorAll(".admin-sidebar-item > .admin-nav-item-icon")
      .forEach((icon) => {
        icon.classList.remove("mx-auto");
        icon.classList.add("mr-3");
      });

    // Restaurar logo
    const logoContainer = sidebar.querySelector(".flex.items-center");
    if (logoContainer) {
      logoContainer.classList.remove("justify-center");
      logoContainer.classList.add("justify-between");
    }

    // Mostrar logo en expandido
    const logoText = sidebar.querySelector(".sidebar-text");
    if (logoText) {
      logoText.classList.remove("hidden");
    }

    // Mostrar botón de cerrar en móvil cuando está expandido
    const closeButton = sidebar.querySelector('[data-drawer-hide="sidebar"]');
    if (closeButton) {
      closeButton.classList.remove("hidden");
    }
  }
}

// Aplicar estado inicial
applySidebarState();

// Toggle del sidebar
document
  .getElementById("sidebar-toggle")
  ?.addEventListener("click", function () {
    sidebarCollapsed = !sidebarCollapsed;
    localStorage.setItem("sidebar-collapsed", sidebarCollapsed);
    applySidebarState();
  });

// Cerrar sidebar al hacer clic en el overlay
document
  .getElementById("sidebar-backdrop")
  ?.addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebar-backdrop");

    if (sidebar && backdrop) {
      sidebar.classList.add("-translate-x-full");
      backdrop.classList.add("hidden");
    }
  });

// Cerrar sidebar al hacer clic en enlaces (móvil)
document.querySelectorAll("#sidebar a").forEach((link) => {
  link.addEventListener("click", function () {
    if (window.innerWidth < 768) {
      const sidebar = document.getElementById("sidebar");
      const backdrop = document.getElementById("sidebar-backdrop");

      if (sidebar && backdrop) {
        sidebar.classList.add("-translate-x-full");
        backdrop.classList.add("hidden");
      }
    }
  });
});

// Detectar cambios de tamaño de ventana
window.addEventListener("resize", function () {
  if (window.innerWidth < 768) {
    // En móvil, asegurar que el sidebar esté expandido
    const sidebar = document.getElementById("sidebar");
    if (sidebar) {
      sidebar.classList.remove("w-16", "collapsed");
      sidebar.classList.add("w-64");
    }
  }
});

// Cerrar submenús al hacer clic fuera (solo en desktop)
document.addEventListener("click", function (event) {
  if (window.innerWidth >= 768 && !sidebarCollapsed) {
    const sidebar = event.target.closest("#sidebar");
    if (!sidebar) {
      document.querySelectorAll(".admin-submenu").forEach((menu) => {
        menu.classList.remove("admin-submenu-open");
        menu.closest(".admin-sidebar-group-item")?.classList.remove("active");
      });
    }
  }
});

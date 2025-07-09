// Función para aplicar el tema inmediatamente al cargar la página
function applyTheme() {
  const theme = localStorage.getItem("color-theme");
  const systemPrefersDark = window.matchMedia(
    "(prefers-color-scheme: dark)"
  ).matches;

  if (theme === "dark" || (!theme && systemPrefersDark)) {
    document.documentElement.classList.add("dark");
    return "dark";
  } else {
    document.documentElement.classList.remove("dark");
    return "light";
  }
}

// Función para actualizar los iconos del botón
function updateThemeIcons(currentTheme) {
  const darkIcon = document.getElementById("theme-toggle-dark-icon");
  const lightIcon = document.getElementById("theme-toggle-light-icon");

  if (!darkIcon || !lightIcon) return;

  if (currentTheme === "dark") {
    darkIcon.classList.add("hidden");
    lightIcon.classList.remove("hidden");
  } else {
    darkIcon.classList.remove("hidden");
    lightIcon.classList.add("hidden");
  }
}

// Aplicar tema inmediatamente
const currentTheme = applyTheme();

// Cuando el DOM esté listo, configurar los event listeners
document.addEventListener("DOMContentLoaded", function () {
  // Actualizar iconos basado en el tema actual
  updateThemeIcons(currentTheme);

  // Configurar el botón de toggle
  const themeToggleBtn = document.getElementById("theme-toggle");

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener("click", function () {
      const isDark = document.documentElement.classList.contains("dark");

      if (isDark) {
        // Cambiar a modo claro
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
        updateThemeIcons("light");
      } else {
        // Cambiar a modo oscuro
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
        updateThemeIcons("dark");
      }
    });
  }
});

// Escuchar cambios en las preferencias del sistema
window
  .matchMedia("(prefers-color-scheme: dark)")
  .addEventListener("change", function (e) {
    // Solo aplicar cambio del sistema si no hay preferencia guardada
    if (!localStorage.getItem("color-theme")) {
      const newTheme = applyTheme();
      updateThemeIcons(newTheme);
    }
  });

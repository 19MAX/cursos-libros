/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class", // Cambiar a 'class' para usar el modo oscuro basado en clases
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.html",
    "./public/**/*.js",
    "./node_modules/flowbite/**/*.js", // Agregar esta línea
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("flowbite/plugin"), // Agregar el plugin
  ],
};

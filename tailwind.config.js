/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./index.html",
      "./**/*.html",
      "./**/*.php"
    ],
    theme: {
      extend: {},
    },
    plugins: [],
    future: {
      hoverOnlyWhenSupported: true,
    },
    corePlugins: {
      preflight: true,
    }
  }
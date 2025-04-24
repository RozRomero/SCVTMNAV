import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/js/app.js', // El archivo JS que utilizarás
        'resources/css/app.css', // El archivo CSS donde usarás Tailwind
      ],
      refresh: true, // Permite recargar la página automáticamente
    }),
  ],
  server: {
    proxy: {
      '/app': 'http://localhost',
    },
  },
});
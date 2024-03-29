import vue from '@vitejs/plugin-vue';
import fs from "fs";
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/scss/app.scss', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: true,
    hmr: {
      host: 'localhost',
    },
    https: {
      key: fs.readFileSync("./certs/localhost-key.pem"),
      cert: fs.readFileSync("./certs/localhost.pem"),
    },
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources/js/'),
      '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
    },
  },
  build: {
    chunkSizeWarningLimit: 1000, // サイズの上限を1000 kBに設定
  },
});

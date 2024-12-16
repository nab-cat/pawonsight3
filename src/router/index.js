import { createRouter, createWebHistory } from 'vue-router';
import Home from '../App.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  // Tambahkan route lain di sini, tapi jangan override /admin
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
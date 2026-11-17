import { createRouter, createWebHistory } from 'vue-router';

// Vais precisar de criar estes ficheiros .vue depois na pasta resources/js/views/
const routes = [
    { path: '/', component: () => import('../views/Home.vue') },
    { path: '/jogo', component: () => import('../views/Board.vue') },
    { path: '/dashboard', component: () => import('../views/Dashboard.vue') }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
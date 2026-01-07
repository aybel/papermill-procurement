import { createRouter, createWebHistory } from 'vue-router';
import MainRoutes from './MainRoutes';
import AuthRoutes from './AuthRoutes';
import { useAuthStore } from '@/stores/authStore';

const PublicRoutes = {
    path: '/',
    component: () => import('@/layouts/blank/BlankLayout.vue'),
    meta: {
        requiresAuth: false
    },
    children: [
        {
            name: 'Landing',
            path: '',
            component: () => import('@/views/auth/Login.vue')
        }
    ]
};

export const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        PublicRoutes,
        MainRoutes,
        AuthRoutes,
        {
            path: '/:pathMatch(.*)*',
            component: () => import('@/views/pages/Error404.vue')
        }
    ]
});

router.beforeEach((to) => {
    const authStore = useAuthStore();

    // Si ya está logeado y visita la landing pública, mandarlo al dashboard.
    if (to.path === '/' && authStore.isAuthenticated) {
        return '/home';
    }

    // Si la ruta requiere auth y no hay sesión, mandarlo a la landing.
    if (to.meta?.requiresAuth && !authStore.isAuthenticated) {
        return '/';
    }

    return true;
});


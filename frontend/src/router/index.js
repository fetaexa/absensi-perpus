import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/components/Login.vue'
import Home from '@/components/Home.vue'
import Main from '@/components/Main.vue'
import History from '@/components/History.vue'
import Profile from '@/components/Profile.vue'
import AttendanceSuccess from '@/components/AttendanceSuccess.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/',
            component: Main,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    redirect: { name: 'login' }
                },
                {
                    path: 'home',
                    name: 'home',
                    component: Home
                },
                {
                    path: 'history',
                    name: 'history',
                    component: History
                },
                {
                    path: 'profile',
                    name: 'profile',
                    component: Profile
                },
                {
                    path: 'absent-success',
                    name: 'absent-success',
                    component: AttendanceSuccess
                }
            ]
        }
    ],
})

router.beforeEach((to) => {
    const isAuthenticated = Boolean(localStorage.getItem('authToken'))

    if (to.meta.requiresAuth && !isAuthenticated) {
        return { name: 'login' }
    }

    if (to.name === 'login' && isAuthenticated) {
        return { name: 'home' }
    }
})

export default router
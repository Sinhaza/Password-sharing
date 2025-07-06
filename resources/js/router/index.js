import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Password from '../components/Password.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/password/:uuid', component: Password },
    { path: '/:pathMatch(.*)*', redirect: '/' }
  ]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
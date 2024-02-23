import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'homepage',
        meta: {
            pageTitle: 'Entity List',
        },
        component: () => import('../views/entity/EntityList.vue'),
    },
    {
        path: '/entity/details/:id',
        name: 'entity-details',
        meta: {
            pageTitle: 'Entity details',
        },
        component: () => import('../views/entity/EntityDetails.vue'),
    },
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
});

export default router;

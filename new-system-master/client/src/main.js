/* eslint-disable no-console */
import Vue from 'vue';
// import keycloak from 'keycloak-js';
// import axios from 'axios';
import RouteTitlePlugin from '@glance-project/fence-vue/src/plugins/route-title-plugin';
// import KeycloakPlugin from '@glance-project/fence-vue/src/plugins/keycloak-plugin';
import * as Sentry from '@sentry/vue';
import App from './App.vue';
import router from './router';
import store from './store';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import vuetify from './plugins/vuetify';

const vue = new Vue({
    router,
    store,
    vuetify,
    render: h => h(App),
}).$mount('#app');

vue.use(
    RouteTitlePlugin,
    {
        router,
        appName: 'New System',
    },
);

Sentry.init({
    vue,
    dsn: process.env.VUE_APP_SENTRY_DNS,
    environment: process.env.VUE_APP_ENVIRONMENT,
    logErrors: true,
});

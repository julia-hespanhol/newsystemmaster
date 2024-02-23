import Vue from 'vue';
import Vuex from 'vuex';
import exception from '@glance-project/fence-vue/src/store/modules/exception.module';
import entity from './modules/entity';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
    },
    mutations: {
    },
    actions: {
    },
    modules: {
        exception,
        entity,
    },
});

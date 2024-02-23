import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#055399',
                secondary: '#0288d1',
                successDisabled: '#BAE6BB',
            },
        },
    },
});

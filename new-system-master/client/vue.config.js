const path = require('path');

module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                /* Use vuetify from the app, not from fence-vue */
                vuetify: path.resolve(__dirname, 'node_modules/vuetify'),
            },
        },
    },
    publicPath: process.env.BASE_URL,
    devServer: {
        host: 'localhost',
    },
};

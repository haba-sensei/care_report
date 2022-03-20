const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .copyDirectory("resources/fonts", "public/fonts")
    .vue();
mix.webpackConfig(require('./webpack.config'));
mix.version();
mix.disableNotifications();

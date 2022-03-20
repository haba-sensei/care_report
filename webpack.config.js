const path = require('path');
const webpack = require('webpack');
module.exports = {
    mode: "development",
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
    module: {
        rules: [
            {
                test: /\.(scss)$/,
                use: [
                    {
                        // inject CSS to page
                        loader: "style-loader",
                    },
                    {
                        // translates CSS into CommonJS modules
                        loader: "css-loader",
                    },
                    {
                        // Run postcss actions
                        loader: "postcss-loader",
                        options: {
                            // `postcssOptions` is needed for postcss 8.x;
                            // if you use postcss 7.x skip the key
                            postcssOptions: {
                                // postcss plugins, can be exported to postcss.config.js
                                plugins: function () {
                                    return [require("autoprefixer")];
                                },
                            },
                        },
                    },
                    {
                        // compiles Sass to CSS
                        loader: "sass-loader",
                    },
                ],
            },
            {
                test: /\.(png|jpg|gif|jpeg)$/,
                use: [
                    {
                        loader: "url-loader",
                        options: {
                            name: "[name].[ext]",
                            esModule: false,
                            limit: 8192,
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
        }),
        new webpack.DefinePlugin({
            "process.env": {
                NODE_ENV: JSON.stringify("development"),
            },
        }),
    ],
};

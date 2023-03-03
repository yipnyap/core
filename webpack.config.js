const webpack = require('webpack');
const path = require('path');

// For our css modules these will be locally scoped
const CSSModuleLoader = {
    loader: 'css-loader',
    options: {
        modules: {
            auto: true,
            localIdentName: '[name]_[local]_[hash:base64:5]',
            exportLocalsConvention: 'camelCase',
        },
        importLoaders: 2,
        sourceMap: false, // turned off as causes delay
    }
}
// For our normal CSS files we would like them globally scoped
const CSSLoader = {
    loader: 'css-loader',
    options: {
        modules: {
            auto: 'global',
            exportLocalsConvention: 'camelCase',
        },
        importLoaders: 2,
        sourceMap: false, // turned off as causes delay
    }
}
// Our PostCSSLoader
const autoprefixer = require('autoprefixer');
const PostCSSLoader = {
    loader: 'postcss-loader',
    options: {
        sourceMap: false, // turned off as causes delay
        postcssOptions: {
            ident: 'postcss',
            plugins: () => [
                autoprefixer({
                    browsers: ['>1%', 'last 4 versions', 'Firefox ESR', 'not ie < 9']
                })
            ]
        }
    }
}
// Standard style loader (prod and dev covered here)
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const devMode = process.env.NODE_ENV !== 'production';
const styleLoader = devMode ? 'style-loader' : MiniCssExtractPlugin.loader;

module.exports = {
    entry: './src/js/source/app.tsx',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'bundle.js',
    },
    devServer: {
        static: {
            directory: path.join(__dirname, 'dist'),
        },
        open: false,
        hot: true,
        allowedHosts: "all",
        port: 9000,
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization'
        }
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.ProgressPlugin({profile: false}),
    ],
    mode: 'development',
    module: {
        rules: [
            {
                test: /\.(jsx|js|tsx|ts)$/,
                include: path.resolve(__dirname, 'src'),
                exclude: /node_modules/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', {
                                "targets": "defaults"
                            }],
                            '@babel/preset-typescript',
                            ['@babel/preset-react', {runtime: 'automatic'}],
                        ],
                        plugins: [
                            '@babel/plugin-transform-runtime',
                            [
                                'module-resolver',
                                {
                                    'root': [
                                        './src'
                                    ],
                                    'alias': {
                                        '@nextgen2': './src/nextgen2',
                                        '@legacy': './src/js/source'
                                    }
                                }
                            ]
                        ]
                    }
                }]
            },
            {
                test: /\.(sa|sc|c)ss$/,
                exclude: /\.module\.(sa|sc|c)ss$/,
                use: [styleLoader, CSSLoader, PostCSSLoader, "sass-loader"]
            },
            {
                test: /\.module\.(sa|sc|c)ss$/,
                use: [styleLoader, CSSModuleLoader, PostCSSLoader, "sass-loader"]
            }
        ]
    },
    resolve: {
        extensions: ['', '.js', '.jsx', '.ts', '.tsx', '.css'],
    }
};
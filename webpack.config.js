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
        url: false,
        importLoaders: 2,
        sourceMap: false, // turned off as causes delay
    },
}
// For our normal CSS files we would like them globally scoped
const CSSLoader = {
    loader: 'css-loader',
    options: {
        modules: {
            mode: 'global',
            exportLocalsConvention: 'camelCase',
        },
        url: false,
        importLoaders: 2,
        sourceMap: false, // turned off as causes delay
    },
}
// Our PostCSSLoader
const autoprefixer = require('autoprefixer');
const tailwindcss = require('tailwindcss');
const PostCSSLoader = {
    loader: 'postcss-loader',
    options: {
        sourceMap: false, // turned off as causes delay
        postcssOptions: {
            ident: 'postcss',
            plugins: [autoprefixer(), tailwindcss('./tailwind.config.js')],
        },
    },
}

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const styleLoader = MiniCssExtractPlugin.loader;

module.exports = {
    entry: './src/js/source/app.tsx',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].js',
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendor',
                    chunks: 'all',
                },
                legacy: {
                    // src/js/source is where we put our legacy code
                    test: /[\\/]src[\\/]js[\\/]source[\\/]/,
                    name: 'legacy',
                    chunks: 'all',
                    priority: -10,
                },
            },
        },
    },
    watchOptions: {
        ignored: [
            '**/node_modules/**',
        ],
        aggregateTimeout: 200,
        poll: 1000,
    },
    devServer: {
        host: '0.0.0.0',
        client: {
            overlay: {
                warnings: false,
                errors: true,
            },
        },
        static: {
            directory: path.join(__dirname, 'dist'),
        },
        open: false,
        allowedHosts: 'all',
        port: 9080,
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization',
        },
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.ProgressPlugin({percentBy: 'entries'}),
        new MiniCssExtractPlugin(),
    ],
    mode: 'development',
    module: {
        rules: [{
            test: /\.(jsx|js|tsx|ts)$/,
            include: path.resolve(__dirname, 'src'),
            exclude: /node_modules/,
            use: [{
                loader: 'babel-loader',
                options: {
                    presets: [
                        ['@babel/preset-env',
                            {
                                'targets': 'defaults',
                            },
                        ],
                        '@babel/preset-typescript',
                        ['@babel/preset-react',
                            {
                                runtime: 'automatic',
                            },
                        ]],
                    plugins: [
                        '@babel/plugin-transform-runtime',
                        ['module-resolver', {
                            'root': ['./src'],
                            'alias': {
                                '@nextgen2': './src/nextgen2',
                                '@legacy': './src/js/source',
                            },
                        },
                        ],
                    ],
                },
            }],
        }, {
            include: path.resolve(__dirname, 'src'),
            test: /\.(sa|sc|c)ss$/,
            exclude: /\.module\.(sa|sc|c)ss$/,
            use: [styleLoader, CSSLoader, PostCSSLoader, 'sass-loader'],
        }, {
            include: path.resolve(__dirname, 'src'),
            test: /\.module\.(sa|sc|c)ss$/,
            use: [styleLoader, CSSModuleLoader, PostCSSLoader, 'sass-loader'],
        }],
    },
    resolve: {
        extensions: ['', '.js', '.jsx', '.ts', '.tsx', '.scss', '.sass'],
    },
};
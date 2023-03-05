module.exports = function (grunt) {

    const sass = require('sass');
    const cssnano = require('cssnano');
    const browserifyCSS = require('browserify-css');

    grunt.initConfig({
        sass: {
            options: {
                implementation: sass,
                sourceMap: true
            },
            build: {
                options: {
                    outputStyle: 'expanded'
                },
                files: {
                    'src/css/raw/styles.css': 'src/sass/main.scss',
                    'src/css/admin-style.css': 'src/sass/wordpress/main.scss',
                    // 'src/css/vklogin-style.css': 'src/sass/wordpress-login/main.scss'
                }
            }
        },
        postcss: {
            autoprefix: {
                options: {
                    processors: [
                        require('autoprefixer')({ overrideBrowserslist: 'last 3 versions' }),
                    ],
                    map: {
                        inline: false
                    }
                },
                files: {
                    'src/css/raw/styles.css': 'src/css/raw/styles.css',
                    'src/css/admin-style.css': 'src/css/admin-style.css',
                    // 'src/css/vklogin-style.css': 'src/css/vklogin-style.css'
                }
            },
            compressed: {
                options: {
                    processors: [
                        cssnano()
                    ],
                    map: {
                        inline: false,
                        annotation: 'src/css/'
                    }
                },
                files: {
                    'src/css/admin-style.min.css': 'src/css/admin-style.css',
                    // 'src/css/vklogin-style.min.css': 'src/css/vklogin-style.css'
                }
            }
        },
        browserify: {
            main: {
                src: 'src/js/source/app.tsx',
                dest: 'src/js/bundle/bundle.js',
            },
            options: {
                // watch: process.env.GRUNT_WATCH === 'true',
                // keepAlive: process.env.GRUNT_WATCH === 'true',
                sourceMap: false,
                configure: function (bundler) {
                    bundler.plugin(require('tsify'));
                    bundler.transform(require('babelify'), {
                        presets: [
                            '@babel/preset-typescript',
                            [
                                '@babel/env'
                            ],
                            ['@babel/preset-react', {runtime: 'automatic'}],
                        ],
                        plugins: [
                            "@babel/plugin-transform-runtime",
                            [
                                "module-resolver",
                                {
                                    "root": [
                                        "./src"
                                    ],
                                    "alias": {
                                        "@nextgen2": "./src/nextgen2",
                                        "@legacy": "./src/js/source"
                                    }
                                }
                            ]
                        ],
                        extensions: ['.js', '.ts', '.tsx'],
                        compact: true,
                        global: true,
                        ignore: [/\/node_modules\/(?!src\/)/]
                    });
                    bundler.transform(browserifyCSS);
                },
            }
        },
        watch: {
            options: {
                livereload: true,
            },
            js: {
                files: ['src/nextgen2/**/*.ts', 'src/nextgen2/**/*.tsx', 'src/js/source/**/*.js', 'src/js/source/**/*.jsx'],
                tasks: ['browserify'],
            },
        },
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register global tasks
    grunt.registerTask('default', ['styles', 'scripts', 'watch']);

    // Register custom tasks
    grunt.registerTask('styles', ['sass:build', 'postcss:autoprefix']);
    grunt.registerTask('scripts', ['browserify', /*'uglify:*/]);
};

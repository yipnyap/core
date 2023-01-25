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
                watch: process.env.GRUNT_WATCH === true,
                keepAlive: process.env.GRUNT_WATCH === true,
                sourceMap: false,
                browserifyOptions: {
                    debug: true
                },
                configure: function (bundler) {
                    bundler.plugin(require('tsify'));
                    bundler.transform(require('babelify'), {
                        presets: [
                            '@babel/preset-typescript',
                            [
                                '@babel/env',
                                {
                                    debug: true
                                }
                            ],
                            ['@babel/preset-react', {runtime: 'automatic'}],
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
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register global tasks
    grunt.registerTask('default', ['styles', 'scripts']);

    // Register custom tasks
    grunt.registerTask('styles', ['sass:build', 'postcss:autoprefix']);
    grunt.registerTask('scripts', ['browserify', /*'uglify:*/]);
};

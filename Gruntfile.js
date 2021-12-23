module.exports = function (grunt) {

    const sass = require('node-sass'),
        cssnano = require('cssnano');

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
                    'style.css': 'src/sass/main.scss',
                    'src/css/admin-style.css': 'src/sass/wordpress/main.scss',
                    'src/css/vklogin-style.css': 'src/sass/wordpress-login/main.scss'
                }
            }
        },
        postcss: {
            autoprefix: {
                options: {
                    processors: [
                        require('autoprefixer')()
                    ],
                    map: {
                        inline: false
                    }
                },
                files: {
                    'style.css': 'style.css',
                    'src/css/admin-style.css': 'src/css/admin-style.css',
                    'src/css/vklogin-style.css': 'src/css/vklogin-style.css'
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
                    'src/css/vklogin-style.min.css': 'src/css/vklogin-style.css'
                }
            }
        },
        browserify: {
            options: {
                browserifyOptions: {
                    extensions: ['.jsx', '.js']
                },
                transform: [
                    [
                        'babelify',
                        {
                            presets: ['@babel/env', '@babel/preset-react'],
                            compact: true
                        }
                    ]
                ]
            },
            build: {
                files: {
                    'src/js/bundle/app.bundle.js': 'src/js/source/app.js',
                    'src/js/bundle/admin.bundle.js': 'src/js/source/admin.js',
                    'src/js/bundle/vklogin.bundle.js': 'src/js/source/vklogin.js'
                }
            }
        },
        uglify: {
            build: {
                files: {
                    'src/js/vklogin.bundle.min.js': 'src/js/bundle/vklogin.bundle.js'
                }
            }
        },
        watch: {
            options: {
                livereload: true
            },
            php: {
                files: ['*.php', '**/*.php']
            },
            sass: {
                files: ['src/sass/**'],
                tasks: ['styles']
            },
            js: {
                files: ['src/js/**/*.js', '!src/js/bundle/**', '!src/js/vendor/*.min.js', '!src/js/*.min.js'],
                tasks: ['scripts']
            },
            jsx: {
                files: ['src/js/**/*.jsx'],
                tasks: ['scripts']
            }
        }
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register global tasks
    grunt.registerTask('default', ['styles', 'scripts', 'launch']);

    // Register custom tasks
    grunt.registerTask('styles', ['sass:build', 'postcss:autoprefix']);
    grunt.registerTask('scripts', ['browserify:build', 'uglify:build']);
    grunt.registerTask('launch', ['watch']);
};
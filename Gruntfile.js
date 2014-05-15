/*global module:false*/
module.exports = function (grunt) {

    //Initializing the configuration object
    grunt.initConfig({

        // Task configuration

        copy: {
            vendor: {
                files: [
                    // Mustache.js
                    {
                        expand: true,
                        flatten: true,
                        cwd: 'vendor_src/mustache/',
                        src: [
                            'mustache.js'
                        ],
                        dest: 'www/js/vendor/'
                    },

                    // jQuery
                    {
                        expand: true,
                        flatten: true,
                        cwd: 'vendor_src/jquery/dist/',
                        src: [
                            '**'
                        ],
                        dest: 'www/js/vendor/'
                    },

                    // Modernizr
                    {
                        expand: true,
                        flatten: true,
                        cwd: 'vendor_src/modernizr/',
                        src: [
                            'modernizr.js'
                        ],
                        dest: 'www/js/vendor/'
                    },

                    // Moment
                    {
                        expand: true,
                        flatten: true,
                        cwd: 'vendor_src/moment/min/',
                        src: [
                            'moment-with-langs.js'
                        ],
                        dest: 'www/js/vendor/'
                    },

                    // Normalize
                    {
                        expand: true,
                        flatten: true,
                        cwd: 'vendor_src/normalize.css/',
                        src: [
                            'normalize.css'
                        ],
                        dest: 'www/css/vendor/'
                    }
                ]
            }
        },

        less: {
            development: {
                options: {
                    compress: false  //minifying the result
                },
                files  : {
                    //compiling frontend.less into frontend.css
                    "www/css/main.comb.css": "www/css/src/main.less"
                }
            },
            production : {
                options: {
                    compress: true  //minifying the result
                },
                files  : {
                    //compiling frontend.less into frontend.css
                    "www/css/main.min.css": "www/css/main.comb.css"
                }
            }
        },

        imagemin: {
            jpeg: {
                options: {
                    progressive: true
                },
                files  : [
                    {
                        expand: true,               // Enable dynamic expansion
                        cwd   : 'www/img/src/',     // Src matches are relative to this path
                        src   : ['*.jpg', '*.jpeg'],       // Actual patterns to match
                        dest  : 'www/img/'          // Destination path prefix
                    }
                ]
            },
            png : {
                files: [
                    {
                        expand: true,               // Enable dynamic expansion
                        cwd   : 'www/img/src/',     // Src matches are relative to this path
                        src   : ['*.png'],       // Actual patterns to match
                        dest  : 'www/img/'          // Destination path prefix
                    }
                ]
            }
        },

        jshint: {
            all    : {
                src: [
                    'Gruntfile.js',
                    'www/js/src/*.js'
                ]
            },
            options: {
                curly  : true,
                eqeqeq : true,
                immed  : true,
                latedef: true,
                newcap : true,
                noarg  : true,
                sub    : true,
                undef  : true,
                boss   : true,
                eqnull : true,
                browser: true,
                globals: {
                    "$"       : false,
                    "jQuery"  : false,
                    "Mustache": false,
                    "GLOBALS" : false,
                    "google"  : false,
                    "moment"  : false
                }
            }
        },

        concat: {
            options: {
                separator: ';\n\n'
            },
            beer   : {
                src : [
                    'www/js/src/beer.js'
                ],
                dest: 'www/js/beer.comb.js'
            },
            vendor : {
                src : [
                    'www/js/vendor/mustache.js',
                    'www/js/vendor/moment-with-langs.js'
                ],
                dest: 'www/js/vendor.comb.js'
            }
        },

        // Javascript Minification
        uglify: {
            options: {
                mangle          : true,
                preserveComments: 'some'
            },
            beer    : {
                files: {
                    'www/js/beer.min.js': ['www/js/beer.comb.js']
                }
            },
            vendor : {
                files: {
                    'www/js/vendor.min.js': ['www/js/vendor.comb.js']
                }
            }
        },

        watch: {
            less     : {
                files  : ['www/css/src/*.less', 'www/css/vendor/*.css', 'www/css/vendor/*.less'],
                tasks  : ['less'],
                options: {
                    livereload: 31337
                }
            },
            copy     : {
                files  : [
                    'vendor_src/mustache/mustache.js',
                    'vendor_src/dist/jquery/**',
                    'vendor_src/modernizr/modernizr.js'
                ],
                tasks  : ['copy'],
                options: {
                    livereload: false
                }
            },
            js       : {
                files  : ['<%= concat.beer.src %>'],
                tasks  : ['jshint', 'concat:beer', 'uglify:beer'],
                options: {
                    livereload: 31337
                }
            },
            vendor_js: {
                files  : ['<%= concat.vendor.src %>'],
                tasks  : ['concat:vendor', 'uglify:vendor'],
                options: {
                    livereload: 31337
                }
            },
            imagemin : {
                files  : ['www/img/src/**/*'],
                tasks  : ['imagemin'],
                options: {
                    livereload: 31337
                }
            },
            grunt    : {
                files  : ['Gruntfile.js'],
                options: {
                    livereload: 31337
                }
            }

        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');

    // Task definition
    grunt.registerTask('default', ['jshint', 'copy', 'concat', 'uglify', 'less', 'imagemin', 'watch']);
};
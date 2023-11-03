'use strict';

var gulp = require('gulp'),
    $ = require('gulp-load-plugins')(),
    browserSync = require('browser-sync').create();

var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

var host = 'http://starter3.tools/app_dev.php/'; // modification de l'URL virtualhost

var paths = {
    sass: [
        './scss/*.scss',
        './scss/partials/*.scss',
        './scss/partials/**/*.scss'
    ],
    css: '../assets/css',
    cssMin: '../assets/css/min',
    scripts: [
        './js/*.js',
        './js/**/*.js',
        ],
    scriptsMin: '../assets/js/min',
    scriptsNormal: '../assets/js/',
    php: [
        '../../src/**/*.php',
    ],
    twig: [
        '../../src/**/*.twig',
        '../../app/**/*.twig'
    ]
};

gulp.task('sass', function () {
    return gulp.src(paths.sass)
        .pipe($.sass().on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: ['> 1%', 'last 2 versions', 'ie 8', 'ie 9']
        }))
        .pipe(gulp.dest(paths.css))
        .pipe($.cleanCss({
            keepSpecialComments: 0
        }))
        .pipe($.rename({extname: '.min.css'}))
        .pipe(gulp.dest(paths.cssMin))
        .pipe(browserSync.stream());
});

gulp.task('scripts', function() {
    return gulp.src(paths.scripts)
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(paths.scriptsNormal))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.scriptsMin))
        .pipe(browserSync.stream());
});


gulp.task('default', ['sass', 'scripts'], function () {
    browserSync.init({
        proxy: host
    });

    var notifyFileChanged = function (event) {
        console.log('File ' + event.type + ' : ' + event.path);
    };

    gulp.watch(paths.sass, ['sass']).on('change', notifyFileChanged);
    gulp.watch(paths.scripts, ['scripts']).on('change', notifyFileChanged);

    gulp.watch([paths.scripts, paths.php, paths.twig]).on('change', function (event) {
        notifyFileChanged(event);
        browserSync.reload();
    });

});
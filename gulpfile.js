var elixir = require('laravel-elixir');
var gulp = require('gulp');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


gulp.task('default', function(){
  gulp.src('./resources/assets/js/**/*.js')
    .pipe(plumber({errorHandler: notify.onError('<%= error.message %>')}))
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('./public/js/'));
  gulp.src('./resources/assets/sass/*.scss')
    .pipe(plumber({errorHandler: notify.onError('<%= error.message %>')}))
    .pipe(sass())
    .pipe(cssmin())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('./public/css/'));
});
gulp.task("watch", function() {
  var targets = [
    './resources/assets/sass/*.scss',
    './resources/assets/js/**/*.js',
  ];
  gulp.watch(targets, ['default']);
});

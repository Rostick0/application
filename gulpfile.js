const { src, dest, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const csso = require('gulp-csso');
const autoprefixer = require('gulp-autoprefixer');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const { watch, reload } = require('browser-sync').create();

function scss() {
    return src('gulp/scss/style.scss')
        .pipe(sass())
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(csso())
        .pipe(dest('view/static/css'))
}

function js() {
    return src(['gulp/js/vars.js', 'gulp/js/functions.js', 'gulp/js/UI.js', 'gulp/js/create.js', 'gulp/js/inn.js'])
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(uglify())
        .pipe(concat('all.js'))
        .pipe(dest('view/static/js'))
}

function serve() {
    watch('gulp/scss/**', series(scss)).on('change', reload);
    watch('gulp/js/**', series(js)).on('change', reload);
}

exports.serve = series(scss, js, serve);
const gulp = require('gulp')
const dartSass = require('sass')
const gulpSass = require('gulp-sass')
const sass = gulpSass(dartSass)
const concat = require('gulp-concat')
const uglifyCss = require('gulp-uglifycss')
const babel =require('gulp-babel')
const uglify = require('gulp-uglify')

function buildCss() {
    return gulp.src(['./assets/css/fontello.css', './styles/sass/site/index.scss'])
        .pipe(sass())
        .pipe(concat('site.min.css'))
        .pipe(uglifyCss({ uglyComments: false }))
        .pipe(gulp.dest('./assets/css/'))
}

function buildAdminCss() {
    return gulp.src(['./assets/css/fontello.css', './styles/sass/admin/index.scss'])
        .pipe(sass())
        .pipe(concat('admin.min.css'))
        .pipe(uglifyCss({ uglyComments: false }))
        .pipe(gulp.dest('./assets/css/'))
}

function buildJs() {
    return gulp.src('./js/**/*.js')
        .pipe(babel({
            comments: false,
        }))
        .pipe(uglify())
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('./assets/js/'))
}

gulp.task('buildCss', buildCss)
gulp.task('buildAdminCss', buildAdminCss);
gulp.task('buildJs', buildJs)

function toMonitor() {
    gulp.watch(['./styles/sass/**/*.scss'], function(cb){ 
        gulp.series('buildCss','buildAdminCss', 'buildJs')()
        cb()
    })
}

module.exports.default = gulp.series(buildCss, buildAdminCss, buildJs, toMonitor)
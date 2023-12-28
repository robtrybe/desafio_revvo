const gulp = require('gulp')
const dartSass = require('sass')
const gulpSass = require('gulp-sass')
const sass = gulpSass(dartSass)
const concat = require('gulp-concat')
const uglifyCss = require('gulp-uglifycss')

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

gulp.task('buildCss', buildCss)
gulp.task('buildAdminCss', buildAdminCss);

function toMonitor() {
    gulp.watch('./styles/sass/**/*.scss', function(cb){ 
        gulp.series('buildCss', 'buildAdminCss')()
        cb()
    })
}

module.exports.default = gulp.series(buildCss, buildAdminCss, toMonitor)
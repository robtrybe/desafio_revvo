const gulp = require('gulp')
const dartSass = require('sass')
const gulpSass = require('gulp-sass')
const sass = gulpSass(dartSass)
const concat = require('gulp-concat')
const uglifyCss = require('gulp-uglifycss')

function buildCss() {
    return gulp.src('./assets/sass/index.scss')
        .pipe(sass())
        .pipe(concat('style.min.css'))
        .pipe(uglifyCss({ uglyComments: true }))
        .pipe(gulp.dest('./public/assets/css/'))
}

gulp.task('buildCss', buildCss)

function toMonitor(cb) {
    gulp.watch('./assets/sass', function(){ gulp.series('buildCss')()})
    cb()
}

module.exports.default = gulp.series(buildCss, toMonitor)
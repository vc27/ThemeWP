var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');
var del = require('del');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();

var paths = {
    scripts: [
        'node_modules/fitvids/dist/fitvids.js',
        'js/childTheme.js'
    ],
    scss: './scss/style.scss',
    scssWatch: './scss/*.scss'
};

gulp.task('clean', function() {
    return del(['build']);
});

gulp.task('scripts', ['clean'], function() {
    return gulp.src(paths.scripts)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('siteScripts.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('js'));
});

gulp.task('scss', function () {
    return gulp.src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(sourcemaps.write('./css'))
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.stream());
});

gulp.task('watch', function() {
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.scssWatch, ['scss']);
});

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "themewp.test"
    });
});

gulp.task('default', ['watch', 'scripts', 'scss', 'browser-sync']);

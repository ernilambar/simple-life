// Env.
require('dotenv').config();

// Config.
var rootPath = './';

// Gulp.
var gulp = require('gulp');

// Browser sync.
var browserSync = require('browser-sync').create();

// Rename.
var rename = require('gulp-rename');

// Uglify.
var uglify = require('gulp-uglify');

gulp.task('scripts', function() {
    return gulp.src( [rootPath + 'scripts/*.js'] )
			.pipe(gulp.dest('js'))
			.pipe(rename({suffix: '.min'}))
			.pipe(uglify())
			.pipe(gulp.dest('js'))
});

gulp.task('watch', function() {
    browserSync.init({
			proxy: process.env.DEV_SERVER_URL,
			open: true
    });

    // Watch CSS files.
    gulp.watch(rootPath + 'style.css').on('change',browserSync.reload);

    // Watch PHP files.
    gulp.watch(rootPath + '**/**/*.php').on('change',browserSync.reload);

    // Watch JS files.
    gulp.watch(rootPath + 'scripts/*.js', gulp.series('scripts') ).on('change',browserSync.reload);
});

// Tasks.
gulp.task('default', gulp.series('watch'));

gulp.task('build', gulp.series('scripts'));

// Env.
require('dotenv').config();

// Config.
var rootPath = './';

// Gulp.
var gulp = require('gulp');

// Zip.
var zip = require('gulp-zip');

// File system.
var fs = require('fs');

// Package.
var pkg = JSON.parse(fs.readFileSync('./package.json'));

// Delete.
var del = require('del');

// Browser sync.
var browserSync = require('browser-sync').create();

// Plumber.
var plumber = require('gulp-plumber');

// Rename.
var rename = require('gulp-rename');

// Jshint.
var jshint = require('gulp-jshint');

// Uglify.
var uglify = require('gulp-uglify');

// Deploy files list.
var deploy_files_list = [
	'**/*',
	'!composer.json',
	'!composer.lock',
	'!gulpfile.js',
	'!Gruntfile.js',
	'!package.json',
	'!package-lock.json',
	'!**/node_modules/**',
	'!**/deploy/**',
	'!**/scripts/**'
];

// Error Handling.
var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

gulp.task('scripts', function() {
    return gulp.src( [rootPath + 'scripts/*.js'] )
	    .pipe(jshint())
	    .pipe(jshint.reporter('default'))
	    .pipe(jshint.reporter('fail'))
			.pipe(plumber())
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

// Clean deploy folder.
gulp.task('clean:deploy', function() {
	return del('deploy')
});

// Copy to deploy folder.
gulp.task('copy:deploy', function() {
	return gulp.src(deploy_files_list, { base: '.' })
			.pipe(gulp.dest('deploy/' + pkg.name))
			.pipe(zip(pkg.name + '.zip'))
			.pipe(gulp.dest('deploy'))
});

// Tasks.
gulp.task('default', gulp.series('watch'));

gulp.task('build', gulp.series('scripts'));

gulp.task('deploy', gulp.series('clean:deploy', 'copy:deploy'));

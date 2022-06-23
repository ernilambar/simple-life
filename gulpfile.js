// Env.
require('dotenv').config();

// Config.
var rootPath = './';

// Gulp Nodes.
var gulp        = require( 'gulp' ),
    gulpPlugins = require( 'gulp-load-plugins' )();

var fs = require('fs');

var pkg = JSON.parse(fs.readFileSync('./package.json'));

// Browser sync.
const browserSync = require('browser-sync').create();

var del = require('del');

// Error Handling.
var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

gulp.task('scripts', function() {
    const { plumber, rename, uglify, jshint } = gulpPlugins;
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

gulp.task( 'watch', function() {
    browserSync.init({
        proxy: process.env.DEV_SERVER_URL,
        open: true
    });

    // Watch CSS files.
    gulp.watch( rootPath + 'style.css' ).on('change',browserSync.reload);

    // Watch PHP files.
    gulp.watch( rootPath + '**/**/*.php' ).on('change',browserSync.reload);

    // Watch JS files.
    gulp.watch( rootPath + 'scripts/*.js', gulp.series( 'scripts' ) ).on('change',browserSync.reload);
});

gulp.task('clean:deploy', function() {
    return del('deploy')
});

gulp.task('copy:deploy', function() {
	const { zip } = gulpPlugins;
	var sourceFiles = [
		'**/*',
		'!gulpfile.js',
		'!package.json',
		'!package-lock.json',
		'!**/node_modules/**',
		'!**/deploy/**',
		'!**/scripts/**'
	];

	return gulp.src(sourceFiles)
	    .pipe(gulp.dest('deploy/' + pkg.name))
	    .pipe(zip(pkg.name + '.zip'))
	    .pipe(gulp.dest('deploy'))
});

// Tasks.
gulp.task( 'default', gulp.series('watch'));

gulp.task( 'build', gulp.series('scripts'));

gulp.task( 'deploy', gulp.series('clean:deploy', 'copy:deploy'));

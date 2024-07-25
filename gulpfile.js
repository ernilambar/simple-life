require( 'dotenv' ).config();

var rootPath = './';
var gulp = require( 'gulp' );
var browserSync = require( 'browser-sync' ).create();
var rename = require( 'gulp-rename' );
var uglify = require( 'gulp-uglify' );

gulp.task( 'scripts', function() {
	return gulp.src( [ rootPath + 'scripts/*.js' ] )
		.pipe( gulp.dest( 'js' ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( uglify() )
		.pipe( gulp.dest( 'js' ) );
} );

gulp.task( 'watch', function() {
	browserSync.init( {
		proxy: process.env.DEV_SERVER_URL,
		open: false,
	} );

	gulp.watch( rootPath + 'style.css' ).on( 'change', browserSync.reload );
	gulp.watch( rootPath + '**/**/*.php' ).on( 'change', browserSync.reload );
	gulp.watch( rootPath + 'scripts/*.js', gulp.series( 'scripts' ) ).on( 'change', browserSync.reload );
} );

// Tasks.
gulp.task( 'default', gulp.series( 'watch' ) );
gulp.task( 'build', gulp.series( 'scripts' ) );

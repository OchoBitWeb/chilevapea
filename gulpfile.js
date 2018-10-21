var gulp = require('gulp');

gulp.task('default', function() {	 
	console.log('Use the following commands');
	console.log('--------------------------');
	console.log('gulp compile-css    to compile the custom.scss to custom.css');
	console.log('gulp compile-js     to compile the custom.js to custom.min.js');
	console.log('gulp watch          to continue watching the files for changes.');
	console.log('gulp wordpress-lang to compile the db-lsx-child-theme.pot, en_EN.po and en_EN.mo');
});

var sass = require('gulp-sass');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sort = require('gulp-sort');
var wppot = require('gulp-wp-pot');
var gettext = require('gulp-gettext');

gulp.task('sass', function() {
	gulp.src('assets/css/custom.scss')
		.pipe(sass())
		.pipe(gulp.dest('assets/css'));
});

gulp.task('js', function() {
	gulp.src('assets/js/custom.js')
		.pipe(jshint())
		.pipe(jshint.reporter('fail'))
		.pipe(concat('custom.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/js'));
});
 
gulp.task('compile-css', ['sass']);
gulp.task('compile-js', ['js']);

gulp.task('watch', function() {	 
	gulp.watch('assets/css/custom.scss', ['sass']);
	gulp.watch('assets/js/custom.js', ['js']);
});

gulp.task('wordpress-pot', function() {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'db-lsx-child-theme',
			package: 'db-lsx-child-theme',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/db-lsx-child-theme.pot'));
});

gulp.task('wordpress-po', function() {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'db-lsx-child-theme',
			package: 'db-lsx-child-theme',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/en_EN.po'));
});

gulp.task('wordpress-po-mo', ['wordpress-po'], function() {
	return gulp.src('languages/en_EN.po')
		.pipe(gettext())
		.pipe(gulp.dest('languages'));
});

gulp.task('wordpress-lang', (['wordpress-pot', 'wordpress-po-mo']));

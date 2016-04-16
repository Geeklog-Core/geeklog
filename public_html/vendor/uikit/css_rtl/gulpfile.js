var pkg         = require('./package.json'),
    del         = require('del'),
    gulp        = require('gulp'),
    runSequence = require('run-sequence').use(gulp),
    rename      = require('gulp-rename'),
    replace     = require('gulp-replace'),
    rtlcss      = require('gulp-rtlcss'),
    cleancss    = require('gulp-clean-css');

gulp.task('default', ['build'], function() {
});

gulp.task('build', function(done) {
    runSequence('clean', 'copy_LR', 'rtlcss', 'minifycss', 'modify', done);
});

gulp.task('clean', function() {
    return del(['./components', './*.css']);
});

gulp.task('copy_LR', function() {
    return gulp.src(['!./../css/**/*.min.css', './../css/**/*.css'])
        .pipe(gulp.dest('./'));
});

gulp.task('rtlcss', function() {
    return gulp.src(['!./node_modules/**/*.css', './**/*.css'])
        .pipe(rtlcss())
        .pipe(replace(/\n\n/g, '\n'))
        .pipe(gulp.dest('./'));
});

gulp.task('minifycss', function() {
    return gulp.src(['!./node_modules/**/*.css', '!./**/*.min.css', './**/*.css'])
        .pipe(rename({suffix: '.min'}))
        .pipe(cleancss({advanced: false}))
        .pipe(gulp.dest('./'));
});

gulp.task('modify', function() {
    return gulp.src(['!./node_modules/**/*.css', './**/*.min.css'])
        .pipe(replace(/License \*\//g, 'License *' + '/\n'))
        .pipe(gulp.dest('./'));
});

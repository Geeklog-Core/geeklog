var pkg         = require('./package.json'),
    fs          = require('fs'),
    del         = require('del'),
    gulp        = require('gulp'),
    glob        = require('glob'),
    runSequence = require('run-sequence').use(gulp),
    shell       = require('gulp-shell'),
    rename      = require('gulp-rename'),
    replace     = require('gulp-replace'),
    minifycss   = require('gulp-minify-css');

gulp.task('default', ['build'], function() {
});

gulp.task('build', function(done) {
    runSequence('clean', 'copy_LR', 'swap_LR', 'modify', 'fix_issue', 'minifycss', 'modify2', done);
});

gulp.task('clean', function(cb) {
    del(['./components', './*.css'], cb);
});

gulp.task('copy_LR', function() {
    return gulp.src(['!./../css/**/*.min.css', './../css/**/*.css'])
        .pipe(gulp.dest('./'));
});

gulp.task('swap_LR', function() {
    var files = glob.sync('.{/components,}/*.css');
    var tasks = [];
    files.forEach(function(file) {
        tasks.push('r2 ' + file + ' ' + file + ' --no-compress');
    });
    return shell.task(tasks)();
});

gulp.task('modify', function() {
    return gulp.src(['!./node_modules/**/*.css', './**/*.css'])
        .pipe(replace(/\n\n/g, '\n'))
        .pipe(replace(/right!important/g, 'right !important'))
        .pipe(replace(/left!important/g, 'left !important'))
        .pipe(replace(/}$/, '}\n'))
        .pipe(gulp.dest('./'));
});

// Fix miss convert of the R2 script
// target:
// border-color: rgba(45, 0.3) 145, 112,;
// replace:
// border-color: rgba(45, 112, 145, 0.3);
gulp.task('fix_issue', function(done) {

    var regex = /border-color: rgba\((\d+(?:\.\d+)?), (\d+(?:\.\d+)?)\) (\d+(?:\.\d+)?), (\d+(?:\.\d+)?),;/mg;

    glob('.{/components,}/*.css', function (err, files) {
        if (err) throw err;
        files.forEach(function(file) {
            fs.readFile(file, {encoding: 'utf-8'}, function(err, content) {
                if (err) throw err;
                var newstr = content.replace(regex, function(str, p1, p2, p3, p4, offset, s) {
                    return 'border-color: rgba(' + p1 + ', ' + p4 + ', ' + p3 + ', ' + p2 + ');';
                });
                fs.writeFile(file, newstr, function(err) {
                    if (err) throw err;
                });
            });
        });
    });
    done();
});

gulp.task('minifycss', function() {
    return gulp.src(['!./node_modules/**/*.css', '!./**/*.min.css', './**/*.css'])
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('./'));
});

gulp.task('modify2', function() {
    return gulp.src(['!./node_modules/**/*.css', './**/*.min.css'])
        .pipe(replace(/License \*\//g, 'License *' + '/\n'))
        .pipe(gulp.dest('./'));
});


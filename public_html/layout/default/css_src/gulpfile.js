var pkg         = require('./package.json'),
    fs          = require('fs'),
    path        = require('path'),
    glob        = require('glob'),
    gulp        = require('gulp'),
    stylus      = require('gulp-stylus'),
    runSequence = require('run-sequence').use(gulp),
    shell       = require('gulp-shell'),
    rename      = require('gulp-rename'),
    minifycss   = require('gulp-minify-css'),
    csscomb     = require('gulp-csscomb'),
    //cmq         = require('gulp-combine-media-queries'),
    //csso        = require('gulp-csso'),
    header      = require('gulp-header'),
    replace     = require('gulp-replace'),
    watch       = require('gulp-watch'),
    nib         = require('nib'),
    browserSync = require('browser-sync');

//var site_url  = 'http://localhost:8000/your_site'; // set the same value as the $_CONF['site_url']

var banner = "<%= pkg.title %> <%= pkg.version %> | Copyright (C) 2012-2015 by <%= pkg.author %> | <%= pkg.homepage %> | License:<%= pkg.license %>";

gulp.task('default', ['build'], function() {

});

gulp.task('watch', function() {
    if (site_url !== '') {
        browserSync({
            proxy: site_url
        });
    }
    watch(['./src/stylus/**/*.styl', './src/stylus/*.json'], function() {
        gulp.start('build');
    });
});

gulp.task('bs-reload', function () {
    browserSync.reload();
});

gulp.task('build', function() {
    runSequence('stylus', 'copy_LR', 'swap_LR', 'fix_issue', 'minify', 'modify', 'deploy', function() {
        browserSync.reload();
    });
});

gulp.task('stylus', function() {
    return gulp.src('./src/stylus/style.styl')
        .pipe(stylus({
            use: nib(),
            compress: false
        }))
        //.pipe(cmq())
        .pipe(csscomb())
        .pipe(header("/* " + banner + " */\n", { 'pkg' : pkg } ))
        .pipe(gulp.dest('./dest/css_ltr'));
});

gulp.task('minify', function() {
    return gulp.src(['!./dest/**/*.min.css', './dest/**/*.css'])
        .pipe(rename({ suffix: '.min' }))
        //.pipe(cmq())
        //.pipe(csso())
        .pipe(minifycss())
        .pipe(header("/* " + banner + " */\n", { 'pkg' : pkg } ))
        .pipe(gulp.dest('./dest/'));
});

gulp.task('deploy', function() {
    return gulp.src('./dest/**')
        .pipe(gulp.dest('./../'));
});

gulp.task('copy_LR', function() {
    return gulp.src('./dest/css_ltr/*')
        .pipe(gulp.dest('./dest/css_rtl/'));
});

gulp.task('swap_LR', function() {
    return shell.task('r2 ./dest/css_rtl/style.css ./dest/css_rtl/style.css --no-compress')();
});

gulp.task('fix_issue', function() {
    return gulp.src('./dest/css_rtl/style.css')
        .pipe(replace(/\.gl-tooltip span((?:\n|.)+?)margin-right/mg,
            function(str, p1, offset, s) {
                return '.gl-tooltip span' + p1 + 'margin-left';
            }))
        .pipe(replace(/\.gl-tooltip:hover span((?:\n|.)+?)margin-right/mg,
            function(str, p1, offset, s) {
                return '.gl-tooltip:hover span' + p1 + 'margin-left';
            }))
        .pipe(gulp.dest('./dest/css_rtl/'));
});

gulp.task('modify', function(done) {

    var regex = /(\/\*\/?(?:\n|[^\/]|[^\*]\/)*\*\/)|(^@media\s+[^\n]+\{\n(?:\n|.)*?\n\})|(^(?:#|\.|\w)(?:\n|.)+?\{\n(?:\n|.)*?\n\})/mg;

    var files = glob.sync('./dest/css_?t?/style.css');

    files.forEach(function(file) {

        var str = [];

        fs.readFile(file, {encoding: 'utf-8'}, function(err, content) {

            if (err) throw err;

            var matches, tmp;

            while (matches = regex.exec(content)) {
                if (matches[1] !== undefined) { // comment
                    tmp = matches[1];
                    if (tmp.indexOf('\n') != -1) {
                        tmp += '\n';
                    }
                    str.push(tmp);
                }
                if (matches[2] !== undefined) { // @media
                    tmp = modifyMedia(matches[2]);
                    tmp += '\n';
                    str.push(tmp);
                }
                if (matches[3] !== undefined) { // CSS rule set
                    str.push(matches[3] + '\n');
                }
            }
            fs.writeFile(file, str.join('\n'), function(err) {
                if (err) throw err;
            });
        });
    });
    done();
});

function modifyMedia(content) {

    var regex = /^(@media\s+[^\n]+\{\n)((?:\n|.)*?)(\n\})/mg;

    var matches = regex.exec(content);

    var regex2 = /(\/\*\/?(?:\n|[^\/]|[^\*]\/)*\*\/)|(^  (?:#|\.|\w)(?:\n|.)+?\{\n(?:\n|.)*?\n  \})/mg;

    var ms, str = '', tmp;

    while (ms = regex2.exec(matches[2])) {
        if (ms[1] !== undefined) {
            tmp = ms[1];
            if (tmp.indexOf('\n') != -1) {
                tmp = tmp.replace(/\n/g, '\n  ');
                tmp += '\n';
            }
            str = str + '  ' + tmp + '\n';
        }
        if (ms[2] !== undefined) {
            str = str + ms[2] + '\n\n';
        }
    }
    str = '\n  ' + str.trim();

    return matches[1] + str + matches[3];
}

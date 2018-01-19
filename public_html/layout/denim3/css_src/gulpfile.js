var pkg         = require('./package.json'),
    fs          = require('fs'),
    path        = require('path'),
    glob        = require('glob'),
    gulp        = require('gulp'),
    stylus      = require('gulp-stylus'),
    runSequence = require('run-sequence').use(gulp),
    rename      = require('gulp-rename'),
    cleancss    = require('gulp-clean-css'),
    csscomb     = require('gulp-csscomb'),
    header      = require('gulp-header'),
    replace     = require('gulp-replace'),
    rtlcss      = require('gulp-rtlcss'),
    watch       = require('gulp-watch'),
    nib         = require('nib'),
    browserSync = require('browser-sync');

//var site_url  = 'http://localhost:8000/your_site'; // set the same value as the $_CONF['site_url']

var banner = "<%= pkg.title %> <%= pkg.version %> | Copyright (C) 2012-2016 by <%= pkg.author %> | <%= pkg.homepage %> | License:<%= pkg.license %>";

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
    runSequence('stylus', 'copy_LR', 'rtlcss', 'modify1', 'minify', 'modify2', 'deploy', function() {
        browserSync.reload();
    });
});

gulp.task('stylus', function() {
    return gulp.src('./src/stylus/*.styl')
        .pipe(stylus({
            use: nib(),
            compress: false
        }))
        .pipe(csscomb())
        .pipe(header("/* " + banner + " */\n", { 'pkg' : pkg } ))
        .pipe(gulp.dest('./dest/css_ltr'));
});

gulp.task('minify', function() {
    return gulp.src(['!./dest/**/*.min.css', './dest/**/*.css'])
        .pipe(rename({ suffix: '.min' }))
        .pipe(cleancss())
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

gulp.task('rtlcss', function() {
    return gulp.src(['!./dest/css_rtl/*.min.css', './dest/css_rtl/*.css'])
        .pipe(rtlcss())
        .pipe(gulp.dest('./dest/css_rtl/'));
});

gulp.task('modify1', function() {
    return gulp.src(['!./dest/css_ltr/*.min.css', './dest/css_ltr/*.css'])
        .pipe(replace(/$\s*\/\*rtl:ignore\*\//mg,
            function(str, p1, offset, s) {
                return '';
            }))
        .pipe(gulp.dest('./dest/css_ltr/'));
});

gulp.task('modify2', function(done) {

    var regex = /(\/\*\/?(?:\n|[^\/]|[^\*]\/)*\*\/)|(^@media\s+[^\n]+\{\n(?:\n|.)*?\n\})|(^(?:#|\.|\*|\w)(?:\n|.)+?\{\n(?:\n|.)*?\n\})/mg;

    var files = glob.sync('./dest/css_?t?/style*(.gradient|.almost-flat).css');

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

    var regex2 = /(\/\*\/?(?:\n|[^\/]|[^\*]\/)*\*\/)|(^  (?:#|\.|\*|\w)(?:\n|.)+?\{\n(?:\n|.)*?\n  \})/mg;

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

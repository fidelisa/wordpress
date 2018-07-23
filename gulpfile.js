var gulp = require('gulp')
var del = require('del');
const zip = require('gulp-zip');
const shell = require('gulp-shell');

var sourceFiles = ['src/**/*'];
var buildFolder = 'build/fdls';
var distFolder = 'dist';

gulp.task('clean', function() {
    return del([
        buildFolder,
        distFolder+'/*.zip'
    ]);
});

gulp.task('copy', ['clean'], function() {
    return gulp.src(sourceFiles)
        .pipe(gulp.dest(buildFolder));
});

gulp.task('zipper', ['copy'], shell.task([
    'cd build && zip -r ../dist/fdls.zip fdls'
]));

gulp.task('default', ['zipper']);
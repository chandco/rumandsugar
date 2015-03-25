var gulp = require('gulp'),
			less = require('gulp-less'),
			path = require('path'),
			watch = require('gulp-watch'),
			autoprefixer = require('gulp-autoprefixer'),
			browserSync = require('browser-sync'),
			uglify = require('gulp-uglify'),
			sourcemaps = require('gulp-sourcemaps'),
			jshint = require('gulp-jshint'),
			imageResize = require('gulp-image-resize'),
			rename = require("gulp-rename"),
            uglifycss = require("gulp-uglifycss"),
            plumber = require("gulp-plumber"),
            cmq = require('gulp-combine-media-queries'),
			changed = require("gulp-changed");

//gulp.src(['js/**/*.js', '!js/**/*.min.js'])

var run = require('gulp-run');


gulp.task('default', ['compile-css', 'javascript'], function () {


    browserSync({
            proxy: "192.168.0.209",
            files: "./css/*.css"
        });
    
    gulp.watch('./css/**/*.less', ['compile-css']);

    gulp.watch('./js/*.js', ['javascript', browserSync.reload]);

    


});


gulp.task('javascript', function() {
	

    gulp.src('./js/*.js')
        .pipe(plumber())    
        .pipe(uglify())
        .pipe(rename(function (path) {
            
            path.basename += ".min";        

        }))
        .pipe(gulp.dest('./js/min/'));


});


gulp.task('compile-css', function () {
	gulp.src('./css/main.less')
                .pipe(plumber())
				.pipe(sourcemaps.init())
			    .pipe(less())
			    //.pipe(autoprefixer())
                //.pipe(uglifycss())
			    .pipe(sourcemaps.write('./maps'))
			    .pipe(gulp.dest('./css/'));

});

gulp.task('dist-css', function () {
    gulp.src('./css/main.less')
                .pipe(plumber())
                //.pipe(sourcemaps.init())
                .pipe(less())
                .pipe(autoprefixer())
                .pipe(cmq({
                  log: true
                }))
                .pipe(uglifycss())
                //.pipe(sourcemaps.write('./maps'))
                .pipe(gulp.dest('./css/'));

});




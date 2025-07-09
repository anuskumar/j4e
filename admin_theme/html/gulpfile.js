var gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
postcss = require("gulp-postcss");
autoprefixer = require("autoprefixer");
var sourcemaps = require('gulp-sourcemaps'); 
var browserSync = require('browser-sync').create(); 
cssbeautify = require('gulp-cssbeautify');
var beautify = require('gulp-beautify');


/*******************  LTR   ******************/


//_______ task for scss folder to css main style 
gulp.task('watch', function() {
        return gulp.src('Azira/assets/scss/style.scss') 
               .pipe(sourcemaps.init())                       
               .pipe(sass())
       .pipe(beautify.css({ indent_size: 4 }))
               .pipe(sourcemaps.write(''))   
               .pipe(gulp.dest('Azira/assets/css'))
               .pipe(browserSync.reload({
                 stream: true
       }))
})

//_______ task for plugins folder to css main style 
gulp.task('plugins', function() {
        return gulp.src('Azira/assets/scss/plugins.scss') 
               .pipe(sourcemaps.init())                       
               .pipe(sass())
       .pipe(beautify.css({ indent_size: 4 }))
               .pipe(sourcemaps.write(''))   
               .pipe(gulp.dest('Azira/assets/css'))
               .pipe(browserSync.reload({
                 stream: true
       }))
})


gulp.task('default', gulp.series('watch', 'plugins'))
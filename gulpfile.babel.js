// Import libs
import gulp from 'gulp';
import sourcemaps from 'gulp-sourcemaps';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import babel from 'gulp-babel';
import imagemin from 'gulp-imagemin';

// Paths
const paths = {
  dist: {
    styles: './public/static/css',
    scripts: './public/static/js',
    images: './public/static/img',
  },
  resources: {
    styles: './resources/assets/styles',
    scripts: './resources/assets/scripts',
    images: './resources/assets/images',
  },
};

// Src files
const src = {
  styles: `${paths.resources.styles}/**/**.scss`,
  scripts: `${paths.resources.scripts}/**/**.js`,
  images: `${paths.resources.images}/**/**.{svg,png,jpg,gif}`,
};

class TaskRunner {
  constructor() {
    // Tasks
    gulp.task('styles', this.styles);
    gulp.task('scripts', this.scripts);
    gulp.task('images', this.images);

    // Default task
    gulp.task('default', ['styles', 'scripts', 'images']);

    // Watch task
    gulp.task('watch', ['default'], () => {
      gulp.watch(src.styles, ['styles']);
      gulp.watch(src.scripts, ['scripts']);
      gulp.watch(src.images, ['images']);
    });
  }

  styles() {
    return gulp.src(src.styles)
      .pipe(sourcemaps.init())
      .pipe(sass({
        outputStyle: 'compressed',
      }).on('error', sass.logError))
      .pipe(postcss([
        autoprefixer({
          browsers: [
            'last 3 versions',
            'last 2 major versions',
            'ie >= 9',
          ],
        }),
      ]))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(paths.dist.styles));
  }

  scripts() {
    return gulp.src(src.scripts)
      .pipe(sourcemaps.init({ loadMaps: true }))
      .pipe(babel({
        presets: [
          "minify",
        ]
      }))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(paths.dist.scripts));
  }

  images() {
    console.log(src.images);
    return gulp.src(src.images)
      .pipe(imagemin())
      .pipe(gulp.dest(paths.dist.images));
  }
}

// Start our task runner
new TaskRunner();

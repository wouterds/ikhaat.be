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
    images: './public/static/img',
    styles: './public/static/css',
    scripts: './public/static/js',
    scriptsVendor: './public/static/js/vendor',
  },
  resources: {
    images: './resources/assets/images',
    styles: './resources/assets/styles',
    scripts: './resources/assets/scripts',
    scriptsVendor: './node_modules',
  },
};

// Src files
const src = {
  images: `${paths.resources.images}/**/**.{svg,png,jpg,gif}`,
  styles: `${paths.resources.styles}/**/**.scss`,
  scripts: `${paths.resources.scripts}/**/**.js`,
  scriptsVendor: [
    `${paths.resources.scriptsVendor}/jquery/dist/jquery.min.js`,
    `${paths.resources.scriptsVendor}/clipboard/dist/clipboard.min.js`,
  ],
};

class TaskRunner {
  constructor() {
    // Tasks
    gulp.task('images', this.images);
    gulp.task('styles', this.styles);
    gulp.task('scripts', this.scripts);
    gulp.task('scripts:vendor', this.scriptsVendor);

    // Default task
    gulp.task('default', ['images', 'styles', 'scripts', 'scripts:vendor']);

    // Watch task
    gulp.task('watch', ['default'], () => {
      gulp.watch(src.images, ['images']);
      gulp.watch(src.styles, ['styles']);
      gulp.watch(src.scripts, ['scripts']);
      gulp.watch(src.scriptsVendor, ['scripts:vendor']);
    });
  }

  images() {
    return gulp.src(src.images)
      .pipe(imagemin())
      .pipe(gulp.dest(paths.dist.images));
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

  scriptsVendor() {
    return gulp.src(src.scriptsVendor)
      .pipe(gulp.dest(paths.dist.scriptsVendor));
  }
}

// Start our task runner
new TaskRunner();

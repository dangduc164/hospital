const { src, dest, watch, series, parallel } = require('gulp');

// sass
const sass             = require( 'gulp-sass' )(require('sass'));
const postcss          = require('gulp-postcss');
const postcssPresetEnv = require( 'postcss-preset-env' );

const babel  = require( 'gulp-babel' );
const uglify = require( 'gulp-uglify-es' ).default;

const webpack       = require( 'webpack' );
const webpackStream = require( 'webpack-stream' );
const webpackConfig = require( './webpack.config' );

const imagemin = require( 'gulp-imagemin' );
const mozjpeg  = require( 'imagemin-mozjpeg' );
const pngquant = require( 'imagemin-pngquant' );

const plumber = require( 'gulp-plumber' );
const notify  = require( 'gulp-notify' );
const rename  = require( 'gulp-rename' );
const newer   = require( 'gulp-newer' );

const ejs = require( 'gulp-ejs' );



// directory
const dir = {
  root: './public_html',
  doc:  './src'
}



// path
const path = {
  scss: {
    root: {
      src:  dir.root + '/assets/src/scss/**/*.scss',
      dest: dir.root + '/assets/css/'
    },
    doc: {
      src:  dir.doc + '/**/*.scss',
      dest: dir.root + '/docs/'
    }
  },
  js: {
    root: {
      src:  dir.root + '/assets/src/js/*.js',
      dest: dir.root + '/assets/js/'
    },
    doc: {
      src:  dir.doc + '/**/*.js',
      dest: dir.root + '/docs/'
    }
  },
  webpack: {
    src: dir.root + '/assets/src/webpack/*.js'
  },
  minify: {
    src  : './imagemin/original/*',
    dest : './imagemin/'
  },
  ejs: {
    src : './ejs/**/*.ejs',
    exc : '!./ejs/**/_*.ejs',
    dest: dir.root + '/docs/'
  }
}



// Tasks

// autoprefixer
const processors = [
  postcssPresetEnv({
    stage        : 3,
    browsers     : [ 'last 2 versions', 'iOS >= 8' ],
    autoprefixer : { cascade : false },
  })
];

// Babel
const babelOptions = {
  presets: ['@babel/preset-env'],
  plugins: [
    [
      "@babel/plugin-transform-runtime",
      {
        "absoluteRuntime": false,
        "corejs": false,
        "helpers": true,
        "regenerator": true
      }
    ]
  ]
};



function scss(){
  return src( path.scss.root.src, { sourcemaps : true } )
    .pipe( plumber({ errorHandler : notify.onError( 'エラー: <%= error.message %>' ) }))
    .pipe( sass.sync({ outputStyle : 'expanded' })) // nested expanded compact compressed
    .pipe( postcss(processors) )
    .pipe( notify( 'SCSS: <%= file.relative %>' ))
    .pipe( dest( path.scss.root.dest, { sourcemaps : './map' }))
}
function scssDoc(){
  return src( path.scss.doc.src, { sourcemaps : true } )
    .pipe( plumber({ errorHandler : notify.onError( 'エラー: <%= error.message %>' ) }))
    .pipe( sass.sync({ outputStyle : 'expanded' })) // nested expanded compact compressed
    .pipe( postcss(processors) )
    .pipe( notify( 'SCSS: <%= file.relative %>' ))
    .pipe( dest( path.scss.doc.dest, { sourcemaps : './map' }))
}



function javaScript(){
  return src( path.js.root.src, { sourcemaps : true })
    .pipe( plumber())
    .pipe( babel( babelOptions ))
    .pipe( uglify({ output : { comments : /^!/ } })) // 圧縮（オプションで正規表現で /*! //! で始まるコメントを残す）
    .pipe( rename({ suffix : '.min' }))
    .pipe( notify( 'JavaScript: <%= file.relative %>' ))
    .pipe( dest( path.js.root.dest, { sourcemaps : './map' }))
}
function javaScriptDoc(){
  return src( path.js.doc.src, { sourcemaps : true })
    .pipe( plumber())
    .pipe( babel( babelOptions ))
    .pipe( uglify({ output : { comments : /^!/ } })) // 圧縮（オプションで正規表現で /*! //! で始まるコメントを残す）
    .pipe( rename({ suffix : '.min' }))
    .pipe( notify( 'JavaScript: <%= file.relative %>' ))
    .pipe( dest( path.js.doc.dest, { sourcemaps : './map' }))
}



function jsWebpack()
{
  return webpackStream(webpackConfig, webpack).on('error', function(){
    this.emit('end');
  }).pipe( dest( path.js.root.dest ) );
}



function imageMinify()
{
  return src( path.minify.src )
    .pipe( newer( path.minify.dest ))
    .pipe( imagemin([
      pngquant({ quality : [0.65, 0.8], speed : 1 }),
      mozjpeg({ quality : 85, progressive : true }),
      imagemin.svgo(),
      imagemin.optipng(),
      imagemin.gifsicle()
    ]))
    .pipe( notify( 'Image Minify' ))
    .pipe( dest( path.minify.dest ))
}



function htmlEjs()
{
  return src( [path.ejs.src, path.ejs.exc] )
    .pipe( plumber({ errorHandler : notify.onError( 'エラー: <%= error.message %>' ) }))
    .pipe( ejs() )
    .pipe( rename({ extname: '.html' }) )
    .pipe( notify('EJS: <%= file.relative %>'))
    .pipe( dest( path.ejs.dest ) )
};



// watch
//
exports.default = function(){
  watch( path.scss.root.src, scss );
  watch( path.scss.doc.src, scssDoc );
  watch( path.js.root.src, javaScript );
  watch( path.js.doc.src, javaScriptDoc );
  watch( path.webpack.src, jsWebpack );
  watch( path.minify.src, imageMinify );
  watch( path.ejs.src, htmlEjs );
};

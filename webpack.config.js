const WebpackBuildNotifierPlugin = require('webpack-build-notifier');

// メインとなるJavaScriptファイル（エントリーポイント）
const entryFilePath = './public_html/assets/src/webpack/module.js';


module.exports = {
  // モード値を production に設定すると最適化された状態で、
  // development に設定するとソースマップ有効でJSファイルが出力される
  mode: 'production',
  resolve: {
    extensions: ['.js', '.ts']
  },
  // メインとなるJavaScriptファイル（エントリーポイント）
  entry: entryFilePath,
  // babel
  module: {
    rules: [
      {
        // 拡張子 .js の場合
        test: /\.js$/,
        use: [
          {
            // Babel を利用する
            loader: 'babel-loader',
            // Babel のオプションを指定する
            options: {
              presets: [
                // プリセットを指定することで、ES2020 を ES5 に変換
                '@babel/preset-env',
              ]
            }
          }
        ]
      }
    ]
  },
  // プラグイン
  plugins: [
    new WebpackBuildNotifierPlugin({
      title: 'Webpack'
    }),
  ],
  // ファイルの出力設定
  output: {
    //path: `${__dirname}/htdocs/assets/js`,
    // 出力ファイル名
    filename: 'module.min.js'
  },
  // ソースマップ
  devtool: 'eval-cheap-source-map'

}

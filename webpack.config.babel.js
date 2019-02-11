import { resolve } from 'path';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';

export default (_env, { mode }) => {
  const isProduction = mode === 'production';

  return {
    resolve: {
      extensions: ['.js', '.scss']
    },
    entry: {
      app: './resources/assets/scripts/app.js',
    },
    output: {
      path: resolve('./public/static'),
      filename: '[name].[hash:7].js',
      publicPath: '/static/',
    },
    module: {
      rules: [
        {
          test: /\.js?$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                modules: true,
                importLoaders: true,
                localIdentName: isProduction ? '[hash:7]' : '[name]-[local]-[hash:7]',
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                plugins: () => [
                  require('postcss-pseudoelements')(),
                  require('postcss-import')({
                    path: './resources/assets/styles',
                  }),
                  require('postcss-mixins')(),
                  require('postcss-preset-env')({
                    features: {
                      'custom-properties': {
                        preserve: false,
                      },
                    },
                  }),
                  require('postcss-nested')(),
                  require('postcss-hexrgba')(),
                  require('postcss-calc')(),
                  require('postcss-custom-media')(),
                  require('cssnano')(),
                ],
              },
            },
          ],
        },
        {
          test: /\.(gif|jpe?g|png)$/,
          loader: 'url-loader',
          options: {
            limit: 25000,
            name: '[hash:7].[ext]',
          },
        },
        {
          test: /\.(ttf|otf|eot|svg|woff(2)?)$/,
          loader: 'file-loader',
          options: {
            name: '[hash:7].[ext]',
          },
        },
      ],
    },
    devServer: {
      noInfo: true,
      disableHostCheck: true,
    },
    devtool: isProduction === false ? 'source-map' : undefined,
    plugins: [
      new MiniCssExtractPlugin({
        filename: '[name].[hash:7].css',
      }),
      new HtmlWebpackPlugin({
        filename: resolve('./resources/views/_base.html.twig'),
        template: './resources/views/_base.template.html.twig',
      }),
    ]
  }
};

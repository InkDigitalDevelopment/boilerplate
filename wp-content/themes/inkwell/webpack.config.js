const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const path = require('path');
const fs = require('fs');

module.exports = (env = {}, argv = {}) => {
  const plugins = [new MiniCssExtractPlugin({ filename: '[name].css' })];

  if (argv.mode === 'development') {
    let localUrl = env.localUrl || process.env.LOCAL_URL;
    const configPath = path.join(__dirname, 'dev.config.json');
    if (!localUrl && fs.existsSync(configPath)) {
      localUrl = JSON.parse(fs.readFileSync(configPath, 'utf8')).localUrl;
    }
    if (!localUrl) {
      throw new Error('Copy dev.config.example.json to dev.config.json and set your Local site URL, then run npm run dev.');
    }
    const url = new URL(localUrl);
    if (!['http:', 'https:'].includes(url.protocol)) {
      throw new Error('The Local site URL must use http:// or https://.');
    }
    plugins.push(new BrowserSyncPlugin({
      proxy: {
        target: url.href,
        proxyRes: [(response) => {
          // Node decodes upstream chunks. Let BrowserSync set response framing
          // after injecting its client, without a conflicting upstream header.
          delete response.headers['transfer-encoding'];
        }],
      },
      files: [
        path.join(__dirname, '*.php'),
        path.join(__dirname, 'inc/**/*.php'),
        path.join(__dirname, 'template-parts/**/*.php'),
        path.join(__dirname, 'page-templates/**/*.php'),
        path.join(__dirname, 'blocks/**/*.{php,json}'),
      ],
      open: false,
      ui: false,
      notify: false,
      ghostMode: false,
    }, { injectCss: true }));
  }

  return {
    context: __dirname,
    entry: {
      app: './src/js/app.js',
      style: './src/css/globals.css',
    },
    output: {
      path: path.resolve(__dirname, 'dist'),
      filename: '[name].js',
    },
    devtool: false,
    plugins,
    module: {
      rules: [
        {
          test: /\.css$/i,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader'],
        },
        {
          test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
          use: 'url-loader?limit=1024',
        },
      ],
    },
  };
};

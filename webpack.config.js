const path = require('path');
const defaultConfig = require('./node_modules/@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,

	mode: 'development',

	entry: {
		app: path.resolve( __dirname, 'js/source', 'app.js' ),
	},
	output: {
		filename: '[name].[contenthash].bundle.js',
		path: path.resolve( __dirname, 'js/dist' ),
	},

	devtool: 'inline-source-map',
};

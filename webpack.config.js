const path = require('path');
const defaultConfig = require('./node_modules/@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
	mode: 'development',
	module: {
		rules: [
			...defaultConfig.module.rules,
			{
				test: require.resolve('react'),
				loader: "expose-loader",
				options: {
				  exposes: ['React'],
				},
			  },
		]
	},
	entry: {
		app: path.resolve( __dirname, 'js/source', 'app.js' ),
	},
	output: {
		libraryTarget: 'umd',
		filename: '[name].[contenthash].bundle.js',
		path: path.resolve( __dirname, 'js/dist' ),
	},
	devtool: 'inline-source-map',
};

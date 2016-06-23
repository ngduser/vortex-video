module.exports = function(grunt) {
  grunt.loadNpmTasks('grunt-webpack');
  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-connect");
  
  grunt.initConfig({
    watch: {
      js: {
        files: ['./src/**/*.js'],
        tasks: ["webpack"],
      },
      options: {
        livereload: false, 
      },
    },
    connect: {
      server: {
        options: {
          port: 9000,
          base: '.',
          protocol: 'http',
          livereload: false,
          open: true,
        },
      },
    },
    webpack: {
      someName: {
        entry: "./src/main.js",
        output: {
          path: "./public/dist/",
          filename: "bundle.js",
        },
        module: {
          loaders: [{
              test: /\.js?$/,
              loader: 'babel-loader',
              exclude: /node_modules/,
              query: {
                presets: ['es2015', 'react', 'stage-0']
              },
            }],
        },
      },
    },
  });
  
  grunt.registerTask('server', ['connect', 'watch']);
}

module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: false,
          yuicompress: false,
          optimization: 2,
          relativeUrls: true,
          sourceMap: true,
          sourceMapFilename: 'lib/css/main.css.map',
          sourceMapBasepath: 'lib/less',
          sourceMapURL: 'main.css.map',
          sourceMapRootpath: '../../lib/less'
        },
        files: {
          // target.css file: source.less file
          'lib/css/main.css': 'lib/less/main.less'
        }
      },
      production: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          'lib/css/main.css': 'lib/less/main.less'
        }
      }
    },
    watch: {
      options: {
        livereload: true,
      },
      styles: {
        files: ['lib/less/**/*.less'], // which files to watch
        tasks: ['less:development'],
        options: {
          nospawn: true
        }
      },
      webfont: {
        files: ['lib/build/svg-icons/*.svg'],
        tasks: ['webfont']
      }
    },
    webfont: {
      icons: {
        src: 'lib/build/svg-icons/*.svg',
        dest: 'lib/fonts',
        destCss: 'lib/less',
        options: {
          font: '_00_kmi-font',
          fontHeight: 1024,
          relativeFontPath: '../fonts',
          htmlDemo: true,
          destHtml: 'lib/build/fonts',
          engine: 'node',
          hashes: true,
          embed: true,
          stylesheet: 'less',
          templateOptions: {
            baseClass: 'kmi-icon',
            classPrefix: 'kmi-icon-',
            mixinPrefix: 'kmi_icon_'
          }
        },
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-webfont');

  grunt.registerTask('default', ['watch']);
  grunt.registerTask('build', ['less:production']);
  grunt.registerTask('builddev', ['less:development']);
  grunt.registerTask('buildfont', ['webfont','less:production']);
  grunt.registerTask('buildfontdev', ['webfont','less:development']);
};
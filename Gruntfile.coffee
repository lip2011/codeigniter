module.exports = (grunt) ->
  grunt.initConfig
    pkg: grunt.file.readJSON('package.json')

    coffee:
      all:
        files:
          'static/admin/js/controller/user_controller.js': 'src_coffee/admin/controller/user_controller.coffee'
          'static/admin/js/model/user_model.js': 'src_coffee/admin/model/user_model.coffee'

    concat:
      all:
        files:
          'static/admin/js/admin.js': [
            'static/admin/js/test.js'
          ]

    uglify:
      all:
        options:
          report: 'gzip'
        files:
          'static/admin/js/admin.min.js': 'static/admin/js/admin.js'

    watch:
      all:
        files: ['src_coffee/**/*.coffee']
        tasks: ['build']

  grunt.loadNpmTasks 'grunt-contrib-coffee'
  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-uglify'
  grunt.loadNpmTasks 'grunt-contrib-watch'
  grunt.loadNpmTasks 'grunt-contrib-copy'

  grunt.registerTask 'default', ['watch']
  grunt.registerTask 'build',   ['coffee']
  grunt.registerTask 'concat_and_uglify',   ['concat', 'uglify']
/* jshint node:true */
module.exports = function(grunt) {
	var path = require('path'),
		SOURCE_DIR = 'src/',
		BUILD_DIR = 'build/';

	// Load tasks.
	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	// Project configuration.
	grunt.initConfig({
		clean: {
			all: [BUILD_DIR],
			dist: {
				dot: true,
				expand: true,
				cwd: BUILD_DIR,
				src: [
					'node_modules',
					'less',
					'README.md',
					'js/src'
				]
			}
		},
		copy: {
			all: {
				files: [{
					dot: true,
					expand: true,
					cwd: SOURCE_DIR,
					src: [
						'**',
						'!**/.{svn,git}/**', // Ignore version control directories.
						'!.DS_Store',
						'!package.json',
						'!Gruntfile.js',
						'!node_modules'
					],
					dest: BUILD_DIR
				}]
			}
		},
		less: {
			dist: {
				expand: true,
				cwd: SOURCE_DIR + 'assets/',
				dest: BUILD_DIR,
				ext: '.css',
				src: [ 'style.less', 'editor-style.less' ]
			},
			dev: {
				expand: true,
				cwd: SOURCE_DIR + 'assets/',
				dest: SOURCE_DIR,
				ext: '.css',
				src: [ 'style.less', 'editor-style.less' ]
			}
		},
		concat: {
			dist: {
				src: [
					SOURCE_DIR + 'assets/js/src/*.js',
				],
				dest: BUILD_DIR + 'assets/js/museum.js'
			},
			dev: {
				src: [
					SOURCE_DIR + 'assets/js/src/*.js',
				],
				dest: SOURCE_DIR + 'assets/js/museum.js'
			}
		},

		compress: {
			main: {
				options: {
					//mode: 'zip',
					archive: 'flounder.zip'
				},
				files: [
					{expand: true, cwd: BUILD_DIR, src: ['**'], dest: '/'}
				]
			}
		},

		watch: {
			colors: {
				files: [SOURCE_DIR + 'assets/**/*.less'],
				tasks: ['less:dev']
			}
		}
	});

	// Register tasks.

	// Build task.
	grunt.registerTask('build', ['clean:all', 'copy:all', 'less:dist', 'concat:dist', 'clean:dist', 'compress:main']);
	// Dev build
	grunt.registerTask('dev', ['less:dev', 'concat:dev' ]);

	// Default task.
	grunt.registerTask('default', ['dev']);

};

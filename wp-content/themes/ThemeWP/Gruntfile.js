module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			css: {
				files: '**/*.scss',
				tasks: ['sass', 'notify:sass']
			},
			scripts: {
				files: ['**/*.js'],
				tasks: ['uglify', 'notify:uglify']
			}
		},
		sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				src: 'sass/style.scss',
				dest: 'css/style.css'
			}
		},
		uglify: {
			options: {
				mangle: false,
				sourceMap: true,
				compress: {}
			},
			my_target: {
				files: {
					'js/siteScripts.js': [
						'node_modules/foundation-sites/dist/foundation.js',
						'js/childTheme.js'
					]
				}
			}
		},
		browserSync: {
			default_options: {
				bsFiles: {
					src: [
						"css/style.css",
						"**/*.php",
						"**/*.js",
					]
				},
				options: {
					watchTask: true,
					proxy: "parenttheme.v1"
				}
			}
		},
		notify: {
			sass: {
				options: {
					title: "SCSS Compile",
					message: "Success!"
				}
			},
			uglify: {
				options: {
					title: "Uglify Compile",
					message: "Success!"
				}
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-notify');

	grunt.registerTask('default', ['browserSync', 'watch']);
}

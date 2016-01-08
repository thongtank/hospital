module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.initConfig({
        watch: {
            files: ['*.php','admin/*.php'],
            options: {
                livereload: true
            }
        },
        uglify: {
            my_target: {
                files: [{
                    expand: 1,
                    cwd: 'js/',
                    ext: '.min.js',
                    src: ['*.js'],
                    dest: 'js/'
                }]
            },
            options: {}
        }
    });
}


var gulp = require('gulp');
var $ = require('gulp-load-plugins')();


//项目一
var Path={
    src:{
        baseUrl:'dev/',
          image:'dev/images/',
           less:'dev/less/',
             js:'dev/js/',
            lib:'dev/lib/',
         plugin:'dev/plugin/'
    },
    dest:{
        baseUrl:'app/',
          image:'app/images/',
            css:'app/css/',
             js:'app/js/',
            lib:'app/lib/',
         plugin:'app/plugin/'
    }
}


//压缩图片
gulp.task('images', function() {
    return gulp.src(Path.src.image+'*.{png,jpg}')
    .pipe($.imagemin())
    .pipe(gulp.dest(Path.dest.image))
});



//压缩背景图
gulp.task('imgs', function() {
    return gulp.src(Path.src.less+'imgs/*.{png,jpg,gif}')
    .pipe($.imagemin())
    .pipe(gulp.dest(Path.dest.css+'imgs'))
});



//less解析为css
gulp.task('less', function() {
    return gulp.src([
        Path.src.less+'*.less',
        '!'+Path.src.less+'pre_var.less',
        '!'+Path.src.less+'pre_mix.less'
        ])
    .pipe($.less())
    .pipe($.cleanCss())
    .pipe(gulp.dest(Path.dest.css))
});


//按依赖合并压缩js
gulp.task('js', function () {
    return gulp.src(Path.src.js+'p_*.js')
        .pipe($.requirejsOptimize(function(file) {
            return {
                mainConfigFile:Path.src.js+'rconfig.js',
                       exclude: [
                           'jq',
                           'common',
                           'header'
                       ]
            };
        }))
        .pipe(gulp.dest(Path.dest.js));
});


//合并压缩
gulp.task('concat_js', function() {
    return gulp.src([
            Path.src.js+"g_common.js",
            Path.src.js+"g_header.js"
        ])
    .pipe($.uglify())
    .pipe($.concat('g_common.js'))
    .pipe(gulp.dest(Path.dest.js))
});


//压缩其他js
gulp.task('trans_js', function() {
    return gulp.src([
            Path.src.js+"iconfig.js",
            Path.src.js+"rconfig.js",
            Path.src.js+"require.js",
        ])
    .pipe($.uglify())
    .pipe(gulp.dest(Path.dest.js))
});

//压缩/lib
gulp.task('compress_lib', function() {
    return gulp.src([,Path.src.lib+"jquery-1.10.2.js"])
    .pipe($.uglify())
    .pipe(gulp.dest(Path.dest.lib))
});

//压缩/plugin
gulp.task('compress_plugin', function() {
    return gulp.src([,Path.src.plugin+"*.js"])
    .pipe($.uglify())
    .pipe(gulp.dest(Path.dest.plugin))
});


//html内less转css
gulp.task('lessToCss', function() {
    var src=Path.src.baseUrl;
    var dest=Path.dest.baseUrl;
    var rf=require("fs");
    rf.exists(dest,function(exists){
        if(exists===false){ rf.mkdir(dest); }//dest目录不存在时新建
        //遍历出.html
        files=rf.readdirSync(src);
        var fileList=[];
        files.forEach(function(self){
            if(/.html/.test(self)){
                fileList.push(self);
            }
        });
        //修改html内容
        fileList.forEach(function(file){
            var data=rf.readFileSync(src+file,"utf-8");  
            data=data.replace(/text\/less/g,"text/css")
            data=data.replace(/less\//g,"css/")
            data=data.replace(/\.less/g,".css")
            data=data.replace('<script language="javascript" type="text/javascript" src="js/less.js"></script>','');
            rf.writeFile(dest+file,data);
        });
    });
});



//项目一
gulp.task("dev",['images','imgs','less','js','concat_js','trans_js','compress_lib','compress_plugin','lessToCss'],function(){});




gulp.task('jade',function(){
    return gulp.src(Path.src.baseUrl+'*.jade')
    .pipe($.plumber())
    .pipe($.jade({
        pretty: "aaa" //转化的html不压缩
    }))
    .pipe(gulp.dest(Path.dest.baseUrl))
});


gulp.task("default",['jade'],function(){ });
    






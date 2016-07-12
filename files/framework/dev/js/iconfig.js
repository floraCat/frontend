(function() {
    'use strict';
    /*
        例：
        请求URL：http://www.xxx.com/contextPath/product.html
        CXT：/contextPath 是Java Web 容器配置的上下文路径(如果有配置的话)
        ROOT：http://www.xxx.com/contextPath 是Web完整的根目录
        HOST：http://www.xxx.com 是域名
        JS：JS根目录
        CSS：CSS根目录
        IMAGES：图片根目录
        LIB：前端插件根目录

     */
    var Iconfig = {
        /*各种路径*/
        CXT: "",
        ROOT: "",
        HOST: "",
        JS: "",
        CSS: "",
        IMAGES: "",
        LIB: "",
        /*各种路径--End*/
    };
    window.Iconfig = Iconfig;
}());
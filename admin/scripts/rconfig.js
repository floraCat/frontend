(function (window) {
    "use strict";

    var require = {
        paths: {
            "jquery": "../lib/jquery/jquery.min",
            "bootstrap": "../lib/bootstrap/js/bootstrap.min",
            "slimScroll": "../lib/slimScroll/jquery.slimscroll.min",
            "fastclick": "../lib/fastclick/fastclick.min",
            "AdminLTE": "../lib/AdminLTE/js/app.min",

            "angular": "../lib/angular/angular.min",
            "angularRoute": "../lib/angular/angular-route.min",
            "angularAnimate": "../lib/angular/angular-animate.min",
            "angularResource": "../lib/angular/angular-resource.min",
            "angularLocale": "../lib/angular/angular-locale_zh-cn.min",
            "angularUiRouter": "../lib/angular-ui-router/angular-ui-router.min",
            "ngStorage": "../lib/ngstorage/ngStorage.min",

            "jqueryUi": "../lib/jquery-ui/jquery-ui.min",
            "ztree": "../lib/zTree/js/jquery.ztree.all.min",
            "player": "../lib/layer/layer.min",
            "layer-ext": "../lib/layer/extend/layer.ext.min",
            "pnotify": "../lib/pnotify/js/pnotify.min",

            "bootstrap-dialog": "../lib/bootstrap3-dialog/js/bootstrap-dialog.min",

            "validatorjs": "../lib/validator-js/validator.min",
            "string": "../lib/string/string.min",
            "moment": "../lib/moment/moment-with-locales.min",

            "bootstrapValidator": "../lib/bootstrapvalidator/js/bootstrapValidator.min",
            "bootstrapValidatorLocal": "../lib/bootstrapvalidator/js/language/zh_CN.min",

            "domReady": "../lib/requirejs-domready/domReady",

            "app": "app"

        },
        waitSeconds: 0,
        shim: {
            "bootstrap": ["jquery"],
            "angular": {exports: "angular", deps: ["jquery"]},
            "angularLocale": ["angular"],
            "angularUiRouter": ["angular"],
            "bootstrapValidator": ["jquery", "bootstrap"],
            "bootstrapValidatorLocal": ["bootstrapValidator"],
            "player": {exports: "player", deps: ["jquery"]},
            "ztree": ["jquery"],
            "adminlte": {exports: "adminlte", deps: ["jquery", "bootstrap", "slimScroll", "fastclick"]},
            "app": ["jquery", "bootstrap", "angular", "angularLocale", "angularUiRouter"]
        },
        priority: ["jquery", "bootstrap", "angular"]
    };

    window.require = require;
}(window));

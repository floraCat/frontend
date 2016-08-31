(function () {
    'use strict';

    window.name = "NG_DEFER_BOOTSTRAP!"; //手动解发初始化：resumeBootstrap
    define(["require", "jquery", "angular", "domReady", "bootstrap", "angularLocale", "app"], function (require, $, angular, domReady) {
        domReady(function (doc) {
            angular.bootstrap(doc, ["app"]);
            angular.resumeBootstrap();
        });

    });
}());
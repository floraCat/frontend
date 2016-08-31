define([
    "jquery",
    "angular",
    './commons/includes'
], function ($, angular) {
    'use strict';

    var Iconfig = $.extend(true, {}, window.Iconfig);
    return angular.module('app', [


        /*
         * Shared modules
         */
        // 'app.core.config',
        'app.router',


        /*
         * Feature areas
         */
        //'app.animations',
        //'app.services',
        // 'app.filters',
        'app.directives',
        'app.controllers'
    ]);
});

define([
    "jquery",
    "angular",
    "../animations.module"
], function ($, angular) {
    'use strict';
    var aModule = angular.module('app.animations');
    aModule.animation('.app-ui-view-root-animation', appUiViewRootAnimation);

    appUiViewRootAnimation.$inject = ['$animateCss'];
    function appUiViewRootAnimation($animateCss) {

        var animate = {
            enter: enter,
            leave: leave
        };

        return animate;

        //----------------------------------------------------------------------------------------------------------------------------------//
        function enter(element, doneFn) {
            var runner = $animateCss(element, {
                event: 'enter',
                structural: true
            }).start();
            runner.done(function () {
                $("body").removeClass("app-body-overflowed");
                doneFn
            });
            return runner;
        }

        function leave(element, doneFn) {
            $("body").addClass("app-body-overflowed");
            var runner = $animateCss(element, {
                event: 'leave',
                structural: true
            }).start();
            runner.done(doneFn);
            return runner;
        }

        //----------------------------------------------------------------------------------------------------------------------------------//

    }

    return aModule;
});

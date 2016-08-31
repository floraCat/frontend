define([
    "jquery",
    "angular"
], function ($, angular) {
    'use strict';

    var aModule = angular.module('app.directives');
    aModule.directive('appForm2', function(){
    	return{
	    	replace:false,
	        templateUrl:"tpls/form.html",

    	}
    });

    return aModule;
});

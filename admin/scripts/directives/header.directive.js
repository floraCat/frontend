define([
    "jquery",
    "angular"
], function ($, angular) {
    'use strict';

    var aModule = angular.module('app.directives');
    aModule.directive('appHeader', function(){
    	return{
    		restrict:'EA',
	    	replace:true,
	        templateUrl:"tpls/header.html"
    	}
    });

    return aModule;
});

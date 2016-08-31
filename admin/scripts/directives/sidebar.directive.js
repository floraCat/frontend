define([
    "jquery",
    "angular"
], function ($, angular) {
    'use strict';

    var aModule = angular.module('app.directives');
    aModule.directive('appSidebar', function(){
    	return{
    		restrict:'EA',
	    	replace:true,
	        templateUrl:"tpls/sidebar.html"
    	}
    });

    return aModule;
});

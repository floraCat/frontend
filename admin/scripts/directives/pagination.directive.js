define([
    "jquery",
    "angular"
], function ($, angular) {
    'use strict';

    var aModule = angular.module('app.directives');
    aModule.directive('appPagination', function(){
    	return{
    		restrict:'EA',
            transclude: true,
	    	replace:true,
	        templateUrl:"tpls/pagination.html"
    	}
    });

    return aModule;
});

define([
    "jquery",
    "angular"
], function ($, angular) {
    'use strict';

    var aModule = angular.module('app.directives');
    aModule.directive('appFooter', function(){
    	return{
    		restrict:'EA',
	    	replace:true,
	        templateUrl:"tpls/footer.html"
    	}
    });

    return aModule;
});

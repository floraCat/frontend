define([
    'jquery',
    'angular'
],function($,angular){
    'use strict';
    
    var aModule=angular.module('app.controllers');

    aModule.controller("listController",[
    	'$scope','httpService',
    	function($scope,httpService){
    		httpService.getPullRequests()
    		.then(function(data){
                console.log(data[0].id);
    			$scope.getPullRequests=data;
    		});
    	}
    ])
    .factory('httpService',[
    	'$q','$http',
    	function($q,$http){
    		var getPullRequests=function(){
    			var deferred=$q.defer();
    			$http.get("plus.php")
    			.success(function(data){
                    deferred.resolve(data);
    				//console.log(data);
    			})
    			.error(function(reason){
    				deferred.reject(reason);
    			})
    			return deferred.promise;
    		}
    		return {
    			getPullRequests:getPullRequests
    		}

    	}
    ]);

    return aModule;

});
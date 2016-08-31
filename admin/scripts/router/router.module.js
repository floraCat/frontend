define([
	'jquery',
	'angular',
	'angularUiRouter'
],function(){
	'use strict';
	var aModule=angular.module("app.router",[
			'ui.router',
		])
			.config(function($stateProvider,$urlRouterProvider){
				$urlRouterProvider.when('', '/home');
				$stateProvider
					.state('admin',{
						abstract:true,
						templateUrl:'views/layout.html'
					})
					.state('admin.home',{
						url:'/home',
						views:{
							'content@admin':{
								templateUrl:'views/home.html'
							}
						}
					})
					.state('admin.list',{
						url:'/list',
						views:{
							'content@admin':{
								templateUrl:'views/list.html',
								controller:'listController'
							}
						}
					})
			});






	// aModule
	// 	.config(configure),
	// 	.run(runner)
	// ;

	// //-------------------------------------------------------------------------//
	// configure.$inject=[];
	// function configure(){
	// }

	// runner.$inject=[];
	// function runner(){
		
	// }


	// //-------------------------------------------------------------------------//
	// return aModule;




});
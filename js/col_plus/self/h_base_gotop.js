
/*
 * 插件名称：返回顶部
 * 监听属性：'data-js-gotop'
 * 简介：滚动一定距离后显示，点击后返回顶部
 * 参数说明：
 *   - 'data-js-gotop'的值为多个参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2；
 *   - @param1：<Number> 控件显示的滚动距离（可选）
 *   - @param2: <Number> 返回顶部时的速度（可选）
 * 其他：
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'返回顶部'模块
	var modeName="[data-js-gotop]";


	//监听
	$(window).on("load",function(){
		var $val=$(modeName).data("js-gotop");
		var $arr=$val.split("|");
		var dist=$arr[0];//控件显示的滚动距离
		var speed=$arr[1];//返回顶部时的速度
		dist=dist?dist:0;
		speed=speed?speed:1;
		if(dist==0){
			$(modeName).show();
		}
		if($(this).scrollTop()>dist){
			$(modeName).fadeIn();
		}
		if($val!=""){
			$(window).scroll(function(){
				if($(this).scrollTop()>dist){
					$(modeName).fadeIn();
				}else{
					$(modeName).fadeOut();
				}
			});	
		}
		$(modeName).on("click",function(){
			$("html,body").animate({scrollTop: 0},0);		
		});
	});


})();


/*
 * 插件名称：hover下拉
 * 监听属性：'data-js-hover'
 * 简介：鼠标滑入下拉显示，鼠标划出下拉隐藏
 * 参数说明：
 *   - 'data-js-hover'无值；
 * 原理：
 *   - 鼠标滑入时this加类.open；
 *   - 鼠标划出时删掉.open
 * 样式设置：
 *   - 下拉层默认隐藏；
 *   - .open下的下拉层显示
 * 其他：
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'hover下拉'模块
	var modeName="[data-js-hover]";

	//显示模式
	$.fn.showMode=function(){
		$(this).stop(false,false).fadeIn();
		return this;
		//.dequeue()
	}
	//隐藏模式
	$.fn.hideMode=function(){
		$(this).stop(false,false).fadeOut();
		return this;
	}


	//监听
	$(window).on("load",function(){
		$(modeName).each(function(){
			var $val=$(this).data("js-hover");
			var $arr=$val.split("|");
			var key=$arr[0];//触发器组容器
			var opts=$arr[1];//显隐层组容器
			$(this).on("mouseover",function(){
				$(this).find(key).addClass("on");
				$(this).find(opts).showMode();
			});
			$(this).on("mouseleave",function(){
				$(this).find(key).removeClass("on");
				$(this).find(opts).hideMode();
			});
		});


	});


})();

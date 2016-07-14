
/*
 * 插件名称：hover下拉显隐
 *
 * 监听属性：'data-js-hover'
 *
 * 简介：鼠标滑入下拉显示，鼠标划出下拉隐藏
 *
 * 参数说明：
 * 'data-js-hover'无值；
 * 
 * 原理：
 * mouseover时this加类.open；mouseout时删掉.open
 * 默认下拉层隐藏；设置.open时内部下拉层显示
 *
 * 其他：
 * #兼容chorme,firefox,ie
 */


+(function(){


	//'hover显隐'模块
	var modeName="[data-js-hover]";


	//监听
	$(window).on("load",function(){
		$(modeName).each(function(){
			$(this).on("mouseover",function(){
				$(this).addClass("open");
			});
			$(this).on("mouseout",function(){
				$(this).removeClass("open");
			});
		});
	});


})();

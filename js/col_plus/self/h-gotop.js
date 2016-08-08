
/*
 * 插件名称：返回顶部
 * 监听属性：'data-js-gotop'
 * 插件描述：（滚动一定距离后显示，）点击后返回顶部
 * 参数说明：
 *   - 'data-js-gotop'的值为两个（可选）参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2；
 *   - @param1：<Number> 控件显示的滚动距离（可选）
 *   - @param2: <Number> 返回顶部时的速度（可选）
 * 其他说明：
  *   - param1/param2的参数值为纯数值，每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'返回顶部'模块
	var _pluginName="[data-js-gotop]";


	//监听
	$(window).on("load",function(){
		var _val=$(_pluginName).data("js-gotop");
		var _arr=_val.split("|");
		var _dist=_arr[0];//控件显示的滚动距离
		var _speed=_arr[1];//返回顶部时的速度
		_dist=_dist?_dist:0;
		_speed=_speed?_speed:1;
		if(_dist==0){
			$(_pluginName).show();
		}
		if($(this).scrollTop()>_dist){
			$(_pluginName).fadeIn();
		}
		if(_val!=""){
			$(window).scroll(function(){
				if($(this).scrollTop()>_dist){
					$(_pluginName).fadeIn();
				}else{
					$(_pluginName).fadeOut();
				}
			});	
		}
		$(_pluginName).on("click",function(){
			$("html,body").animate({scrollTop: 0},0);		
		});
	});


})();

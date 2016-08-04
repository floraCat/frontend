
/*
 * 插件名称：hover下拉框
 * 监听属性：'data-js-hover'
 * 插件描述：鼠标滑入下拉显示，鼠标划出下拉隐藏
 * 参数说明：
 *   - 'data-js-hover'的值为三个(最后一个可选)参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发按键（必需）
 *   - @param2:下拉框（必需）
 *   - @param3:下拉框显示模式（可选）
 * 基本原理：
 *   - 鼠标滑入触发按键加类名.on，下拉框加类名.active同时显示
 *   - 鼠标划出时所添加的类名删除，同时下拉框隐藏
 * 其他说明：
 *   - param1/param2的参数值为所有可行的css选择器，如（.cls,#id,p,>a,[data-role]等），每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'hover下拉框'模块
	var _pluginName="[data-js-hover]";


	//监听
	$(window).on("load",function(){
		$(_pluginName).each(function(){
			var _val=$(this).data("js-hover");
			var _arr=_val.split("|");
			var _key=_arr[0];//触发按键
			var _drop=_arr[1];//下拉框
			var _showMode=_arr[2];//下拉框显示模式
			$(this).on("mouseover",function(){
				$(this).find(_key).addClass("active");
				if(_showMode=="fade"){
					$(this).find(_key).addClass("on");
					$(this).find(_drop).addClass("active").fadeIn();
				}else{
					$(this).find(_key).addClass("on");
					$(this).find(_drop).addClass("active").show();
				}
			});
			$(this).on("mouseleave",function(){
				$(this).find(_key).removeClass("on");
				$(this).find(_drop).removeClass("active").hide();
			});
		});
	});


})();

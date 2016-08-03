
/*
 * 插件名称：下拉框
 * 监听属性：'data-js-dropdown'
 * 简介：模拟默认的下拉框
 * 参数说明：
 *   - 'data-js-dropdown'的值为多个参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发按键（必需）
 *   - @param2:下拉框（必需）
 *   - @param3:多个下拉框的父级，参数无值时为单个下拉框（可选）
 *   - 所有参数可以是类名如'.clsName'，也可以是属性名如'p'
 * 其他：
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'下拉框'模块
	var modeName="[data-js-dropdown]";


	//监听
	$(window).on("load",function(){
		$(modeName).each(function(){
			var $val=$(this).data("js-dropdown");
			var $arr=$val.split("|");
			var key=$arr[0];
			var opts=$arr[1];
			var parent=$arr[2]?$arr[2]:'';
			$(this).on("click",function(ev){
				dropdown_click($(this),key,opts,parent,ev);
			});
		});
	});


	//下拉操作 __运用事件委托
	var dropdown_click=function($this,key,opts,parent,ev){
		var target=ev.target;
		if(key.indexOf(".")>=0){//类名
			var isKey=$(target).attr("class").indexOf(key.substr(1))>=0?true:false;
		}else{//属性名
			var isKey=target.nodeName.toLowerCase()==key?true:false;
		}
		if(isKey){//target是key
			var $key=$(target);
			var $parent=parent?$key.closest(parent):$this;
			var $option=$parent.find(opts);
			if(!$key.hasClass("on")){
				cleanUp();
				$key.addClass("on");
				$option.addClass("h_show").show();
				$option.scrollTop(0);

				if(ev && ev.stopPropagation){ ev.stopPropagation();}
				else{ ev.cancelBubble=true;}
				$(document).on("click",function(ev2){
					var target2=ev2.target;
					if($(target2).attr("data")=="js-dropdown" || $(target2).parents("[data-js-dropdown]").length>0){
					}else{
						cleanUp();
						ev2.preventDefault();
						$(document).off("click");
					}
				});
			}else{ cleanUp();}
		}	
	}


	//还原
	var cleanUp=function(){
		$(modeName).find(".on").removeClass("on");
		$(".h_show").hide().removeClass("h_show");
		$(document).off("keydown");
	}


})();

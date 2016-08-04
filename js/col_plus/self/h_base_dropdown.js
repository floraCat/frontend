
/*
 * 插件名称：点击下拉框
 * 监听属性：'data-js-dropdown'
 * 插件描述：模拟默认的下拉框
 * 参数说明：
 *   - 'data-js-dropdown'的值为三个(最后一个可选)参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发按键（必需）
 *   - @param2:下拉框（必需）
 *   - @param3:下拉框显示模式（可选）
 * 基本原理：
 *   - 点击触发按键加类名.on，下拉框加类名.active同时显示
 *   - 下拉框显示的前提下点击下拉框不隐藏，点击触发按键或空白处时下拉框隐藏
 * 其他说明：
 *   - param1/param2的参数值为所有可行的css选择器，如（.cls,#id,p,>a,[data-role]等），每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'点击下拉框'模块
	var _pluginName="[data-js-dropdown]";


	//监听
	$(window).on("load",function(){
		$(_pluginName).each(function(){
			var _val=$(this).data("js-dropdown");
			var _arr=_val.split("|");
			var _key=_arr[0];//触发按键
			var _drop=_arr[1];//下拉框
			var _showMode=_arr[2];//下拉框显示模式
			$(this).on("click",function(ev){
				dropClick($(this),_key,_drop,_showMode,ev);
			});
		});
	});


	//下拉操作 + 点击空白处隐藏
	var dropClick=function($this,_key,_drop,_showMode,ev){
		var _target=ev.target;
		if(_key.indexOf(".")>=0){//_key为类名
			var _isKey=$(_target).attr("class").indexOf(_key.substr(1))>=0?true:false;
		}else{//_key为属性名
			var _isKey=_target.nodeName.toLowerCase()==_key?true:false;
		}
		if(_isKey){//target是_key
			var _keyCur=$(_target);
			var _dropCur=$this.find(_drop);
			if(!_keyCur.hasClass("on")){
				cleanUp();
				_keyCur.addClass("on");
				if(_showMode=="fade"){
					_dropCur.addClass("active").fadeIn();
				}else{
					_dropCur.addClass("active").show();
				}
				_dropCur.scrollTop(0);
				ev.stopPropagation();//防冒泡，即防止点击_pluginName时同时也触发了下面的document点击事件（虽然此例不影响表面效果）
				$(document).on("click",function(ev2){
					var _target2=ev2.target;
					if($(_target2).attr("data")=="js-dropdown" || $(_target2).parents("[data-js-dropdown]").length>0){
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
		$(_pluginName).find(".on").removeClass("on");
		$(_pluginName).find(".active").hide().removeClass("active");
	}


})();

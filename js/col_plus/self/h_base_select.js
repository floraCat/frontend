
/*
 * 插件名称：自定义选项框
 * 监听属性：'data-js-select'
 * 插件描述：模拟默认的选项框
 * 参数说明：
 *   - 'data-js-select'的值为三个（最后一个可选）参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发按键（必需）
 *   - @param2:下拉选项框（必需）
 *   - @param3:下拉选项框显示模式（可选）
 * 其他说明：
 *   - 触发按键和下拉选项必需带有属性'data-val'
 *   - param1/param2的参数值为所有可行的css选择器，如（.cls,#id,p,>a,[data-role]等），每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'自定义选项框'模块
	var _pluginName="[data-js-select]";


	//监听
	$(window).on("load",function(){
		$(_pluginName).each(function(){
			var _val=$(this).data("js-select");
			var _arr=_val.split("|");
			var _key=_arr[0];//触发按键
			var _drop=_arr[1];//下拉选项框
			var _showMode=_arr[2];//显隐模式
			selectDefault($(this),_key,_drop);
			$(this).on("click",function(ev){
				selectClick($(this),_key,_drop,_showMode,ev);
			});
		});
	});


	//自动补全默认值
	var selectDefault=function($this,_key,_drop){
		$this.each(function(){
			var _keyDef=$(this).find(_key);
			var _dropDef=$(this).find(_drop);
			if(_dropDef.find(".selected").length>0){//默认值：1-先考虑.selected
				var _val=_dropDef.find(".selected").attr("data-val");
				var _txt=_dropDef.find(".selected").text();
				_keyDef.attr("data-val",_val).text(_txt);
			}else if(!_keyDef.text() && !_keyDef.attr("data-val")){//默认值：2-如text和data都没,最后考虑第一个选项
				var _val=_dropDef.find("[data-val]").eq(0).attr("data-val");
				var _txt=_dropDef.find("[data-val]").eq(0).text();
				_keyDef.attr("data-val",_val).text(_txt);
			}
		});
	}


	//下拉操作 + 点击空白处隐藏
	var selectClick=function($this,_key,_drop,_showMode,ev){
		var _target=ev.target;


		// if(_key.indexOf(".")>=0){//_key类名
		// 	if($(_target).attr("class")){
		// 		var _isKey=$(_target).attr("class").indexOf(_key.substr(1))>=0?true:false;
		// 	}else{ var _isKey=false;}
		// }else{//_key属性名
		// 	var _isKey=_target.nodeName.toLowerCase()==_key?true:false;
		// }


		if(_drop.indexOf(".")>=0){//_drop类名
			if($(_target).attr("class")){
				var _isDrop=$(_target).attr("class").indexOf(_drop.substr(1))>=0?true:false;
			}else{ var _isDrop=false;}
		}else{//_drop属性名
			var _isDrop=_target.nodeName.toLowerCase()==_drop?true:false;
		}
console.log(_isDrop);

		if($(_target).parents("[data-js-select]").length>0 && _isDrop==false){//_target是_key
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
				optionClick(_keyCur,_dropCur);//点击选项
				selectKeydown(_dropCur,_keyCur);//键盘操作
				ev.stopPropagation();//防冒泡，即防止点击_pluginName时同时也触发了下面的document点击事件
				$(document).on("click",function(ev2){
					cleanUp();
					ev2.preventDefault();
					$(document).off("click");
				});
			}else{ cleanUp();}
		}	
	}


	//点击选项
	var optionClick=function(_keyCur,_dropCur){
		_dropCur.on("click","[data-val]",function(){
			var _txt=$(this).text();
			var _data=$(this).data("val");
			_keyCur.attr("data-val",_data).text(_txt);	
			$(this).addClass("selected").siblings("[data-val]").removeClass("selected");
			cleanUp();
		});
	}


	//键盘操作
	var selectKeydown=function(_dropCur,_keyCur){
		$(document).on("keydown",function(ev){
			ev.preventDefault();
			ev.stopPropagation();
			var _index=_dropCur.find(".selected")._index();
			var _items=_dropCur.find("[data-val]");
			if (ev.which == 38 && _index > 0) _index--;//向上
			if (ev.which == 40 && _index < _items.length-1) _index++;//向下			
			_items.eq(_index).addClass("selected").siblings().removeClass("selected");
			_keyCur.text(_items.eq(_index).text()).attr("data-val",_items.eq(_index).data("val"));
			var _curKey=ev.which || ev.keyCode || ev.charCode;
			if(_curKey==13 || _curKey==27){ cleanUp();}// 确认键 || Esc键
		});
	}


	//还原
	var cleanUp=function(){
		$(_pluginName).find(".on").removeClass("on");
		$(_pluginName).find(".active").hide().removeClass("active");
		$(document).off("keydown");
	}


})();

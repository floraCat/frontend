
/*
 * 插件名称：切换卡
 * 监听属性：'data-js-tabs'
 * 插件描述：多个显隐层选择触发切换
 * 参数说明：
 *   - 'data-js-tabs'的值为三个（最后一个可选）参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发器组容器（必需）
 *   - @param2:显隐层组容器（必需）
 *   - @param3:显隐层显示模式（可选）
 * 其他说明：
 *   - param1/param2的参数值为所有可行的css选择器，如（.cls,#id,p,>a,[data-role]等），每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'切换卡'模块
	var _pluginName="[data-js-tabs]";


	//监听
	$(window).on("load",function(){
		$(_pluginName).each(function(){
			var _val=$(this).data("js-tabs");
			var _arr=_val.split("|");
			var _keys=_arr[0];//触发器组容器
			var _drops=_arr[1];//显隐层组容器
			var _showMode=_arr[2];//显隐层显示模式
			tabDefault($(this),_keys,_drops,_showMode);
			$(this).on("click",function(ev){
				tabClick($(this),_keys,_drops,_showMode,ev);
			});
		});
	});


	//.on对应index的层显示
	var tabDefault=function($this,_keys,_drops,_showMode){
		$this.each(function(){
			var _indexCur=$(this).find(_keys+" .on").index();
			_indexCur=_indexCur>=0?_indexCur:0;
			if(_showMode=="fade"){
				$(this).find(_drops).children().eq(_indexCur).fadeIn().siblings().hide();
			}else{
				$(this).find(_drops).children().eq(_indexCur).show().siblings().hide();
			}
		});
	}


	//切换操作
	var tabClick=function($this,_keys,_drops,_showMode,ev){
		var _target=ev.target;
		var _isKey=$(_target).parents(_keys).length>0?true:false;
		if(_isKey==true){//target在_keys内
			var _keysCur=$(_target).parent().children().length<=1?$(_target).parent():$(_target);
			if(!_keysCur.hasClass("on")){
				var _indexCur=_keysCur.index();
				var _dropsCur=$this.find(_drops);
				_keysCur.addClass("on").siblings().removeClass("on");
				if(_showMode=="fade"){
					_dropsCur.children().eq(_indexCur).fadeIn().siblings().hide();
				}else{
					_dropsCur.children().eq(_indexCur).show().siblings().hide();
				}
			}
		}	
	}


})();

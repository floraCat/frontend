
/*
 * 插件名称：模态弹出层
 * 监听属性：'data-js-modal'
 * 插件描述：带覆盖层的大尺寸弹出层
 * 参数说明：
 *   - 'data-js-modal'的值为四个（最后两个可选）参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3|param4；
 *   - @param1:触发按键（必需）
 *   - @param2:模态弹出层（必需）
 *   - @param3:模态弹出层内的退出按键（可选）
 *   - @param4:模态弹出层显示模式（可选）
 * 其他说明：
 *   - param1/param2/param3的参数值为所有可行的css选择器，如（.cls,#id,p,>a,[data-role]等），每个参数不需要用引号包裹
 *   - 兼容chorme,firefox,ie
 */


+(function(){

	'use strict';

	//'模态弹出层'模块
	var _pluginName="[data-js-modal]";

	//自定义参数
	var _maskColor="#333";//覆盖层底色
	var _maskOpacity=".3";//覆盖层透明度


	//监听
	$(window).on("load",function(){
		$(_pluginName).each(function(){
			var _val=$(this).data("js-modal");
			var _arr=_val.split("|");
			var _btn=_arr[0];//触发按键
			var _modal=_arr[1];//模态弹出层
			var _quit=_arr[2];//模态弹出层内的退出按键
			var _showMode=_arr[3];//模态弹出层显示模式
			$(this).on("click",function(ev){
				modalClick($(this),_btn,_modal,_quit,_showMode,ev);
			});
		});
	});


	//弹出操作 + 点击空白处隐藏
	var modalClick=function($this,_btn,_modal,_quit,_showMode,ev){
		var _target=ev.target;
		if(_btn.indexOf(".")>=0){//_btn为类名
			if($(_target).attr("class")){
				var _isBtn=$(_target).attr("class").indexOf(_btn.substr(1))>=0?true:false;
			}else{ var _isKey=false;}
		}else{//_btn为属性名
			var _isBtn=_target.nodeName.toLowerCase()==_btn?true:false;
		}
		if(_isBtn){//target是_btn
			var _btnCur=$(_target);
			var _modalCur=$this.find(_modal);
			if(_showMode=="fade"){
				_modalCur.addClass("active").fadeIn();
			}else{
				_modalCur.addClass("active").show();
			}
			$this.append('<i class="j-mask" style=" position:fixed; top:0; left:0; z-index:99; width:100%; height:100%; opacity:'+_maskOpacity+'; filter:alpha(opacity='+_maskOpacity*100+'); background:'+_maskColor+'"></i>');
			_modalCur.css({"position":"fixed","z-index":"999","top":0,"left":0,"width":"100%","height":"100%","overflow-y":"auto"});
			var _innerDiv=_modalCur.children().eq(0);//_target内第一个children
			_innerDiv.addClass("j-inner").css({"position":"relative","margin-left":"auto","margin-right":"auto"});
			var _inHeight=_innerDiv.outerHeight();
			var _winHeight=$(window).height();
			if(_inHeight<_winHeight-30){
				var _distTop=(_winHeight-_inHeight)/2;
				_innerDiv.css("margin-top",_distTop);
			}else{
				_innerDiv.css({"margin-top":"30px","margin-bottom":"30px"});
			}
			$("html").css({"overflow-y":"hidden"});	
			$this.find(_quit).click(function(){
				cleanUp();
			});
			_modalCur.on("click",function(ev2){
				var _target2=ev2.target;
				if($(_target2).is(_innerDiv) || $(_target2).parents(".j-inner").length>0){
				}else{
					cleanUp();
				}
			});
		}	
	}


	//还原
	var cleanUp=function(){
		$("body .j-mask").remove();
		$(_pluginName).find(".on").removeClass("on");
		$(_pluginName).find(".active").hide().removeClass("active");
		$(_pluginName).find(".j-inner").removeClass("j-inner");
		$(document).off("keydown");
		$("html").css({"overflow-y":"auto"});
	}


})();

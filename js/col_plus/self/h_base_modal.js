
/*
 * 插件名称：模态弹出层
 * 监听属性：'data-js-modal'
 * 简介：带覆盖层的大尺寸弹出层
 * 参数说明：
 *   - 'data-js-modal'的值为多个参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 *   - @param1:触发按键（必需）
 *   - @param2:弹出层（必需）
 *   - @param3:弹出层内的退出按键（可选）
 *   - 所有参数可以是类名如'.clsName'，也可以是属性名如'p'
 * 其他：
 *   - 兼容chorme,firefox,ie
 *   - body被冻结（覆盖层底部不能点击和滚动）
 *   - 弹出层超出屏幕高度可上下滚动
 */


+(function(){

	'use strict';

	//'下拉框'模块
	var modeName="[data-js-modal]";

	//自定义参数
	var $color_mask="#333";//覆盖层底色
	var $opacity_mask=".3";//覆盖层透明度


	//监听
	$(window).on("load",function(){
		$(modeName).each(function(){
			var $val=$(this).data("js-modal");
			var $arr=$val.split("|");
			var btn=$arr[0];
			var dialog=$arr[1];
			var quit=$arr[2];
			$(this).on("click",function(ev){
				modal_click($(this),btn,dialog,quit,ev);
			});
		});
	});


	//弹出操作 __运用事件委托
	var modal_click=function($this,btn,dialog,quit,ev){
		var target=ev.target;
		if(btn.indexOf(".")>=0){
			if($(target).attr("class")){
				var isBtn=$(target).attr("class").indexOf(btn.substr(1))>=0?true:false;
			}else{ var isBtn=false;}
		}else{
			var isBtn=target.nodeName.toLowerCase()==btn?true:false;
		}
		if(isBtn){
			var $btn=$(target);
			var $target=$this.find(dialog);
			$target.addClass("h_show").show();
			$this.append('<i id="h_mask" style=" position:fixed; top:0; left:0; z-index:99; width:100%; height:100%; opacity:.8; filter:alpha(opacity=80); background:'+$color_mask+'"></i>');
			$target.css({"position":"fixed","z-index":"999","top":0,"left":0,"width":"100%","height":"100%","overflow-y":"auto"});
			var $inner=$target.children().eq(0);//target内第一个children
			$inner.addClass("h_inner").css({"position":"relative","margin-left":"auto","margin-right":"auto"});
			var h_inner=$inner.outerHeight();
			var h_window=$(window).height();
			if(h_inner<h_window-30){
				var margin_top=(h_window-h_inner)/2;
				$inner.css("margin-top",margin_top);
			}else{
				$inner.css({"margin-top":"30px","margin-bottom":"30px"});
			}
			$("html").css({"overflow-y":"hidden"});	
			$this.find(quit).click(function(){
				cleanUp();
			});
			//点弹出层其他地方隐藏
			$target.on("click",function(ev2){
				var target2=ev2.target;
				if($(target2).is($inner) || $(target2).parents(".h_inner").length>0){
				}else{
					cleanUp();
				}
			});
		}	
	}


	//还原
	var cleanUp=function(){
		$("body #h_mask").remove();
		$(modeName).find(".on").removeClass("on");
		$(".h_show").hide().removeClass("h_show");
		$(".h_inner").removeClass("h_innerW");
		$(document).off("keydown");
		$("html").css({"overflow-y":"auto"});
	}


})();

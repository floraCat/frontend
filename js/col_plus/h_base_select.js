
/*
 * 插件名称：自定义选项框
 *
 * 监听属性：'data-js-select'
 *
 * 简介：模拟默认的选项框
 *
 * 参数说明：
 * 'data-js-select'的值为多个参数组合的字符串，每个参数用'|'隔开，格式如：param1|param2|param3；
 * @param1:触发按键（必需）
 * @param2:下拉层（必需）
 * @param3:多个下拉框的父级，参数无值时为单个下拉框（可选）
 * 所有参数可以是类名如'.clsName'，也可以是属性名如'p'
 *
 * 其他：
 * #兼容chorme,firefox,ie
 */


+(function(){


	//'下拉框'模块
	var modeName="[data-js-select]";


	//监听
	$(window).on("load",function(){
		$(modeName).each(function(){
			var $val=$(this).data("js-select");
			var $arr=$val.split("|");
			var key=$arr[0];
			var opts=$arr[1];
			var parent=$arr[2]?$arr[2]:'';
			select_default(key,opts,parent);
			$(this).on("click",function(ev){
				select_click($(this),key,opts,parent,ev);
			});
		});
	});


	//自动补全默认值
	var select_default=function(key,opts,parent){
		$(parent).each(function(){
			$key_cur=$(this).find(key);
			$opts_cur=$(this).find(opts);
			if($opts_cur.find(".selected").length>0){//默认值：1-先考虑.selected
				$val=$opts_cur.find(".selected").attr("data-val");
				$txt=$opts_cur.find(".selected").text();
				$key_cur.attr("data-val",$val).text($txt);
			}else if(!$key_cur.text() && !$key_cur.attr("data-val")){//默认值：2-如text和data都没,最后考虑第一个选项
				$val=$opts_cur.find("[data-val]").eq(0).attr("data-val");
				$txt=$opts_cur.find("[data-val]").eq(0).text();
				$key_cur.attr("data-val",$val).text($txt);
			}
		});
	}


	//下拉操作 __运用事件委托
	var select_click=function($this,key,opts,parent,ev){
		var ev=ev || window.event;
		var target=ev.target || ev.srcElement;

		if(key.indexOf(".")>=0){//类名
			isKey=$(target).attr("class").indexOf(key.substr(1))>=0?true:false;
		}else{//属性名
			isKey=target.nodeName.toLowerCase()==key?true:false;
		}
		if(isKey){//target是key
			$key=$(target);
			$parent=parent?$key.closest(parent):$this;
			$option=$parent.find(opts);
			if(!$key.hasClass("on")){
				cleanUp();
				$key.addClass("on");
				$option.addClass("h_show").show();
				$option.scrollTop(0);
				select_select($key,$option,$parent);
				select_keydown($option,$key);

				if(ev && ev.stopPropagation){ ev.stopPropagation();}
				else{ ev.cancelBubble=true;}
				$(document).on("click",function(ev2){
					cleanUp();
					ev2.preventDefault();
					$(document).off("click");
				});
			}else{ cleanUp();}
		}	
	}


	//点击选中
	var select_select=function($key,$option,$parent){
		$option.on("click","[data-val]",function(){
			var txt=$(this).text();
			var data=$(this).data("val");
			$key.attr("data-val",data).text(txt);	
			$(this).addClass("selected").siblings("[data-val]").removeClass("selected");
			cleanUp();
		});
	}


	//键盘操作
	var select_keydown=function($option,$key){
		$(document).on("keydown",function(e){
			e.preventDefault();
			e.stopPropagation();
			var index=$option.find(".selected").index();
			var $items=$option.find("[data-val]");
			if (e.which == 38 && index > 0) index--;//向上
			if (e.which == 40 && index < $items.length-1) index++;//向下			
			$items.eq(index).addClass("selected").siblings().removeClass("selected");
			$key.text($items.eq(index).text()).attr("data-val",$items.eq(index).data("val"));
			var curKey=e.which || e.keyCode || e.charCode;
			if(curKey==13 || curKey==27){ cleanUp();}// 确认键 || Esc键
		});
	}


	var cleanUp=function(){
		$(modeName).find(".on").removeClass("on");
		$(".h_show").hide().removeClass("h_show");
		$(document).off("keydown");
	}


})();

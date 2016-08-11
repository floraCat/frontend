
/*
 * 插件名称：提示弹窗
 * 插件描述：可配置多种常用的提示弹窗
 * 参数说明：
 *   - @data_id:弹窗的识别ID
 *   - @icon:提示图标的类名
 *   - @title:标题
 *   - @note: 提示信息：文本|定位 [例：'弹窗提示信息|center']
 *   - @setTime: 倒计时：毫秒数
 *   - @btn: 按键：文本|定位|data-role值|底色|字色|边线色|链接 [例：'确定|right|confirm|#89b632|white|#89b632|http://www.baidu.com']
 *   - @btn2: 按键2：文本|定位|data-role值|底色|字色|边线色|链接 [例：'取消|left|cancel|#fff|#529d20|#beda84']
 *   - @icon_quit: 弹窗退出图标定位
 *   - @callback: 回调函数
 * 其他说明：
 *   - 兼容chorme,firefox,ie
 */


;(function($){

	'use strict';
	alert(111);

	//自定义参数
	var _maskColor="#333";//覆盖层底色
	var _maskOpacity=".3";//覆盖层透明度


	$.jDialog=function(_opts){

		var _defaults={
			data_id:'1', //识别id
			icon:'', //图标：class名（在style里添加对应的样式,'icon_ok'已有样式）
			title:'提示标题', //标题
			note:'弹窗提示信息', //提示信息：文本|定位 [例：'弹窗提示信息|center']
			setTime:'', //倒计时：毫秒数
			btn:'', //按键：文本|定位|data-role值|底色|字色|边线色|链接 [例：'确定|right|confirm|#89b632|white|#89b632|http://www.baidu.com']
			btn2:'', //按键2：文本|定位|data-role值|底色|字色|边线色|链接 [例：'取消|left|cancel|#fff|#529d20|#beda84']
			icon_quit:'right', //退出x：定位
			callback:function(){} //回调
		}
		var _opts=$.extend(_defaults,_opts);
	
		//图标
		if(_opts.icon){
			var _htmlIcon='<div class="icon '+_opts.icon+'"></div>';
		}else{var _htmlIcon='';}

		//标题
		if(_opts.title){
			var _htmlTitle='<p class="title">'+_opts.title+'</p>';
		}else{ var _htmlTitle='';}

		//提示
		if(_opts.note){
			var _note=_opts.note.split('|');
			var _htmlNote='<p class="note" style="text-align:'+_note[1]+'">'+_note[0]+'</p>';
		}else{ var _htmlNote='';}

		//倒计时秒数
		if(_opts.setTime){
			var _setTime=_opts.setTime/1000;
			var _htmlSetTime='<p class="setTime">本窗口<span>'+_setTime+'</span>s后自动关闭</p>';
		}else{ var _htmlSetTime='';}

		//按键
		if(_opts.btn){
			var _btn=_opts.btn.split('|');
			if(_btn[6]){ 
				var _link='href="'+_btn[6]+'"';
			}else{ var _link='';}
			var _htmlBtn='<a data-role="'+_btn[2]+'" class="btn '+_btn[1]+'" '+_link+' style="background:'+_btn[3]+'; color:'+_btn[4]+'; border:'+_btn[5]+' 1px solid;">'+_btn[0]+'</a>';			
		}else{ var _htmlBtn='';}
		
		//按键2[如有]
		if(_opts.btn2){
			var _btn2=_opts.btn2.split('|');
			if(_btn2[6]){ 
				var _link2='href="'+_btn2[6]+'"';
			}else{ var _link2='';}
			var _htmlBtn2='<a data-role="'+_btn2[2]+'" class="btn '+_btn2[1]+'" '+_link2+' style="background:'+_btn2[3]+'; color:'+_btn2[4]+'; border:'+_btn2[5]+' 1px solid;">'+_btn2[0]+'</a>';
		}else{ var _htmlBtn2='';}

		//退出x
		if(_opts.icon_quit){
			var _htmlQuit='<div class="quit '+_opts.icon_quit+'"></div>';
		}

		//弹窗html结构
		var _htmlAll = '<div class="mDialog" data-js-dialog="'+_opts.data_id+'">'
					+_htmlIcon
					+_htmlTitle
					+_htmlNote
					+_htmlSetTime
					+'<ol class="btns">'
						+_htmlBtn
						+_htmlBtn2
					+'</ol>'
					+_htmlQuit
				+'</div>';


		//添加弹窗到body
		$('body').append(_htmlAll);
		if(_opts.data_id){ var _dataId=$("[data-js-dialog="+_opts.data_id+"]");}
		var _distTop=($(window).height()-150)/2-30;
		_dataId.css("top",_distTop);
		$('html,body').css('overflow-y','hidden');
		

		//添加样式
		$('body').append(
'<style>'
+'.mDialog{ position: fixed; z-index:999; width: 240px; padding: 20px 25px; left: 50%; top: 100px; margin-left: -140px; background-color: #f7f7f7; border-radius: 5px; }'
+'.mDialog .title{ font-size: 14px; font-weight: bold; line-height: 21px; }'
+'.mDialog .note{ font-size: 12px; color: #666; margin-top: 15px;}'
+'.mDialog .setTime{ font-size: 12px; color: #ccc; margin-top: 5px; text-align: center;}'
+'.mDialog .btns{ padding: 0 10px; overflow: hidden; }'
+'.mDialog .btn{ padding: 3px 10px; border-radius: 4px; color: #fff; cursor: pointer;}'
+'.mDialog .btn.left{ float: left; margin-top: 15px; }'
+'.mDialog .btn.right{ float: right; margin-top: 15px; }'
+'.mDialog .quit{ position: absolute; top: -13px; width: 35px; height: 35px; background:url(col_plus/pictures/plus/i_quit.png); background-size: 100%; cursor: pointer;}'
+'.mDialog .quit.left{ left: -13px; }'
+'.mDialog .quit.right{ right: -13px; }'
+'.mDialog .icon{ width: 70px; height: 70px; margin:0 auto 10px;}'
+'.mDialog .icon.icon_ok{ background: url(col_plus/pictures/plus/img_ok.png) no-repeat center; background-size: 100%;}'
+'.mDialog .icon.icon_wrong{ background: url(col_plus/pictures/plus/img_wrong.png) no-repeat center; background-size: 100%;}'
+'</style>');


		//添加覆盖层
		if($("body > .j-mask").length<=0){
			$("body").append('<div class="j-mask" style=" position:fixed; top:0; left:0; z-index:99; width:100%; height:100%; background:'+_maskColor+'; opacity:'+_maskOpacity+'; filter:alpha(opacity='+_maskOpacity*100+');"></div>');
		}
		 

		//取消倒计时
		if(_opts.setTime){
			var _loop=setInterval(function(){
				var _timeCur=_dataId.find(".setTime span").text();
				_timeCur--;
				_dataId.find(".setTime span").text(_timeCur);
				if(_timeCur<0){
					clearInterval(_loop);
					_opts.callback();
					clearUp();
				}
			},1000);
		}	

		//点击退出x
		_dataId.find(".quit").click(function(){
			clearUp();
		});

		//点击data-role值为cancel的按键
		_dataId.find(".btn[data-role=cancel]").click(function(){
			clearUp();
		});

		//回调（点击data-role值为confirm的按键）
		_dataId.find(".btn[data-role=confirm]").click(function(){
			clearUp();
			_opts.callback();
		});

		//退出函数
		var clearUp=function(){
			if(_opts.setTime){ clearInterval(_loop);}
			$("body > .j-mask").remove();
			_dataId.remove();
			$('html,body').css('overflow-y','auto');
		}


	}//jDialog

})(jQuery);



/*
*弹窗
*2016-5-4
 */

(function($){

	$.H_dialog=function(opts){

		var defaults={
			id:'H_dialog', //识别id
			icon:'', //图标：class名（在style里添加对应的样式,'icon_ok'已有样式）
			title:'弹窗标题', //标题
			note:'弹窗提示信息', //提示信息
			setTime:'', //倒计时：毫秒数
			btn:'确定|right|confirm|#89b632|white', //按键：文本|定位|data-role值|底色|字色|边线色
			btn2:'', //按键2：文本|定位|data-role值|底色|字色|边线色|链接 [例：'取消|left|cancel|#fff|#529d20|#beda84']
			icon_quit:'right', //退出x：定位
			callback:function(){} //回调
		}
		var opts=$.extend(defaults,opts);
	
		//图标
		if(opts.icon){
			icon='<div class="icon '+opts.icon+'"></div>';
		}else{icon='';}

		//标题
		if(opts.title){
			title='<p class="title">'+opts.title+'</p>';
		}else{ title='';}

		//提示
		if(opts.note){
			note='<p class="note">'+opts.note+'</p>';
		}else{ note='';}

		//倒计时秒数
		if(opts.setTime){
			setTime=opts.setTime/1000;
			timeNote='<p class="setTime">本窗口<span>'+setTime+'</span>s后自动关闭</p>';
		}else{timeNote='';}

		//按键
		var btn=opts.btn.split('|');
		if(btn[6]){ 
			link='href="'+btn[6]+'"';
		}else{link='';}
		html_btn='<a data-role="'+btn[2]+'" class="btn '+btn[1]+'" '+link+' style="background:'+btn[3]+'; color:'+btn[4]+'; border:'+btn[5]+' 1px solid;">'+btn[0]+'</a>';
		
		//按键2[如有]
		if(opts.btn2){
			var btn2=opts.btn2.split('|');
			if(btn2[6]){ 
				link2='href="'+btn2[6]+'"';
			}else{link2='';}
			html_btn2='<a data-role="'+btn2[2]+'" class="btn '+btn2[1]+'" '+link2+' style="background:'+btn2[3]+'; color:'+btn2[4]+'; border:'+btn2[5]+' 1px solid;">'+btn2[0]+'</a>';
		}else{ html_btn2='';}

		//退出x
		if(opts.icon_quit){
			icon_quit='<div class="quit '+opts.icon_quit+'"></div>';
		}

		//弹窗html结构
		var html = '<div id="'+opts.id+'" class="mDialog">'
					+icon
					+title
					+note
					+timeNote
					+'<ol class="btns">'
						+html_btn
						+html_btn2
					+'</ol>'
					+icon_quit
				+'</div>';


		//添加弹窗到body
		$('body').append(html);
		if(opts.id){ $id=$("#"+opts.id);}
		var top_dialog=(windowHeight()-150)/2;
		$id.css("top",top_dialog);
		$('html,body').css('overflow-y','hidden');
		

		//添加样式
		$('body').append(
'<style>'
+'.mDialog{ position: fixed; z-index:999; width: 200px; padding: 20px 25px; left: 50%; top: 100px; margin-left: -140px; background-color: #f7f7f7; border: #ddd 1px solid; border-radius: 5px; }'
+'.mDialog .title{ font-size: 14px; font-weight: bold; line-height: 21px; }'
+'.mDialog .note{ font-size: 12px; color: #ccc; margin-top: 15px;}'
+'.mDialog .setTime{ font-size: 12px; color: #ccc; margin-top: 15px; text-align: center;}'
+'.mDialog .btns{ padding: 0 15px; overflow: hidden; }'
+'.mDialog .btn{ padding: 3px 10px; border-radius: 4px; color: #fff; cursor: pointer;}'
+'.mDialog .btn.left{ float: left; margin-top: 15px; }'
+'.mDialog .btn.right{ float: right; margin-top: 15px; }'
+'.mDialog .quit{ position: absolute; top: -10px; width: 30px; height: 30px; background:url(images/pics/i_quit.png); background-size: 100%; cursor: pointer;}'
+'.mDialog .quit.left{ left: -10px; }'
+'.mDialog .quit.right{ right: -10px; }'
+'.mDialog .icon{ width: 70px; height: 70px; margin:0 auto 10px;}'
+'.mDialog .icon.icon_ok{ background: url(../images/mode/m/img_ok.png) no-repeat center; background-size: 100%;}'
+'</style>');


		//添加覆盖层
		if($("body > #h_mask").length<=0){
			$("body").append('<div id="h_mask" style=" position:fixed; top:0; left:0; z-index:99; width:100%; height:100%; background:#000; opacity:.6; filter:alpha(opacity=60);"></div>');
			$("body > #h_mask").on("click",function(){
				clearUp();						 
			});
		}
		 

		//取消倒计时
		if(opts.setTime){
			setI=setInterval(function(){
				var cur=$id.find(".setTime span").text();
				cur--;
				$id.find(".setTime span").text(cur);
				if(cur<0){
					clearInterval(setI);
					opts.callback();
				}
			},1000);
		}	

		//点击退出x
		$id.find(".quit").click(function(){
			clearUp();
		});

		//点击data-role值为cancel的按键
		$id.find(".btn[data-role=cancel]").click(function(){
			clearUp();
		});

		//回调（点击data-role值为confirm的按键）
		$id.find(".btn[data-role=confirm]").click(function(){
			clearUp();
			opts.callback();
		});


		//视图高
		function windowHeight(){
			if(self.innerHeight){ var windowHeight = self.innerHeight;
			}else{
				if(document.documentElement && document.documentElement.clientHeight){    
					var windowHeight = document.documentElement.clientHeight;
				}else{
					if(document.body){ var windowHeight = document.body.clientHeight;}
				}
			} 
			return windowHeight; 
		}
		

		//退出函数
		var clearUp=function(){
			if(opts.setTime){ clearInterval(setI);}
			$("body > #h_mask").remove();
			$id.remove();
			$('html,body').css('overflow-y','auto');
		}


	}//H_dialog

})(jQuery);


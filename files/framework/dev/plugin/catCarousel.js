
/*
旋转木马
*/


;(function ( $, window, document, undefined ) {
			
		var pluginName = "H_carousel",

			defaults = {
				itemBox: ".itemBox", //显示图片容器
				navBox: ".os", //导航圆点容器
				prev: ".prev", //向前箭头
				next: ".next", //向后箭头
				effect: "fade", //切换效果 [否则为slide] 
				perUnit: 1, //每组显示图片的个数
				default_on: 0, //默认显示图片组的index
				hasNav: false, //导航圆点是否已有
				loop: true, //是否循环播放
				autoPlay: true, //是否自动播放
				delayAnimate: 400, //切换效果所用时长
				delayTime: 3000 //切换之间的间隔
			};

		// 构造函数
		function Plugin ( element ) {
				this.obj=$(element);
				this.options=this.obj.data("js-carousel");
				this.settings = $.extend( {}, defaults, this.options );
				
				this.itemBox=this.obj.find(this.settings.itemBox);
				this.navBox=this.obj.find(this.settings.navBox);
				this.prev=this.obj.find(this.settings.prev);
				this.next=this.obj.find(this.settings.next);
				this.effect=this.settings.effect;
				this.perUnit=this.settings.perUnit;
				this.default_on=this.settings.default_on;
				this.hasNav=(this.settings.hasNav==false||this.settings.hasNav=="false")?false:true;
				this.loop=(this.settings.loop==true||this.settings.loop=="true")?true:false;
				this.autoPlay=(this.settings.autoPlay==false||this.settings.autoPlay=="false")?false:true;
				this.delayAnimate=this.settings.delayAnimate;
				this.delayTime=this.settings.delayTime;
				
				this.init();
		}

		$.extend(Plugin.prototype, {
				
				//初始化
				init:function(){
					this.items=this.itemBox.children();//图片单元
					this.itemSize=this.items.length;//图片个数
					this.page=(this.perUnit>1)?Math.ceil(this.itemSize/this.perUnit):this.itemSize;//页数
					this.unitSize=this.page;//图片(组)个数
					this.prev_index=this.index=this.default_on;//当前index
					this.next_index=this.index+1;
					if(this.perUnit>1){this.group();}//图片分组
					this.unit=this.itemBox.children();//图片(组)单元 
					this.first=0;//最前index
					this.last=this.unitSize-1;//最后index
					this.layout();//整体布局
					this.handleNav();//导航圆点操作
					this.handleArrow();//左右箭头操作
					if(this.autoPlay){ 
						this.auto_play();//自动播放
						this.hoverStop();//hover停止播放
					}
				},
				
				//图片分组
				group:function(){
					var htmlUnit=[];
					for(var i=0; i<this.page; i++){
						htmlUnit[i]=[];
						for(var j=0; j<this.perUnit; j++){
							var perItem=this.items.eq(i*this.perUnit+j);
							htmlUnit[i].push(perItem);
						}
						$htmlUnit=$('<div class="unit" style="float:left; overflow:hidden;"></div>')
								  .appendTo(this.itemBox).html(htmlUnit[i]);
					}
				},
				
				//整体布局
				layout:function(){
					this.itemBox.wrap('<div class="tempWrap" style=" overflow:hidden; position:relative;"></div>');
					this.unit.width(this.obj.width());
					if(this.effect=="fade"){
						this.itemBox.css({"position":"relative","width":this.obj.width()+"px","height":this.obj.height()+"px" });
						this.unit.css({"position":"absolute","top":"0","left":"0","width":"100%","height":"100%"})
								 .hide().eq(this.index).show();
					}else{
						if(this.loop){
							this.unit.css({"float":"left"});
							this.itemBox.prepend(this.unit.eq(this.page-1).clone()).append(this.unit.eq(1).clone());
							this.unitSize+=2;
							this.index+=1;
							this.first=1;
							this.last=this.unitSize-1;
							this.itemBox.css("left","-"+this.obj.width()*this.index+"px");
						}
						this.itemBox.width(this.obj.width()*this.unitSize);
					}
				},
				
				//导航圆点操作
				handleNav:function(){
					var that=this;
					if(!this.hasNav){
						for(var i=0; i<this.page; i++){
							this.navBox.append('<li>'+i+'</li>');
						}
					}
					this.navBox.children().eq(this.default_on).addClass("on");
					this.navBox.children().on("mouseover",function(){
						var index_li=$(this).index();
						if(that.effect=="slide" && that.loop){
							if(index_li!=that.index-1){
								that.prev_index=that.index;
								that.next_index=index_li+1;
								that.index=index_li+1;
							}
						}else{
							if(index_li!=that.index){
								that.prev_index=that.index;
								that.next_index=index_li;
								that.index=index_li;
							}
						}
						that.doPlay();
					});
				},
				
				//左右箭头样式
				classArrow:function(){
					if(!this.loop){
						this.prev.add(this.next).removeClass("off");
						if(this.index==this.first){this.prev.addClass("off");}
						if(this.index==this.last){this.next.addClass("off");}
					}
				},
				
				//左右箭头事件
				handleArrow:function(){
					var that=this;
					this.prev.on("click",function(){
						if(that.index==that.first){
							if(that.loop){
								that.prev_index=that.first;
								that.next_index=that.last;
								that.index=that.last;
							}else{
								that.prev_index=that.next_index=that.first;
								that.index=that.first;
							}
						}else{
							that.prev_index=that.index;
							that.next_index=that.index-1;
							that.index--;
						}
						that.doPlay();
					});
					this.next.on("click",function(){
						if(that.index==that.last){
							if(that.loop){
								that.prev_index=that.last;
								that.next_index=that.first;
								that.index=that.first;
							}else{
								that.prev_index=that.next_index=that.last;
								that.index=that.last;
							}
						}else{
							that.prev_index=that.index;
							that.next_index=that.index+1;
							that.index++;
						}
						that.doPlay();
					});
					this.classArrow();
				},
								
				//播放执行
				doPlay:function(prev_index){
					var that=this;
					if(this.effect=="fade"){
						this.unit.eq(that.prev_index).fadeOut();
						this.unit.eq(that.next_index).fadeIn();
					}else{
						this.itemBox.dequeue().animate({"left":"-"+that.obj.width()*that.next_index+"px"},that.delayAnimate);
						that.itemBox.animate({"left":"-"+that.obj.width()*that.next_index+"px"},0);
					}
					this.navBox.children().eq(this.next_index).addClass("on").siblings().removeClass("on");
					this.classArrow();
				},
				
				//自动播放
				auto_play:function(){
					var that=this;
					//console.log(that.next);
					this.autoInterval=setInterval(function(){
						that.next.click();
						//that.index++;
						//that.doPlay();
						
					},that.delayTime);	
					//console.log(window);return;
				},
				
				//hover停止播放
				hoverStop:function(){
					var that=this;
					if(this.loop){
						this.itemBox.add(this.prev).add(this.next).add(this.navBox).hover(function(){
							clearInterval(that.autoInterval);								  
						},function(){
							that.auto_play();
						});	
					}				
				}
				
		});
		
		//挂载到jq原型上
		$.fn[ pluginName ] = function ( ) {
				this.each(function() {
						if ( !$.data( this, "plugin_" + pluginName ) ) {
								$.data( this, "plugin_" + pluginName, new Plugin( this ) );
						}
				});
				return this;
		};
		
		//调用
		$(window).on("load",function(){
			$("[data-js-carousel]").H_carousel();
		});

})( jQuery, window, document );

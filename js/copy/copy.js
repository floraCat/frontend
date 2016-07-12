
//复制到剪切板
$(function(){
	$(".modeList ol a").click(function(){
		$(".zclip").remove();
		_this=$(this);
		var data_title=$(this).parents("ol").data("title");
		var data_name=$(this).data("name");
		var submitdata={
			data_title:data_title,
			data_name:data_name
		};
		if($(this).hasClass("view")){
			$.post('__index.php?act=view',submitdata,
			function(data){
				console.log(data);
				//$(".cutter").text(data);
				var a=window.open("about:blank");
				var d=a.document;
				d.write("<xmp>"+data+"</xmp>");
			},'json');
		}else{
			$.post('__index.php?act=copy',submitdata,
			function(data){
				console.log(data);
				$(".cutter").text(data);
				_this.zclip({
					path: "../../ZeroClipboard.swf",
					copy: function(){
					return $(".cutter").text();
					},
					afterCopy:function(){
						$(".mAlert").show().delay(1000).fadeOut();
					}
				});
			},'json');
		}
	});	

});



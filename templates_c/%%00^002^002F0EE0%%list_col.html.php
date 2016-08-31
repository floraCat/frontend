<?php /* Smarty version 2.6.22, created on 2016-08-31 01:28:36
         compiled from list_col.html */ ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/col_style.css" />
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/copy/jquery.zclip.min.js"></script>
</head>
<body>



<!--头部-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "global_header.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<div class="noteList">
	<p style="width:1200px; margin:0 auto; text-align: left;">
		<span>点击图片进入详情页 / </span>
		<span>快捷键说明 </span>
		<span class="f"> -></span>
		<span><em>效果展示</em>：模块的前端展示效果</span>
		<span class="c"> | </span>
		<span><em>源码复制</em>：把模板的主体源码复制到剪切板</span>
		<span class="c"> | </span>
		<span><em>自定义设置</em>：提供源码的修改</span>
	</p>
</div>




<!--筛选-->
<div class="listSort">
	<h5>筛选：</h5>
    <ul>
        <a class="on" data-cat="all" href="col_handle.php?page=<?php echo $_GET['page']; ?>
&col=<?php echo $_GET['col']; ?>
&list=<?php echo $_GET['list']; ?>
">全部</a>

        <?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['arr_sort']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['list']['show'] = true;
$this->_sections['list']['max'] = $this->_sections['list']['loop'];
$this->_sections['list']['step'] = 1;
$this->_sections['list']['start'] = $this->_sections['list']['step'] > 0 ? 0 : $this->_sections['list']['loop']-1;
if ($this->_sections['list']['show']) {
    $this->_sections['list']['total'] = $this->_sections['list']['loop'];
    if ($this->_sections['list']['total'] == 0)
        $this->_sections['list']['show'] = false;
} else
    $this->_sections['list']['total'] = 0;
if ($this->_sections['list']['show']):

            for ($this->_sections['list']['index'] = $this->_sections['list']['start'], $this->_sections['list']['iteration'] = 1;
                 $this->_sections['list']['iteration'] <= $this->_sections['list']['total'];
                 $this->_sections['list']['index'] += $this->_sections['list']['step'], $this->_sections['list']['iteration']++):
$this->_sections['list']['rownum'] = $this->_sections['list']['iteration'];
$this->_sections['list']['index_prev'] = $this->_sections['list']['index'] - $this->_sections['list']['step'];
$this->_sections['list']['index_next'] = $this->_sections['list']['index'] + $this->_sections['list']['step'];
$this->_sections['list']['first']      = ($this->_sections['list']['iteration'] == 1);
$this->_sections['list']['last']       = ($this->_sections['list']['iteration'] == $this->_sections['list']['total']);
?>
        <a data-cat="<?php echo $this->_tpl_vars['arr_sort'][$this->_sections['list']['index']][0]; ?>
" href="col_handle.php?page=<?php echo $_GET['page']; ?>
&col=<?php echo $_GET['col']; ?>
&list=<?php echo $_GET['list']; ?>
&sort=<?php echo $this->_tpl_vars['arr_sort'][$this->_sections['list']['index']][0]; ?>
"><?php echo $this->_tpl_vars['arr_sort'][$this->_sections['list']['index']][1]; ?>
</a>
        <?php endfor; endif; ?>
    </ul>
</div>
<!--/筛选-->




<div class="modeList">

<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['temp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['list']['show'] = true;
$this->_sections['list']['max'] = $this->_sections['list']['loop'];
$this->_sections['list']['step'] = 1;
$this->_sections['list']['start'] = $this->_sections['list']['step'] > 0 ? 0 : $this->_sections['list']['loop']-1;
if ($this->_sections['list']['show']) {
    $this->_sections['list']['total'] = $this->_sections['list']['loop'];
    if ($this->_sections['list']['total'] == 0)
        $this->_sections['list']['show'] = false;
} else
    $this->_sections['list']['total'] = 0;
if ($this->_sections['list']['show']):

            for ($this->_sections['list']['index'] = $this->_sections['list']['start'], $this->_sections['list']['iteration'] = 1;
                 $this->_sections['list']['iteration'] <= $this->_sections['list']['total'];
                 $this->_sections['list']['index'] += $this->_sections['list']['step'], $this->_sections['list']['iteration']++):
$this->_sections['list']['rownum'] = $this->_sections['list']['iteration'];
$this->_sections['list']['index_prev'] = $this->_sections['list']['index'] - $this->_sections['list']['step'];
$this->_sections['list']['index_next'] = $this->_sections['list']['index'] + $this->_sections['list']['step'];
$this->_sections['list']['first']      = ($this->_sections['list']['iteration'] == 1);
$this->_sections['list']['last']       = ($this->_sections['list']['iteration'] == $this->_sections['list']['total']);
?>
<li>
	<a class="a img" href="col_handle.php?page=<?php echo $_GET['page']; ?>
&col=<?php echo $_GET['col']; ?>
&folder=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['folder']; ?>
&details=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
" target="_blank">
		<?php if ($_GET['page'] == 'plus'): ?>
			<img src="col_<?php echo $_GET['page']; ?>
/pictures/<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl_short']; ?>
.png" />
		<?php else: ?>
			<img src="col_<?php echo $_GET['page']; ?>
/pictures/<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
.png" />
		<?php endif; ?>
	</a>
	<?php if ($_GET['page'] == 'plus'): ?>
		<h5><?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl_short']; ?>
 / <?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl_zh']; ?>
</h5>
	<?php else: ?>
		<h5><?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
 / <?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl_zh']; ?>
</h5>
	<?php endif; ?>
	
	<?php if ($_GET['page'] != 'plus'): ?>
	<ol data-title="<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
">
		<a href="col_handle.php?page=<?php echo $_GET['page']; ?>
&col=<?php echo $_GET['col']; ?>
&folder=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['folder']; ?>
&_temp=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
" target="_blank">效果展示</a>
		<a class="copy">源码复制</a>
		<?php if ($_GET['page'] != 'unit'): ?>
		<a href="col_handle.php?page=<?php echo $_GET['page']; ?>
&col=<?php echo $_GET['col']; ?>
&folder=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['folder']; ?>
&act=setting&ttl=<?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['ttl']; ?>
" target="_blank">自定义设置</a>
		<?php endif; ?>
	</ol>
	<xmp class="code" style=" display:none;"><?php echo $this->_tpl_vars['temp'][$this->_sections['list']['index']]['code']; ?>
</xmp>
	<?php endif; ?>
</li>
<?php endfor; endif; ?>



</div>


<div class="h_mask"></div><!--覆盖层-->
<div class="mAlert2">已复制到剪切板！</div>



<script>
$(function(){
	//筛选
	var sort_index=$("#sort").val();
	$("[data-cat="+sort_index+"]").addClass("on").siblings().removeClass("on");
	$(".listSort ul li").on("click",function(){
		$(this).addClass("on").siblings().removeClass("on");
	});
});

//复制到剪切板
$(function(){
	$(".modeList .copy").each(function(){
		$(this).zclip({
			path: "js/copy/ZeroClipboard.swf",
			copy: function(){
				var str_code=$(this).parents("li").find(".code").text();
				var start_js=str_code.indexOf("$(function(){")+13;
	            var end_js=str_code.indexOf("/script")-1;
	            var str_js=str_code.substr(start_js,end_js-start_js);
	            if(str_js.replace(/\s+/g,"")=="});"){
	                var start_js_2=str_code.indexOf("<script>");
	                str_code=str_code.substr(0,start_js_2);
	            }
	            return str_code;
			},
			afterCopy:function(){
				$(".h_mask").show().delay(1000).fadeOut();
				$(".mAlert2").css("top",$(window).height()/2-30+"px").show().delay(1000).fadeOut();
			}
		});
	});
});
</script>







<!--当前导航加.on-->
<input type="hidden" id="page" value="<?php echo $_GET['page']; ?>
" />
<input type="hidden" id="sort" value="<?php echo $_GET['sort']; ?>
" />
<script>
$(function(){
    var page=$("#page").val();
    $(".pNav ."+page).addClass("on").parent().siblings().children().removeClass("on");
});
</script>



<!--底部-->
<!--_refer-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "global_footer.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--refer_-->


</body>
</html>
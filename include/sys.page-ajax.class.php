<?php
/*分类类*/
class sys_page
{
	/*构造函数*/
	function __construct()
    {

    }
    /*分页获取分页*/
    /*
     * $pageCur当前第几页
     * $pageSum一共多少条记录
     */
    public function getPage($pageCur=0,$pageSum=0)
    {
        if($pageCur==0)
        {
            $pageCur=$_REQUEST['page'];
        } 
        if($pageCur=='')
        {
            $pageCur=0;
        }
        else
        {
            $pageCur=intval($pageCur)-1;
        }
       // echo __SYS_PAGE_SIZE__;
        $pageCurRs=$pageCur+1;
        $starNum=$pageCur*$GLOBALS["pagesize"];
        if($starNum<0)
        {
            $starNum=1;
        }
        
        $BackArr=array();
        $BackArr["pageCurRs"]=$pageCurRs;//页的记录数
        $BackArr["pageSum"]=$pageSum;//记录总数
        $BackArr["starNum"]=$starNum;//记录开始数
        $BackArr["pageCur"]=$pageCur;//当前页
        return $BackArr;
    }


    /*分页的HTML 代码*/
   /*
    * $pageCur 当前页
    * $pageSum 数量
    * $perpage 每页多少
    * $paras 参数
    * $inact 执行参数
    */ 
	public function pager($pageCur = 1, $pageSum = 0, $perpage =20, $paras="",$inact)
	{
 
		//$this->lang=$lang; 
		$maxpage = ceil($pageSum / $perpage);
		$maxpage = $maxpage > 0 ? $maxpage : 1;
		$pageCur = $pageCur<1?1:$pageCur;

		$prepage = $pageCur - 1;
		  
		$nextpage = $pageCur + 1;
		$_sstr = '';
		$sstr = '';
	 
	 	if($inact){
	 		$url = "?act=".$inact;
	 	}
		
		if( trim($paras) )
		{
			if( substr($paras, 0, 1) == "&" )
				$url .= $paras;
			else
				$url .= "&".$paras;
		}
		
			$headpageStr = $pageCur != 1 ? "<li><a data-role='1'>首 页</a></li> " : ' <li><span>首 页</span></li> ' ;

			$prepageStr = $prepage  != 0 ? " <li><a data-role='".$prepage."'>上一页</a></li> " : ' <li><span>上一页</span></li> ';
			 
			$nextpageStr = $nextpage != $maxpage + 1 ? " <li><a data-role='".$nextpage."'>下一页</a></li> " : ' <li><span>下一页</span></li> ';
			$footpageStr = $pageCur != $maxpage ?  " <li><a data-role='".$maxpage."'>末 页</a></li> " : ' <li><span>末 页</span></li> ';
			
			$s_first= $pageCur<=3?1:$pageCur-3;
			$s_last= $pageCur<$maxpage-3?$pageCur+3:$maxpage;
			for ($s = $s_first; $s <= $s_last; $s ++)
			{
				if($s == $pageCur)
					$_sstr .= "<li><span class='pageCur'>" . $s . "</span></li>";
				else
					$_sstr .= "<li><a data-role='".$s."'>" . $s . "</a></li>";
			}
			$sstr =  $_sstr ;
			$lastStr = "<em>&nbsp;&nbsp;&nbsp;&nbsp;总记录数 <strong>".$pageSum."</strong> 条,&nbsp;每页 <strong>".$perpage."</strong> 条,&nbsp;&nbsp;第 <strong>$pageCur / $maxpage</strong> 页</em>";
 
		$pagerStr = $headpageStr . $prepageStr . $sstr. $nextpageStr . $footpageStr . $lastStr;
		return $pagerStr;
	}
	
}
?>
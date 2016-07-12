<?php
/**
 *URL跳转
 *
 */
class sys_jumpurl
{
	public function __construct()
    {

	}
	// 弹出提示
	public function alter($Str,$Url)
	{
		echo "<Script language='JavaScript'> alert('".$Str."');</Script>";
		echo "<meta http-equiv=refresh content=0;URL=".$Url.">";
		exit;
	}

	/**
    * 刷新本页
    * string $url 要跳转到的地址
    */
    public function refresh_parent($url,$alert)
    {
         echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                ';
         echo '<script src="js/jquery.js"></script>';
         echo '<script src="js/thickbox.js"></script>';
         echo '</head><body>';
    	 echo '<script type="text/javascript">$(function (){';
         echo 'parent.location.reload();';
         echo 'alert("'.iconv("GB2312", "UTF-8", $alert).'");';
         echo 'self.parent.tb_remove();';
         echo '});</script>';
         echo '</body></html>';
    }


    /**
    * 普通的跳转
    * string $url 要跳转到的地址
    */
    public function redirect($url)
    {
		
    	if (isset($_SERVER["SERVER_SOFTWARE"]) && preg_match("/IIS/", $_SERVER["SERVER_SOFTWARE"]))
    	{
    		echo "<script>window.location=\"" . str_replace("\"", "%22", $url) . "\";</script>";
    	}
    	else
    	{
			echo "<script>window.location='".$url."';</script>";//后曾代替原有的
    		//原有的 header("location:".$url);
    	}
    }

    /**
	* 跳转到其它页面,并终止程序的执行
	*  string $url 要转向的地址或路
	*/
    public function sendRedirect($url)
    {
        response::redirect($url);
        exit();
    }


    /**
	* 返回本页,以执行不同的动作
	*
	* @param string $query 查询条件
	* @param integer $refresh 是否刷新,默认为1(刷新)
	* @return void
	* @access public
	*/
    function selfRedirect($query = "", $refresh = 1)
    {
        $url = server::getRequestPage();
        if ($refresh == 1)
        {
            $query = "PHPSESSID=" . md5(microtime()) . "&" .$query;
            $query = rtrim($query, "&");
        }
        if ($query != "")
        {
            if (!preg_match("/\?/", $url))
            {
                $url .= "?" . $query;
            }
            else
            {
                $url .= "&" . $query;
            }
        }
        response::redirect($url);
        exit();
    }

	/**
	* js的跳转,并终止程序的执行
	*
	* @param string $alert 提示语,默认为空
	* @param string $expression 执行的js语句,默认为"history.back()"(返回)
	* @return void
	* @access public
	*/
    function jsRedirect($alert = "", $expression = "history.back()")
    {
		ob_end_clean();
        if ($alert != "")
        {
        	$alert = addslashes($alert);
            $alert = str_replace("\n", "\\n", $alert);
            echo "<script language=\"javascript\">";
            echo "alert(\"{$alert}\");";
            echo "</script>";
        }
        if ($expression != "")
        {
            echo "<script language=\"javascript\">\n";
            if( $expression == "history.back()" )
            	echo $expression . "\n";
            else
            	echo "document.location.href='".$expression."';";
            echo "</script>";
        }
        exit();
    }

	/**
	*
	* <b>输出内容</b>
	*
	*
	* <b>调用方式</b>
	* - response::println("a")
	* - response::println("a", array("b", "c"))
	*
	*
	* @param mixed 不定参数
	* @return void
	* @access public
	*/
    function println()
    {
    	$args = func_get_args();
    	if (!empty($args))
    	{
    		foreach ($args as $arg)
    		{
		        if (is_bool($arg))
		        {
		            if ($arg == true)
		            {
		                echo "true\n";
		            }
		            else
		            {
		                echo "false\n";
		            }
		        }
		        else if (is_null($arg))
		        {
		        }
		        else
		        {
		            print_r($arg);
		        }
    		}
    	}
    }

    //输出信息并退出(调用此方法前的所有输出将被清除)
    public function printMessageOnExit( $msg )
	{
		ob_clean();
		if( $msg )
			echo $msg;
		exit();
	}


	/*
	* 方法说明: 根据参数输出JSON数据
	*
	*输入参数:
	*	msg			信息描述
	*	status		信息状态(1成功信息, 0失败信息, 2提示信息)
	*
	*输出参数:
	*	返回JSON数据
	*
	*/
	public function printJSONOnExit( $msg, $status=2 )
	{
		echo "{success:$status, msg:'$msg'}";
		exit();
	}


	public function printJSONOnExitArray( $msg, $status=2, $fieldarray=array() )
	{
		$str_array = array();
		$str_array[] = "success:$status";
		$str_array[] = "msg:'$msg'";
		foreach($fieldarray AS $key=>$val)
		{
			$str_array[] = $key.':'.$val;
		}

		echo '{'.join(',',$str_array).'}';//"{success:$status, msg:'$msg'}";
		exit();
	}
}
?>
<?php
/**
 *类说明:返回系统资料
 *
 *
 */
class sys_get
{
    //构造函数
	function __construct()
    {

    }
	
	/**获取地址**/
	public function getUrl()
	{
		$temp = $_SERVER["REQUEST_URI"];
		return $temp;
	}
   	/*
	*
    * 当前页面地址
    */
	function get_filename()//file name with para
	{
		$temp = $_SERVER["REQUEST_URI"];
		$filename = substr(strrchr($temp, "/"),1);
		$filearr =explode("?",$filename);
		if(empty($filearr[0]))
			return 'index.php';
		return $filearr[0];
	}

    /**
     * 将文中关键词高亮显示
     *
     * */
    function get_hl_text($text)
    {
        $text = preg_replace("/\b(regex)\b/i", '<span style="background:#5fc9f6">\1</span>', $text);
        return $text;
    }


	/** 获取IP*****/
	function get_real_ip()
	{
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
			for ($i = 0; $i < count($ips); $i++)
			{
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i]))
				{
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	/** 获取IP*****/
	function get_ip()
	{
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
			for ($i = 0; $i < count($ips); $i++)
			{
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i]))
				{
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	//get
	function g($rs)
	{
		return trim($_GET[trim($rs)]);
	}

}
?>
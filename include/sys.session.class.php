<?php
/**
 *类说明: 检查SESSION
 *
 *
 */
class sys_session_class
{
    function __construct()
    { 
    } 
	/** 检查SESSION是否存在内容*/
	public function CheckSession()
	{
		if($_SESSION)
		{
			return true;
		}
        else
        {
            return false;
        }
	}

    /** 清空SESSION 清空返回TRUE 未清空返回FALSE**/
    public function clearSession()
    {
		foreach($_SESSION as $key=>$val)
		{
			unset($_SESSION[$key]);
		}    
        $r=$this->CheckSession();
        return $r;
    } 
	/*
	检查用户是否登录成功，未登录成功转到登录页
	直接引用返定义的登录配置,减少对类的修改.
	检查普通用户的登录情况
	*/
	public function check_agents_session($define_session_1,$define_session_2,$define_session_3)
	{
		if( $_SESSION[$define_session_1]!="" && $_SESSION[$define_session_2]!="" && $_SESSION[$define_session_3]!="")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*建立登录页的SESSION 会给出查询出来的用户资料 2013-02-13*/
	public function CreateLoginSession($arr)
	{
		if($arr)
		{
			return false;
		} 
	}
	
	
	
}
?>
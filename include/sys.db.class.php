<?php
include_once("adodb/adodb.inc.php");
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;//adodb不返回数字下标记录
/*************
 * 引用ADODB中的常用函数
 * $debug为
 *
 *
 **********/
class db
{ 
    public function db($debug=false)
    {
		$DB = NewADOConnection('mysql'); 
		$DB->Connect(__MYSQL_HOST__, __MYSQL_USER__, __MYSQL_PASSWORD__, __MYSQL_DATABASE_NAME__);
		$DB->debug=$debug;
		//$DB->SetCharSet("utf8");
		$DB->Execute("set names utf8");
		$this->DB=$DB;
		 
	}
	
    /**
     *  新增 写入数据库方法 2011-12-10
     *  表名$table，$mod_array，值对 形如:$mod_array=array("order_id"=>1,"ready_goods_id"=>1,"ready_goods_status"=>1)
    */
    public function addTableRecode($table,$mod_array)
    {
        //还需要在这里调用写入数据库的操作时间2011-12-10
		//$this->DB->debug=true;
        if( empty($table)||empty($mod_array)||!is_array($mod_array) ){
			return false;
		}
        $rs = $this->DB->AutoExecute($table,$mod_array,'INSERT');
        if( $rs ){
			return $this->DB->_insertid();
		}else{
			return false;
		}
    }
	
	/**
	* 向某表增加记录
	*
	* @param 表名$table，$mod_array，值对 形如:$mod_array=array("order_id"=>1,"ready_goods_id"=>1,"ready_goods_status"=>1)
	* @return boolean 
	* @access public
    * 注：向某增加记录，并返回增加后的值
	* 2012-2-09
	*/
   
    function addTableRecode_value($table,$mod_array)
    {
		if( empty($table)||empty($mod_array)||!is_array($mod_array) )
			return false;
		//$this->db->debug=true;    
		$rs = $this->DB->AutoExecute($table,$mod_array,'INSERT');
		if( $rs )
			return $this->DB->_insertid();
		return false;
    }
	

    /**
     * 新增 查询数据库方法 返回单条记录 2011-12-10
	 * 给定条件$where，和表名$table，得到表的一行数据
	 *
	 *  $where，$table
	*/
    public function getTableRowResult($table,$where='1=1')
    {
        if( empty($table)||empty($where)){
			return false;
		}
		//$this->DB->debug=true;  //打印出所有sql语句
        $sql = "SELECT * FROM $table WHERE $where";
        $rs = $this->DB->GetRow($sql);
		if( $rs ){
			return $rs;
		}else{
			return false;
		}
     }

     /**
     * 新增 查询数据库方法 返回多条记录 2011-12-10
	 * 给定条件$where，和表名$table，得到表的多行数据
	 *
	 *  $where，$table
	*/
    public function getTableAllResult($table,$where="1=1")
    {
        if( empty($table)||empty($where)){
			return false;
		}
        $sql = "SELECT * FROM $table WHERE $where";
        //$this->DB->debug=true;
        $rs = $this->DB->GetAll($sql);
        if( $rs )
		{
			return $rs;
		}else{
			return false;
		}
    } 


    public function getTableAllResults($table1,$table2,$where1="1=1",$where2="1=1",$where)
    {
        if( empty($table1)||empty($where1)||empty($table2)||empty($where2)){
			return false;
		}
        $sql = "SELECT * FROM $table1 WHERE $where1 UNION ALL  SELECT * FROM $table1 WHERE $where2 $where";
        //$this->DB->debug=true;
        $rs = $this->DB->GetAll($sql);
        if( $rs )
		{
			return $rs;
		}else{
			return false;
		}
    } 
	
    /** 
     * 新增加 更新数据库 2011-12-10
    */
	public function updateTableCon($mod_array,$table_name,$where)
	{
		if( empty($mod_array)||!is_array($mod_array) ){
			return false;
		}
		//$this->DB->debug=true;
		$rs = $this->DB->AutoExecute($table_name,$mod_array,'UPDATE', $where); 

		if( $rs ){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	* 给定条件$where，和表名$table，删除某表记录
	* 更新数据库 2012-1-13
	*/
	public function deleteTableResult($table,$where) 
	{
		if( empty($table)|| empty($where)){
			return false;
		}
		//$this->db->debug=true; 
		$rs = $this->DB->Execute("DELETE FROM $table WHERE $where"); 
		if( $this->DB->Affected_Rows() < 1 ){
			return false;
		}else{
			return true;
		}
	}



    //執行
    public function Execute($sql, $spec=NULL)
    {
		if($spec==NULL){
			return $result=$this->DB->Execute($sql);
		}else{
			return $result=$this->DB->Execute($sql, $spec);
		}
	}

	//自动執行SELECT, UPDATE
    public function AutoExecute($table, $values, $operation, $where=NULL)
    {
		if($where==NULL){
			return $this->DB->AutoExecute($table, $values, $operation);
		}else{
			return $this->DB->AutoExecute($table, $values, $operation, $where=NULL);
		}
	}


	//報错
	function ErrorMsg(){
		return $this->DB->ErrorMsg();
	}

	//取得ID
	function GetOne($sql){
		return $this->DB->GetOne($sql);
	}

	//取得当前列
	function GetRow($sql){
		return $this->DB->GetRow($sql);
	}

	//取得数组
	function GetAll($sql){
		return $this->DB->GetAll($sql);
	}

	//
	function GetAssoc($sql){
		return $this->DB->GetAssoc($sql);
	}

	//取得插入ID
	function Insert_ID(){

		return $this->DB->_insertid();
	}

}

?>
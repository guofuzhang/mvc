<?php
//声明命名空间 
namespace Admin\Model;
use \Frame\Libs\BaseModel;

//定义用户模型类，并继承基础模型类
final class UserModel extends BaseModel{
	//受保护的数据表名称
	protected $table = "user";
	
	//用户登录更新
	public function loginUpdate($data,$id)
	{
		$str = "";
		foreach($data as $key=>$value)
		{
			$str .= "$key='$value',";
		}
		$str .= "login_times=login_times+1";
		//构建更新的SQL语句
		$sql = "UPDATE {$this->table} SET {$str} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}



}
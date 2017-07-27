<?php
//声明命名空间
namespace Frame\Libs;
use \Frame\Vendor\PDOWrapper;

//定义抽象的基础模型类
abstract class BaseModel{
	
	//受保护的pdo对象的属性
	protected $pdo = NULL;
	//受保护的模型类对象数组属性
	protected static $modelObjArr = array();

	//公共的构造方法
	public function __construct()
	{
		$this->pdo = new PDOWrapper();
	}

	//模型类的单例方法：一个模型类，只能创建一个对象
	public static function getInstance()
	{
		/*
			$modelObjArr['\Home\Model\StudentModel'] = StudentModel对象
			$modelObjArr['\Home\Model\NewsModel']    = NewsModel对象
		*/
		//获取静态化方法调用的类名称
		$modelClassName = get_called_class();
		//判断模型类对象是否存在
		if(!isset(self::$modelObjArr[$modelClassName]))
		{
			self::$modelObjArr[$modelClassName] = new $modelClassName();
		}
		//如果模型类对象存在，则返回
		return self::$modelObjArr[$modelClassName];
	}

	//获取一行数据
	public function fetchOne($where="2>1",$orderby="id asc")
	{
		$sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderby} LIMIT 1";
		return $this->pdo->fetchOne($sql);
	}

	//获取多行数据
	public function fetchAll()
	{
		$sql = "SELECT * FROM {$this->table}";
		return $this->pdo->fetchAll($sql);
	}

	//插入一条记录
	public function insert($data)
	{
		$fields = "";
		$values = "";
		foreach($data as $key=>$value)
		{
			$fields .= "$key,";
			$values .= "'$value',";
		}
		$fields = rtrim($fields,",");
		$values = rtrim($values,",");
		//构建插入的SQL语句
		$sql = "INSERT INTO {$this->table}($fields) VALUES($values)";
		return $this->pdo->exec($sql);
	}

	//更新一条记录
	public function update($data,$id)
	{
		$str = "";
		foreach($data as $key=>$value)
		{
			$str .= "$key='$value',";
		}
		$str = rtrim($str,",");
		//构建更新的SQL语句
		$sql = "UPDATE {$this->table} SET {$str} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}

	//删除记录
	public function delete($id)
	{
		$sql = "DELETE FROM {$this->table} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}

	//获取记录数
	public function rowCount($where="2>1")
	{
		$sql = "SELECT * FROM {$this->table} WHERE {$where}";
		return $this->pdo->rowCount($sql);
	}
}


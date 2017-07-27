<?php
//声明命名空间
namespace Frame\Vendor;
use \PDO;			//引入PDO类
use \PDOException;	//引入PDOException类

//定义PDOWrapper类
final class PDOWrapper{
	
	//数据库配置信息
	private $db_type;	//数据库类型
	private $db_host;	//主机名
	private $db_port;	//端口号
	private $db_user;	//用户名
	private $db_pass;	//密码
	private $db_name;	//数据库名
	private $charset;	//字符集
	private $pdo = NULL;//保存PDO对象

	//构造方法：初始化PDO
	public function __construct()
	{
		$this->db_type = $GLOBALS['config']['db_type'];
		$this->db_host = $GLOBALS['config']['db_host'];
		$this->db_port = $GLOBALS['config']['db_port'];
		$this->db_user = $GLOBALS['config']['db_user'];
		$this->db_pass = $GLOBALS['config']['db_pass'];
		$this->db_name = $GLOBALS['config']['db_name'];
		$this->charset = $GLOBALS['config']['charset'];
		//创建PDO对象
		$this->connectDb();
		//设置PDO的报错模式：异常模式
		$this->setErrMode();
	}

	//连接数据库
	private function connectDb()
	{
		try{
			$dsn = "{$this->db_type}:dbhost={$this->db_host};dbport={$this->db_port};";
			$dsn .= "dbname={$this->db_name};charset={$this->charset}";
			$this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
		}catch(PDOException $e){
			$str = "<h2>创建PDO对象失败</h2>";
			$str .= "错误状态码：".$e->getCode();
			$str .= "<br>错误行号：".$e->getLine();
			$str .= "<br>错误文件：".$e->getFile();
			$str .= "<br>错误信息：".$e->getMessage();
			echo $str;
		}
	}

	//设置PDO的报错模式
	private function setErrMode()
	{
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	//执行SQL语句：insert、update、delete、set
	public function exec($sql)
	{
		try{
			//返回执行结果
			return $this->pdo->exec($sql);
		}catch(PDOException $e)
		{
			//调用错误显示方法
			$this->showErr($e);
		}
	}

	//获取一行数据
	public function fetchOne($sql)
	{
		try{
			//执行SELECT语句，并返回结果集对象
			$PDOStatement = $this->pdo->query($sql);
			//返回一维数组(关联数组)
			return $PDOStatement->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			//调用错误显示方法
			$this->showErr($e);
		}
	}

	//获取多行数据
	public function fetchAll($sql)
	{
		try{
			//执行SELECT语句，并返回结果集对象
			$PDOStatement = $this->pdo->query($sql);
			//返回二维数组(关联数组)
			return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			//调用错误显示方法
			$this->showErr($e);
		}
	}

	//获取记录总数
	public function rowCount($sql)
	{
		try{
			//执行SELECT语句，并返回结果集对象
			$PDOStatement = $this->pdo->query($sql);
			//返回记录数
			return $PDOStatement->rowCount();
		}catch(PDOException $e){
			//调用错误显示方法
			$this->showErr($e);
		}
	}

	//错误显示方法
	private function showErr($e)
	{
		$str = "<h2>SQL语句有问题</h2>";
		$str .= "错误状态码：".$e->getCode();
		$str .= "<br>错误行号：".$e->getLine();
		$str .= "<br>错误文件：".$e->getFile();
		$str .= "<br>错误信息：".$e->getMessage();
		echo $str;
	}
}
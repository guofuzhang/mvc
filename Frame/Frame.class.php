<?php
//声明命名空间
namespace Frame;
//框架的初始类文件
final class Frame{
	
	//公共的静态的初始化方法
	public static function run()
	{
		self::initCharset();	//网页字符集设置
		self::initConfig();		//初始化配置参数
		self::initRoute();		//初始化路由参数
		self::initConst();		//常用常量设置
		self::initAutoLoad();	//类的自动加载
		self::initDispatch();	//请求分发
	}

	//网页字符集初始化
	private static function initCharset()
	{
		//声明网页字符集
		header("content-type:text/html;charset=utf-8");
		//开启SESSION会话
		session_start();
	}

	//初始化配置参数
	private static function initConfig()
	{
		$GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
	}

	//初始化路由参数：获取平台名称、控制器名称、动作名称
	private static function initRoute()
	{
		$p	= $GLOBALS['config']['default_platform'];
		$c	= isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
		$a	= isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
		define("PLAT",$p);
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}

	//常用目录常量的设置
	private static function initConst()
	{
		//举例：./Home/View/Student/index.html
		//define("VIEW_PATH",APP_PATH."View".DS.CONTROLLER.DS);//视图目录
		define("VIEW_PATH",APP_PATH."View".DS);//视图目录，去掉控制器名称
		define("FRAME_PATH",ROOT_PATH.DS."Frame".DS); //Frame目录
	}

	//类的自动加载
	private static function initAutoLoad()
	{
		spl_autoload_register(function($className){
			/*
				$className = "\Home\Controller\StudentController()";
				将上面类名，转成真实的类文件路径
				$filename = "./Home/Controller/StudentController.class.php"
			*/
			//根据传递的类名参数，来构建真实的类文件路径
			$filename = ROOT_PATH . DS . str_replace("\\",DS,$className) . ".class.php";
			//包含类文件
			if(file_exists($filename)) require_once($filename);
		});
	}

	//请求分发：创建什么控制器对象，调用控制器对象的什么方法
	private static function initDispatch()
	{
		//构建控制器类名：\Home\Controller\NewsController()
		$c = "\\".PLAT."\\"."Controller"."\\".CONTROLLER . "Controller"; 
		//创建控制器类对象
		$controllerObj = new $c();
		//调用控制器对象的方法
		$a = ACTION;
		$controllerObj->$a();
	}
}



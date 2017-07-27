<?php
//声明命名空间
namespace Frame\Libs;
use \Frame\Vendor\Smarty; //引入Smarty类

//定义抽象的基础控制器类
abstract class BaseController{
	//受保护的Smarty对象属性
	protected $smarty = NULL;

	//构建方法：初始化工作
	public function __construct()
	{
		$this->initSmarty(); //Smarty初始化
	}

	//Smarty初始化方法
	protected function initSmarty()
	{
		//(1)创建Smarty对象
		$smarty = new Smarty();
		//(2)Smarty配置
		$smarty->left_delimiter = "<{";		//左定界符
		$smarty->right_delimiter = "}>";	//右定界符
		$smarty->setTemplateDir(VIEW_PATH); //视图目录
		$smarty->setCompileDir(sys_get_temp_dir()); //编译目录C:/windows/temp
		//(3)向$this->smarty属性赋值
		$this->smarty = $smarty;
	}

	//跳转方法
	protected function jump($message,$url='?',$time=3)
	{
		//(1)向jump.html视图文件赋值
		/*
			$this->smarty->assign("message",$message);
			$this->smarty->assign("url",$url);
			$this->smarty->assign("time",$time);
		*/
		//用以下一行代码代替上面三行代码
		$this->smarty->assign(array(
			'message'	=> $message,
			'url'		=> $url,
			'time'		=> $time,
		));
		//(2)调用视图文件来显示结果
		$this->smarty->display("Public/jump.html"); // 视图目录：Admin/View/
		die();//中断程序向下执行
	}

	//权限验证
	protected function denyAccess()
	{
		//判断用户是否登录
		if(empty($_SESSION['username']))
		{
			//跳转到登录页面
			$this->jump("你还没有登录，请先请登录！","?c=User&a=login");
		}
	}
}



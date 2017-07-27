<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;

//定义首页控制器类
final class IndexController extends BaseController{
	//首页显示方法
	public function index()
	{
		$this->denyAccess();//权限检测
		//调用index.html视图文件
		$this->smarty->display("Index/index.html");
	}

	//顶部框架视图文件
	public function top()
	{
		$this->denyAccess();
		//调用top.html视图文件
		$this->smarty->display("Index/top.html");
	}

	//左部框架视图文件
	public function left()
	{
		$this->denyAccess();
		//调用left.html视图文件
		$this->smarty->display("Index/left.html");
	}

	//中部框架视图文件
	public function center()
	{
		$this->denyAccess();
		//调用center.html视图文件
		$this->smarty->display("Index/center.html");
	}

	//主框架视图文件
	public function main()
	{
		$this->denyAccess();
		//调用main.html视图文件
		$this->smarty->display("Index/main.html");
	}
}
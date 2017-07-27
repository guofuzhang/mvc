<?php
//前端应用配置文件
return array(
	/*数据库配置*/
	'db_type'	=> 'mysql',		//数据库类型
	'db_host'	=> 'localhost',	//主机名
	'db_port'	=> '3306',		//端口号
	'db_user'	=> 'root',		//用户名
	'db_pass'	=> 'root',		//密码
	'db_name'	=> 'blog',		//数据库名
	'charset'	=> 'utf8',		//字符集

	/*默认参数配置*/
	'default_platform'		=> 'Home',	//前端应用(平台)
	'default_controller'	=> 'Index',	//默认控制器名称
	'default_action'		=> 'index', //默认动作(方法)
);
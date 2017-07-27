<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\UserModel;

//定义用户控制器类，并继承基础控制器类
final class UserController extends BaseController{
	//显示用户列表
	public function index()
	{
		$this->denyAccess();
		//创建用户模模型类对象
		$modelObj = UserModel::getInstance();
		//调用模型类对象的fetchAll()方法，返回多行数据
		$users = $modelObj->fetchAll();
		//向视图赋值，并显示视图文件
		$this->smarty->assign("users",$users);
		$this->smarty->display("User/index.html");
	}

	//显示添加用户的表单
	public function add()
	{
		$this->denyAccess();
		$this->smarty->display("User/add.html");
	}

	//插入表单数据到数据库
	public function insert()
	{
		$this->denyAccess();
		//(1)获取表单提交值
		$data['username']	= $_POST['username'];
		//判断用户名是否存在
		$records = UserModel::getInstance()->rowCount("username='{$data['username']}'");
		if($records)
		{
			$this->jump("用户名{$data['username']}已经被注册了！","?c=User&a=add");
		}
		//判断两次密码是否一致
		if($_POST['password']!=$_POST['confirmpwd'])
		{
			$this->jump("两次输入的密码不一致","?c=User&a=add");
		}
		$data['password']	= md5($_POST['password']);
		$data['name']		= $_POST['name'];
		$data['tel']		= $_POST['tel'];
		$data['status']		= $_POST['status'];
		$data['role']		= $_POST['role'];
		$data['addate']		= time();
		//(2)调用模型类对象的insert()方法写入数据
		UserModel::getInstance()->insert($data);
		//(3)跳转到列表页
		$this->jump("用户注册成功！","?c=User",5);
	}

	//显示修改用户的表单
	public function edit()
	{
		$this->denyAccess();
		$id = $_GET['id'];
		$user = UserModel::getInstance()->fetchOne("id={$id}");
		$this->smarty->assign("user",$user);
		$this->smarty->display("User/edit.html");
	}

	//更新用户资料
	public function update()
	{
		$this->denyAccess();
		//(1)获取表单提交值
		$id	= $_POST['id'];
		//判断密码是否为空，如果为空，则不更新密码
		if($_POST['password']==$_POST['confirmpwd'])
		{
			if(!empty($_POST['password']))
			{
				$data['password'] = md5($_POST['password']);
			}
		}
		$data['name']		= $_POST['name'];
		$data['tel']		= $_POST['tel'];
		$data['status']		= $_POST['status'];
		$data['role']		= $_POST['role'];
		//(2)更新表单数据
		UserModel::getInstance()->update($data,$id);
		//(3)跳转到列表页
		$this->jump("id={$id}的用户更新成功！","?c=User");
	}

	//删除用户
	public function delete()
	{
		$this->denyAccess();
		$id = $_GET['id'];
		$modelObj = UserModel::getInstance();
		if($modelObj->delete($id))
		{
			$this->jump("id={$id}的用户删除成功！","?c=User");
		}else
		{
			$this->jump("id={$id}的用户删除失败！","?c=User");
		}
	}

	//用户登录的方法
	public function login()
	{
		//调用登录的视图文件login.html
		$this->smarty->display("User/login.html");
	}

	//用户登录检测的方法
	public function loginCheck()
	{
		//(1)获取表单提交值
		$username	= $_POST['username'];
		$password	= md5($_POST['password']);
		$verify		= $_POST['verify'];
		$data['last_login_ip']		= $_SERVER['REMOTE_ADDR'];
		$data['last_login_time']	= time();
		
		//(2)判断验证码输入是否正确
		if(strtolower($verify)!=$_SESSION['captcha'])
		{
			$this->jump("验证码没有输入或输入有误！","?c=User&a=login");
		}

		//(3)判断用户输入的登录信息是否正确
		$user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
		if(empty($user))
		{
			$this->jump("用户名或密码不正确！","?c=User&a=login");
		}
		//(3)更新用户信息：最后登录的IP、最后登录的时间、登录次数加1
		UserModel::getInstance()->loginUpdate($data,$user['id']);
		//(4)将用户必要信息存入SESSION
		$_SESSION['uid']		= $user['id']; //用户id
		$_SESSION['username']	= $username;   //用户名称
		//(4)跳转到后台管理首页
		$this->jump("用户登录成功，正在跳转到后台管理首页！","?c=Index");
	}

	//验证码方法
	public function captcha()
	{
		//创建验证码的对象
		$c = new \Frame\Vendor\Captcha();
		//获取验证码的值，并存入SESSION
		$_SESSION['captcha'] = $c->getCode();
	}

	//用户退出
	public function logout()
	{
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		session_destroy(); //删除SESSION文件
		$this->jump("用户退出成功！","?c=User&a=login");
	}
}
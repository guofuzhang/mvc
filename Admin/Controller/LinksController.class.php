<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\LinksModel;

//定义友情链接控制器类
final class LinksController extends BaseController{
	//友情链接首页
	public function index()
	{
		$links = LinksModel::getInstance()->fetchAll();
		$this->smarty->assign("links",$links);
		$this->smarty->display("Links/index.html");
	}

	//添加友情链接
	public function add()
	{
		$this->smarty->display("Links/add.html");
	}

	//插入友情链接数据
	public function insert()
	{
		//获取表单数据
		$data['domain']	= $_POST['domain'];
		$data['url']	= $_POST['url'];
		$data['orderby']= $_POST['orderby'];
		//写入数据
		LinksModel::getInstance()->insert($data);
		//跳转到列表页
		$this->jump("记录添加成功","?c=Links");
	}

	//显示修改用户的表单
	public function edit()
	{
		$this->denyAccess();
		$id = $_GET['id'];
		$link = LinksModel::getInstance()->fetchOne("id={$id}");
		$this->smarty->assign("link",$link);
		$this->smarty->display("Links/edit.html");
	}

	//更新友情链接
	public function update()
	{
		$this->denyAccess();
		//(1)获取表单提交值
		$id	= $_POST['id'];
		$data['domain']		= $_POST['domain'];
		$data['url']		= $_POST['url'];
		$data['orderby']	= $_POST['orderby'];
		//(2)更新表单数据
		LinksModel::getInstance()->update($data,$id);
		//(3)跳转到列表页
		$this->jump("id={$id}的记录更新成功！","?c=Links");
	}

	//删除用户
	public function delete()
	{
		$this->denyAccess();
		$id = $_GET['id'];
		$modelObj = LinksModel::getInstance();
		if($modelObj->delete($id))
		{
			$this->jump("id={$id}的记录删除成功！","?c=Links");
		}else
		{
			$this->jump("id={$id}的记录删除失败！","?c=Links");
		}
	}
}
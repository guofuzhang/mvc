<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;

//定义文章分类控制器类
final class CategoryController extends BaseController{
	//显示分类列表
	public function index()
	{
		//获取分类的原始数据
		$categorys = CategoryModel::getInstance()->fetchAll();

		//获取无限级分类数据：调用模型类的无限级分类方法categoryList()
		$categorys = CategoryModel::getInstance()->categoryList($categorys);

		//调用视图显示
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Category/index.html");
	}

	//添加文章分类
	public function add()
	{
		//获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		//向视图赋值，并显示视图
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Category/add.html");
	}

	//插入文章分类数据
	public function insert()
	{
		//获取表单数据
		$data['classname']	= $_POST['classname'];
		$data['orderby']	= $_POST['orderby'];
		$data['pid']		= $_POST['pid'];
		//调用模型类的insert()方法，写入数据
		CategoryModel::getInstance()->insert($data);
		//跳转到列表页
		$this->jump("文章分类添加成功！","?c=Category");
	}

	//修改分类数据
	public function edit()
	{
		//获取地址栏的id参数
		$id = $_GET['id'];
		//获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		//根据ID获取一条记录
		$arr = CategoryModel::getInstance()->fetchOne("id={$id}");

		//向视图赋值，并显示视图
		$this->smarty->assign(array(
			'categorys'	=> $categorys,
			'arr'		=> $arr,
		));
		$this->smarty->display("Category/edit.html");
	}

	//更新分类的方法
	public function update()
	{
		//获取表单提交值
		$id	= $_POST['id'];
		$data['classname']	= $_POST['classname'];
		$data['orderby']	= $_POST['orderby'];
		$data['pid']		= $_POST['pid'];
		//更新数据到数据库
		CategoryModel::getInstance()->update($data,$id);
		//跳转到列表页
		$this->jump("id={$id}的记录更新成功！","?c=Category");
	}

	//删除记录
	public function delete()
	{
		$id = $_GET['id'];
		CategoryModel::getInstance()->delete($id);
		$this->jump("id={$id}记录删除成功！","?c=Category");
	}
}
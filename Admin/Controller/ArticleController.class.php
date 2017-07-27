<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;
use \Admin\Model\ArticleModel;

//定义文章控制器类
final class ArticleController extends BaseController{

	//文章首页
	public function index()
	{
		//(1)获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);

		//(2)构建搜索条件
		$where		= "2>1";
		if(!empty($_REQUEST['category_id'])){
			$where .= " AND category_id=".$_REQUEST['category_id'];
		}
		if(!empty($_REQUEST['keyword'])){
			$where .= " AND title LIKE '%".$_REQUEST['keyword']."%'";
		}

		//(3)分页参数
		$orderby	= "id desc";
		$pagesize	= 10;
		$page		= isset($_GET['page']) ? $_GET['page'] : 1;
		$startrow	= ($page-1)*$pagesize;
		$records	= ArticleModel::getInstance()->rowCount($where);
		$params		= array(
			'c'	=> CONTROLLER,
			'a'	=> ACTION,
		);
		if(!empty($_REQUEST['category_id'])) $params['category_id'] = $_REQUEST['category_id'];
		if(!empty($_REQUEST['keyword'])) $params['keyword'] = $_REQUEST['keyword'];


		//(4)获取连表查询的分页的文章数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);

		//(5)创建分页对象
		$pageObj = new \Frame\Vendor\Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();
		
		//(6)向视图赋值，并显示视图
		$this->smarty->assign(array(
			'categorys'	=> $categorys,
			'articles'	=> $articles,
			'pageStr'	=> $pageStr,
		));
		$this->smarty->display("Article/index.html");
	}

	//添加文章
	public function add()
	{
		//获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		//向视图赋值，并显示视图
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Article/add.html");
	}

	//插入文章数据
	public function insert()
	{
		//获取表单提交值
		$data['category_id']	= $_POST['category_id'];
		$data['user_id']		= $_SESSION['uid'];
		$data['title']			= $_POST['title'];
		$data['content']		= $_POST['content'];
		$data['orderby']		= $_POST['orderby'];
		$data['top']			= isset($_POST['top']) ? 1 : 0;
		$data['addate']			= time();
		//调用模型类对象的insert()方法，写入数据
		ArticleModel::getInstance()->insert($data);
		//跳转到列表页
		$this->jump("文章添加成功！","?c=Article");
	}

	//显示编辑文章的表单
	public function edit()
	{
		//(1)根据传递的id，获取对应的一条记录
		$id = $_GET['id'];
		$article = ArticleModel::getInstance()->fetchOne("id={$id}");
		
		//(2)获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);

		//(3)向视图赋值，并调用视图显示
		$this->smarty->assign(array(
			"article"	=> $article,
			"categorys"	=> $categorys,
		));
		$this->smarty->display("Article/edit.html");
	}

	//更新文章数据
	public function update()
	{
		//(1)获取表单提交数据
		$id	= $_POST["id"];
		$data['category_id']	= $_POST['category_id'];
		$data['title']			= $_POST['title'];
		$data['orderby']		= $_POST['orderby'];
		$data['top']			= empty($_POST['top']) ? 0 : 1;
		//给文章内容中的特殊符号，进行转义，如：\\、\'、\"
		$data['content']		= addslashes($_POST['content']); 

		//(2)调用文章模型类对象的update()方法
		ArticleModel::getInstance()->update($data,$id);

		//(3)跳转到列表页
		$this->jump("id={$id}的记录更新成功！","?c=Article");
	}

	//删除文章
	public function delete()
	{
		$id = $_GET['id'];
		ArticleModel::getInstance()->delete($id);
		$this->jump("id={$id}的文章删除成功！","?c=Article");
	}
}
<?php
//声明命名空间
namespace Home\Controller;
use \Frame\Libs\BaseController;
use \Home\Model\LinksModel;
use \Home\Model\CategoryModel;
use \Home\Model\ArticleModel;

//定义首页控制器
final class IndexController extends BaseController{
	
	//首页显示方法
	public function index()
	{
		//(1)获取友情链接的数据
		$links = LinksModel::getInstance()->fetchAll();

		//(2)获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAllWithJoin()
		);

		//(3)获取文档按月份归档数据
		$dates = ArticleModel::getInstance()->fetchAllWithJoinAndCount();

		//(4)构建查询条件
		$where = "2>1";
		if(!empty($_GET['category_id'])) $where .= " AND category_id=".$_GET['category_id'];
		if(!empty($_REQUEST['title']))   $where .= " AND title like '%".$_REQUEST['title']."%'";

		//(5)分页参数
		$orderby	= "id desc";
		$pagesize	= 3;
		$page		= !empty($_GET['page']) ? $_GET['page'] : 1;
		$startrow	= ($page-1)*$pagesize;
		$records	= ArticleModel::getInstance()->rowCount($where);
		$params		= array(
			'c'	=> CONTROLLER,
			'a'	=> ACTION,
		);
		if(!empty($_GET['category_id'])) $params['category_id'] = $_GET['category_id'];
		if(!empty($_REQUEST['title']))   $params['title'] = $_REQUEST['title'];

		//(5)获取连表查询的文章的分页数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);
		
		//(6)分页字符串
		$pageObj = new \Frame\Vendor\Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();
		
		//向视图赋值，并显示视图文件
		$this->smarty->assign(array(
			'links'		=> $links,
			'categorys'	=> $categorys,
			'dates'		=> $dates,
			'articles'	=> $articles,
			'pageStr'	=> $pageStr,
		));
		$this->smarty->display("Index/index.html");
	}

	//博文目录
	public function showList()
	{
		//(1)获取友情链接的数据
		$links = LinksModel::getInstance()->fetchAll();

		//(2)获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAllWithJoin()
		);

		//(3)获取文档按月份归档数据
		$dates = ArticleModel::getInstance()->fetchAllWithJoinAndCount();

		//(4)构建查询条件
		$where = "2>1";
		if(!empty($_GET['category_id'])) $where .= " AND category_id=".$_GET['category_id'];
		if(!empty($_REQUEST['title']))   $where .= " AND title like '%".$_REQUEST['title']."%'";

		//(5)分页参数
		$orderby	= "id desc";
		$pagesize	= 30;
		$page		= !empty($_GET['page']) ? $_GET['page'] : 1;
		$startrow	= ($page-1)*$pagesize;
		$records	= ArticleModel::getInstance()->rowCount($where);
		$params		= array(
			'c'	=> CONTROLLER,
			'a'	=> ACTION,
		);
		if(!empty($_GET['category_id'])) $params['category_id'] = $_GET['category_id'];
		if(!empty($_REQUEST['title']))   $params['title'] = $_REQUEST['title'];

		//(5)获取连表查询的文章的分页数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);
		
		//(6)分页字符串
		$pageObj = new \Frame\Vendor\Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();
		
		//向视图赋值，并显示视图文件
		$this->smarty->assign(array(
			'links'		=> $links,
			'categorys'	=> $categorys,
			'dates'		=> $dates,
			'articles'	=> $articles,
			'pageStr'	=> $pageStr,
		));
		//向视图赋值，并显示视图
		$this->smarty->display("Index/list.html");
	}

	//显示文章详细内容
	public function content()
	{
		//(1)根据传递的文章的id，获取连表查询的数据
		$id = $_GET['id'];
		$article = ArticleModel::getInstance()->fetchOneWithJoin($id);

		//(2)更新阅读数
		ArticleModel::getInstance()->updateRead($id);

		//(3)获取前一条或后一条文章数据
		$prevNext[] = ArticleModel::getInstance()->fetchOne("id<$id","id desc");
		$prevNext[] = ArticleModel::getInstance()->fetchOne("id>$id");

		//(4)向视图赋值，并显示视图
		$this->smarty->assign(array(
			"article"	=> $article,
			"prevNext"	=> $prevNext,
		));
		$this->smarty->display("Index/content.html");
	}

	//文章点赞方法
	public function praise()
	{
		//只有登录用户，才可以点赞
		if(isset($_SESSION['username']))
		{
			//获取文章id
			$id = $_GET['id'];
			//判断文章是否点赞过
			if(empty($_SESSION['praise'][$id]))
			{
				//更新文章的点赞数
				ArticleModel::getInstance()->updatePraise($id);
				//将点赞的状态存入SESSION
				$_SESSION['praise'][$id] = 1;
				//跳转到上一个页面
				$this->jump("id={$id}的文章点赞成功！","?c=Index&a=content&id=$id");
			}else
			{
				//跳转到上一个页面
				$this->jump("id={$id}的文章已经点赞了，不能重复点赞！","?c=Index&a=content&id=$id");
			}
		}else
		{
			//跳转登录页面
			$this->jump("只有登录用户才能点赞！","./admin.php");
		}
	}
}
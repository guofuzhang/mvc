<?php
//声明命名空间 
namespace Home\Model;
use \Frame\Libs\BaseModel;

//定义文章分类模型类
final class CategoryModel extends BaseModel{
	
	//受保护的数据表名称
	protected $table = "category";

	//获取无限级分类数据
	public function categoryList($arrs,$level=0,$pid=0)
	{
		static $categorys = array();
		//循环遍历分类的原始数据
		foreach($arrs as $arr)
		{
			//如果传递的$pid参数，与$arr['pid']相等，就将该记录加入到新数组$categorys
			if($pid==$arr['pid'])
			{
				$arr['level'] = $level; //添加新元素，来记录菜单的等级
				$categorys[] = $arr; //将新的数组元素，添加到$categorys数组中

				//递归调用
				$this->categoryList($arrs,$level+1,$arr['id']);
			}
		}
		//返回结果数组
		return $categorys;
	}

	//获取连表查询的文章分类数据
	public function fetchAllWithJoin()
	{
		//构建连表查询的SQL语句
		$sql = "SELECT category.*,count(article.id) AS article_count FROM category ";
		$sql .= "LEFT JOIN article ON category.id=article.category_id ";
		$sql .= "GROUP BY category.id";

		//执行SQL语句，并返回二维数组
		return $this->pdo->fetchAll($sql);
	}
}
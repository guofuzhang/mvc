<?php
//声明命名空间
namespace Admin\Model;
use \Frame\Libs\BaseModel;

//定义文章模型类
final class ArticleModel extends BaseModel{
	
	//受保护的数据表名称
	protected $table = "article";

	//获取连表查询的文章数据
	public function fetchAllWithJoin($where="2>1",$orderby="id desc",$startrow=0,$pagesize=10)
	{
		//构建连表查询的SQL语句
		$sql = "SELECT article.*,category2.classname,user.username FROM article";
		$sql .= " LEFT JOIN category2 ON article.category_id=category2.id";
		$sql .= " LEFT JOIN user ON article.user_id=user.id";
		$sql .= " WHERE {$where}";
		$sql .= " ORDER BY {$orderby}";
		$sql .= " LIMIT $startrow,$pagesize";

		//执行SQL语句，并返回二维数组
		return $this->pdo->fetchAll($sql);
	}
}
<?php
//声明命名空间
namespace Home\Model;
use \Frame\Libs\BaseModel;

//定义文章模型类
final class ArticleModel extends BaseModel{
	
	//受保护的数据表名称
	protected $table = "article";

	//获取文章按月份归档数据
	public function fetchAllWithJoinAndCount()
	{
		//构建查询的SQL语句
		$sql = "SELECT date_format(from_unixtime(addate),'%Y年%m月') AS months,";
		$sql .= "count(id) AS article_count FROM article ";
		$sql .= "GROUP BY months ORDER BY months DESC";
		//执行SQL语句，并返回结果
		return $this->pdo->fetchAll($sql);
	}

	//获取连表查询的文章数据
	public function fetchAllWithJoin($where="2>1",$orderby="id desc",$startrow=0,$pagesize=10)
	{
		//构建查询的SQL语句
		$sql = "SELECT article.*,user.name,category.classname FROM article ";
		$sql .= "LEFT JOIN user ON user.id=article.user_id ";
		$sql .= "LEFT JOIN category ON category.id=article.category_id ";
		$sql .= "WHERE {$where} ";
		$sql .= "ORDER BY {$orderby} ";
		$sql .= "LIMIT {$startrow},{$pagesize}";
		//执行SQL语句，并返回结果
		return $this->pdo->fetchAll($sql);
	}

	//获取指定id的连表查询的数据
	public function fetchOneWithJoin($id)
	{
		//构建查询的SQL语句
		$sql = "SELECT article.*,user.name,category.classname FROM article ";
		$sql .= "LEFT JOIN user ON user.id=article.user_id ";
		$sql .= "LEFT JOIN category ON category.id=article.category_id ";
		$sql .= "WHERE article.id={$id}";
		//执行SQL语句，并返回结果
		return $this->pdo->fetchOne($sql);
	}

	//更新阅读数
	public function updateRead($id)
	{
		//构建更新的SQL语句
		$sql = "UPDATE {$this->table} SET `read`=`read`+1 WHERE id={$id}";
		//执行SQL语句
		return $this->pdo->exec($sql);
	}

	//更新点赞数
	public function updatePraise($id)
	{
		//构建更新的SQL语句
		$sql = "UPDATE {$this->table} SET `praise`=`praise`+1 WHERE id={$id}";
		//执行SQL语句
		return $this->pdo->exec($sql);
	}
}
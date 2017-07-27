<?php
/**
 * Created by PhpStorm.
 * User: zhangqingbai
 * Date: 2017-07-25 0025
 * Time: 12:15
 */
//该类创建一个db对象
namespace Admin\Model;
use \Frame\Libs\Db;

final class IndexModel
{
    private $db=null;
//    类内初始化db对象,用db属性存储

    public function __construct()
    {
        $this->db=Db::getInstance();
    }
//获取到多行数据,对象下的db方法
    public function fetchALL()
    {
        $sql="select * from student ORDER BY id DESC limit 5 ";
        return $this->db->fetchAll($sql);
    }

    public function delete($id)
    {
        $sql="delete * from student where id=$id";
        return $this->exec($sql);
    }

}
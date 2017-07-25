<?php
/**
 * Created by PhpStorm.
 * User: zhangqingbai
 * Date: 2017-07-19 0019
 * Time: 23:20
 */
namespace Admin\Controller;
use Admin\Model\IndexModel;
final class IndexController{
//    定义首页控制器类
//控制器下的方法
    public function index()
    {
        $IndexObj=new IndexModel();
       $arr=$IndexObj->fetchALL();
       include VIEW_PATH.DS."index.php";
}
}
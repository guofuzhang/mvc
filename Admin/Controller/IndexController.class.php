<?php
/**
 * Created by PhpStorm.
 * User: zhangqingbai
 * Date: 2017-07-19 0019
 * Time: 23:20
 */
namespace Admin\Controller;
use Admin\Model\IndexModel;
use Frame\Libs\baseController;

final class IndexController extends baseController {
//    定义首页控制器类
//控制器下的方法
    public function index()
    {
        $IndexObj=IndexModel::getinstance();
       $arr=$IndexObj->fetchALL();
       include VIEW_PATH.DS."index.php";
       $this->smarty->assign("arr",$arr);
       $this->smarty->display("index.html");
}

    public function delete()
    {
        $id=$_GET['id'];
        $modelObj=IndexModel::getinstance();
        $modelObj->delete($id);
        $this->jump("已经删除","?",3);
}
   protected  function  jump($msg,$url,$time){
        echo "$msg";
        header("refresh:$time;url=$url");
   }
}
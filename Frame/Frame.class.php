<?php
//声明命名空间
namespace Frame;
//框架初始类文件
use Frame\Libs\Db;
use Illuminate\Routing\Controller;

final class Frame
{
    public static function run()
    {
        //网页字符集//初始化配置文件//获取路由参数//常用常量设置 类的自动加载,请求分发
        self::initCharset();//设置字符集
        self::initConfig();//设置配置文件
        self::initRoute();//初始化路由参数
        self::initConst();//初始化常量
        self::initAutoload();//类的自动加载
        self::initDispatch();//请求分发

    }

    private static function initCharset()
    {
        header("content-type:text/html;charset=utf-8");
//        echo "背景";
    }

    private static function initConfig()
    {
        $GLOBALS['config']=require_once(APP_PATH.'Conf'.DS.'Config.php');
    }

    private static function initRoute()
    {
//        获取平台的名称,控制器名称,动作名称
        $p=$GLOBALS['config']['default_platform'];
        $c=isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['default_controller'];
        $a=isset($_GET['a'])?$_GET['a']:$GLOBALS['config']['default_action'];
//        var_dump($p,$c,$a);
//            $p $c $a
        define("PLAT",$p);
        define("CONTROLLER",$c);
        define("ACTION",$a);
    }

    private static function initConst()
    {
        define("VIEW_PATH",APP_PATH.'View'.DS.CONTROLLER.DS);
        define("FRAME_PATH",ROOT_PATH.DS.'Frame'.DS);
    }

    public static function initAutoLoad()
    {
        spl_autoload_register(function ($className){
//            类的自动加载
            $filename=ROOT_PATH.str_replace("\\",DS,$className).".class.php";//转换目录下的斜线
//            echo $filename;
            if(file_exists($filename)) {require_once ($filename);};
            echo "<pre>";
            echo $filename;
        });

    }

    private static function initDispatch()
    {
        //构建控制器类名：\Home\Controller\NewsController()
        $c = "\\".PLAT.DS."Controller".DS.CONTROLLER . "Controller";
        //创建控制器类对象
        $ctr= new $c();
        //调用控制器对象的方法
        $a = ACTION;
        $ctr->$a();
    }




}
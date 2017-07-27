<?php
//声明命名空间
namespace Frame\Vendor;
//包含原始的Smarty类文件
/*
	Smarty文件的真实路径：./Frame/Vendor/Smarty/libs/Smarty.class.php
	将路径的斜线，转成DS：FRAME_PATH."Vendor".DS."Smarty".DS."libs".DS."Smarty.class.php"
*/
require_once(FRAME_PATH."Vendor".DS."Smarty".DS."libs".DS."Smarty.class.php");
//定义Smarty类，并继承原始的Smarty类
final class Smarty extends \Smarty{
	
}
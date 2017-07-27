<?php
//******************后端的入口文件************************
//(0)常用常量的设置
define("DS",DIRECTORY_SEPARATOR);//目录分割符、动态的
define("ROOT_PATH",getcwd()); //网站根目录
define("APP_PATH",ROOT_PATH.DS."Admin".DS);//完整路径：./Admin/

//(1)包含框架初始类文件
require_once(ROOT_PATH.DS."Frame".DS."Frame.class.php");
//(2)调用初始化框架类的方法
\Frame\Frame::run();
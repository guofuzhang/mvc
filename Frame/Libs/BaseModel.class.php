<?php
namespace Frame\Libs;
use  \Frame\Vendor\PDOWrapper;
abstract class BaseModel{
    protected $pdo=null;

    public function __construct()
    {
        $this->pdo=new PDOWrapper();
    }

    protected static $modelObjarr=array();
    public static function getinstance()
    {

        $modelclassname=get_called_class();
        if(!isset(self::$modelObjarr[$modelclassname])){
            self::$modelObjarr[$modelclassname]=new $modelclassname;
        }
        return self::$modelObjarr[$modelclassname];
    }

}
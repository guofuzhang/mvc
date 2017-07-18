<?php
namespace Frame\Libs;
use  \Frame\Vendor\PDOWrapper;
abstract class BaseModel{
    protected $pdo=null;

    public function __construct()
    {
        $this->pdo=new PDOWrapper();
    }

}
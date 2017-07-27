<?php
namespace Frame\Libs;
use  \Frame\Vendor\Smarty;
abstract class baseController{
    protected $smarty=null;

    public function __construct()
    {
        $this->initSmarty();
    }

    protected function initSmarty(){
      $smarty=new Smarty();
      $smarty->left_delimiter="<{";
      $smarty->right_delimiter="}>";
      $smarty->setTemplateDir(VIEW_PATH);
      $smarty->setCompileDir(sys_get_temp_dir());
      $this->smarty=$smarty;
    }
}
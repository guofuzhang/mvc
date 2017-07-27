<?php
//声明命名空间
namespace Admin\Model;
use \Frame\Libs\BaseModel;

//定义文章分类模型类
final class CategoryModel extends BaseModel{
	
	//受保护的数据表名称
	protected $table = "category2";

	//获取无限级分类数据
	public function categoryList($arrs,$level=0,$pid=0)
	{
		/*
			参数说明：
			$arrs原始分类数据
			$level菜单的等级：第1级、第2级、第3级，与缩进和空格数有关
			$pid，当前菜单的id，就是下级菜单的pid
		*/
		//静态变量：函数或方法执行完毕，该变量不消失。
		//静态变量，只在第1次调用时，初始化一次，以后就不再初始化了
		static $categorys = array();
		//循环遍历分类的原始数据
		foreach($arrs as $arr)
		{
			//如果传递的$pid参数，与$arr['pid']相等，就将该记录加入到新数组$categorys
			if($pid==$arr['pid'])
			{
				$arr['level'] = $level; //添加新元素，来记录菜单的等级
				$categorys[] = $arr; //将新的数组元素，添加到$categorys数组中

				//递归调用
				$this->categoryList($arrs,$level+1,$arr['id']);
			}
		}
		//返回结果数组
		return $categorys;
	}
}
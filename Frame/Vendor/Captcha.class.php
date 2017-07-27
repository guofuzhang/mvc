<?php
//声明命名空间
namespace Frame\Vendor;

//定义图像验证码类
final class Captcha{
	//私有的成员属性
	private $code;		//验证码字符串
	private $codelen;	//字符串长度
	private $width;		//图片宽度
	private $height;	//图片高度
	private $fontsize;	//文字大小
	private $fontfile;	//字体文件
	private $img;		//图像资源

	//构造方法
	public function __construct($codelen=4,$width=85,$height=40,$fontsize=18)
	{
		$this->codelen	= $codelen;
		$this->width	= $width;
		$this->height	= $height;
		$this->fontsize	= $fontsize;
		$this->fontfile	= "./Public/Admin/Images/msyh.ttf";
		$this->createCode();	//生成随机验证码字符串
		$this->createImg();		//创建画布
		$this->createBg();		//填充背景色
		$this->createText();	//写入字符串
		$this->outPut();		//输出图像
	}

	//生成验证码字符串
	private function createCode()
	{
		$str = "";
		$arr_list = array_merge(range('A','Z'),range(0,9)); //合并数组
		shuffle($arr_list); //打乱数组
		shuffle($arr_list); //打乱数组
		$arr_index = array_rand($arr_list,4); //随机取4个下标
		//根据下标，取回对应的数组元素的值
		foreach($arr_index as $index)
		{
			$str .= $arr_list[$index];
		}
		$this->code = $str; //向code属性赋值
	}

	//创建图像画布
	private function createImg()
	{
		//创建画布，并生成图像资源，所有操作都是基于该画布的
		$this->img = imagecreatetruecolor($this->width,$this->height);
	}

	//填充背景色
	private function createBg()
	{
		//分配颜色
		$color = imagecolorallocate($this->img,mt_rand(0,250),mt_rand(0,250),mt_rand(0,250));
		//在画布上绘制一个填充矩形
		imagefilledrectangle($this->img,0,0,$this->width,$this->height,$color);
	}

	//写入字符串
	private function createText()
	{
		//分配文本颜色
		$color = imagecolorallocate($this->img,mt_rand(0,200),mt_rand(0,200),mt_rand(0,200));
		//写入字符串
		imagettftext($this->img,$this->fontsize,0,8,30,$color,$this->fontfile,$this->code);
	}

	//输出图像
	private function outPut()
	{
		header("content-type:image/png");
		imagepng($this->img);
		imagedestroy($this->img);
	}

	//外部获取验证码字符串
	public function getCode()
	{
		//将验证码转成全小写，验证码不区分大小写
		return strtolower($this->code);
	}
}
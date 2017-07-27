<?php
//声明命名空间
namespace Frame\Vendor;

//定义分页类
final class Pager{
	//私有的成员属性
	private $pagesize;	//每页显示多少条
	private $page;		//当前页码
	private $records;	//总记录数
	private $pages;		//总页数
	private $first;		//首页
	private $prev;		//上一页
	private $next;		//下一页
	private $last;		//最后一页
	private $url;		//链接地址  例如：?c=Article&a=index&page=1
	
	//构造方法
	public function __construct($pagesize,$page,$records,$params=array())
	{
		$this->pagesize	= $pagesize;
		$this->page		= $page;
		$this->records	= $records;
		$this->pages	= ceil($this->records/$this->pagesize);
		$this->url		= $this->getUrl($params);	//构建链接地址
		$this->first	= $this->getFirst();	//获取[首页]字符串
		$this->prev		= $this->getPrev();	//获取[上一页]字符串
		$this->next		= $this->getNext();
		$this->last		= $this->getLast();
	}

	//构建链接的地址
	private function getUrl($params)
	{
		/*
			参数$params是一个数组，数组元素为：
			array(
				'c'				=> 'Article',
				'a'				=> 'index',
				'category_id'	=> 23,
				'title'			=> '北京'
			)
			//最终结果：?c=Article&a=index&page=1
		*/
		$str = "";
		foreach($params as $key=>$value)
		{
			$str .= "$key=$value&";
		}
		//返回链接地址
		return "?".$str."page=";
	}

	//获取首页字符串
	private function getFirst()
	{
		if($this->page==1)
		{
			return "[首页]";
		}else
		{
			return "[<a href='{$this->url}1'>首页</a>]";
		}
	}

	//获取上一页字符串
	private function getPrev()
	{
		if($this->page==1)
		{
			return "[上一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page-1)."'>上一页</a>]";
		}
	}

	//获取下一页字符串
	private function getNext()
	{
		if($this->page==$this->pages)
		{
			return "[下一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page+1)."'>下一页</a>]";
		}
	}

	//获取最后一页字符串
	private function getLast()
	{
		if($this->page==$this->pages)
		{
			return "[最后一页]";
		}else
		{
			return "[<a href='{$this->url}{$this->pages}'>最后一页</a>]";
		}
	}

	//返回分页字符串
	public function showPageStr()
	{
		//如果只有1页，只显示总记录数
		if($this->pages>1)
		{
			$str = "共有{$this->records}条记录 每页显示{$this->pagesize}条记录 ";
			$str .= "当前{$this->page}/{$this->pages} ";
			$str .= "{$this->first} {$this->prev} {$this->next} {$this->last}";
			return $str;
		}else
		{
			return "共有{$this->records}条记录";
		}
	}

}
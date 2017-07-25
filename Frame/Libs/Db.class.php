<?php
/**
 * Created by PhpStorm.
 * User: zhangqingbai
 * Date: 2017-07-19 0019
 * Time: 23:26
 */
namespace Frame\Libs;
final class Db
{
    private static $obj = null;
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $charset;

    private function __construct()
    {
        $this->db_host = $GLOBALS['config']['db_host'];
        $this->db_user = $GLOBALS['config']['db_user'];
        $this->db_pass = $GLOBALS['config']['db_pass'];
        $this->db_name = $GLOBALS['config']['db_name'];
        $this->charset = $GLOBALS['config']['charset'];
        $this->f_mysql_connect();
        $this->f_mysql_select();
        $this->f_charset();
    }

    private function __clone()
    {
//
    }

    public static function getInstance()
    {
        if (!self::$obj instanceof self) {
            self::$obj = new self();
        }
        return self::$obj;

    }

    private function f_mysql_connect()
    {

        if (@!mysql_connect($this->db_host, $this->db_user, $this->db_pass)) {
            die("数据库连接失败");
        }
    }

    private function f_mysql_select()
    {
        if (@!mysql_select_db("itcast")) {
            exit("数据库选择失败");
        };

    }

    private function f_charset()
    {
        return $this->exec("set names $this->charset");
    }

    public function exec($sql)
    {
        $sql = strtolower($sql);
        if (substr($sql, 0, 6) == "select") {
            die("请使用query()方法执行当前的sql语句");
        } else {
            return mysql_query($sql);
        }
    }

    public function query($sql)
    {
        $sql = strtolower($sql);
        if (substr($sql, 0, 6) != "select") {
            die("请使用exec
            ()方法执行当前的sql语句");
        } else {
            return mysql_query($sql);
        }


    }
//获取一行数据
    public function fetchOne($sql,$type=3)
    {
        $res=$this->query($sql);
        $types=array(
            "1"=>MYSQL_BOTH,
            "2"=>MYSQL_NUM,
            "3"=>MYSQL_ASSOC,
    );

        return mysql_fetch_array($res,$types[$type]);
    }
//获取多行数据
    public function fetchAll($sql,$type=3)
    {
        $res=$this->query($sql);
        $types=array(
            "1"=>MYSQL_BOTH,
            "2"=>MYSQL_NUM,
            "3"=>MYSQL_ASSOC,
        );
        while ($row=mysql_fetch_array($res,$types[$type]))//循环出每一行的结果并返还给数组
        {$arr[]=$row;}
        return $arr;
    }

    public function rowCount($sql)
    {
        $res=$this->query($sql);
        return mysql_num_rows($res);

    }

    public function __destruct()
    {
        mysql_close();
    }
}
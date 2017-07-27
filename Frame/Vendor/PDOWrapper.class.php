<?php
/**
 * Created by PhpStorm.
 * User: zhangqingbai
 * Date: 2017-07-22 0022
 * Time: 9:46
 */
namespace Frame\Vendor;
use PDO;
use PDOException;//错误处理方式
final class PDOWrapper{
    private $dbhost;
    private $dbname;
    private $dbtype;
    private $dbport;
    private $username;
    private $password;
    private $charset;
    private $pdo;

    public function __construct()
    {

        $this->dbtype=$GLOBALS['config']['db_type'];
        $this->dbhost=$GLOBALS['config']['db_host'];
        $this->dbport=$GLOBALS['config']['db_port'];
        $this->dbname=$GLOBALS['config']['db_name'];
        $this->charset=$GLOBALS['config']['charset'];
        $this->username=$GLOBALS['config']['db_user'];
        $this->password=$GLOBALS['config']['db_pass'];
        $this->pdo();
        $this->seterror();

    }

    private function pdo()
    {
        try{
            $dsn="{$this->dbtype}:dbhost={$this->dbhost};dbport={$this->dbport};charset={$this->charset}";
            $pdo_username="{$this->username}";
            $pdo_password="{$this->password}";
            $this->pdo=new PDO($dsn,$pdo_username,$pdo_password);


        }catch (PDOException $e){
//            这个信息文件有一行码错误;
            $str="错误信息:".$e->getMessage();
            $str.="错误文件:".$e->getFile();
            $str.="错误行号:".$e->getLine();
            $str.="错误代码:".$e->getCode();
            echo $str;
        }
    }

    private function seterror()
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }


    public function exec($sql)
    {
        try{
            return $this->pdo->exec($sql);
        }catch (PDOException $e){
            $this->errorshow($e);
        }
    }

    public function fetchOne($sql)
    {
        try{
            $PDOStatement=$this->pdo->query($sql);
            return $PDOStatement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            $this->errorshow($e);
        }
    }

    public function fetchAll($sql)
    {
        try{
            $PDOStatement=$this->pdo->query($sql);
            return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            $this->errorshow($e);
        }
    }

    public function rowCount($sql)
    {
        try{
            $PDOStatement=$this->pdo->query($sql);
            return $PDOStatement->rowCount(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            $this->errorshow($e);
        }
    }


    

    private function errorshow($e)
    {
        $str="当前语句有问题!";
        $str.="错误信息:".$e->getMessage();
        $str.="错误文件:".$e->getFile();
        $str.="错误行号:".$e->getLine();
        $str.="错误代码:".$e->getCode();
        echo $str;

    }
}
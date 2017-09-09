<?php

namespace houdunwang\model;

//PDOException也是一个全局类 所以在命名空间中调用时需要先use 或者加上\
use PDOException;
use PDO;
use Exception;

//View类:与数据库对接
class Base{

    //1.静态属性$pdo:接收pdo对象 便于在不同方法中使用
    //2.赋值null作用:用于判断数据库是否连接
    private static $pdo=null;
    //1.属性$table:表名,查询时表格名字是不固定的 这里用$table存放
    private $table;
    //1.属性$where:存放输入的where条件语句
    //2.给予默认值:空字符串，当没有输入where语句时为空
    private $where='';
    //1.属性$data:存放查询到的数据
    private $data;
    //1.属性$field:存放字段
    private $field = '*';
    //构造方法:一开始连接数据库
    //$class:当前调用的类名，也就是表格对应类，用于截取表格名字
    public function __construct($class)
    {
        //if判断:连接数据库后 $pdo将存放一个对象不为null 这里判断是否已经连接数据库
        if(is_null(self::$pdo)){
            //调用connect方法，连接数据库
            self::connect();
        }
        //dd($class);
        //1.将类名中的表格名截取出来
        $this->table = strtolower(ltrim(strrchr($class,'\\'),'\\'));
        //dd($this->table);
    }

    public static function connect(){
        //try catch语句 获取错误信息
        try{
            //1.$dsn:数据源
            //2.为了更方便的连接不同数据源 将数据的参数存入到配置文件中 当需要连接时更改配置文件即可，不用在繁琐的去更改方法中参数
            //3.c方法:框架中c方法一般用于设置、获取，以及保存配置参数的方法
            $dsn = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
            //连接数据库
            self::$pdo = new PDO($dsn,c('database.user'),c('database.password'));
            //设置字符集
            self::$pdo->query('set name utf8');
            //调用错误属性
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            //throw new PDOException:获取的错误信息更为详细
            throw new PDOException($e->getMessage());
        }
    }

    //find方法:查询数据库中的一条数据
    public function find($id){
        //echo 'find';
        //1.$pk:表格主键
        //2.作用:不同表格的主键命名不同 这里需要从表格中获取下
        //3.getPk方法;获取主键的名称的方法
        $pk = $this->getPk();
        //1.调用where()方法:默认以主键查找
        $this->where("$pk={$id}");
        $field = $this->field;
        //1.$sql:存放拼接的mysql查询语句
        $sql = "select {$field} from ".$this->table." ".$this->where;
        //dd($sql);die;
        //1.变量$data:存放查询到的结果
        //2.因为存在return $this 返回一个对象包括查询到的结果 这里需要一个方法将对象中的数组部分弄出来
        $data = $this->query($sql);
        //1.查询结果为一个二维数组 这里使用current函数转换为一维数组
        //2.问题:当没有查询结果时 $data为空数组 这时current($data)返回false  所以需要一个判断
        if(!empty($data)){
            //有查询结果

            //1.转换一维数组
            $this->data = current($data);
            //1.return:返回对象 便于链式调用
            return $this;
        }
        //1.没有查询结果 直接返回空数组
        return $this;
    }

    //findAll方法:查询多条数据
    public function findAll(){
        //$field:想要查询的字段
        $field = $this->field;
        //$sql:拼接sql语句查询多条数据
        $sql = "select {$field} from {$this->table} {$this->where}";
        //dd($sql);
        //变量$data:存放查询的结果
        $data = $this->query($sql);
        return $this;
    }

    //del方法:删除数据
    //形参$pk:主键键值
    public function del($id=''){
        //1.思考:两种方式 通过主键删除或者其他where条件 而且两种形式必须触发其中一个 才能执行删除操作否则 return false
        //2.if判断:where或者主键键值
        if($this->where || $id){
            //1.如果输入的是主键 则获取主键名称并给属性$where赋值
            if($id){
                //获取主键
                $pk = $this->getPk();
                $this->where = "where $pk={$id}";
            }
            $sql = "delete from {$this->table} {$this->where}";
            //dd($pk);
            //执行sql语句
            //exec方法:执行没有结果集的操作
            //$row:存放返回值
            $row = $this->exec($sql);
            //dd($sql);die;
            return $row;
        }else{
            //不执行删除操作
            return false;
        }
    }

    //update方法:更新数据
    //规定必须传入一个数组
    public function update(array $data){
        //1.判断:当输入了where语句 但是为空字符
        if(trim(empty($this->where))){
            return false;
        }

        //$fields:存取分离好的字段和对应内容
        $fields = '';
        //foreach循环:将数组中的键名键值分别分离成字段和对应内容
        foreach($data as $k=>$v){
            //判断:当字段值为整型时 不需要单引号
            if(is_int($v)){
                $fields .= "$k=$v".',';
            }else{
                $fields .= "$k='$v'".',';
            }
        }
        //去除右侧的逗号
        $fields = rtrim($fields,',');
        //dd($fields);die;
        //dd($data);die;
        $sql = "update {$this->table} set {$fields} {$this->where} ";
        //dd($sql);
        //执行更新语句
        return $this->exec($sql);
    }

    //insert方法:插入数据
    public function insert(array $data){

        //$fields:存取分离好的字段
        $fields = '';
        //$values:存放字段内容
        $values = '';
        //foreach循环:将数组中的键名键值分别分离成字段和对应内容
        foreach($data as $k=>$v){
            //拼接字段
            $fields .= "$k".',';
            //判断:当字段内容为整型时 不需要单引号
            if(is_int($v)){
                $values .= "$v".',';
            }else{
                $values .= "'$v'".',';
            }
        }
        //dd($fields);die;
        //去除右侧逗号
        $fields = rtrim($fields,',');
        $values = rtrim($values,',');
        $sql = "insert into {$this->table} ({$fields}) values($values)";
        //dd($sql);
        //执行dql语句
        return $this->exec($sql);
    }

    //count方法:统计数据
    public function count(){
        //拼接sql语句
        //as作用:方便观察
        $sql = "select {$this->field},count(*) as total from {$this->table} {$this->where}";
        //dd($sql);
        $data = $this->query($sql);
        //dd($data);
        //$total:存放统计出来的数值
        $total = $data[0]['total'];
        //dd($total);
        return $total;
    }

    //orderBy方法:排序
    //形参$field:按照按个字段排序  $style:排序方式
    public function orderBy($fields,$style=''){
        //拼接sql语句
        $sql = "select {$this->field} from {$this->table} {$this->where} order by {$fields} {$style}";
        //dd($sql);die;
        //执行sql排序语句
        $data = $this->query($sql);
        return $data;
    }

    //exec方法:执行没有结果集的操作
    public function exec($sql){
        //try catch语句
        try {
            //1.执行mysql语句
            //2.$row:存放返回值
            $row = self::$pdo->exec($sql);

            //判断:如果执行的添加操作 就返回添加的主键
            if($lastId = self::$pdo->lastInsertId()){
                return $lastId;
            }
            //将获取的数据return出去 用于界面使用
            return $row;
        } catch (PDOException $e) {
            //1.throw new PDOException:获取的错误信息更为详细
            throw new PDOException($e->getMessage());
        }

    }

    //field方法:获取查询的字段
    public function field($field){
        //将想要查询的字段存放到属性中
        $this->field = $field;
        return $this;
    }

    //where方法:sql语句的where条件
    //形参$where:用户输入的where条件
    public function where($where){
        //1.判断:当输入了where语句 但是为空字符
        if(trim(empty($where))){
            //dd($this);
            return $this;
        }
        $this->where = "where {$where}";
        return $this;
    }

    //toArray方法:将返回的对象中的数组分离出来
    public function toArray(){
        //1.考虑问题:当查询的数据为空时返回一个空数组
        if($this->data){
            //1.这里的$this是上一个方法返回的对象 里面有个data属性存放着数组 这里调用data属性即可
            return $this->data;
        }
        return [];
    }

    //getPk方法:获取当前使用的表格的主键名称
    //思路:表格主键id 出现在表结构中 可以查询表结构将查询结果(数组)存放到变量中
    public function getPk(){
        //查询表结构
        $sql = 'desc '.$this->table;
        //dd($sql);
        //执行语句
        //$desc:存放以表结构组成的数组
        $desc = $this->query($sql);
        //dd($desc);
        //foreach作用:由于不知道表格中的主键到底在表结构的那个位置 所以需要匹配表结构的每个元素
        //表结构主键特点:含有 PRI 关键词
        foreach ($desc as $v){
            //判断是否为主键
            if($v['Key']=='PRI'){
               $pk = $v['Field'];
               //break作用:当匹配完成 结束循环
               break;
            }
        }
        //return:将获取的主键返回出去
        return $pk;

    }

    //1.query方法:用于操作有结果的查询
    //2.形参$sql:要执行的查询语句
    public function query($sql)
    {
        //try catch语句
        try {
            //1.执行mysql语句
            //2.$res:存放查询到的结果
            $res = self::$pdo->query($sql);
            //1.将查询结果获取到，为一个二维数组
            //2.$row:存放获取到的关联数组
            $row = $res->fetchAll(PDO::FETCH_ASSOC);
            //将获取的数据return出去 用于界面使用
            return $row;

        } catch (PDOException $e) {
            //1.throw new PDOException:获取的错误信息更为详细
            throw new PDOException($e->getMessage());
        }
    }

}
<?php

namespace houdunwang\model;

//View类:当Entry调用模板时首先加载这个类
class Model{

    //__call方法:当调用一个当前类没有的普通方法时 会自动执行这个函数
    //$name:调用的方法名
    public function __call($name, $arguments)
    {
        //调用parseAction方法
        return self::parseAction($name,$arguments);
    }
    //__callStatic方法:当调用一个当前类没有的静态方法时 自动执行
    public static function __callStatic($name, $arguments)
    {
        return self::parseAction($name,$arguments);
    }

    //parseAction方法:调用Base类的$name方法
    public static function parseAction($name,$arguments){
        //1.获取当前调用的类名
        //2.作用:查询时需要使用表名  这个时候需要从类名中获取 因为调用时是一张表对应一个类
        $class = get_called_class ();
        //dd($class);
        return call_user_func_array([new Base($class),$name],$arguments);
    }
}
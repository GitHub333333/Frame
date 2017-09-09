<?php

namespace houdunwang\view;

//View类:当Entry调用模板时首先加载这个类
class View{

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
        return call_user_func_array([new Base,$name],$arguments);
    }
}
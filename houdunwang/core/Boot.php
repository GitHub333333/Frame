<?php
//命名空间 以目录路径为标准
namespace houdunwang\core;

//启动类
class Boot{

    //应用执行方法
    public static function run(){
        //设置报错样式
        self::handler();
        //echo 1;//测试是否调用到此方法
        //1.初始化框架
        self::init();
        //1.执行应用
        //2.作用:对地址栏参数的调用
        //3.地址栏参数:框架中参数格式一般为 ?s=home/entry/add
        self::appRun();
    }

    private static function handler(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    //init方法
    //作用：初始化框架
    public static function init(){
        //1.声明头部
        //2.作用:防止代码在浏览器显示出乱码
        header( 'Content-type:text/html;charset=utf8');
        //1.设置时区
        //2.作用:防止时间不正确
        date_default_timezone_set('PRC');
        //1.启动session
        //2.作用:判断session_id是否已存在 true表明session已经启动 不再重复执行session_start()
        session_id() || session_start();
    }

    //appRun方法
    //作用:地址栏参数的传递
    public static function appRun(){
        //1.判断s参数是否存在
        //2.s参数:?s=home/entry/add 分别代表 模块/类名/方法名
        if(isset($_GET['s'])){
            //$_GET['s']存在

            //dd($_GET['s']);
            //1.参数数据转为数组形式
            //2.作用:方便提取为变量，用来调用不同模块不同类的不同方法
            $s = explode('/',$_GET['s']);
            //1.组合类名
            //2.类的调用需要完整的命名空间，其中 模块名、类名是可变的
            //3.首字母大写转换原因:地址栏参数为小写，而类名首字母为大写
            $class = '\app\\'.$s[0].'\controller\\'.ucfirst($s[1]);
            //dd($class);
            //1.方法名 地址栏s参数的第二个
            $action = $s[2];

            //1.定义常量
            //作用:在使用函数加载模板路径时 需要用到s参数中的值 是相对应的
            define('MODULE',$s[0]);
            define('CONTROLLER',$s[1]);
            define('ACTION',$s[2]);

        }else{
            //参数$_GET['s']不存在

            //1.给予类名默认值
            $class = '\app\home\controller\Entry';
            //1.给予方法默认值
            //2.默认值:首页显示的方法
            $action = 'index';

            //定义常量
            //给予常量默认值
            define('MODULE','home');
            define('CONTROLLER','entry');
            define('ACTION','index');
        }
        //1.call_user_func_array:调用类内部的方法 参数1:[实例化的类,需调用的方法] 参数2:一个数组 必须写(不传入值也要写上)
        //2.第一个参数传入类:$class 方法:$action
        //3.echo作用:作用于核心文件houdunwang的v层下的Base类的__toString方法
        echo call_user_func_array([new $class,$action],[]);
    }


}
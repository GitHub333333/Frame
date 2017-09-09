<?php

namespace houdunwang\view;

//Base类:用于分配变量和处理加载模板路径
class Base{

    //属性$data:用于存放要显示和获取的数据
    protected $data;
    //属性$file;用于存放模板路径
    protected $file;

    //make方法:加载不同的模板文件
    public function make(){
        //echo 'make';
        //加载index模板文件
        //include '../app/home/view/entry/index.php';
        //可提取的变量:模块名  类名  方法名-->这个时候就用到了 houdunwang中Boot类定义的常量
        //将模板路径存放于$this->file中  用于在__toString中使用
        $this->file ='../app/'.MODULE.'/view/'.CONTROLLER.'/'.ACTION.'.php';
        //return $this作用:链式调用使用
        return $this;
    }

    //with方法:将Entry类获取的数据库数据 拿过来
    public function with($var){
        //将传入的数组 插入到$this->data中
        $this->data = $var;
        //dd($this->data);
        //return $this作用:链式调用使用
        return $this;
    }

    //__toString方法:当输出一个对象时的时候自动调用这个方法
    public function __toString()
    {
        //extract函数:将数组的键名转为变量名 键值转为变量值 这样变量就可以在界面中使用
        //extract($this->data);
        //加载模板文件
        //dd($this->file);
        include $this->file;
        //return作用:使用__toString方法必须写这个 不写会报错
        return '';
    }


}
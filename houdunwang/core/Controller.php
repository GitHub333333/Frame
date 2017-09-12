<?php

namespace houdunwang\core;

//控制类 用来管理提示消息
class Controller{

    //1.属性$url:用来接收跳转地址
    //2.作用与message模板文件
    public $url;

    //1.message方法:调用提示消息模板
    //2.形参$msg:提示的内容，通过调用同一模板文件实现不同的提示消息(添加、编辑、删除等)
    protected  function message($msg){
        //1.加载提示模本文件
        include './view/message.php';
        die;
    }

    //1.setRedirect方法:跳转指定地址或者返回上一级
    //2.形参$url:Entry类中调用message需要跳转的地址
    public function setRedirect($url=''){
        //1.if判断:判断是跳转地址是否为空
        if(empty($url)){
            //没有指定

            //1.$this->url 的值作用于messge方法
            //2.让界面返回上一级
            $this->url="window.history.back()";
        }else{
            //指定了跳转地址

            //1.赋予跳转语句location.href 跳转指定界面
            $this->url="location.href='{$url}'";
            //dd($this->url);
        }
        //dd($this);
        //1.这里return $this的原因在Entry类中已说明
        return $this;
    }

}


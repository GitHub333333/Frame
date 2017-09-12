<?php

namespace app\admin\controller;

use houdunwang\view\View;
use system\model\Admin;

//admin里的Entry类:后台界面
class Entry extends Common{

    //后台首页
    public function index(){
        //加载后台首页
        //echo 1;die;
        return View::make();
    }

    //密码修改界面
    public function modifyp(){
        if(IS_POST){
            //dd($_POST);

            //调用modifyp方法 并将输入的数据传递过去
            $res = Admin::modifyp($_POST);
            //dd($res);

            //根据返回结果给予提示和跳转界面
            if($res['code']){
                //修改成功
                //跳转到后台管理的首页
                $this->setRedirect('?s=admin/entry/index')->message($res['msg']);
            }else{
                //修改失败
                $this->setRedirect()->message($res['msg']);
            }

        }
        //加载密码修改界面
        return View::make();
    }

    //退出登录
    public function logout(){
        session_unset();
        session_destroy();
        $this->setRedirect('?s=admin/login/index')->message('退出成功');
    }

}
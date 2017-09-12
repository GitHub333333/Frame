<?php

namespace app\admin\controller;

//班级管理
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Grade as G;


class Grade extends Common{

    //班级列表首页
    public function index(){

        //查询数据库数据
        $data = G::orderBy('gid')->findALl()->toArray();
        //dd($data);
        //dd(compact('data'));
        //compact:将数据变为 以变量名为键名 变量值为键值的数组
        return View::make()->with(compact('data'));
    }

    //班级列表添加界面
    public function add(){

        //判断数据是否是post请求
        if(IS_POST){
            //将提交的数据传递给模型类的add方法数据验证
            //$res:存储数据验证后返回的数据
            $res = (new G())->add($_POST);
            if($res['code']){
                $this->setRedirect(u('admin.grade.index'))->message($res['msg']);
            }else{
                $this->setRedirect()->message($res['msg']);
            }
        }
        return View::make();
    }

    //班级编辑界面
    public function edit(){

        //获取需要显示的旧数据的主键
        $id = $_GET['gid'];
        //获取当前主键的数据
        $oldData = G::find($id)->toArray();
        //dd($oldData);

        //判断是否是post请求
        if(IS_POST){
            //调用edit方法
            $res = (new G())->edit($_POST,$id);
            if($res['code']){
                $this->setRedirect(u('admin.grade.index'))->message($res['msg']);
            }else{
                $this->setRedirect()->message($res['msg']);
            }

        }

        //加载编辑模板
        return View::make()->with(compact('oldData'));
    }

    public function del(){
        //获取需要显示的旧数据的主键
        $id = $_GET['gid'];
        //echo 1;
        //dd($id);die;
        //删除对应下标数据
        G::del($id);
        $this->setRedirect(u('admin.grade.index'))->message('删除成功');
    }


}
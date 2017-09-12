<?php
namespace app\admin\controller;



use houdunwang\core\Controller;
//Commom类:公共控制类
class Common extends Controller {

    public function __construct()
    {
        //判断:当数据库中不存在admin_id这个字段 让它跳到登录界面
        if(!isset($_SESSION['admin_id'])){
            //header():跳转到指定界面
            header('location:?s=admin/login/index');
        }

    }



}
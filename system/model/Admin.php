<?php

namespace system\model;

use houdunwang\core\Controller;
use houdunwang\model\Model;


class Admin extends Model {

    //login方法:验证管理员提交的数据
    public static function login($post){
        //dd($post);
        //$u:用户
        $u = $post['admin_u'];
        //$p:密码
        $p = $post['admin_p'];
        //$c:验证码
        $c = $post['code'];

        //将哈希加密后的字符串存储到admin表格中
        //echo password_hash("$p", PASSWORD_DEFAULT);

        //数据验证:为空
        if(!trim($u)) return ['code'=>'0','msg'=>'请输入用户名'];
        if(!$p) return ['code'=>'0','msg'=>'请输入密码'];
        if(!trim($c)) return ['code'=>'0','msg'=>'请输入验证码'];
        //与数据库进行匹配
        //$admin:存放数据库查询的结果
        $admin = Admin::where("admin_u='$u'")->findAll()->toArray();
        //dd($admin);
        //判断输入的数据与数据库数据不匹配
        //用户名的判断
        if(!$admin) return ['code'=>'0','msg'=>'用户名不正确'];
        //密码的判断
        if(!password_verify($p,$admin[0]['admin_p'])) return ['code'=>'0','msg'=>'密码不正确'];
        //验证码的判断
        //将输入的验证码和存储的密码全都转换为小写 让它不区分大小写
        if(strtolower($c) != strtolower($_SESSION['phrase'])) return ['code'=>'0','msg'=>'验证码不正确'];

        //将用户数据存储到到session中
        //$_SESSION['admin_id']:是用于判断用户是否登录的
        $_SESSION['admin_id'] = $admin[0]['admin_id'];
        //$_SESSION['admin_u']:时用于在后台挂历界面显示用户名称的
        $_SESSION['admin_u'] = $admin[0]['admin_u'];

        //代码运行到这里说明 数据全都匹配正确
        return ['code'=>'1','msg'=>'登录成功'];
    }

    public static function modifyp($modify){
        //dd($modify);

        //旧密码
        $oldp = $modify['oldP'];
        //新密码:第一次输入
        $newp = $modify['newP'];
        //新密码:第二次输入
        $newp2 = $modify['newP2'];

        //数据验证:为空
        if(!$oldp) return ['code'=>'0','msg'=>'请输入旧密码'];
        if(!$newp) return ['code'=>'0','msg'=>'请输入新密码'];
        if(!$newp2) return ['code'=>'0','msg'=>'请确认新密码'];

        //$pp:存放数据库的密码
        $pp =  Admin::findAll($_SESSION['admin_id'])->toArray();
        //dd($pp);die;
        //判断旧密码是否正确
        if(!password_verify($oldp,$pp[0]['admin_p'])) return ['code'=>'0','msg'=>'旧密码不正确'];

        //判断两次密码输入是否一致
        if($newp != $newp2) return ['code'=>'0','msg'=>'两次密码输入不一致'];

        //到这里 说明数据都正确将新密码加密后存储到数据库
        $admin_p =  password_hash("$newp2", PASSWORD_DEFAULT);
        //由于更新方法 要求输入数组 这里讲新密码存储到数组中
        $data = [
            'admin_p'=> $admin_p,
        ];
        //将新密码更新到数据库中
        Admin::where("admin_id={$_SESSION['admin_id']}")->update($data);

       //修改成功
        return ['code'=>'1','msg'=>'修改成功'];
    }



}
<?php

namespace app\admin\controller;

use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Admin;

//继承Controller原因:登录或者失败要提示

//Login类:登录管理
class Login extends Controller {

    //Index方法:登录方法
    public function index(){


        //判断:是否接受到了POST请求
        if(IS_POST){
            //dd($_SESSION['phrase']);
            //dd($_POST);
            //调用Admin类的login方法 验证数据
            //$res:接收数据验证后的返回结果用于判断
            $res = Admin::login($_POST);
            //判断返回值
            //code为1:登录成功
            if($res['code']){
                //code为1:登录成功

                //登录成功后，为管理员跳转到后台管理界面
                $this->setRedirect('?s=admin/entry/index')->message($res['msg']);

            }else{
                //code为0:登录失败

                //给予失败提示信息 并返回上一级界面
                $this->setRedirect()->message($res['msg']);
            }
        }
        //echo 1;
        //加载登录模板
        return View::make();
    }

    public static function code(){
        header('Content-type: image/jpeg');
        $phraseBuilder = new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build();
        //将验证码存储到session里
        $_SESSION['phrase'] = $builder->getPhrase();
        $builder->output();
    }


}
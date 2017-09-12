<?php

//命名空间
namespace app\home\controller;

use houdunwang\core\Controller;
use houdunwang\model\Base;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Article;
use system\model\Stu;

//前台界面
class Entry extends Controller {
    public function index(){

        //Controller::message('成功');
        //调用查询方法
        //这里使用一张表对应一个类
        //new Base();
        //$data = stu::find(2);
        //dd($data);
        //Article::find(1);
        //echo 'index11';
        //return作用:__toString需要当Boot类中的call_user_func_array()函数输出一个对象时自动执行，所以这里需要将View类中的方法return的$this在调用后return出去，才能让__toString 函数自动触发
        //return View::with()->make();

        //---where条件语句
       //Stu::where('st_name="高10"');

        //--finfAll 查询多条
        //$data = Stu::findAll()->toArray();
        //dd($data);

        //--del 删除
        //$row = Stu::del(4);
        //$row = Stu::where('st_name="添加"')->del();
        //dd($row);

        $data = [
            'st_name'=>'修改1',
            'cl_id'=>5,
        ];
        //--update 更新
        //$row = Stu::where('')->update($data);
        //dd($row);
        //$data = Stu::field('cl_id')->find(2)->toArray();
        //dd($data);

        ///--insert 添加数据
        //$row = Stu::insert($data);
        //dd($row);

        //--count 统计数据
        //$total = Stu::where("st_name='修改1'")->count();
        //dd($total);

        //--orderBy 排序
        //$data = Stu::where('st_name="添加添加"')->orderBy('cl_id');
        //dd($data);

        return View::make();
    }
    public function add(){
        echo 'add';
        //1.调用setRedirect、message方法 参数分别为:跳转地址、提示消失
        //2.链式调用:$this->方法->方法 注意点:方法被调用时，箭头前面必须是一个对象
        //3.分析:当调用setRedirect后 方法内没有产生任何返回值，也就是NULL，箭头指向的下一个方法无法被调用，所以如果链式操作中前一个方法没有return一个对象($this)，会报错
        $this->setRedirect()->message('添加成功');
    }
}
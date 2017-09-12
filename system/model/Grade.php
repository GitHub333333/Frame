<?php

namespace system\model;

use houdunwang\model\Model;

//继承Model原因 操作数据库需要调用houdunwang的base方法

//Grade方法:对班级操作的数据进行验证及返回结果
class Grade extends Model {

    //add方法:对添加的班级进行验证
    public function add($add){
        //dd($add);
        //判断提交的数据是否为空
        if(!trim($add['gname'])) return ['code'=>0,'msg'=>'班级名称不能为空'];

        //1.班级名称不能重复
        //2.$res:数据查询结果为数组时 也就是为true时 说明班级名称已存在
        $res = $this->where("gname='{$add['gname']}'")->findALl()->toArray();
        //dd($res);
        if($res){
            //为true:班级名称已存在
            return ['code'=>0,'msg'=>'班级名称已存在'];
        }
        //验证通过 往数据库插入
        $this->insert($add);

        return ['code'=>1,'msg'=>'班级添加成功'];
    }

    //edit方法:对数据进行验证
    public function edit($edit,$id){
        //dd($edit);
        //dd($id);
        //判断数据是否为空
        if(!trim($edit['gname'])) return ['code'=>0,'msg'=>'班级名称不能为空'];
        //判断修改的班级名称是否存在
        //注意:这里不能和自己比较
        $res = $this->where("gname='{$edit['gname']}' and gid!={$id}")->findALl()->toArray();
        //dd($res);
        //判断当查询有结果时 说明列表中已经存在相同班级
        if($res) return ['code'=>0,'msg'=>'班级名称已存在'];
        //判断数据是否修改了
        $res2 = $this->where("gname='{$edit['gname']}'")->findALl()->toArray();
        //dd($res2);die;
        if($res2) return ['code'=>0,'msg'=>'您未做修改'];

        //新数据覆盖掉原数据
        $this->where("gid={$id}")->update($edit);

        //验证通过 修改成功
        return ['code'=>1,'msg'=>'修改成功'];
    }

}
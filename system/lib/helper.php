<?php



function dd($res){
    echo '<pre style="background: #ccc;padding: 8px;border-radius: 5px;font-size: 15px;font-family: 微软雅黑">';
    if(is_null ($res)){
        var_dump ($res);
    }else if(is_bool ($res)){
        var_dump($res);
    }else{
        print_r ($res) ;
    }
    echo '</pre>';
}



//c函数
if(!function_exists('c')){
    //$var:连接数据库时传入的参数
    //$var:数据库名.关键字(user、daname等)
    function c($var){
        //数组转换原因:将数据库名称、和一些规定名称 分离出来 便于加载模板或者调用配置文件的键值
        $info = explode('.',$var);


        //加载数据库文件 将获取到的数组存放到变量$data中
        $data = include '../system/config/'.$info[0].'.php';
        //判断作用:传入的参数(用户名，密码等)是否是正确的
        return isset($data[$info[1]]) ? $data[$info[1]] : null;

    }
}


if(!function_exists ('u')){

    function u($url,$args = []){
       //http_built_query将数组中的元素转换成   键名1=键值1&键名2=键值2
        $args = http_build_query ($args);
        //将参数转换成数组
        $info = explode ('.',$url);
        //dd($info);
        if(count ($info)==2){
            return "index.php?s=".MODULE."/{$info[0]}/{$info[1]}" . "&{$args}";
        }
        if(count ($info)==1){
            return "index.php?s=".MODULE."/".CONTROLLER."/{$info[0]}". "&{$args}";
        }
        return "index.php?s={$info[0]}/{$info[1]}/{$info[2]}". "&{$args}";
    }
}


//定义一个变量去接收是否发起了POST请求
define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);

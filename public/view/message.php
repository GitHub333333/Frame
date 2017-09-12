<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>提示</title>
    <link rel="stylesheet" href="./static/bs3/css/bootstrap.css">
</head>
<body>
    <div class="jumbotron" style="text-align: center">
    	<div class="container">
    		<h1><?php echo $msg ?></h1>
    		<p><a href="javascript:<?php echo $this->url ?>;"><span id="time">3</span>秒后自动跳转，如果无法跳转请单击这里</a></p>
<!--    		<p>-->
<!--    			<a class="btn btn-primary btn-lg">问题反馈</a>-->
<!--    		</p>-->
    	</div>
    </div>
</body>
<script>

    //定时器作用:让3秒倒计时 开始倒数计数
    setInterval(function(){
        //抓取元素
        var time = document.getElementById('time');
        //让时间每秒钟减一
        time.innerHTML = time.innerHTML-1;
    },1000)
        //定时炸弹作用:让界面跳转
        setTimeout(function(){
            <?php echo $this->url ?>
        },3000);
</script>
</html>

<?php include "../app/admin/view/Common/header.php";  ?>

        <!--右侧主体区域部分 start-->
        <div class="col-xs-12 col-sm-9 col-lg-10">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="javascript:;" >密码修改</a></li>
            </ul>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">密码修改</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">用户</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  placeholder="" disabled value="<?php echo $_SESSION['admin_u'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">旧密码</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="oldP" placeholder="请输入旧密码" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">新密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control"  name="newP" placeholder="请输入新密码" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">确认新密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="newP2" placeholder="请确认新密码" value="">
                            </div>
                        </div>

                    </div>
                </div>
                <button class="btn btn-primary">确认</button>
            </form>
        </div>
    </div>
    <!--右侧主体区域部分结束 end-->


<?php include "../app/admin/view/Common/footer.php";  ?>
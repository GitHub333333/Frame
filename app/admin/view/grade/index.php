<?php include "../app/admin/view/common/header.php"?>

<script src="./static/modal_js/modal.js"></script>


<!--右侧主体区域部分 start-->
<div class="col-xs-12 col-sm-9 col-lg-10">
    <!-- TAB NAVIGATION -->
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="" >班级列表</a></li>
        <li><a href="<?php echo u('admin.grade.add')?>" >班级添加</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">班级列表</h3>
        </div>
        <div class="panel-body" >
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>班级编号</th>
                    <th>班级名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
<!--                判断 当查询导数据时 才显示列表-->
                <?php if(!empty($data)){ ?>
                    <?php foreach ($data as $v){ ?>
                    <tr>
                        <td><?php echo  $v['gid'] ?></td>
                        <td><?php echo  $v['gname'] ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" style="width: 100px">
                                <a href="<?php echo u('admin.grade.edit',['gid'=>$v['gid']])?>" class="btn btn-primary">编辑</a>
                                <a href="javascript:;" class="btn btn-danger btn-lg"  onclick="del(<?php echo $v['gid']?>)" style="float: right">删除</a>
                            </div>
                        </td>
                    </tr>
                        <?php } ?>
                <?php }else{ ?>
                    <tr>
                        <td style="float: right;">您还没有添加班级！</td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <!-- Button trigger modal -->




</div>
<script>
//    function del(gid){
//        //alert(gid);
//
//        //是否确认删除的判断
//        if(confirm('确认删除吗')){
//            location.href = "<?php //echo u('admin.grade.del') ?>//" + "&gid=" + gid;
//        }
//    }

    function del(gid){
        var url = "?s=admin/grade/del&gid="+gid;
        //modal方法:将删除的模态框 封装在了static modal_js里 上面加载了方法 方法中输出了一个模态框到body界面
        modalDel(url);
    }



</script>



<?php include "../app/admin/view/common/footer.php"?>


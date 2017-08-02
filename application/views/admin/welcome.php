

    <div id="wrapper">

        <!-- Navigation -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">首页</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            登录详情
                        </div>
                        <div class="panel-body">
                            <li>登录账号：<span><?php echo $loginInfo['account']; ?></span></li>
                            <!-- <li>登录次数：<span><?php //echo $loginInfo['logined_count']; ?></span></li> -->
                            <li>最近一次登录时间：<span><?php echo $loginInfo['update_time']; ?></span></li>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

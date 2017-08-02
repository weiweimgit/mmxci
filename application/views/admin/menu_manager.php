
<style type="text/css">
    ul{
        list-style: none;
    }
    .modal-dialog{
        padding-top: 10%;
    }
    .modify_customer_info{
        font-size: 10px;
    }
    .modify_customer_points{
        font-size: 10px;
    }
    .customer_info_ul{
        text-align: center;
    }
    .info_li{
        width: 35%;
    }
    .tab-content{
        margin-top: 20px;
    }
    .remark_tips{
        font-weight: 500;
        vertical-align: top;
    }
    .modify_button{
        font-size: 20px;
        margin-left: 15px;
        cursor: pointer;
        color: #337ab7;
    }
    #wpbody-content{
        padding: 20px 30px 65px 20px;
    }
    .kaensoft-points-rewards-input{
        width: 200px;
    }
    .kaensoft-points-rewards-select{
        width: 200px;
    }
    .blend-dialog-show{
        z-index: 9999;
        border-radius: 5px !important;
        text-align: center;
    }
    .modal-backdrop{
        background-color: #fff;
        z-index: 1;
    }
    .blend-dialog-confirm{
        border-radius: 0px 0px 5px 5px !important;
    }

    /*bootstrap button*/
    .dropdown-menu{
        min-width: 100% !important;
    }
    .btn_weixin_menu{
        margin-top: 15px;
        outline: none;
    }
    .btn_reserve{
        margin-left:15%;
    }
    .btn_submit{
        margin-left: 15%;
    }

    /* bootstrap modal*/
    .new_input{
        width:60%;
    }
    .modal-title{
        text-align: center;
    }
    .modal_body_ul{
        text-align: right;
    }
    .modal_body_ul li{
        margin-right:20%;
        margin-bottom: 15px;
    }
    .modal_body_text{
        text-align: center;
    }

    /*新增一级菜单modal框*/
    .add_option,.add_option_two,.add_option_three{
        display: none;
    }
    .tips_warning{
        color: red;
    }
    /*datatable*/
    .table>thead:first-child>tr:first-child>th{
        width: 100px !important;
    }
    table.table-bordered.dataTable tbody td{
        width: 100px !important;
    }
    p {
        width: 100px;
        word-wrap: break-word;
    }
    .btn-primary{
        font-size: 12px !important;
    }
</style>

<div id="wrapper">

    <!-- Navigation -->

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">微信底部菜单</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
               <!-- Modal One,新增一个一级菜单 -->
            <div class="modal fasde" id="myModalOne" tabindex="-1" role="dialog" aria-labelledby="myModalLabelOne">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelOne">新增一级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul">
                                <li>一级菜单名称：<input type="text" placeholder="建议勿超过5个汉字" id="mainmenu_new_one" class="mainmenu_new_input new_input"></li>
                                <li>排列序号：<input type="number" placeholder="大于0的整数/勿与已有序号重复" id="mainmenu_new_two" class="mainmenu_new_input new_input"></li>
                                <li>是否有二级菜单：
                                    <select id="mainmenu_new_three" class="mainmenu_new_input new_input">
                                        <option value="1">有</option>
                                        <option value="0">无</option>
                                    </select>
                                </li>
                                <li id="top_menu_type" class="add_option">一级菜单类型：
                                    <select id="mainmenu_new_four" class="mainmenu_new_input new_input">
                                        <option value="view">点击跳转</option>
                                        <option value="click">点击自动回复</option>
                                    </select>
                                </li>
                                <li id="url_key_one" class="add_option">跳转指向链接：<input type="text" placeholder="http://www.abc.com" id="mainmenu_new_five" class="mainmenu_new_input new_input"></li>
                                <li id="url_key_two" class="add_option">自动回复关键词：<input type="text" placeholder="abc" id="mainmenu_new_five_two" class="mainmenu_new_input new_input"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="new_mainmenu_sure" >立即新增</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- Modal Two,删除一个一级菜单 -->
            <div class="modal fade bs-example-modal-sm" id="myModalTwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTwo">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelTwo">删除一级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul modal_body_text">
                                <span>确定要删除该一级菜单吗？</span>
                                </br>
                                <span class="tips_warning">删除后该一级菜单下设置的二级将全部被删除!!!</span>
                                <input type="hidden" id="hidden_id_two" value="">
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="delete_mainmenu_sure" >立即删除</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- Modal A,修改一个一级菜单 -->
            <div class="modal fade" id="myModalA" tabindex="-1" role="dialog" aria-labelledby="myModalLabelA">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelA">修改一级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul">
                                <li>一级菜单名称：<input type="text" id="mainmenu_modify_one" class="mainmenu_modify_input new_input"></li>
                                <li>排列序号：<input type="text" id="mainmenu_modify_two" class="mainmenu_modify_input new_input"></li>
                                <li>是否有二级菜单：
                                    <select id="mainmenu_modify_three" class="mainmenu_modify_input new_input">
                                        <option value="1">有</option>
                                        <option value="0">无</option>
                                    </select>
                                </li>
                                <li id="top_menu_type_two" class="add_option_two">一级菜单类型：
                                    <select id="mainmenu_modify_four" class="mainmenu_modify_input new_input">
                                        <option value="view">点击跳转</option>
                                        <option value="click">点击自动回复</option>
                                    </select>
                                </li>
                                <li id="url_key_three" class="add_option_two">跳转指向链接：<input type="text" id="mainmenu_modify_five" class="mainmenu_modify_input new_input"></li>
                                <li id="url_key_four" class="add_option_two">自动回复关键词：<input type="text" placeholder="abc" id="mainmenu_modify_five_two" class="mainmenu_modify_input new_input"></li>

                                <input type="hidden" id="hidden_id_a" value="">
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="modify_mainmenu_sure" >立即修改</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- Modal Three,新增一个二级菜单 -->
            <div class="modal fade" id="myModalThree" tabindex="-1" role="dialog" aria-labelledby="myModalLabelThree">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelThree">新增二级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul">
                                <li>一级菜单名称：
                                    <select id="submenu_new_one" class="submenu_new_input new_input">
                                    </select>
                                </li>
                                <li>二级菜单名称：<input type="text" id="submenu_new_two" class="submenu_new_input new_input"></li>
                                <li>二级菜单排列序号：<input type="text" id="submenu_new_three" class="submenu_new_input new_input"></li>
                                <li>菜单类型：
                                    <select id="submenu_new_four" class="submenu_new_input new_input">
                                        <option value="view">点击跳转</option>
                                        <option value="click">点击自动回复</option>
                                    </select>
                                </li>
                                <li id="url_key_five" class="add_option_three">跳转指向链接：<input type="text" id="submenu_new_five" class="submenu_new_input new_input" placeholder="http://www.abc.com"></li>
                                <li id="url_key_six" class="add_option_three">自动回复关键词：<input type="text" id="submenu_new_five_two" class="submenu_new_input new_input" placeholder="abc"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="new_submenu_sure" >立即新增</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- Modal Four,删除一个二级菜单 -->
            <div class="modal fade bs-example-modal-sm" id="myModalFour" tabindex="-1" role="dialog" aria-labelledby="myModalLabelFour">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelFour">删除二级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul modal_body_text">
                                确定要删除该二级菜单吗？
                                <input type="hidden" id="hidden_id_four" value="">
                                <input type="hidden" id="hidden_id_four_submenu" value="">
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="delete_submenu_sure" >立即删除</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- Modal B,修改一个二级菜单 -->
            <div class="modal fade" id="myModalB" tabindex="-1" role="dialog" aria-labelledby="myModalLabelB">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabelB">修改二级菜单</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal_body_div">
                            <ul class="modal_body_ul">
                                <li>当前一级菜单：<input type="text" disabled="disabled" id="submenu_modify_old" class="submenu_modify_input new_input"></li>
                                <li>一级菜单名称：
                                    <select id="submenu_modify_one" class="submenu_modify_input new_input">
                                    </select>
                                </li>
                                <li>二级菜单名称：<input type="text" id="submenu_modify_two" class="submenu_modify_input new_input"></li>
                                <li>排列序号：<input type="text" id="submenu_modify_three" class="submenu_modify_input new_input"></li>
                                <li>菜单类型：
                                    <select id="submenu_modify_four" class="submenu_modify_input new_input">
                                        <option value="view">点击跳转</option>
                                        <option value="click">点击自动回复</option>
                                    </select>
                                </li>
                                <li id="url_key_seven" class="add_option_four">跳转指向链接：<input type="text" id="submenu_modify_five" class="submenu_modify_input new_input"></li>
                                <li id="url_key_eight" class="add_option_four">自动回复关键词：<input type="text" id="submenu_modify_five_two" class="submenu_modify_input new_input"></li>

                                <input type="hidden" id="hidden_id_b" value="">
                                <input type="hidden" id="hidden_id_b_submenu" value="">
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消关闭</button>
                        <button type="button" class="btn btn-primary" id="modify_submenu_sure" >立即修改</button>
                    </div>
                </div>
              </div>
            </div>

            <!-- datatable -->
            <div class="table_content" >
                <!--bootstrap nav -->
                <ul class="nav nav-tabs" role="tablist" id="myTabOne">
                    <li role="presentation" class="tab_li tab_1 active"><a href="#content_one" role="tab" data-toggle="tab" aria-controls="content_one">一级菜单管理</a></li>
                    <li role="presentation" class="tab_li tab_2"><a href="#content_two" role="tab" data-toggle="tab" aria-controls="content_two">二级菜单管理</a></li>
                </ul>

                <!-- 按钮分布 -->
                    <button type="button" class="btn btn-success btn_weixin_menu btn_new_main_menu" id="add_main_menu_one" data-toggle="modal" data-target="#myModalOne">新增一级菜单</button>
                    <button type="button" class="btn btn-success btn_weixin_menu btn_new_sub_menu" id="add_main_menu_two" data-toggle="modal" data-target="#myModalThree">新增二级菜单</button>
                <!-- <button type="button" class="btn btn-info btn_weixin_menu btn_reserve">保存不发布</button> -->
                <button type="button" class="btn btn-warning btn_weixin_menu btn_submit">立即发布</button>
                <button type="button" class="btn btn-default btn_weixin_menu" disabled="disabled"></button>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="content_one">
                        <table id="table_one" class="table table-striped table-bordered table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>一级菜单名称</th>
                                    <th>有无二级菜单</th>
                                    <th>菜单类型</th>
                                    <th>URL/回复关键词</th>
                                    <th>排列序号</th>
                                    <th>最后修改时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="content_two">
                        <table id="table_two" class="table table-striped table-bordered table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>所属一级菜单名称</th>
                                    <th>二级菜单名称</th>
                                    <th>菜单类型</th>
                                    <th>菜单序号</th>
                                    <th>URL/回复关键词</th>
                                    <th>最后修改时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

    <!-- ajax tab控制 -->
<script type="text/javascript">
    $(function(){
        $('#myTabOne a').click(function (e) {
          e.preventDefault()
          $(this).tab('show');
        })
    });
</script>

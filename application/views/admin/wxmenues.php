
<style type="text/css">
    #line-chart {
        height:300px;
        width:800px;
        margin: 0px auto;
        margin-top: 1em;
    }
    .brand { font-family: georgia, serif; }
    .brand .first {
        color: #ccc;
        font-style: italic;
    }
    .brand .second {
        color: #fff;
        font-weight: bold;
    }
    .title1{
        display: inline-block;
        width: 20%;
        text-align: right;
        margin-bottom: 1em;
    }
    .modal .modal-body {
        padding: 2em;
        text-align: center;
    }
    .addmune{
        background: #1986e6;
        cursor: pointer;
        display: inline-block;
        width: 100px;
        color:#fff;
        text-align: center;
        margin: 20px 12px 20px 12px;
        max-width: 98%;
        margin-left: 3%;
        padding: 8px;
        border-radius: 10px;
    }
    .addmune_two{
        margin-left: 0px !important;
        background-color: #2ca51b;
    }
    .menushow{
        border-color: #ccc;
        text-align: center;
        margin: 0px 12px 20px 12px;
        width: 94%;
        margin: 0 3%;
    }
    .menushow th{
        /*background: #dabe2a;*/
        padding: 10px;
    }
    .menushow td{
        padding: 8px;
    }
    .modify_button,.del{
        background: #2fa2d6;
        margin-left: 4px;
        color: #fff;
        cursor: pointer;
        padding: 5px;
    }
    .onemenu{
        background-color: #eee;
    }
    .menu_item_link, .menu_item_link_sub{
        display: none;
    }
    .modal-title{
        text-align: center;
    }
    .published_menu{
        background: #aaa !important;
    }
</style>

<div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">微信底部菜单管理</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="addmune addmune_one" data-toggle='modal' data-target='#addModal' >添加一级菜单</div>
                 <div class="addmune addmune_two" data-toggle='modal' data-target='#addModal2' >添加二级菜单</div>

                <?php if( $publish_status == true ): ?>
                     <div class="addmune published_menu">已发布到最新</div>
                <?php else: ?>
                     <div class="addmune publish_menu">立即发布</div>
                <?php endif; ?>

                 <!-- 首次渲染内容 -->
                <table class="menushow" class="table table-striped table-bordered table-hover" border="1" width="98%">
                     <tr>
                         <th>菜单类型</th>
                         <th>标题</th>
                         <th>事件类型</th>
                         <th>链接</th>
                         <th>关键词</th>
                         <th>排序</th>
                         <th>创建时间</th>
                         <th>更新时间</th>
                         <th>操作</th>
                     </tr>
                     <?php if( !empty( $wxmenues ) ): ?>
                         <?php foreach ($wxmenues as $key1 => $menu): ?>
                             <?php
                                 if( $menu['type'] == 'view' ){
                                     $type = '浏览跳转事件';
                                 }else if( $menu['type'] == 'click' ){
                                     $type = '点击回复事件';
                                 }else{
                                     $type = '带有子菜单';
                                 }
                             ?>
                             <tr class="onemenu">
                                 <td>一级菜单</td>
                                 <td><?php echo $menu['title']; ?></td>
                                 <td><?php echo $type; ?></td>
                                 <td><?php echo $menu['url']; ?></td>
                                 <td><?php echo $menu['keyword']; ?></td>
                                 <td><?php echo $menu['idx']; ?></td>
                                 <td><?php echo $menu['create_time']; ?></td>
                                 <td><?php echo $menu['update_time']; ?></td>
                                 <td><span data-toggle='modal' data-target='#modifyModal' class='modify_button' data_id="<?php echo $menu['id']; ?>" data_idx="<?php echo $menu['idx']; ?>">修改</span><span data-toggle='modal' data-target='#delModal' class='del' data_id="<?php echo $menu['id']; ?>" pid="<?php echo $menu['pid']; ?>" data_idx="<?php echo $menu['idx']; ?>">删除</span></td>
                             </tr>
                             <?php if( !empty( $menu['submenu'] ) ): ?>
                                 <?php foreach ($menu['submenu'] as $key2 => $v): ?>
                                     <?php
                                         if( $v['type'] == 'view' ){
                                             $type_sub = '浏览跳转事件';
                                         }else if( $v['type'] == 'click' ){
                                             $type_sub = '点击回复事件';
                                         }else{
                                             $type_sub = '带有子菜单';
                                         }
                                     ?>
                                     <tr>
                                         <td></td>
                                         <td><?php echo $v['title']; ?></td>
                                         <td><?php echo $type_sub; ?></td>
                                         <td><?php echo $v['url']; ?></td>
                                         <td><?php echo $v['keyword']; ?></td>
                                         <td><?php echo $v['idx']; ?></td>
                                         <td><?php echo $v['create_time']; ?></td>
                                         <td><?php echo $v['update_time']; ?></td>
                                         <td><span data-toggle='modal' data-target='#modifyModal' class='modify_button' data_id="<?php echo $v['id']; ?>" data_idx="<?php echo $v['idx']; ?>">修改</span><span data-toggle='modal' data-target='#delModal' class='del' data_id="<?php echo $v['id']; ?>" pid="<?php echo $v['pid']; ?>" data_idx="<?php echo $v['idx']; ?>">删除</span></td>
                                     </tr>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         <?php  endforeach; ?>
                     <?php endif; ?>
                 </table>

                 <!-- 新增一级菜单modal -->
                 <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">一级菜单新增</h4>
                             </div>
                             <div class="modal-body">
                                 <div class="menu_item menu_item_type">
                                     <span class="title1">菜单类型：</span>
                                     <input class="addpid" type="" value="一级菜单" pid="0" name="" readonly>
                                 </div>
                                 <div class="menu_item menu_item_title">
                                     <span class="title1">标题：</span>
                                     <input class="addtitle1" type="text" placeholder="一级菜单名称(建议不超4个字)" name="">
                                 </div>
                                 <div class="menu_item menu_item_event">
                                     <span class="title1">事件类型：</span>
                                     <select class="addtype">
                                         <option value="click">点击回复事件</option>
                                         <option value="view">浏览跳转事件</option>
                                         <option value="">无(有二级菜单)</option>
                                     </select>
                                 </div>
                                 <div class="menu_item menu_item_keyword">
                                     <span class="title1">关键词：</span>
                                     <input class="addkeyword" placeholder="欢迎您的关注" type="text" name="">
                                 </div>
                                 <div class="menu_item menu_item_link">
                                     <span class="title1">链接：</span>
                                     <input class="addurl" placeholder="http://www.baidu.com" type="text" name="">
                                 </div>
                                 <div class="menu_item menu_item_order">
                                     <span class="title1">排序：</span>
                                     <input placeholder="1(越小越靠左)" class="addidx" type="number" name="">
                                 </div>
                                 <input class="id" type="hidden" name="">
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                 <button type="button" class="btn btn-primary btn_add">提交更改</button>
                             </div>
                         </div><!-- /.modal-content -->
                     </div><!-- /.modal -->
                 </div>

                 <!-- 新增二级菜单modal -->
                 <div class="modal fade" id="addModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">二级菜单新增</h4>
                             </div>
                             <div class="modal-body">
                                 <div class="menu_item menu_item_type_sub">
                                     <span class="title1">菜单类型：</span><input type="" value="二级菜单" name="" readonly>
                                 </div>
                                 <div class="menu_item menu_item_parent_sub">
                                     <span class="title1">父级菜单：</span>
                                     <select class="parentName2">

                                     </select>
                                 </div>
                                 <div class="menu_item menu_item_title_sub">
                                     <span class="title1">标题：</span>
                                     <input placeholder="二级菜单名称(建议不超7个字)" class="addtitle2" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_event_sub">
                                     <span class="title1">事件类型：</span>
                                     <select class="addtype2">
                                         <option value="click">点击回复事件</option>
                                         <option value="view">浏览跳转事件</option>
                                     </select>
                                 </div>
                                 <div class="menu_item menu_item_keyword_sub">
                                     <span class="title1">关键词：</span>
                                     <input placeholder="欢迎您的关注" class="addkeyword2" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_link_sub">
                                     <span class="title1">链接：</span>
                                     <input placeholder="http://www.baidu.com" class="addurl2" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_order_sub">
                                     <span class="title1">排序：</span>
                                     <input placeholder="1(越小越靠上)" class="addidx2" type="" name="">
                                 </div>
                                 <input class="id" type="hidden" name="">
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                 <button type="button" class="btn btn-primary btn_add2">提交更改</button>
                             </div>
                         </div><!-- /.modal-content -->
                     </div><!-- /.modal -->
                 </div>

                 <!-- 修改菜单 -->
                 <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">菜单修改</h4>
                             </div>
                             <div class="modal-body">
                                 <div class="menu_item menu_item_type_modify">
                                     <span class="title1">菜单类型：</span><input id="type_modify" class="pid2" type="text" readonly name="">
                                 </div>
                                 <div class="menu_item menu_item_title_modify">
                                     <span class="title1">标题：</span>
                                     <input id="title_modify" class="title" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_event_modify">
                                     <span class="title1">事件类型：</span>
                                     <select class="addtype_modify">
                                         <option value="click">点击回复事件</option>
                                         <option value="view">浏览跳转事件</option>
                                     </select>
                                 </div>
                                 <div class="menu_item menu_item_link_modify">
                                     <span class="title1">链接：</span>
                                     <input id="link_modify" class="url" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_keyword_modify">
                                     <span class="title1">关键词：</span>
                                     <input id="keyword_modify" class="keyword" type="" name="">
                                 </div>
                                 <div class="menu_item menu_item_order_modify">
                                     <span class="title1">排序：</span>
                                     <input id="order_modify" class="idx" type="" name="">
                                 </div>
                                 <input id="modify_id" type="hidden" name="">
                                 <input id="modify_pid" type="hidden" name="">
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                 <button type="button" class="btn btn-primary btn_update">提交更改</button>
                             </div>
                         </div><!-- /.modal-content -->
                     </div><!-- /.modal -->
                 </div>

                 <!-- 删除菜单 -->
                 <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">删除菜单</h4>
                             </div>
                             <div class="modal-body delbody">

                             </div>
                             <input type="hidden" class="deldata" name="">
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                 <button type="button" class="btn btn-primary btn_del">确定</button>
                             </div>
                         </div><!-- /.modal-content -->
                     </div><!-- /.modal -->
                 </div>
            </div>
        </div>

        <script type="text/javascript">
            $("[rel=tooltip]").tooltip();
            $(function() {
                $('.demo-cancel-click').click(function(){return false;});
            });
        </script>

        <!-- 下拉框切换控制 -->
        <script type="text/javascript">
            $(function(){
                // 一级菜单
                $('.addtype').change(function(){
                    var this_val = $(this).val();
                    if( this_val == 'click' ){
                        $('.menu_item_keyword').show();
                        $('.menu_item_link').hide();
                    }else if( this_val == 'view' ){
                        $('.menu_item_keyword').hide();
                        $('.menu_item_link').show();
                    }else{
                        $('.menu_item_keyword').hide();
                        $('.menu_item_link').hide();
                    }
                });

                // 二级菜单
                $('.addtype2').change(function(){
                    var this_val = $(this).val();
                    if( this_val == 'click' ){
                        $('.menu_item_keyword_sub').show();
                        $('.menu_item_link_sub').hide();
                    }else if( this_val == 'view' ){
                        $('.menu_item_keyword_sub').hide();
                        $('.menu_item_link_sub').show();
                    }else{
                        $('.menu_item_keyword_sub').hide();
                        $('.menu_item_link_sub').hide();
                    }
                });

                // 修改菜单
                $('.addtype_modify').change(function(){
                    var this_val = $(this).val();
                    if( this_val == 'click' ){
                        $('.menu_item_keyword_modify').show();
                        $('.menu_item_link_modify').hide();
                    }else if( this_val == 'view' ){
                        $('.menu_item_keyword_modify').hide();
                        $('.menu_item_link_modify').show();
                    }else{
                        $('.menu_item_keyword_modify').hide();
                        $('.menu_item_link_modify').hide();
                    }
                });

            });
        </script>

        <!-- 菜单变化控制 -->
        <script type="text/javascript">
            // 添加一级菜单操作事件+ajax函数
            $( '.btn_add' ).click(function(){
                var addpid = $( '.addpid' ).attr('pid');
                var addtitle1 = $( '.addtitle1' ).val();
                var addtype = $( '.addtype' ).val();
                var addkeyword = $( '.addkeyword' ).val();
                var addurl = $( '.addurl' ).val();
                var addidx = $( '.addidx' ).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/wxmenues/addWchatMenu'); ?>",
                    data: {
                        pid: addpid,
                        title: addtitle1,
                        type: addtype,
                        keyword: addkeyword,
                        url: addurl,
                        idx: addidx
                    },
                    success:function(e){
                        // alert('success');
                        var obj = JSON.parse(e);
                        console.log(obj);
                        if( obj.code == '0' ){
                            // alert( obj.msg );
                            window.location.reload();
                        }else{
                            alert( obj.msg );
                        }
                    },
                    error:function(e){
                        alert('系统繁忙，请稍后重试!');
                        console.log(e);
                        window.location.reload();
                    }
                })
            });

            // 点击添加二级菜单时获取一级菜单信息，并添加二级菜单内容操作事件
            $( '.addmune_two' ).unbind().click(function(){
                $.ajax({
                    type: "POST",
                      url: "<?php echo site_url('admin/wxmenues/parentMenues'); ?>",
                      data: {
                      },
                      success:function(e){
                            var obj = JSON.parse(e);
                            console.log(obj.data);
                            obj = obj.data;
                            var html = "";
                            for( var i = 0; i < obj.length; i++ ){
                                html += "<option value=" + obj[i]['id'] + ">" + obj[i]['title'] + "</option>";
                            }
                            $( '.parentName2' ).html(html);
                            // post二级菜单内容
                            addmenu2();
                      }
                });
            });

            // 点击修改菜单按钮时获取当前id的菜单信息，并修改菜单内容操作事件
            $( '.modify_button' ).unbind().click(function(){
                var id = $(this).attr('data_id');
                $.ajax({
                    type: "POST",
                      url: "<?php echo site_url('admin/wxmenues/getMenuInfoById'); ?>",
                      data: {
                        id:id
                      },
                      success:function(e){
                            var obj = JSON.parse(e);
                            // console.log(obj);
                            obj = obj.data;

                            if( obj.pid == '0' ){
                                $('#type_modify').val( '一级菜单' );
                            }else {
                                $('#type_modify').val( '二级菜单' );
                            }
                            $('#title_modify').val(obj.title);
                            $('#order_modify').val(obj.idx);
                            $('#modify_id').val(obj.id);
                            if( obj.type == 'click' && obj.pid == '0' ){
                                $('.menu_item_keyword_modify').show();
                                $('.menu_item_link_modify').show();
                                var data = '<option value="click">点击回复事件</option><option value="view">浏览跳转事件</option><option value="">无(有二级菜单)</option>';
                                $('.addtype_modify').html(data);
                                $('#keyword_modify').val(obj.keyword);
                                $('.menu_item_link_modify').hide();
                            }else if( obj.type == 'view' && obj.pid == '0' ){
                                $('.menu_item_keyword_modify').show();
                                $('.menu_item_link_modify').show();
                                var data = '<option value="view">浏览跳转事件</option><option value="click">点击回复事件</option><option value="">无(有二级菜单)</option>';
                                $('.addtype_modify').html(data);
                                $('#link_modify').val(obj.url);
                                $('.menu_item_keyword_modify').hide();
                            }else if( obj.type == '' ){
                                $('.menu_item_keyword_modify').show();
                                $('.menu_item_link_modify').show();
                                var data = '<option value="">无(有二级菜单)</option>';
                                $('.addtype_modify').html(data);
                                $('.menu_item_keyword_modify').hide();
                                $('.menu_item_link_modify').hide();
                            }else if( obj.type == 'click' && obj.pid != '0' ){
                                $('.menu_item_keyword_modify').show();
                                $('.menu_item_link_modify').show();
                                var data = '<option value="click">点击回复事件</option><option value="view">浏览跳转事件</option>';
                                $('.addtype_modify').html(data);
                                $('#keyword_modify').val(obj.keyword);
                                $('.menu_item_link_modify').hide();
                            }else if( obj.type == 'view' && obj.pid != '0' ){
                                $('.menu_item_keyword_modify').show();
                                $('.menu_item_link_modify').show();
                                var data = '<option value="view">浏览跳转事件</option><option value="click">点击回复事件</option>';
                                $('.addtype_modify').html(data);
                                $('#link_modify').val(obj.url);
                                $('.menu_item_keyword_modify').hide();
                            }

                            editUpdate();
                      }
                });
            })

            // 删除菜单操作事件
            $( '.del' ).unbind().click(function(){
                  var td = $(this).parent( 'td' ).siblings();
                  var id = $(this).attr('data_id');
                  var pid = $(this).attr('pid');
                  if( pid == '0' ){
                      var html = '删除一级菜单，该菜单下的子菜单也会被删除，您确定要删除吗？';
                  }else{
                      var html = '您确定要删除该二级菜单吗？'
                  }
                  $( '.delbody' ).html( html );
                  $( '.deldata' ).val( id );
                  delmenu( id, pid );
            });

            // 修改菜单ajax函数
            function editUpdate(){
                $( '.btn_update' ).unbind().click(function(){
                    var id = $('#modify_id').val();
                    var title = $('#title_modify').val();
                    var type = $('.addtype_modify').val();
                    var keyword = $('#keyword_modify').val();
                    var url = $('#link_modify').val();
                    var order = $('#order_modify').val();
                      $.ajax({
                          type: "POST",
                            url: "<?php echo site_url('admin/wxmenues/updateMenu'); ?>",
                            data: {
                               id: id,
                               title: title,
                               type: type,
                               keyword: keyword,
                               url: url,
                               idx: order
                            },
                            success:function(e){
                                  //alert(e);
                                  var obj = JSON.parse( e );
                                  // console.log(obj);
                                  if( obj.code == '0' ){
                                     alert( obj.msg );
                                     window.location.reload();
                                  }else{
                                    alert( obj.msg );
                                  }
                            },
                            error: function(){
                                alert('系统繁忙，请稍后重试');
                            }
                    })
                })
            }

            // 添加二级菜单ajax函数
            function addmenu2(){
                $( '.btn_add2' ).unbind().click(function(){
                    var addpid = $( '.parentName2' ).val();
                    var addtitle2 = $( '.addtitle2' ).val();
                    var addtype = $( '.addtype2' ).val();
                    var addurl = $( '.addurl2' ).val();
                    var addkeyword = $( '.addkeyword2' ).val();
                    var addidx = $( '.addidx2' ).val();
                    $.ajax({
                        type: "POST",
                          url: "<?php echo site_url('admin/wxmenues/addsubmenu'); ?>",
                          data: {
                             pid: addpid,
                             title: addtitle2,
                             type: addtype,
                             url: addurl,
                             keyword: addkeyword,
                             idx: addidx
                          },
                          success:function(e){
                             var obj = JSON.parse(e)
                             if( obj.code == '0' ){
                                 // alert( obj.msg );
                                 window.location.reload();
                             }else{
                                 alert( obj.msg );
                             }
                          }
                    })
                })
            }

            // 删除菜单ajax函数
            function delmenu( id, pid ){
                var id = id;
                $( '.btn_del' ).unbind().click(function(){
                     $.ajax({
                        type: "POST",
                          url: "<?php echo site_url('admin/wxmenues/delmenu'); ?>",
                          data: {
                             id: id,
                             pid: pid
                          },
                          success:function(e){
                             //alert(e);
                              var obj = JSON.parse( e );
                              // console.log(obj);
                              if( obj.code == '0' ){
                                 // alert( obj.msg );
                                 window.location.reload();
                              }else{
                                alert( obj.msg );
                              }
                          },
                          error:function(e){
                            alert('系统繁忙，请稍后重试');
                          }
                    })
                })
            }
        </script>

        <!-- 发布控制 -->
        <script type="text/javascript">
            $(function(){
                $('.publish_menu').click(function(){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo site_url('admin/wxmenues/publish') ?>',
                        data:{
                        },
                        success:function(e){
                            var obj = JSON.parse(e);
                            if( obj.code == '0' ){
                                alert( obj.msg );
                                window.location.reload();
                            }else{
                                console.log(obj);
                                alert( obj.msg );
                            }
                        },
                        error:function(){
                            alert('系统繁忙，请稍后重试');
                            window.location.reload();
                        }
                    });
                });
            });
        </script>
    </div>
</div>
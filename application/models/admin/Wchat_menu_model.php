<?php  
class Wchat_menu_model extends CI_Model{

      /**
       *  [addmenu 添加菜单方法，一二级公用]
       * @param  [type] $data [description]
       * @return [type]       [description]
       */
   	  public function addmenu( $data ){
          $pid = $data['pid'];

          if( $pid == '0' ){
              // 检测已有菜单数量
              $count = $this->_checkMenuCount( $pid );
              if( $count >= 3 ){
                 return return_msg( '40012', '一级菜单最多只能有3个' );
                 die;
              }
              // 插入数据
              $bool = $this->db->insert( 'wechat_menu', $data );
              if( $bool ){
                 $res = $this->_update_publish_status( '0' );
                 return return_msg( '0', '添加成功!', $res );
              }else{
                 return return_msg( '40000', '系统繁忙，请稍后再试！' );
              }
          }else if( $pid != '0' ){
             // 检测是否存在所选一级菜单
             $parentData = $this->getMenuDataById( $pid );
              if( empty($parentData) ){
                 return return_msg( '40013', '未选择有效的一级菜单，请选择一个可存放二级菜单的一级菜单' );
                 die;
              }
              // 检测已有菜单数量
              $count = $this->_checkMenuCount( $pid );
              if( $count >= 5 ){
                 return return_msg( '40014', '二级菜单最多只能有5个' );
                 die;
              }
              // 插入数据
          	   $bool = $this->db->insert( 'wechat_menu', $data );
              if( $bool ){
                 $this->_update_publish_status( '0' );
                 return return_msg( '0', '添加成功!' );
              }else{
                 return return_msg( '40000', '系统繁忙，请稍后再试！' );
              }
          }
   	  }

      /**
       * [updatemenu 更新菜单，一二级公用]
       * @param  [type] $data [description]
       * @return [type]       [description]
       */
      public function updatemenu( $data ){
          $id = $data['id'];
          $bool = $this->db->set( $data )->where('id', $id)->update('wechat_menu');
          if( $bool ){
            $this->_update_publish_status( '0' );
            return return_msg('0','更新成功！');
          }else{
            return return_msg('40000', '系统繁忙，请稍后再试！');
          }
      }

      /**
       * [deletemenu 删除菜单，一二级公用]
       * @param  [type] $id  [description]
       * @param  [type] $pid [description]
       * @return [type]      [description]
       */
   	  public function deletemenu( $id, $pid ){
          $arr = array(
              'id' => $id
            );
          $arrTwo = array(
              'pid' => $id
            );
   	   	  if( $pid == '0' ){
              $bool = $this->db->delete( 'wechat_menu', $arr );
              $boolTwo = $this->db->delete( 'wechat_menu', $arrTwo );
              if( $bool && $boolTwo ){
                $this->_update_publish_status( '0' );
                return return_msg('0','删除成功');
              }else{
                return return_msg('40000','系统繁忙，请稍后再试！');
              }
   	   	  }else{
              $bool = $this->db->delete( 'wechat_menu', $arr );
              if( $bool){
                $this->_update_publish_status( '0' );
                return return_msg('0','删除成功');
              }else{
                return return_msg('40000','系统繁忙，请稍后再试！');
              }
   	   	  }
   	  }

   	  public function getData(){
   	  	  $data = $this->db->where( 'pid','0' )->order_by('idx', 'ASC')->get( 'wechat_menu' );
   	  	  $res = $data->result_array();
   	  	  foreach ($res as $key => $value) {
   	  	  	  $submenu = $this->db->where( 'pid', $value['id'] )->order_by('idx', 'ASC')->get( 'wechat_menu' );
   	  	  	  $subnum = $submenu->result_array();
   	  	  	  if( !empty( $subnum ) ){
                  $res[$key]['submenu'] = $subnum;
   	  	  	  }else{
                  $res[$key]['submenu'] = '';
            }
   	  	  }
          return $res;
   	  }

      public function getPublishStatus(){
          $data = $this->db->get( 'wechat_config' )->row_array();
          if( $data['publish_status'] == '1' ){
            // return return_msg('0', '获取成功', true);
            return true;
          }else{
            // return return_msg('0', '获取成功', false);
            return false;
          }
      }

      public function getMenuDataById( $id ){
          $data = $this->db->where( 'id', $id )->get( 'wechat_menu' )->row_array();
          return return_msg('0','获取成功',$data);
      }

      /**
       * [_checkMenuCount 用$pid 查询菜单数量]
       * @param  [type] $pid [description]
       * @return [type]      [description]
       */
      private  function _checkMenuCount( $pid ){
          $count = $this->db->where( 'pid', $pid )->count_all_results( 'wechat_menu' );
          return $count;
      }

      /**
       * [getParentMenues 获取所有的一级菜单]
       * @return [type] [description]
       */
      public function getParentMenues(){
          $data = $this->db->order_by('idx', 'ASC')->get_where( 'wechat_menu', array( 'pid' => '0', 'type' => '' ) )->result_array();
          return return_msg( '0', '获取成功', $data );
      }

      /**
       * [getWxAccessToken 获取access_token,本地有效期设置1.5小时]
       * @return [type] [description]
       */
      public function getWxAccessToken(){
          $tokenCheck = $this->db->where( 'key_id', 'access_token')->get('wechat_config')->row_array();
          
          // 获取数据库appid 和 appsecret
          $appidCheck = $this->db->where( 'key_id', 'appid')->get('wechat_config')->row_array();
          $appsecretCheck = $this->db->where( 'key_id', 'appsecret')->get('wechat_config')->row_array();
          $appid = $appidCheck['key_val'];
          $appsecret = $appsecretCheck['key_val'];
          $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid .'&secret=' . $appsecret;

          // 存在，未过期
          if( !empty( $tokenCheck ) && (strtotime( $tokenCheck['end_time'] ) > time() ) ){
              $token = $tokenCheck['key_val'];
              $data = array(
                  'code' => '0',
                  'msg' => '直接获取成功',
                  'access_token' => $token
                );
              return $data;
              die;
          // 存在，已过期
          }else{
              $response = file_get_contents( $url );
              $res = json_decode( $response, true );
              if( isset( $res['access_token'] ) ){
                $token = $res['access_token'];
              }else{
                $data = array(
                    'code' => $res['errcode'],
                    'msg' => $res['errmsg']
                  );
                return $data;
                die;
              }

              if( !empty( $tokenCheck ) && ( strtotime( $tokenCheck['end_time'] ) < time() ) ){
                  $arr = array(
                    'key_val' => $token,
                    'start_time' => date( 'Y-m-d H:i:s', time() ),
                    'end_time' => date( 'Y-m-d H:i:s', (time() + 5400) )
                  );

                  $bool = $this->db->where('key_id','access_token')->update( 'wechat_config', $arr );
                  if( $bool ){
                    $data = array(
                        'code' => '0',
                        'msg' => '更新成功',
                        'access_token' => $token
                      );
                    return $data;
                  }else{
                    $data = array(
                        'code' => '40000',
                        'msg' => '系统繁忙，请稍后再试！'
                      );
                    return $data;
                  }
              }else if( empty( $tokenCheck ) ){
                  $arr = array(
                    'key_id' => 'access_token',
                    'key_val' => $token,
                    'start_time' => date( 'Y-m-d H:i:s', time() ),
                    'end_time' => date( 'Y-m-d H:i:s', (time() + 5400) )
                  );

                  $bool = $this->db->insert( 'wechat_config', $arr );
                  if( $bool ){
                    $data = array(
                        'code' => '0',
                        'msg' => '创建成功',
                        'access_token' => $token
                      );
                    return $data;
                  }else{
                    $data = array(
                        'code' => '40000',
                        'msg' => '系统繁忙，请稍后再试！'
                      );
                    return $data;
                  }
              }
          }
      }

      public function publish( $access_token ){
          $data = $this->db->where( 'pid','0' )->order_by('idx', 'ASC')->get( 'wechat_menu' );
          $res = $data->result_array();
          $newData = array();
          foreach ($res as $key => $value) {
              $submenu = $this->db->where( 'pid', $value['id'] )->order_by('idx', 'ASC')->get( 'wechat_menu' );
              $subnum = $submenu->result_array();
              if( !empty( $subnum ) ){
                  $newDataSub = array();
                  $newData[$key]['name'] = $value['title'];
                  foreach( $subnum as $i => $v ){
                    $newDataSub[$i]['type'] = $v['type'];
                    $newDataSub[$i]['name'] = $v['title'];
                    if( $v['type'] == 'click' ){
                        $newDataSub[$i]['key'] = $v['keyword'];
                    }else if( $v['type'] == 'view' ){
                        $newDataSub[$i]['url'] = $v['url'];
                    }
                  }
                  $newData[$key]['sub_button'] = $newDataSub;
              }else{
                  $newData[$key]['type'] = $value['type'];
                  $newData[$key]['name'] = $value['title'];
                  if( $value['type'] == 'click' ){
                      $newData[$key]['key'] = $value['keyword'];
                  }else if( $value['type'] == 'view' ){
                      $newData[$key]['url'] = $value['url'];
                  }
              }
          }

          $sendDataArr = array();
          $sendDataArr['button'] = $newData;
          $sendDataJson = json_encode( $sendDataArr, JSON_UNESCAPED_UNICODE );

          $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;

          // 设置header信息
          $header = array(  
            "Accept: application/json",  
            "Content-Type: application/json;charset=utf-8",  
          );

          // 初始化curl
          if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $sendDataJson);

            $notice = curl_exec($ch);
            curl_close($ch);
            $noticeArr = json_decode( $notice, true );
            if( $noticeArr['errcode'] == '0' ){
              $this->_update_publish_status( '1' );
              $data = return_msg( '0', '发布成功' );
            }else if( $noticeArr['errcode'] == '40015' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，菜单类型不合法' );
            }else if( $noticeArr['errcode'] == '40016' || $noticeArr['errcode'] == '40017' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，菜单按钮个数不合法' );
            }else if( $noticeArr['errcode'] == '40018' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，按钮名字长度不合法' );
            }else if( $noticeArr['errcode'] == '40019' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，按钮KEY长度不合法' );
            }else if( $noticeArr['errcode'] == '40020' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，按钮URL长度不合法' );
            }else if( $noticeArr['errcode'] == '40055' ){
              $data = return_msg( $noticeArr['errcode'], '发布失败，URL格式不合法' );
            }else{
              $data = return_msg( $noticeArr['errcode'], $noticeArr['errmsg'] );
            }

          } else {
            $data = return_msg( '3', '您的服务器尚未开启curl扩展' );
          }

          return $data;
      }

      /**
       * [_update_publish_status 更新发布状态]
       * @param  [type] $status [description]
       * @return [type]         [description]
       */
      private function _update_publish_status( $status ){
        $data = array( 'publish_status' => $status );
        $this->db->set( $data )->update('wechat_config');
      }
}
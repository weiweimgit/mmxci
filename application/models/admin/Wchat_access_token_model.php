<?php

class Wchat_access_token_model extends CI_Model{

    public function __construct(){
        $this->timeNow = date( 'Y-m-d H:i:s', time() );
    }

    /**
      *  [getWxAccessToken 获取微信access_token]
      * @return [type]       [description]
    */
    public function getWxAccessToken(){
      $tokenInfo = $this->get_token();
      if( empty( $tokenInfo ) ){
        $this->create_token();
        $token = $this->get_token();
      }else{
        if( ( strtotime( $this->timeNow ) > strtotime( $tokenInfo['end_time'] ) ) || empty( $tokenInfo['key_val'] ) ){
          $this->update_token();
          $token = $this->get_token();
        }else{
          $token = $this->get_token();
        }
      }
      return $token['key_val'];
    }

    public function get_token(){
      $res = $this->db->where( array( 'key_id' => 'access_token' ) )->get( 'wechat_config_meta' )->row_array();
      return $res;
    }

    public function create_token(){
      $res = $this->get_token_from_wx();
      $data['key_id'] = 'access_token';
      $data['key_val'] = $res['access_token'];
      $data['start_time'] = $this->timeNow;
      $data['end_time'] = date( 'Y-m-d H:i:s', strtotime( $this->timeNow ) + $res['expires_in'] );
      $this->db->insert( 'wechat_config_meta', $data );
    }

    public function update_token(){
      $res = $this->get_token_from_wx();
      $data['key_id'] = 'access_token';
      $data['key_val'] = $res['access_token'];
      $data['start_time'] = $this->timeNow;
      $data['end_time'] = date( 'Y-m-d H:i:s', strtotime( $this->timeNow ) + $res['expires_in'] );
      $data['update_time'] = $this->timeNow;
      $this->db->set( $data )->where( 'key_id', $data['key_id'] )->update( 'wechat_config_meta' );
    }

    private function get_token_from_wx(){
      $wxInfo = $this->db->get( 'wechat_config' )->row_array();
      $appId = $wxInfo['appid'];
      $appSecret = $wxInfo['appsecret'];
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
      $resJson = file_get_contents( $url );
      $resArr = json_decode( $resJson, true );
      return $resArr;
    }
}
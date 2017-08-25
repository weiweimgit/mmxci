<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 带场景的公众号二维码生成
 */
class Scene_qrcode extends CI_Controller {
	function __construct(){
        parent::__construct();
    }

    public function get_tickit(){
    	$this->load->model( 'admin/wchat_access_token_model' );
    	$access_token = $this->wchat_access_token_model->getWxAccessToken();
    	$tickitUrl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
    	$tickitJson = $this->do_requst( $tickitUrl );
    	$tickitArr = json_decode( $tickitJson, true );
    	$tickit = $tickitArr['ticket'];

    	$qrcodeUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode( $tickit );

    	// $qrcode_img = file_get_contents( $qrcodeUrl );
    	echo '<img src="' . $qrcodeUrl . '">';
    }

    public function do_requst( $url ){
    	$data = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "shop123"}}}';
	    if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			$response = curl_exec($ch);
			$response = str_replace('\"', "'", $response);
			curl_close($ch);
		} else {
		  	$response = '您的服务器尚未开启curl扩展';
		}
		error_log( $response );
		return $response;
    	// $result = json_decode($response, true);
    	// return $result;
    }
}
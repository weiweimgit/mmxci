<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	微信Token相关类
*/
class Token extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model( 'admin/wchat_access_token_model' );
	}

	public function index(){
		echo '123';
	}

	public function get_access_token(){
		$token = $this->wchat_access_token_model->getWxAccessToken();
		echo $token;
	}
}
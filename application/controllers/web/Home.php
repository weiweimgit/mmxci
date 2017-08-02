<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * web首页
 */
class Home extends CI_Controller {
		function __construct(){
            parent::__construct();
            if( !$this->session->userdata('useridweb') ){
            	redirect('web/login');
            }
        }

        /**
         * [index 网站首页展示]
         * @DateTime 2017-05-21T18:31:24+0800
         * @return   [type]                   [description]
         */
        public function index(){
            // 根据userid获取登陆账号信息，显示到首页
            $useridweb = $this->session->userdata('useridweb');
            $this->load->model('web/login_model', 'login_model');
            $data['loginInfo'] = $this->login_model->get_login_info( $useridweb );

        	$data['title'] = '学生首页';
            $this->load->view('web/header',$data);
        	$this->load->view('web/menu_top');
        	$this->load->view('web/home');
        	$this->load->view('web/footer');
        }

        public function ajax_content(){
            $this->load->model('admin_content_model');
            echo $this->admin_content_model->get_van_order();
        }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$this->session->unset_userdata( 'username' );
		//if ($this->session->userdata('username')){
          //  redirect('admin/welcome');
        //}
        $data['title'] = '后台登录';

        $this->load->view('admin/header',$data);
        $this->load->view('admin/login');
        $this->load->view('admin/footer');
	}

	public function validate(){
		// 直接访问validate时，清除登录session
		unset($_SESSION['username']);

		$this->form_validation->set_rules('username','用户名','required|min_length[5]');
		$this->form_validation->set_rules('password','密码','required');

		if( $this->form_validation->run() ){

			// 表单验证通过，进入数据库验证
			$this->load->model('admin/login_model', 'login_model');
            $res = $this->login_model->verify_users(
                $this->input->post('username'),
                $this->input->post('password')
            );

            if($res !== false){
            	// 数据库验证成功：设置session，跳转到首页
                $data = array( 'userid' => $res['id'], 'username' => $this->input->post('username'), 'role_id'=>$res['role_id']);
                $this->session->set_userdata($data);
                redirect('admin/welcome');
            }else{
            	$data['title'] = '登录';
            	$data['msg'] = '账号或密码错误';
				$this->load->view('admin/header',$data);
				$this->load->view('admin/login');
				$this->load->view('admin/footer');
            }

		}else{
			$data['title'] = '登录';
			$this->load->view('admin/header',$data);
			$this->load->view('admin/login');
			$this->load->view('admin/footer');
		}
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Wxmenues extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model( 'admin/wchat_menu_model' );
	}

	public function index()
	{
		$wxmenues = $this->wchat_menu_model->getData();
		$publish_status = $this->wchat_menu_model->getPublishStatus();
	    // 根据角色id获取左边菜单内容，角色id根据登陆的账户获得
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

	    // 根据登录名获取登陆账号信息，显示到首页
	    $userid = $this->session->userdata('userid');
	    $this->load->model('admin/login_model', 'login_model');
	    $data['loginInfo'] = $this->login_model->get_login_info( $userid );

		$data['title'] = '首页';
		$data['menues'] = $res;
		$data['publish_status'] = $publish_status;
		$data['wxmenues'] = $wxmenues;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/wxmenues');
		$this->load->view('admin/footer');
	}

	public function publishStatus(){
		$res = $this->wchat_menu_model->getPublishStatus();
		echo $res;
	}

	/**
	 * [addWchatMenu 一级菜单添加]
	 */
	public function addWchatMenu(){
		// $dataJson = file_get_contents('php://input', 'r');
		// $dataJson = $GLOBALS['HTTP_RAW_POST_DATA'];
		// json_decode raw 参数
		// $data = json_decode( $dataJson, true );
		$data = $_POST;
		$data['pid'] = 0;

		// title为空时，直接返回
		if( empty( $data['title'] ) ){
			$res = return_msg( '1001', '菜单标题不能为空' );
			echo $res;
			die;
		}

		// idx为空时，设置默认值10
		if( empty( $data['idx'] ) ){
			$data['idx'] = 10;
		}

		//根据菜单类型确定 keyword和url的值
		if( $data['type'] == 'click' ){
			// $data['keyword'] = $this->input->post('keyword');
			$data['url'] = '';
			// keyword为空时，直接返回
			if( empty( $data['keyword'] ) ){
				$res = return_msg( '1001', '关键词不能为空' );
				echo $res;
				die;
			}
		}else if( $data['type'] == 'view' ){
			$data['keyword'] = '';
			// $data['url'] = $this->input->post('url');
			// url为空时，直接返回
			if( empty( $data['url'] ) ){
				$res = return_msg( '1001', '跳转链接不能为空' );
				echo $res;
				die;
			}
		}else{
			$data['keyword'] = '';
			$data['url'] = '';
		}

		$newData = filter_string_wx_menues( $data );
		$res = $this->wchat_menu_model->addmenu( $newData );
		echo $res;
	}

	/**
	 * [addsubmenu 添加二级菜单]
	 * @return [type] [description]
	 */
	public function addsubmenu(){
		// $dataJson = file_get_contents('php://input', 'r');
		// $dataJson = $GLOBALS['HTTP_RAW_POST_DATA'];
		// json_decode raw 参数
		// $data = json_decode( $dataJson, true );
		$data = $_POST;

		// pid不合法，直接返回
		if( $data['pid'] == '0' ){
			$res = return_msg( '101', '菜单类型有误' );
			echo $res;
			die;
		}

		// title为空时，直接返回
		if( empty( $data['title'] ) ){
			$res = return_msg( '1001', '菜单标题不能为空' );
			echo $res;
			die;
		}

		// idx为空时，设置默认值10
		if( empty( $data['idx'] ) ){
			$data['idx'] = 10;
		}

		//根据菜单类型确定 keyword和url的值
		if( $data['type'] == 'click' ){
			$data['keyword'] = $data['keyword'];
			$data['url'] = '';
			// keyword为空时，直接返回
			if( empty( $data['keyword'] ) ){
				$res = return_msg( '1001', '关键词不能为空' );
				echo $res;
				die;
			}
		}else if( $data['type'] == 'view' ){
			$data['keyword'] = '';
			$data['url'] = $data['url'];
			// url为空时，直接返回
			if( empty( $data['url'] ) ){
				$res = return_msg( '1001', '跳转链接不能为空' );
				echo $res;
				die;
			}
		}else{
			$data['keyword'] = '';
			$data['url'] = '';
		}

		$newData = filter_string_wx_menues( $data );
		$res = $this->wchat_menu_model->addmenu( $newData );
		echo $res;
	}

	/**
	 * [updateMenu 更新菜单内容]
	 */
	public function updateMenu(){
		// $dataJson = file_get_contents('php://input', 'r');
		// $dataJson = $GLOBALS['HTTP_RAW_POST_DATA'];
		// json_decode raw 参数
		// $data = json_decode( $dataJson, true );
		$data = $_POST;
		$data['update_time'] = date( 'Y-m-d H:i:s', time() );

		// id为空时，直接返回
		if( empty( $data['id'] ) ){
			$res = return_msg( '101', '菜单编号不能为空' );
			echo $res;
			die;
		}

		// title为空时，直接返回
		if( empty( $data['title'] ) ){
			$res = return_msg( '1001', '菜单标题不能为空' );
			echo $res;
			die;
		}

		// idx为空时，设置默认值10
		if( empty( $data['idx'] ) ){
			$data['idx'] = 10;
		}

		//根据菜单类型确定 keyword和url的值
		if( $data['type'] == 'click' ){
			$data['keyword'] = $data['keyword'];
			$data['url'] = '';
			// keyword为空时，直接返回
			if( empty( $data['keyword'] ) ){
				$res = return_msg( '1001', '关键词不能为空' );
				echo $res;
				die;
			}
		}else if( $data['type'] == 'view' ){
			$data['keyword'] = '';
			$data['url'] = $data['url'];
			// url为空时，直接返回
			if( empty( $data['url'] ) ){
				$res = return_msg( '1001', '跳转链接不能为空' );
				echo $res;
				die;
			}
		}else{
			$data['keyword'] = '';
			$data['url'] = '';
		}

		$newData = filter_string_wx_menues( $data );
		$res = $this->wchat_menu_model->updatemenu( $newData );
		echo $res;
	}

	/**
	 * [delmenu 删除菜单]
	 * @return [type] [description]
	 */
	public function delmenu(){
		// $dataJson = file_get_contents('php://input', 'r');
		// $dataJson = $GLOBALS['HTTP_RAW_POST_DATA'];
		// json_decode raw 参数
		// $data = json_decode( $dataJson, true );
		$data = $_POST;
		// id为空时，直接返回
		if( empty( $data['id'] ) ){
			$res = return_msg( '101', '菜单编号不能为空' );
			echo $res;
			die;
		}
		$id = $data['id'];
		$pid = $data['pid'];
		$res = $this->wchat_menu_model->deletemenu( $id, $pid );
		echo $res;
	}

	/**
	 * [parentMenues 查找所有一级菜单内容]
	 * @return [type] [description]
	 */
	public function parentMenues(){
		$res = $this->wchat_menu_model->getParentMenues();
		echo $res;
	}

	/**
	 * [getMenuInfoById 通过id查找菜单内容]
	 * @return [type] [description]
	 */
	public function getMenuInfoById(){
		// $dataJson = file_get_contents('php://input', 'r');
		// $dataJson = $GLOBALS['HTTP_RAW_POST_DATA'];
		// json_decode raw 参数
		// $data = json_decode( $dataJson, true );
		$data = $_POST;
		// title为空时，直接返回
		if( empty( $data['id'] ) ){
			$res = json_encode( return_msg( '1001', '菜单编号不能为空' ), JSON_UNESCAPED_UNICODE );
			echo $res;
			die;
		}
		$id = $data['id'];
		$res = $this->wchat_menu_model->getMenuDataById( $id );
		echo $res;
	}

	/**
	 * [publish 发布菜单]
	 * @return [type] [description]
	 */
	public function publish(){
		$this->load->model( 'admin/wchat_access_token_model' );
		$token = $this->wchat_access_token_model->getWxAccessToken();
		if( !empty( $token ) ){
			$res = $this->wchat_menu_model->publish( $token );
		}else{
			$res = return_msg( '400015', 'token丢失' );
		}
		echo $res;
	}

}
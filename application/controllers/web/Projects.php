<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	学生选课功能
*/
class Projects extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('useridweb') ){
			redirect('web/login');
		}
		$this->load->model( 'web/Projects_model', 'projects_model' );
	}

	/**
	 * [index 课程列表（课程介绍）首页]
	 * @DateTime 2017-05-21T17:34:06+0800
	 * @return   [type]                   [description]
	 */
	public function index(){
		$useridweb = $this->session->userdata('useridweb');
		// 全部课题
		$data['projects'] = $this->projects_model->projects_list( $useridweb );
		// 已读的课题
		$data['projectsReads'] = $this->projects_model->projects_read_list( $useridweb );
		// 学生收藏的课题
		$data['projectsWishes'] = $this->projects_model->projects_wishes_list( $useridweb );

		$data['title'] = '课程列表';
	    $this->load->view('web/header',$data);
		$this->load->view('web/menu_top');
		$this->load->view('web/projects');
		$this->load->view('web/footer');
	}

	/**
	 * [myWishListChange 修改是否喜欢(收藏)状态]
	 * @return [type] [description]
	 */
	public function myWishListChange(){
		$wish_mark = $this->input->get('wish_mark');
		$id = $this->input->get('id');
		$useridweb = $this->session->userdata('useridweb');
		$res = $this->projects_model->my_wish_list_change( $wish_mark, $id, $useridweb );
		echo return_msg( '0', '修改成功', $wish_mark );
	}

	/**
	 * [myReadListChange 修改是否已读状态]
	 * @return [type] [description]
	 */
	public function myReadListChange(){
		$read_mark = $this->input->get('read_mark');
		$id = $this->input->get('id');
		$useridweb = $this->session->userdata('useridweb');
		$res = $this->projects_model->my_read_list_change( $read_mark, $id, $useridweb );
		echo return_msg( '0', '修改成功', $read_mark );
	}

	/**
	 * [selection 课程选择列表页面]
	 * @DateTime 2017-05-21T17:35:27+0800
	 * @return   [type]                   [description]
	 */
	public function selection(){
		$useridweb = $this->session->userdata('useridweb');
		$data['projectsAll'] = $this->projects_model->projects_all_list( $useridweb );
		$data['projectsHadSelected'] = $this->projects_model->projects_had_selected_list( $useridweb );

		$data['title'] = '选课列表';
	    $this->load->view('web/header',$data);
		$this->load->view('web/menu_top');
		$this->load->view('web/project_selection');
		$this->load->view('web/footer');
	}

	/**
	 * [selectionSubmission 课程选择后提交处理方法]
	 * @DateTime 2017-05-21T17:35:50+0800
	 * @return   [type]                   [description]
	 */
	public function selectionSubmission(){
		$useridweb = $this->session->userdata('useridweb');
		$arr = array();
		for ($i=1; $i <= 10 ; $i++) {
			$name = 'project_' . $i;
			$name_rank = 'project_rank_' . $i;
			$post_name = $this->input->post( $name );
			$post_name_rank = $this->input->post( $name_rank );
			if( !empty( $post_name ) && !empty( $post_name_rank ) ){
				$arr[$i]['project_id'] = $this->input->post( $name );
				$arr[$i]['project_rank_nr'] = $this->input->post( $name_rank );
			}
		}
		$this->projects_model->projects_select_submission( $useridweb, $arr );
		redirect( 'web/projects/selection' );
	}
}
	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');

	}
	
	public function index()
	{
		if ($this->session->userdata('user_id') > 0) {
			$this->load->view('welcome_message');
		}else{
			$this->load->view('login_index');
		}
	}

	public function check_login()
	{
		if (trim($this->input->post('submit')) == 'submit') {
			$this->form_validation->set_rules('user_name', 'user Name', 'required|trim');
			$this->form_validation->set_rules('password', 'password', 'required|trim');
				// echo "<pre>";print_r($this->input->post());die();

			if ($this->form_validation->run() == FALSE) {
				$data['user_name'] = $this->input->post('user_name');
				$data['password'] = $this->input->post('password');
				$this->load->view('login_index', $data);

			}else{
				$user_name = $this->input->post('user_name');
				$password = $this->input->post('password');
				$result = $this->user_model->check_login($user_name, $password);
				// echo "<pre>";print_r($result);die();
				if ($result && $result == TRUE) {
					redirect('index_con');
				} else{
					$this->load->view('login_index');
				}
			}
		}else{
			$this->load->view('login_index');
		}
	}
	public function logout()
	{
		// echo "<pre>";print_r($this->session->userdata());die();
		if($this->session->userdata('userid') != "") {
			$array_items = array('user_name' => '', 'userid' => '');
			$this->session->unset_userdata($array_items);
			unset($_SESSION);
			$this->session->set_userdata($array_items);
			$this->session->sess_destroy();
			redirect('index_con');	
		} else {
			redirect('index_con');
		}
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function __construct()
   {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
 
	public function index()
	{
		$this->load->view('login');
	}
	
	public function authenticate()
	{
		$this->load->model('loginmodel');
		$username = $this->db->escape_str(trim($this->input->post('username', true)));
		$password = $this->db->escape_str(trim($this->input->post('password', true)));
		$role = $this->input->post('role', true);
		
		$verify = $this->loginmodel->getData($username, $password, $role);
		if($verify)
		{
			$this->session->set_userdata('user',$verify);
			if($role != 'Influencer'){
				redirect('home/index');
			} else {
				redirect('influencer/index');
			}
		}
		else {
			$this->session->set_flashdata('error','Username Password Mismatch!!!');
			redirect('login/index');

		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login/index');
	}
}
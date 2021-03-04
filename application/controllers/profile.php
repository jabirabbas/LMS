<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
   {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
   }
 
	public function index()
	{
		$data['filename'] = 'profile.php';
		$this->load->view('home', $data);
	}
	
	public function save()
	{
		$profile = $this->input->post();
		
		$role = $this->session->userdata('user')->role;
		
		$check = $this->db->get_where('users', array('password'=>md5($profile['oldpassword']), 'id'=>$this->session->userdata['user']->id));
		$result = $check->result();
		
		if(!empty($result)){
			$profile['password'] = md5($profile['newpassword']);
			unset($profile['oldpassword'], $profile['cpassword'], $profile['newpassword']);
			
			$this->db->update('users', $profile,array('id'=>$this->session->userdata['user']->id));
			$this->session->set_flashdata('message','Profile was successfully updated!');	
		}
		else
		{
			$this->session->set_flashdata('error','Old Password is incorrect!');		
		}
		redirect('profile/index');
	}
	
	
}
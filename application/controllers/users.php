<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('to_excel');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}
 
	public function index()
	{
		if(!empty($this->input->post())){
			$data['criteria'] = $this->input->post();
		}
		if($this->session->userdata('user')->role == 'Admin'){
			$query = 'select u.*, (select name from users where id = u.parent_id) as reporting_manager from users u';
			if(!empty($data['criteria']['role']))
				$query .= ' where u.role = "'.$data['criteria']['role'].'"';
			if(!empty($data['criteria']['name']))
				$query .= ' where u.name like "%'.$data['criteria']['name'].'%"';
			$sql = $this->db->query($query);
		} else {
			$sql = $this->db->query('select u.* from users u where parent_id = '.$this->session->userdata('user')->id);
		}
		$data['users'] = $sql->result();
		$data['filename'] = 'users.php';
		$this->load->view('home', $data);
	}
	
	public function add()
	{
		$sql = $this->db->get_where('users',array('role'=>'Manager'));
		$data['users'] = $sql->result();
		
		$data['filename'] = 'users_add.php';
		$this->load->view('home', $data);
	}
	
	public function edit()
	{
		$id = $this->uri->segment(3);
		$sql = $this->db->get_where('users', array('id' => $id));
		$data['user'] = $sql->row();	
		
		$this->db->where('id != '.$id);
		$sql = $this->db->get_where('users',array('role'=>'Manager'));
		$data['users'] = $sql->result();
		
		$data['filename'] = 'users_add.php';
		$this->load->view('home', $data);
	}
	
	private function isValidMd5($md5) {
	  return strlen($md5) == 32 && ctype_xdigit($md5);
	}
	
	public function save()
	{
		$id = $this->input->post('id');
		$users = $this->input->post();
		
		//validation for unique username
		if(!$id) {
			$config = array(
					array(
						 'field'   => 'username',
						 'label'   => 'Username',
						 'rules'   => 'is_unique[users.username]'
					  )
					);
			
			$this->form_validation->set_rules($config); 
			$this->form_validation->set_message('is_unique', 'username "'.$users['username'].'" already exists, Please try another one!');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', validation_errors());
				redirect('users/add');
				exit;	
			}	
		}

		if($this->isValidMd5($users['password']) != 1) $users['password'] = md5($users['password']);

		$users['cpc'] = ($users['cpc'] == '') ? 0 : $users['cpc'];
		$users['cpl'] = ($users['cpl'] == '') ? 0 : $users['cpl'];
		$users['cpa'] = ($users['cpa'] == '') ? 0 : $users['cpa'];
		$users['cpo'] = ($users['cpo'] == '') ? 0 : $users['cpo'];
		
		if($id) {
			$this->db->where('id', $id);
			$this->db->update('users', $users);
			$this->session->set_flashdata('message','User was successfully updated!');	
		}
		else {
			unset($users['id']);
			$this->db->insert('users', $users);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message','User was successfully added!');
		}
		redirect('users');
	}
	
	public function delete()
	{
		$id = $this->uri->segment(3);
		$this->db->delete('users', array('id' => $id));
		redirect('users/index'); 
	}
	
	public function deleteMultiple()
	{
		$id = $this->uri->segment(3);
		$this->db->where('id IN('.$id.')');
		$this->db->delete('users');
		redirect('users/index'); 
	}
	
	public function excel()
	{
		if($this->session->userdata('user')->role == 'Admin'){
			$sql = $this->db->select('u.id, u.name, u.username, u.role, u.source, (select name from users where id = u.parent_id) as reporting_manager, u.email as email_address, u.mobile, u.address, u.ga_code, u.channel_url, u.bank_details')->get('users u');
		} else {
			$sql = $this->db->select('id, name, username, role')->get_where('users u',array('parent_id' => $this->session->userdata('user')->id));
		}
		
		$this->to_excel->create_excel($sql, 'users');
		redirect('users/index');
	}
	
}
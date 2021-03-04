<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('to_excel');
		$this->load->helper('url');

	}
 
	
	public function index()
	{
		$sql = $this->db->order_by('role')->where('role != "Admin"')->get('users');
		$users = $sql->result();

		$order = array('Admin', 'Supervisor', 'Executive');
		
		$i = 0;
		foreach($order as $o){
			foreach($users as $u){
				if($o == $u->role){		
					$newSet[$u->role][$i]['id']=$u->id;
					$newSet[$u->role][$i]['name']=$u->name;
					$i++;
				}
			}
			$i=0;
		}
		
		$data['users'] = $newSet;
		
		$data['filename'] = 'message_add.php';
		$this->load->view('home', $data);
	}
	
	
	public function save()
	{
		
		$msg = $this->input->post();

		if($msg['user_id'] == ""){
			$msg['type'] = 'Public';
			$msg['user_id'] = 0;
		} else {
			$msg['type'] = 'Private';			
		}
		
		$msg['datetime'] = date('Y-m-d H:i:s');

		$this->db->insert('messages', $msg);
		
		$this->session->set_flashdata('message','Message was successfully Posted!');
		redirect('message');
	}
}

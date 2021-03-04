<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dist extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('to_excel');
		$this->load->helper('url');

	}
 
	
	public function add()
	{
		$sql = $this->db->order_by('role')->where('role = "Executive"')->get('users');
		$data['users'] = $sql->result();
		
		$sql = $this->db->select('l.id, l.name, d.user_id, l.mobile')->join('distribution d','d.lead_id = l.id','left')->get_where('leads l','l.status IN ("Pending","Assigned") and source = "'.$this->session->userdata('user')->source.'"');

		$data['leads'] = $sql->result();
				
		$data['filename'] = 'dist_add.php';
		$this->load->view('home', $data);
	}
	
	
	public function save()
	{
		
		$dist = $this->input->post();

		foreach($dist['lead_id'] as $dl){
			$this->db->delete('distribution', array('lead_id'=>$dl));
			$this->db->insert('distribution', array('user_id'=>$dist['user_id'], 'lead_id'=>$dl));
			$this->db->update('leads',array('status'=>'Assigned'),array('id'=>$dl));
		}
		
		$this->session->set_flashdata('message','Lead was successfully Assigned!');
		redirect('dist/add');
	}
}

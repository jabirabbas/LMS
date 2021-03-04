<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
		//users array
		if($this->session->userdata('user')->role == 'Admin'){
			$sql = $this->db->order_by('role')->where(array('role' => "Executive"))->get('users');	
			$data['users'] = $sql->result();
		} else if($this->session->userdata('user')->role == 'Manager'){
			$sql = $this->db->order_by('role')->where(array('role' => "Executive", 'parent_id'=>$this->session->userdata('user')->id))->get('users');
			$data['users'] = $sql->result();	
		}

		//source array
		$sql = $this->db->select('distinct(source) as source')->order_by('source')->get('leads');
		$data['source'] = $sql->result();
		
		$data['filename'] = 'search.php';
		$this->load->view('home', $data);
	}
	
	public function find()
	{
		
		//users array
		if($this->session->userdata('user')->role == 'Admin'){
			$sql = $this->db->order_by('role')->where(array('role' => "Executive"))->get('users');	
			$data['users'] = $sql->result();
		} else if($this->session->userdata('user')->role == 'Manager'){
			$sql = $this->db->order_by('role')->where(array('role' => "Executive", 'parent_id'=>$this->session->userdata('user')->id))->get('users');
			$data['users'] = $sql->result();	
		}

		//source array
		$sql = $this->db->select('distinct(source) as source')->order_by('source')->get('leads');
		$data['source'] = $sql->result();
		
		$criterias = $this->input->post();

		if(empty($criterias)){
			$this->session->set_flashdata('error', 'Please select atleast 1 criteria for search');
			redirect('search');
			exit;
		} else {

			if($criterias['name']){
				$this->db->like('name',$criterias['name']);
			}
			if($criterias['mobile']){
				$this->db->like('mobile',$criterias['mobile']);
			}
			if($criterias['email']){
				$this->db->like('email',$criterias['email']);
			}
			if($criterias['source']){
				$this->db->like('source',$criterias['source']);
			}
			if($criterias['status']){
				$this->db->like('status',$criterias['status']);
			}
			if($criterias['user_id']){
				$this->db->join('distribution d','d.lead_id = l.id');
				$this->db->where('d.user_id = '.$criterias['user_id']);
			} else {
				$this->db->join('distribution d','d.lead_id = l.id','left');
			}

			if(!empty($criterias['fromdate'])){
				$todate = (empty($criterias['todate'])) ? date('Y-m-d') : $criterias['todate'];
				$this->db->where('date(l.created_on) between "'.$criterias['fromdate'].'" and "'.$todate.'"');
			}

			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.notes, l.created_on, l.modified_on, (select name from users where id = d.user_id ) as assigned')->get('leads l');
			$data['leads'] = $sql->result();
			
			//for maintaining selections
			$data['criteria'] = (object) $criterias;
			
		}
		
		//echo '<pre>'; print_r($data); exit;
		
		$data['filename'] = 'search.php';
		$this->load->view('home', $data);
	}
	
	public function excel()
	{
		$criterias = $this->input->post();
		
		if(empty($criterias)){
			$this->session->set_flashdata('error', 'Please select atleast 1 criteria for search');
			redirect('search');
			exit;
		} else {

			if($criterias['name']){
				$this->db->like('name',$criterias['name']);
			}
			if($criterias['mobile']){
				$this->db->like('mobile',$criterias['mobile']);
			}
			if($criterias['email']){
				$this->db->like('email',$criterias['email']);
			}
			if($criterias['source']){
				$this->db->like('source',$criterias['source']);
			}
			if($criterias['status']){
				$this->db->like('status',$criterias['status']);
			}
			if($criterias['user_id']){
				$this->db->join('distribution d','d.lead_id = l.id');
				$this->db->where('d.user_id = '.$criterias['user_id']);
			} else {
				$this->db->join('distribution d','d.lead_id = l.id','left');
			}

			if(!empty($criterias['fromdate'])){
				$todate = (empty($criterias['todate'])) ? date('Y-m-d') : $criterias['todate'];
				$this->db->where('date(l.created_on) between "'.$criterias['fromdate'].'" and "'.$todate.'"');
			}

			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.source, l.notes as comment, l.created_on, l.modified_on, (select name from users where id = d.user_id ) as assigned')->get('leads l');
			$data['leads'] = $sql->result();
				
			$this->to_excel->create_excel($sql, 'leads');
			redirect('search/index');
		}
	}
}
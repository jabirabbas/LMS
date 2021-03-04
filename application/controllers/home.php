<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

   public function __construct()
   {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('to_excel');
		$this->load->helper('url');

		if(!$this->session->userdata('user')){
			redirect('login');								   
		}
	}
 
	public function index()
	{
		$id = $this->session->userdata('user')->id;

		if(!empty($this->input->post())){
			$data['criteria'] = $this->input->post();
		}

		$data['graph'] = new stdClass();
		$numbers = array();

		//applying filters
		if(!empty($data['criteria']['fromdate'])){
			$todate = (empty($data['criteria']['todate'])) ? date('Y-m-d') : $data['criteria']['todate'];
			$this->db->where('date(created_on) between "'.$data['criteria']['fromdate'].'" and "'.$todate.'"');
		}
		if(!empty($data['criteria']['source'])){
			$this->db->where('source = "'.$data['criteria']['source'].'"');
		}

		if($this->session->userdata('user')->role == "Admin" or $this->session->userdata('user')->role == "Head"){
			$sql = $this->db->select('count(id) as y, status as name')->order_by('id desc')->group_by('status')->get('leads');
			$data['graph'] = json_encode($sql->result(), JSON_NUMERIC_CHECK);	
			$numbers = $sql->result();	
		} else if($this->session->userdata('user')->role == "Manager"){
			$sql = $this->db->select('count(id) as y, status as name')->group_by('status')->get_where('leads',array('source' =>$this->session->userdata('user')->source));
			$data['graph'] = json_encode($sql->result(), JSON_NUMERIC_CHECK);
			$numbers = $sql->result();		
		} else if($this->session->userdata('user')->role == "Executive"){
			$sql = $this->db->select('count(id) as y, status as name')->join('distribution','distribution.lead_id = leads.id')->group_by('status')->get_where('leads', array('distribution.user_id' => $this->session->userdata('user')->id));
			$data['graph'] = json_encode($sql->result(), JSON_NUMERIC_CHECK);
			$numbers = $sql->result();		
		}	

		foreach($numbers as $n){
			$data['numbers'][$n->name] = $n->y;
		}

		//bar graph
		$query = 'SELECT DATE_FORMAT(created_on,"%b-%Y") as months, count(id) as count FROM `leads`';
		if(!empty($data['criteria']['source'])){
			$query .= ' where source = "'.$data['criteria']['source'].'"';
		}
		$query .= ' group by month(created_on) order by created_on desc limit 12';
		$sql = $this->db->query($query)->result();
		$data['months'] = array_column($sql, 'months');
		$data['count'] = array_column($sql, 'count');
		
		//source array
		$sql = $this->db->select('distinct(source) as source')->order_by('source')->get('leads');
		$data['source'] = $sql->result();
		
		//message history
		/*if($this->session->userdata('user')->role == "Admin"){
			$sql = $this->db->select('m.*, u.name')->join('users u','u.id = m.user_id', 'left')->order_by('m.id desc')->get('messages m');
		} else {
			$sql = $this->db->order_by('id desc')->get_where('messages','user_id = '.$id.' or user_id = 0',50,1);			
		}
		$data['messages'] = $sql->result();
		
		
		//latest message
		if($this->session->userdata('user')->role != "Admin"){
			$data['message'] = $this->db->order_by('id desc')->get_where('messages','user_id = '.$id.' or user_id = 0',1,0)->row();			
		}
		
		//callback

		/*if($this->session->userdata('user')->role == "Admin"){
			$sql = 'select id, firstname, lastname, mobile, callback as date, "callback" as type from leads where callback >= "'.date('Y-m-d',strtotime('-7 days')).'" and callback <> "0000-00-00" and callback <> ""';
		} else {
			$sql = 'select l.id, l.name, l.mobile, l.email from leads l inner join distribution d on d.lead_id = l.id where (d.user_id = '.$id.' or d.user_id IN (select id from users where parent_id = '.$id.')) and l.callback >= "'.date('Y-m-d',strtotime('-7 days')).'" and l.callback <> "0000-00-00" and l.callback <> ""';
		}
		$res = $this->db->query($sql);
		$callback = $res->result();
		
		//ced
		if($this->session->userdata('user')->role == "Admin"){
			$sql = 'select id, firstname, lastname, mobile, ced as date, "ced" as type from leads where ced <= "'.date('Y-m-d',strtotime('+200 days')).'" and ced <> "0000-00-00" and ced <> ""';
		} else {
			$sql = 'select l.id, l.firstname, l.lastname, l.mobile, l.ced as date, "ced" as type from leads l inner join distribution d on d.lead_id = l.id where (d.user_id = '.$id.' or d.user_id IN (select id from users where parent_id = '.$id.')) and l.ced <= "'.date('Y-m-d',strtotime('+200 days')).'" and l.ced <> "0000-00-00" and l.ced <> ""';
		}
		$res1 = $this->db->query($sql);
		$ced = $res1->result();
		
		$notifications = array_merge($callback, $ced);
		
		usort($notifications, function($a, $b) {
			return $a->date - $b->date;
		});		
		
		echo '<pre>'; print_r($notifications); exit;	
		
		$this->session->set_userdata('notifications',$notifications);*/

		//echo '<pre>'; print_r($data); exit;	
		
		$this->load->view('home', $data);
	}

	public function excel()
	{
		$criterias = $this->input->post();
		
		if(empty($criterias)){
			$this->session->set_flashdata('error', 'Please select atleast 1 criteria for search');
			redirect('home');
			exit;
		} else {

			if($criterias['source']){
				$this->db->like('l.source',$criterias['source']);
			}
			if(!empty($criterias['fromdate'])){
				$todate = (empty($criterias['todate'])) ? date('Y-m-d') : $criterias['todate'];
				$this->db->where('date(l.created_on) between "'.$criterias['fromdate'].'" and "'.$todate.'"');
			}

			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.source, l.created_on, l.modified_on, (select name from users where id = d.user_id ) as assigned')->join('distribution d','d.lead_id = l.id','left')->get('leads l');
			//echo $this->db->last_query(); exit;
			$data['leads'] = $sql->result();
				
			$this->to_excel->create_excel($sql, 'leads');
			redirect('home/index');
		}
	}
	
}
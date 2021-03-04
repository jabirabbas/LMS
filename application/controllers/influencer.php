<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Influencer extends CI_Controller {

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

		//yesterday data
		$query = 'select clicks, app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and DATE(leads.created_on) = DATE(NOW() - INTERVAL 1 DAY)) as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and DATE(leads.created_on) = DATE(NOW() - INTERVAL 1 DAY) and leads.status="AC Opened") as ac_opened from influencer_activity where DATE(date) = DATE(NOW() - INTERVAL 1 DAY) and influencer_id = '.$id;
		$sql = $this->db->query($query);
		$data['yesterday'] = $sql->row();

		//current month data
		$month = date('m');
		$year = date('Y');

		if(!empty($this->input->post('mfilter'))){
			$val = explode('-',$this->input->post('mfilter'));
			$month = $val[1];
			$year = $val[0];

			$arr = ["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
			$data['mfilter'] = $arr[ltrim($month,0)].' '.$year;
			$data['filter'] = $this->input->post('mfilter');
		}

		$q = 'select sum(clicks) as clicks, sum(app_installs) as app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'") as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'" and leads.status="AC Opened") as ac_opened from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" and influencer_id = '.$id;
		$sql = $this->db->query($q);
		$data['month'] = $sql->row();

		//data for populating clicks table with source
		$q = 'select * from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" and influencer_id = '.$id;
		$sql = $this->db->query($q);
		$data['records'] = $sql->result();

		//stats
		$stats = $this->db->query('select DATE_FORMAT(date,"%d %b %Y") as date, sum(clicks) as clicks, sum(app_installs) as app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = '.$id.' and date(leads.created_on) = influencer_activity.date) as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = '.$id.' and date(leads.created_on) = influencer_activity.date and leads.status="AC Opened") as ac_opened from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" and influencer_id = '.$id.' group by date order by date')->result_array();

		$arr = array();
		$obj = new stdClass();
		$obj->name = 'Clicks';
		$obj->data = array_column($stats,'clicks');
		array_push($arr, $obj);
		
		$obj = new stdClass();
		$obj->name = 'Leads';
		$obj->data = array_column($stats,'leads');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'App Installs';
		$obj->data = array_column($stats,'app_installs');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'A/C Opened';
		$obj->data = array_column($stats,'ac_opened');
		array_push($arr, $obj);

		$data['dates'] = json_encode(array_column($stats,'date'));
		$data['stats'] = json_encode($arr,JSON_NUMERIC_CHECK);

		//earnings
		array_walk_recursive($stats, function(&$val, $key){
			if($key == 'clicks') $val *= $this->session->userdata('user')->cpc;
			if($key == 'leads') $val *= $this->session->userdata('user')->cpl;
			if($key == 'app_installs') $val *= $this->session->userdata('user')->cpa;
			if($key == 'ac_opened') $val *= $this->session->userdata('user')->cpo;
		});
		$arr = array();
		$obj = new stdClass();
		$obj->name = 'Clicks';
		$obj->data = array_column($stats,'clicks');
		array_push($arr, $obj);
		
		$obj = new stdClass();
		$obj->name = 'Leads';
		$obj->data = array_column($stats,'leads');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'App Installs';
		$obj->data = array_column($stats,'app_installs');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'A/C Opened';
		$obj->data = array_column($stats,'ac_opened');
		array_push($arr, $obj);

		$data['earnings'] = json_encode($arr,JSON_NUMERIC_CHECK);
		//echo '<pre>'; print_r($data); exit;	
		
		$this->load->view('influencer', $data);
	}

	public function my_payouts(){
		$sql = $this->db->order_by('id desc')->get_where('payments',array('user_id'=>$this->session->userdata('user')->id));
		$data['result'] = $sql->result();

		$data['filename'] = 'payouts.php';
		$this->load->view('influencer',$data); 
	}

	public function payouts(){
		$sql = $this->db->select('payments.*, users.name')->order_by('id desc')->join('users','users.id = payments.user_id')->get('payments');
		$data['result'] = $sql->result();

		$data['filename'] = 'payouts.php';
		$this->load->view('influencer',$data); 
	}

	public function summary()
	{
		$data['count'] = $this->db->get_where('users',array('role'=>'Influencer'))->num_rows();

		//yesterday data
		$sql = $this->db->query('select clicks, app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where DATE(leads.created_on) = DATE(NOW() - INTERVAL 1 DAY)and users.ga_code != "") as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where DATE(leads.created_on) = DATE(NOW() - INTERVAL 1 DAY) and leads.status="AC Opened" and users.ga_code != "") as ac_opened from influencer_activity where DATE(date) = DATE(NOW() - INTERVAL 1 DAY)');
		$data['yesterday'] = $sql->row();

		//current month data
		$month = date('m');
		$year = date('Y');

		if(!empty($this->input->post('mfilter'))){
			$val = explode('-',$this->input->post('mfilter'));
			$month = $val[1];
			$year = $val[0];

			$arr = ["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
			$data['mfilter'] = $arr[ltrim($month,0)].' '.$year;
			$data['filter'] = $this->input->post('mfilter');
		}

		$q = 'select sum(clicks) as clicks, sum(app_installs) as app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'" and users.ga_code != "") as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'" and leads.status="AC Opened" and users.ga_code != "") as ac_opened from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'"';
		$sql = $this->db->query($q);
		$data['month'] = $sql->row();

		//stats
		$stats = $this->db->query('select DATE_FORMAT(date,"%d %b %Y") as date, sum(clicks) as clicks, sum(app_installs) as app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where date(leads.created_on) = influencer_activity.date and users.ga_code != "") as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where date(leads.created_on) = influencer_activity.date and leads.status="AC Opened" and users.ga_code != "") as ac_opened from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" group by date order by date')->result_array();

		$arr = array();
		$obj = new stdClass();
		$obj->name = 'Clicks';
		$obj->data = array_column($stats,'clicks');
		array_push($arr, $obj);
		
		$obj = new stdClass();
		$obj->name = 'Leads';
		$obj->data = array_column($stats,'leads');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'App Installs';
		$obj->data = array_column($stats,'app_installs');
		array_push($arr, $obj);

		$obj = new stdClass();
		$obj->name = 'A/C Opened';
		$obj->data = array_column($stats,'ac_opened');
		array_push($arr, $obj);

		$data['dates'] = json_encode(array_column($stats,'date'));
		$data['stats'] = json_encode($arr,JSON_NUMERIC_CHECK);

		//echo '<pre>'; print_r($data); exit;

		$data['filename'] = 'influencer_admin.php';
		$this->load->view('home',$data);
	}

	public function payout_add(){
		$data['users'] = $this->db->get_where('users',array('role'=>'Influencer'))->result();

		$data['filename'] = 'payout_add.php';
		$this->load->view('home',$data);	
	}

	public function save(){
		$d = $this->input->post();
		$d['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('payments',$d);
		$this->session->set_flashdata('message','Payout made successfully.');
		redirect('influencer/payouts');
	}

	public function get_period(){
		$id = $this->uri->segment(3);
		$sql = $this->db->query('select period from (select distinct(date_format(leads.created_on,"%m-%Y")) as period from leads join users on users.ga_code = leads.code where users.id = '.$id.' union select distinct(date_format(date,"%m-%Y")) as dates from influencer_activity where influencer_id = '.$id.') as e where e.period NOT IN(select period from payments where user_id = '.$id.')')->result();
		$return = '<option value="0">--Select Period--</option>';
		foreach ($sql as $val) {
			$return .= '<option value="'.$val->period.'">'.$val->period.'</option>';
		}
		echo $return; exit;
	}

	public function get_amount(){
		$id = $this->uri->segment(3);

		$user = $this->db->get_where('users',array('id'=>$id))->row();

		$val = explode('-',$this->uri->segment(4));
		$month = $val[0];
		$year = $val[1];
			
		$q = 'select sum(clicks) as clicks, sum(app_installs) as app_installs, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'") as leads, (select count(leads.id) from leads join users on leads.code = users.ga_code where users.id = "'.$id.'" and MONTH(leads.created_on) = "'.$month.'" and YEAR(leads.created_on) = "'.$year.'" and leads.status="AC Opened") as ac_opened from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" and influencer_id = '.$id;
		$sql = $this->db->query($q);
		$params = $sql->row();
		
		$total = 0;
		$total += ($params->clicks * $user->cpc);
		$total += ($params->leads * $user->cpl);
		$total += ($params->app_installs * $user->cpa);
		$total += ($params->ac_opened * $user->cpo);


		//data for populating clicks table with source
		$q = 'select * from influencer_activity where MONTH(date) = "'.$month.'" and YEAR(date) = "'.$year.'" and influencer_id = '.$id;
		$sql = $this->db->query($q);
		$records = $sql->result();

		$table = '<table class="table">
                                <thead>
                                  <tr><th>No. of clicks</th><th>Source</th></tr>
                                </thead>
                                <tbody>';
        foreach ($records as $arr) {
          $data = json_decode($arr->json);
          if(!empty($data)){
            $table .= '<tr bgcolor="#f4f4f4"><td colspan="2">'.date('d M Y',strtotime($arr->date)).'</td></tr>';
            
            foreach ($data as $val) {
              $table .= '<tr><td>'.$val->key.'</td><td>'.$val->val.'</td></tr>';
            }
          }
        }
        
        $table .= '</tbody></table>';

		echo $total.'~'.$table; exit;
	}
	
}
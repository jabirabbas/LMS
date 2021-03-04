<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
        $this->load->library("pagination");
		$this->load->library('to_excel');
		$this->load->library('form_validation');
		$this->load->library('nativesession');
		$this->load->helper('url');
		
		$config['upload_path'] = '././files/';
		$config['allowed_types'] = 'doc|docx|pdf|wmv|wav|mp4|mp3|xls|xlsx|gif|jpg|png|txt';
		$this->load->library('upload', $config);
		
		if(!$this->session->userdata('user')){
			redirect('login');								   
		}

	}
 
	public function index()
	{
		if(!$this->session->userdata('limit')){
			$this->session->set_userdata('limit',50);
		}

		$config = array();
		$param = ($this->uri->segment(3)) ? $this->uri->segment(3) : 'All';
        $config["base_url"] = site_url("leads/index/$param");
        $config["per_page"] = $this->session->userdata('limit');
        $config["uri_segment"] = 4;

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $status = ($this->uri->segment(3) != 'All') ? urldecode($this->uri->segment(3)) : '';

        $id = $this->session->userdata('user')->id;
		if($this->session->userdata('user')->role == "Admin"){
			if($status == '')
        		$config["total_rows"] = $data['total_rows'] = $this->db->count_all_results('leads');
        	else
        		$config["total_rows"] = $data['total_rows'] = $this->db->get_where('leads',array('status'=>$status))->num_rows();
        	$this->db->flush_cache();


        	if($status != '') $this->db->where(array('status'=>$status));
			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.source, l.notes, l.modified_on, l.created_on, (select name from users where id = d.user_id  ) as assigned, l.seen')->join('distribution d','d.lead_id = l.id','left')->order_by('id desc')->limit($this->session->userdata('limit'), $page)->get('leads l');
		} else if($this->session->userdata('user')->role == "Manager"){
			if($status != '') $this->db->where(array('status'=>$status));
			$config["total_rows"] = $data['total_rows'] = $this->db->get_where('leads',array('source' => $this->session->userdata('user')->source))->num_rows();
			$this->db->flush_cache();

			if($status != '') $this->db->where(array('status'=>$status));
			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.source, l.notes, l.modified_on, l.created_on, (select name from users where id = d.user_id  ) as assigned, l.seen')->join('distribution d','d.lead_id = l.id','left')->order_by('id desc')->limit($this->session->userdata('limit'), $page)->get_where('leads l',array('l.source' => $this->session->userdata('user')->source));
		} else {
			if($status != '') $this->db->where(array('status'=>$status));
			$config["total_rows"] = $data['total_rows'] = $this->db->join('distribution d','d.lead_id = l.id')->join('users u','u.id = d.user_id')->where('d.user_id = '.$id)->get('leads l')->num_rows();
            $this->db->flush_cache();

            if($status != '') $this->db->where(array('status'=>$status));
			$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.notes, l.created_on, l.modified_on, (select name from users where id = d.user_id ) as assigned, l.seen')->join('distribution d','d.lead_id = l.id')->join('users u','u.id = d.user_id')->limit($this->session->userdata('limit'), $page)->where('d.user_id = '.$id)->order_by('id desc')->get('leads l');
		}

		$config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
         
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="firstlink">';
        $config['first_tag_close'] = '</span>';
         
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<span class="lastlink">';
        $config['last_tag_close'] = '</span>';
         
        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<span class="nextlink">';
        $config['next_tag_close'] = '</span>';

        $config['prev_link'] = 'Prev Page';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<span class="curlink">';
        $config['cur_tag_close'] = '</span>';

        $config['num_tag_open'] = '<span class="numlink">';
        $config['num_tag_close'] = '</span>';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		
		$data['leads'] = $sql->result();
		$data['filename'] = 'leads';

		$this->load->view('home', $data);
	}
	
	public function add()
	{
		//print_r($this->nativesession->get('lead')); exit;
		$data['filename'] = 'leads_add.php';
		$this->load->view('home', $data);
	}
	
	public function edit()
	{
		$id = $this->uri->segment(3);
		$sql = $this->db->get_where('leads', array('id' => $id));
		$data['lead'] = $sql->row();
		
		//updating seen if lead opened by assigned to
		$dist = $this->db->get_where('distribution','lead_id = '.$data['lead']->id)->row();
		if($this->session->userdata('user')->id == $dist->user_id){
			$this->db->update('leads',array('seen'=>1),'id = '.$dist->lead_id);	
		}
		
		$sql = $this->db->get_where('files', array('lead_id' => $id));
		$data['files'] = $sql->result();	

		$sql = $this->db->get('poa');
		$data['poa'] = $sql->result();	

		$sql = $this->db->get('poi');
		$data['poi'] = $sql->result();	
		
		$data['filename'] = 'leads_add.php';
		$this->load->view('home', $data);
	}

	public function save()
	{
		$this->nativesession->delete('lead');
		
		$id = $this->input->post('id');
		$leads = $this->input->post();
		
		//echo '<pre>'; print_r($leads); exit;
		
		/*if($_FILES['files']['name'][0]!=""){
			//transferring $_FILES to another $_FILES[
			foreach($_FILES['files'] as $key => $val)
			{
				$i = 0;
				foreach($val as $new_key)
				{
					$temp_array[$i][$key] = $new_key;
					$i++;
				}
			}
	
			$i = 0;
			foreach($temp_array as $key => $val)
			{
				$_FILES['file'.$i] = $val;
				$i++;
			}
	
			#clear the original array;
			unset($_FILES['files']);
			
			$i = 0;
			foreach($_FILES as $key => $value){
				if($value['error'][$key] == 0){
					if(!$this->upload->do_upload($key))
					{	
						$this->nativesession->set('lead', (object) $leads);
						$this->session->set_flashdata('error',$this->upload->display_errors());
						redirect('leads/add');
					}
					$fileDetails = $this->upload->data();
					$files[]['file_name'] = $fileDetails['file_name'];
				}
				
				$i++;
			}
		}*/

		if(!empty($leads['poi'])){
			$leads['poi'] = implode(',',$leads['poi']);
		}

		if(!empty($leads['poa'])){
			$leads['poa'] = implode(',',$leads['poa']);
		}
		
		if($id) {
			
			$leads['modified_on']=date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			$this->db->update('leads', $leads);
			
			//inserting data in files table
			if(!empty($files)){
				foreach($files as $fil){
					$this->db->insert('files', array('file_name'=>$fil['file_name'],'lead_id'=>$id));
				}
			}
			
			$this->session->set_flashdata('message','Lead was successfully updated!');	
		}
		else {
			
			$leads['created_on']=date('Y-m-d H:i:s');
			$this->db->insert('leads', $leads);
			$id = $this->db->insert_id();
			
			//inserting data in files table
			if(!empty($files)){
				foreach($files as $fil){
					$this->db->insert('files', array('file_name'=>$fil['file_name'],'lead_id'=>$id));
				}
			}
			
			$this->session->set_flashdata('message','Lead was successfully created!');
		}
		redirect('leads');
	}
	
	public function delete()
	{
		$page = $this->uri->segment(4);
		$param = $this->uri->segment(3);
		$id = $this->input->get('id');

		$this->db->delete('leads', array('id' => $id));
		
		//selecting files if any
		/*$sql = $this->db->get_where('files', array('lead_id' => $id));
		$files = $sql->result();
		
		foreach($files as $f){
			unlink('../../files/'.$f->name);
		}
		$this->db->delete('files',array('lead_id'=>$id));*/
		$this->session->set_flashdata('message','Lead deleted successfully.');
		redirect("leads/index/$param/$page"); 
	}
	
	public function deleteMultiple()
	{
		$page = $this->uri->segment(4);
		$param = $this->uri->segment(3);
		$id = $this->input->get('id');

		$this->db->where('id IN('.$id.')');
		$this->db->delete('leads');
		
		//selecting files if any
		/*$id = explode(',',$id);
		
		foreach($id as $i){
			$sql = $this->db->get_where('files', array('lead_id' => $i));
			$files = $sql->result();
			
			foreach($files as $f){
				unlink('../../files/'.$f->name);
			}
			$this->db->delete('files',array('lead_id'=>$i));
		}*/
		$this->session->set_flashdata('message','Selected leads deleted successfully.');
		redirect("leads/index/$param/$page"); 
	}

	public function setpage(){
		$this->session->set_userdata('limit',$this->input->post('limit'));
		redirect('leads/index');
	}

	public function updateBulkStatus()
	{
		$page = $this->uri->segment(4);
		$param = $this->uri->segment(3);
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->db->where('id IN('.$id.')');
		$this->db->update('leads',array('status'=>urldecode($status),'seen'=>1));
		$this->session->set_flashdata('message','Status updated successfully.');
		redirect("leads/index/$param/$page"); 
	}
	
	public function excel()
	{
		$sql = $this->db->select('l.id, l.name, l.email, l.mobile, l.status, l.source, l.notes as comment, l.created_on, l.modified_on, (select name from users where id = d.user_id ) as assigned')->join('distribution d','d.lead_id = l.id','left')->get('leads l');
		$this->to_excel->create_excel($sql, 'leads');
		redirect('leads/index');
	}
	
}

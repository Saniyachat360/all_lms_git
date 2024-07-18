<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_campaign extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table','form_validation','session'));
		$this->load->helper(array('form','url'));
				
		$this->load->model('add_campaign_model');
		
		
	}
	
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
		}
 public function index()
{
	
		$this->session();
		
		$query1=$this->add_campaign_model->select_campaign();
		$data['select_campaign']=$query1;

		$query2=$this->add_campaign_model->select_grp();
		$data['select_grp']=$query2;


	$data['var']=site_url('add_campaign/add');
	$this->load->view('include/admin_header.php');
	$this->load->view('add_campaign_view.php',$data);
	$this->load->view('include/footer.php');
	
	
} 	

public function add()

{
	$campaign_name=$this->input->post('campaign_name');
	$group_id=$this->input->post('group_id');
	
	$query=$this->add_campaign_model->add_campaign($campaign_name,$group_id);
	
	
	redirect('add_campaign');

	
}


public function edit_campaign($id)

{
	$this->session();
		
	$query=$this->add_campaign_model->select_campaign_id($id);
	$data['select_campaign_id']=$query;
	
	$query2=$this->add_campaign_model->select_grp();
	$data['select_grp']=$query2;
			
	$data['var']=site_url('add_campaign/update_campaign');
	$this->load->view('include/admin_header.php');
	$this -> load -> view('edit_campaign_view',$data);
	$this -> load -> view('include/footer');

	
}

public function update_campaign()

{
		
	
	$id=$this->input->post('id');
	
	$campaign_name=$this->input->post('campaign_name');
	echo $group_id=$this->input->post('group_id');
	
	
	$q=$this->add_campaign_model->update_campaign($id,$campaign_name,$group_id);
	
	redirect('add_campaign');
	
	
}



public function delete_campaign($id)

{
	
	
	
	//echo $id;
	
	$q=$this->add_campaign_model->delete_campaign($id);
	
	redirect('add_campaign');
	
}
function select_location() {
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_map_process m');
		$this -> db -> join('tbl_location l','l.location_id=m.location_id');
		$this -> db -> where('m.status!=', '-1');
		$this->db->where('l.location_id !=','38');
		if($_SESSION['role']==5){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		if($_SESSION['role']==4){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
public function test_dse()
{
	
	$location_dse1=array();
	$get_locations=$this->select_location();
	foreach($get_locations as $location_dse) {
	
        $location_dse1[] = $location_dse->location_id; 
}
	$location='All';
	$dse_name='';

	$this->db->select("u.fname,u.lname,u.id,l.location");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this -> db -> join('tbl_location l','l.location_id=m.location_id');
	$this->db->where('m.process_id',$_SESSION['process_id']);
	if($location!=''){
		if($location =='All'){
			$this -> db -> where_in('m.location_id', $location_dse1);
			
		}else{
		$this -> db -> where('m.location_id', $location);
		}
	}
	if($dse_name!=''){
		$this -> db -> where('u.id', $dse_name);
	}
		$this -> db -> where('u.id!=', 1);
		$this -> db -> where('u.status', 1);
			if($_SESSION['process_id'] == 8){
				$this -> db -> where('u.role', 16);
			}else{
				$this -> db -> where('u.role', 4);
			}
			
	$this->db->order_by('u.fname','asc');
	$query=$this->db->get();
	echo $this->db->last_query();
	return $query->result();
}


}
?>
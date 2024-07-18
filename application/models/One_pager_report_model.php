<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class One_pager_report_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $table_name;
	public $table_name1;
	function __construct() {
		
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
			$this -> process_name = $this -> session -> userdata('process_name');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7 || $this -> process_id == 8) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup f';
			} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all f';
	
		}		
	}
	function select_location() {
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_manager_process m');
		$this -> db -> join('tbl_location l','l.location_id=m.location_id');
		$this -> db -> where('m.status!=', '-1');
		$this->db->where('l.location_id !=','38');
		if($this->role==5){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		if($this->role==4){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		//if($_SESSION['user_id']!=1){
		$this -> db -> where('user_id', $_SESSION['user_id']);
		//}
		$this->db->group_by('l.location_id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
		function select_cse() {
		$this -> db -> select('concat(u.fname," ",u.lname) as cse_name,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get();
	//		echo $this->db->last_query();
		return $query -> result();

	}
		function select_dse($location) {
		$this -> db -> select('concat(u.fname," ",u.lname) as dse_name,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> join('tbl_mapdse d','d.dse_id=u.id');
		$this -> db -> where('m.location_id', $location);
		if($this->role==5){
			$this -> db -> where('d.tl_id', $_SESSION['user_id']);
		}
		if($this->role==4){
			$this -> db -> where('u.id', $_SESSION['user_id']);
		}
			$this -> db -> where('u.id!=', 1);
			$this -> db -> where('u.role', 4);
		$this -> db -> where('u.status', 1);
		$this->db->order_by('u.fname','asc');
		$query = $this -> db -> get();
	//		echo $this->db->last_query();
		return $query -> result();

	}
/*		public function cse_productivity($cse_id,$from_date,$to_date)
{
	
	$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		if($cse_id!=''){
				$this -> db -> where('u.id', $cse_id);
		}
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get()->result();
		if(count($query)>0){
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected');
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected');
	$total_call_delay_15=$this->total_call_delay($row->id,$from_date,$to_date,'15');
	$total_call_delay_30=$this->total_call_delay($row->id,$from_date,$to_date,'30');
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date);
	$evaluation_allotted=$this->appointment_type($row->id,$from_date,$to_date,'Evaluation Allotted');
	$test_drive=$this->appointment_type($row->id,$from_date,$to_date,'Test Drive');
	$home_visit=$this->appointment_type($row->id,$from_date,$to_date,'Home Visit');
	$showroom_visit=$this->appointment_type($row->id,$from_date,$to_date,'Showroom Visit');
		
	$select_data[]=array('cse_fname'=>$row->fname,'cse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit);
}
		}else{
			$select_data=array();
		}
	return $select_data;
}*/
}
?>
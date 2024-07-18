<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_notification_model extends CI_Model {

	public $process_name;

	public $role;

	public $user_id;

	public 	$location;

	public function __construct() {

		parent::__construct();

		//Session Values

		$this->today=date('Y-m-d');

		$this->process_name=$this->session->userdata('process_name');

		 $this->role=$this->session->userdata('role');

		$this->user_id=$this->session->userdata('user_id');

		$this->process_id=$this->session->userdata('process_id');

		$this->location=$this->session->userdata('location');

		$this->location_id=$this->session->userdata('location_id');

		

		//Excecutive array

		

		$this->tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL","Evaluation Team Leader");

		$this->executive_role=array("CSE","DSE","Service Excecutive","Insurance Executive","Accessories Executive","Finance Executive","Evaluation Executive");

	}

	

	public function location_data($location_name){

			$user=$this->input->post('user');

			$select_role=array("3","4","8","10","12","14","16");

			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');

			$this -> db -> from('lmsuser u');

			$this->db->join('tbl_manager_process p','p.user_id=u.id');

			$this->db->join('tbl_location l','l.location_id=p.location_id');

			$this->db->join('tbl_mapdse m','m.dse_id=u.id','left');

			$this -> db -> where('p.location_id', $location_name);

			$this -> db -> where('p.process_id', $this->process_id);

			$this -> db -> where('u.status', 1);

		

			if(in_array($this->role,$select_role)){

					$this->db->where('id',$this->user_id);

				}else{

					if($user=='DSE'){

					

					if(in_array($_SESSION['role_name'],$this->tl_role)){

					$this->db->where('m.tl_id',$this->user_id);

					}else{

						$this->db->where_in('role_name',$this->executive_role);

					}

					

					}else{

						

					if(in_array($_SESSION['role_name'],$this->tl_role)){

					$this->db->where('id',$this->user_id);

					}else{

						$this->db->where_in('role_name',$this->tl_role);

					}

					}

			}

		$this -> db -> order_by('u.fname', 'asc');

			$query = $this -> db -> get() ;

		//	echo $this->db->last_query();

			$query=$query-> result();

			//print_r($query);

			if(count($query)>0){

			foreach($query as $row){

			//	echo $row->id. 'role '.$row->role;

				$unassigned_leads = $this -> unassigned_leads($row -> id,$row->role);

				$new_leads=$this -> new_leads($row -> id,$row->role);

				$call_today=$this -> call_today($row -> id,$row->role);

				$pending_new_leads=$this -> pending_new($row -> id,$row->role);

				$pending_followup=$this -> pending_followup($row -> id,$row->role);

				

				

				$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'unassigned_leads' => $unassigned_leads,  'new_leads' => $new_leads,'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup);

			

			}

			}else{

				//$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');

			$select_leads = array();

				

			}

			return	$select_leads;

	}





	public function unassigned_leads($id,$role){



		$this -> db -> select('count(complaint_id) as unassign');

		$this -> db -> from('lead_master_complaint ln');

		$this -> db -> where('ln.nextAction!=', "Close");

		if ($role==3) {

			$this -> db -> where('assign_by_cse_tl', 0);

			$this -> db -> where('ln.assign_to_cse', $id);

		}elseif($role==2){

			$this -> db -> where('assign_by_cse_tl', 0);

		}

		$query = $this -> db -> get();

		//echo $this->db->last_query();

		$query1 = $query -> result();

		$total_unassigned = $query1[0] -> unassign;

		return $total_unassigned;

	}

	public function new_leads($id,$role){

		

		$today=date('Y-m-d');

		$this -> db -> select('count(complaint_id) as new_leads');

		$this -> db -> from('lead_master_complaint ln');

		

		if ($role==3) {

			$this -> db -> where('cse_followup_id', 0);

			$this -> db -> where('ln.assign_to_cse', $id);

			$this -> db -> where('ln.assign_to_cse_date', $today);

		}elseif($role==2){

			$this -> db -> where('assign_by_cse_tl', $id);

			

			$this -> db -> where('ln.assign_to_cse_date', $today);

			$this -> db -> where('cse_followup_id', 0);

		}

		$query = $this -> db -> get();

		//echo $this->db->last_query();

		$query1 = $query -> result();

		$total_new_lead = $query1[0] -> new_leads;

		return $total_new_lead;

	}

	public function call_today($id,$role){

		//echo $id;

		$today=date('Y-m-d');

		

		$this -> db -> select('count(ln.complaint_id) as call_today');

		$this -> db -> from('lead_master_complaint ln');

		$this -> db -> join('lead_followup_complaint f','f.id=ln.cse_followup_id');

	

	if ($role==3) {

	

			$this -> db -> where('ln.assign_to_cse', $id);

			//$this -> db -> where('ln.assign_to_dse_tl',0);

		}elseif($role==2){

		

			$this -> db -> where('assign_by_cse_tl', $id);

		}

	$this -> db -> where('f.nextfollowupdate', $today);



		$query = $this -> db -> get();

		//echo $this->db->last_query();

		$query1 = $query -> result();

		$total_call_today = $query1[0] -> call_today;

		return $total_call_today;

	}

public function pending_new($id,$role){

		

		$today=date('Y-m-d');

		

		$this -> db -> select('count(complaint_id) as pending_new');

		$this -> db -> from('lead_master_complaint ln');

	

		if ($role ==3) {

			

			$this -> db -> where('cse_followup_id', 0);

			

			$this -> db -> where('ln.assign_to_cse', $id);

			$this -> db -> where('ln.assign_to_cse_date < ', $today);

			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');

		}

		elseif($role ==2)  {

			

			$this -> db -> where('assign_by_cse_tl', $id);

			$this -> db -> where('ln.assign_to_cse_date < ', $today);

			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');

			$this -> db -> where('cse_followup_id', 0);

		}

		$query = $this -> db -> get();

		//echo $this->db->last_query();

		$query1 = $query -> result();

		$total_pending_new = $query1[0] -> pending_new;

		return $total_pending_new;

	}

public function pending_followup($id,$role){

		//echo $id;

		//echo $role;

		$today=date('Y-m-d');

	

		$this -> db -> select('count(ln.complaint_id) as call_today');

		$this -> db -> from('lead_master_complaint  ln');

		$this -> db -> join('lead_followup_complaint f','f.id=ln.cse_followup_id');

		if($role ==3) {

			

			$this -> db -> where('ln.assign_to_cse', $id);

			//$this -> db -> where('ln.assign_to_dse_tl',0);

		}elseif($role ==2) {

	

			$this -> db -> where('assign_by_cse_tl', $id);

			//$this -> db -> where('ln.assign_to_dse_tl',0);

		}

		//$this -> db -> where('ln.process', $this->process_name);

		$this -> db -> where('f.nextfollowupdate <', $today);

		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');

	

		$query = $this -> db -> get();

		//echo $this->db->last_query();

		$query1 = $query -> result();

		$total_call_today = $query1[0] -> call_today;

		return $total_call_today;

	}



}

	

	



?>
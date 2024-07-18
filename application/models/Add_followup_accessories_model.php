<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_accessories_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this -> location_id = $_SESSION['location_id'];
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14");
		$this -> all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13");
		$this -> tl_list = '("2","5", "7", "9", "11", "13")';
	}
		//Select process
	function process() 
	{
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('tbl_process');
		//$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	
		
	}	
	//Select Location
	public function select_location() {
		$this -> db -> select('p.location_id,l.location');
	//	$this -> db -> from('tbl_location');
		$this -> db -> from('tbl_map_process p');
		$this->db->join('tbl_location l','l.location_id=p.location_id');
		$this -> db -> where('p.process_id', $this->process_id);
		$query = $this -> db -> get();
			
		return $query -> result();
	}
// Transfer lead location
	function select_transfer_location($tprocess) 
	{
			$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$tprocess);
		$query = $this->db->get();
		return $query->result();
	
	
		
	}
		//Select lms user
	function lmsuser($location,$tprocess) {
		$toLocation = $location;
		
		 $from_user_role = $this -> role;
		$fromUser=$this->user_id;
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> join('tbl_location l1', 'l1.location_id=l.location', 'left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
		if($tprocess==$this->process_id)
		{
		if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array = array("2", "3", "5", "7", "9", "11", "13");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $this -> tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $this -> executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				
				}
				$t = $t . "role in" . $this -> tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $this -> tl_list;
			}
		}
		}
else {
	if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array = array("2", "5", "7", "9", "11", "13");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $this -> tl_array)) {
			
			$t = ' ( ';
			
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $this -> executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				$t = ' ( ';
				
				$t = $t . "role in" . $this -> tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $this -> tl_list;
				$this -> db -> where($t);
			}
		}
}
		//$this -> db -> where_in('role',$this->tl_array);
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$this->user_id);
		$this -> db -> where('u.process_id', $tprocess);
		$this -> db -> where('l1.location', $toLocation);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();
		
	}

	public function select_lead($enq_id) {
		$this -> db -> select('*');
		$this -> db -> from('lead_master_all');
		$this -> db -> where('enq_id', $enq_id);
		$query = $this -> db -> get();
		return $query -> result();

	}
	public function select_followup_lead($enq_id)
	{
		$this -> db -> select('f.date,f.nextfollowupdate,f.feedbackStatus,f.nextAction,f.comment,u.fname,u.lname');
		$this -> db -> from('lead_followup_all f');
		$this->db->join('lmsuser u','u.id=f.assign_to');
		$this -> db -> where('leadid', $enq_id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_accessories_list($enq_id)
	{
		$this -> db -> select('*');
		$this -> db -> from('accessories_order_list a ');
		$this->db->join('make_models m','m.model_id=a.model');
		$this -> db -> where('enq_id', $enq_id);
		$this->db->where('a.status!=','-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
public function select_accessories()
	{
		$this -> db -> select('*');
		$this -> db -> from('accessories');
		$this->db->where('status!=','-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_model()
	{
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this->db->where('status!=','-1');
		$this->db->where('make_id','1');
		$this->db->or_where('model_id','159');
		$query = $this -> db -> get();
		return $query -> result();
	}
public function select_feedback_status()
	{
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this->db->where('fstatus!=','Deactive');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select Nextaction Status
	function next_action_status() {
		
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	public function select_next_action($feedbackStatus)
	{
	$this->db->select('nextActionName');
	$this->db->from('tbl_mapNextAction');
	$this->db->where('feedbackStatusName',$feedbackStatus);
	$this->db->where('map_next_to_feed_status!=','Deactive');
	$query=$this->db->get();
	return $query->result();

		
		$query = $this -> db -> get();
		return $query -> result();
		
	}
public function delete_accessories($purchase_id)
{
	$query=$this->db->query("update accessories_order_list set status='-1' where purchase_id='$purchase_id'");
}
public function insert_followup()
{
	echo $assign_to=$_SESSION['user_id'];
	echo $enq_id=$this->input->post('booking_id');
	echo $email=$this->input->post('email');
	echo $feedbackstatus=$this->input->post('feedbackstatus');
	echo $nextAction=$this->input->post('nextAction');
	echo $eagerness=$this->input->post('eagerness');
	echo $address=$this->input->post('address');
	echo $followupdate=$this->input->post('followupdate');
	echo $comment=$this->input->post('comment');
	echo '<br>';
	print_r($this->input->post('accessories_id'));
	print_r($this->input->post('model_id'));
	print_r($this->input->post('quantity'));
	print_r($this->input->post('price'));
	print_r($this->input->post('date'));
	$today=date('Y-m-d');
	$time = date("H:i:s A");
	$insert_query=$this->db->query("INSERT INTO `lead_followup_all`(`leadid`,`comment`, `nextfollowupdate`,`eagerness`, `assign_to`,`date`,`feedbackStatus`, `nextAction`) 
	VALUES ('$enq_id','$comment','$followupdate','$eagerness','$assign_to','$today','$feedbackstatus','$nextAction')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master_all set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',eagerness='$eagerness' where enq_id='$enq_id'");
	for($i=0;$i<count($this->input->post('accessories_id'));$i++){
	$accessories=explode('#', $_POST['accessories_id'][$i]);
	$accessories_id[]=$accessories[0];
	$accessories_name[]=$accessories[1];
	}
	$model_id=$this->input->post('model_id');
	$quantity=$this->input->post('quantity');
	$price=$this->input->post('price');
	$date=$this->input->post('date');
	for($i=0;$i<count($this->input->post('accessories_id'));$i++){
		$customer_id=$this->input->post('customer_id');
	//	$total_price+=$price[$i]*$quantity[$i];
	$data=array(
	'accessories_id'=>$accessories_id[$i],
	'accessories_name'=>$accessories_name[$i],
	'model'=>$model_id[$i],
	'customer_id'=>$this->input->post('customer_id'),
	'qty'=>$quantity[$i],
	'price'=>$price[$i],
	'enq_id'=>$enq_id,
	'created_date'=>$date[$i]);
	$this->db->insert('accessories_order_list',$data);
	
	}
	/*if(count($this->input->post('accessories_id'))>1){
		$query=$this->db->query("INSERT INTO `accessories_order`(`total_price`, `customer_id`, `created_date`, `created_time`) 
	VALUES ('$total_price','$customer_id','$today','$time')");
	}*/
	
}
public function select_customer_details($enq_id)
{
		$this -> db -> select('l.*,m.model_name');
		$this -> db -> from('lead_master_all l');
		$this->db->join('make_models m','m.model_id=l.model_id','left');
		$this -> db -> where('enq_id', $enq_id);
		$query = $this -> db -> get();
		return $query -> result();
	
}
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class lead_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			//Session Values
		$this->process_name=$this->session->userdata('process_name');
		 $this->role=$this->session->userdata('role');
		$this->user_id=$this->session->userdata('user_id');
		$this->process_id=$_SESSION['process_id'];
		$this->location=$this->session->userdata('location');
		$this->location_id=$this->session->userdata('location_id');
		//Select Table 
		if($this->process_id==6 || $this->process_id==7)
		{
			$this->table_name='lead_master';
			$this->table_name1='lead_followup';			
		}
		else
		{
			$this->table_name='lead_master_all';		
			$this->table_name1='lead_followup_all';		
		}
		//Excecutive array
		
		$this->tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL");
	}

	public function select_location() {
		$this -> db -> select("l.location,l.location_id");
		$this -> db -> from("tbl_location l");
		$this->db->join('lmsuser u','u.location= l.location_id');
		if($_SESSION['role']==5 ){
			$this->db->where('u.id',$_SESSION['user_id']);
		}
		$this->db->group_by('l.location_id');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function total_lead($location_id, $fromdate, $todate,$role,$process_name,$user_id) {		
	
			$total_leads = $this -> total_lead_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id);
			$total_unassigned_leads = $this -> total_unassigned_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id);
			$total_pending_new_leads = $this -> total_pending_new_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id);
			$total_pending_followup_leads = $this -> total_pending_followup_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id);
			
		$select_leads = array('total_leads' => $total_leads, 'total_unassigned_leads' => $total_unassigned_leads, 'total_pending_new_leads' => $total_pending_new_leads, 'total_pending_followup_leads' => $total_pending_followup_leads);
		return $select_leads;

	}

	////////////////CSE Count //////////////////////
	public function total_lead_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id) 
	{
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $this->process_name);
		// If user DSE TL
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
		
		}
		// If user DSE 
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
		}
		// If user Excecutive
		elseif (in_array($role,$this->executive_array)) {
	
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}
		//if user TL 
		elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('ln.assign_by_cse_tl', $this->user_id);
		
			
		}
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_leads = $query1[0] -> total_leads;
		return $total_leads;
	}

	public function total_unassigned_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id) {
		
		//echo $id;
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("1","2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $this->process_name);
		$this -> db -> where('ln.nextAction!=', "Close");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
			$this -> db -> where('ln.assign_to_dse', 0);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('assign_by_cse_tl', 0);
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', 0);
		
			
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> total_leads;
		return $total_unassigned;
	}

	public function total_pending_new_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id) {
		
		$today=$todate;
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $this->process_name);
		$this -> db -> where('ln.nextAction!=', "Close");
		
		if($role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.dse_followup_id',0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
		}
		elseif(in_array($role,$this->tl_array)) {
			$this -> db -> where('ln.assign_to_dse_tl', 0);
			$this -> db -> where('assign_by_cse_tl', $this->user_id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('cse_followup_id', 0);
		}
else {
	$this -> db -> where('ln.assign_to_dse_tl', 0);
	$this -> db -> where('assign_by_cse_tl !=', 0);
	$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('cse_followup_id', 0);
	
}
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> total_leads;
		return $total_pending_new;

	}

	public function total_pending_followup_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id) {
		
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($this->table_name.' ln');
		if($role == '5')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
		}
		else {
			$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
		}
		if (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			//$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $this->user_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}
		$this -> db -> where('ln.process', $this->process_name);
		$this -> db -> where('f.nextfollowupdate <', $today);
		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");	
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> total_leads;
		return $total_call_today;

	}

	public function booking_days_cse($location_id, $days, $fromdate, $todate) {
		
		$this -> db -> select("count(l.enq_id) as total_leads");
		$this -> db -> from('lead_master l');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> join('lead_followup lm', 'l.cse_followup_id=lm.id');
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('lm.days60_booking', $days);
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	////////////////DSE Count //////////////////////
	public function total_lead_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function total_unassigned_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");
		$this -> db -> where('l.assign_to_dse', 0);
		//$this -> db -> where('l.assign_to_dse_tl!=', 0);
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.nextAction!=', 'Close');
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function total_pending_new_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(l.enq_id) as total_leads');
		$this -> db -> from('lead_master l');
		$this -> db -> where('l.dse_followup_id', '0');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.assign_to_dse_tl_date <', $yesterday);
		$this -> db -> where('l.assign_to_dse_date <', $yesterday);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function total_pending_followup_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$this -> db -> select('count(lm.id) as total_leads');
		$this -> db -> from("lead_master l");
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where('lm.nextfollowupdate<', $today);
		$this -> db -> where('lm.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function booking_days_dse($dse_tl_id, $days, $fromdate, $todate) {
		
		$this -> db -> select("count(l.enq_id) as total_leads");
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where('lm.days60_booking', $days);
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function total_feedback($location_id, $fromdate, $todate,$role,$process_name,$user_id) {
	
	if($this->process_name=='Finance')
	{
		$feedback2 = 'Appointment taken';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback3 = 'Login';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback4 = 'Login and Reject';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback5 = 'Login and Cancel';
			$total_count5 = $this -> total_feedback_count_cse( $feedback5, $fromdate, $todate,$role,$process_name,$user_id);
			$nextAction11 = 'Lost';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id);
			$nextAction12 = 'Disbursement';
			$total_count12 = $this -> total_nextAction_count_cse($nextAction12, $fromdate, $todate,$role,$process_name,$user_id);
			
			$select_leads = array($nextAction11 => $total_count11[0] -> total_count, $nextAction12 => $total_count12[0] -> total_count,  $feedback2 => $total_count2[0] -> total_count, $feedback3 => $total_count3[0] -> total_count, $feedback4 => $total_count4[0] -> total_count, $feedback5 => $total_count5[0] -> total_count);
		
	}else if($this->process_name=='Accessories')
		{
			$feedback2 = 'Will Decide Later';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback3 = 'Purchase from Outside';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback7 = 'Dont want Maruti';
			$total_count7 = $this -> total_feedback_count_cse($feedback7, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback4 = 'High Amount';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback5 = 'Booking Cancel';
			$total_count5 = $this -> total_feedback_count_cse($feedback5, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback6 = 'Waiting for Vehicle';
			$total_count6 = $this -> total_feedback_count_cse($feedback6, $fromdate, $todate,$role,$process_name,$user_id);
			$nextAction11 = 'Lost';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id);
			$nextAction12 = 'Home Visit';
			$total_count12 = $this -> total_nextAction_count_cse($nextAction12, $fromdate, $todate,$role,$process_name,$user_id);
			$nextAction13 = 'Showroom Visit';
			$total_count13 = $this -> total_nextAction_count_cse($nextAction13, $fromdate, $todate,$role,$process_name,$user_id);
			$select_leads = array($nextAction11 => $total_count11[0] -> total_count, $nextAction12 => $total_count12[0] -> total_count, $nextAction13 => $total_count13[0] -> total_count, $feedback2 => $total_count2[0] -> total_count, $feedback3 => $total_count3[0] -> total_count, $feedback4 => $total_count4[0] -> total_count, $feedback5 => $total_count5[0] -> total_count, $feedback6 => $total_count6[0] -> total_count, $feedback7 => $total_count7[0] -> total_count);
		
	
			
		}
	else
		{
				$feedback2 = 'Interested';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback3 = 'Busy';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id);
			$feedback4 = 'Lost to Co-Dealer';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id);
			
			$nextAction11 = 'Follow-up';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id);
			$select_leads = array($nextAction11 => $total_count11[0] -> total_count,  $feedback2 => $total_count2[0] -> total_count, $feedback3 => $total_count3[0] -> total_count, $feedback4 => $total_count4[0] -> total_count);
	
				}
		return $select_leads;
	}

	public function total_feedback_count_cse($feedback_stauts, $fromdate, $todate,$role,$process_name,$user_id) {
		
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_count,ln.feedbackStatus');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $this->process_name);
		
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		if($role == '5')
		{
			$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
			
		}
		elseif($role == '4')
		{
			$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('assign_by_cse_tl',  $this->user_id);
		
			
		}
		$this -> db -> where('ln.feedbackStatus', $feedback_stauts);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		$query1 = $query -> result();
	
		return $query1;

	}

	public function total_nextAction_count_cse($nextAction, $fromdate, $todate,$role,$process_name,$user_id) {
		
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_count,ln.nextAction');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $this->process_name);
		
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		if($role == '5')
		{
			$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
			
		}
		elseif($role == '4')
		{
			$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('assign_by_cse_tl',  $this->user_id);
		
			
		}
		$this -> db -> where('ln.nextAction', $nextAction);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		$query1 = $query -> result();
	
		return $query1;
	}

	/*public function total_feedback_count_dse($dse_tl_id, $feedback_stauts, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.feedbackStatus');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('lm.feedbackStatus', $feedback_stauts);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}

	public function total_nextAction_count_dse($dse_tl_id, $nextAction, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.nextAction');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('lm.nextAction', $nextAction);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		return $query -> result();

	}*/

}
?>

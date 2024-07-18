<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ebook_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $location;
	function __construct() {
		parent::__construct();
		//Session Values
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
		//Select Table
		

	}




public function select_ebook_all_count(){
		
		
		$payment_fromdate=$this->input->post('payment_fromdate');
		$payment_todate=$this->input->post('payment_todate');
		$payment_status=$this->input->post('payment_status');
		ini_set('memory_limit', '-1');

	
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select('distinct(customer_id)');

		$this -> db -> from('tbl_payment_customer_all l');
	
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}
	
	
	
		
		$query = $this -> db -> get();
		
	
		return $query -> result();

		
	}
		public function select_ebook_all_lead() {

		$payment_fromdate=$this->input->post('payment_fromdate');
		$payment_todate=$this->input->post('payment_todate');
		$payment_status=$this->input->post('payment_status');
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select(' m.model_name,v.variant_name, l.customer_name as name,l.customer_email_id as email,l.customer_mobile_no as contact_no,l.created_date,l.edbms_id,l.customer_id,
			l.customer_reg_no,l.showroom_location,l.amount,r.color_name,l.razorpay_payment_id,l.payment_status,l.status,l.razorpay_order_id,l.created_time
			');

		$this -> db -> from('tbl_payment_customer_all l');
	$this -> db -> join('make_models m','m.model_id=l.customer_model','left');
		$this -> db -> join('model_variant v','v.variant_id=l.customer_variant','left');
	$this -> db -> join('tbl_color r','r.color_id=l.model_color','left');
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
	
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}
	
	
		$this -> db -> group_by('l.customer_id');
		$this -> db -> order_by('l.customer_id', 'desc');
		if($payment_todate ==''){
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		}
		$query = $this -> db -> get();
		if($_SESSION['user_id']==538){
			//echo $this->db->last_query();
		}
	
		return $query -> result();

	}
	public function select_payment_all_lead() {

		 $payment_fromdate=$this->input->get('payment_fromdate');
		 $payment_todate=$this->input->get('payment_todate');
		$payment_status=$this->input->get('payment_status');
		ini_set('memory_limit', '-1');

		
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select(' m.model_name,v.variant_name, l.customer_name as name,l.customer_email_id as email,l.customer_mobile_no as contact_no,l.created_date,l.edbms_id,l.customer_id,
			l.customer_reg_no,l.showroom_location,l.amount,r.color_name,l.razorpay_payment_id,l.payment_status,l.status,l.razorpay_order_id
			');

		$this -> db -> from('tbl_payment_customer_all l');
	$this -> db -> join('make_models m','m.model_id=l.customer_model','left');
		$this -> db -> join('model_variant v','v.variant_id=l.customer_variant','left');
	$this -> db -> join('tbl_color r','r.color_id=l.model_color','left');
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
	
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}
	
	
		$this -> db -> group_by('l.customer_id');
		$this -> db -> order_by('l.customer_id', 'desc');
		$this -> db -> limit('100');

		$query = $this -> db -> get();
		if($_SESSION['user_id']==538){
			//echo $this->db->last_query();
		}
	//echo $this->db->last_query();
		return $query -> result();

	}
}
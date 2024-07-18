<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_payment_booking_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_booking($name, $email, $mobile_no, $model_id,$amount, $merchant_txn, $message) {
		// echo $name;
		// echo $email;			
		// exit;

		$this->today=date('Y-m-d');
    	$this->time  = date("h:i:s A");
		// $name=$this->input->post('firstname');
		// $mobile_no=$this->input->post('phone');
		// $email=$this->input->post('email');
		// $model_id=$this->input->post('model_id');
		// $amount=$this->input->post('amount');
		$this->db->query("INSERT INTO `tbl_booking_payment`(`customer_name`,`customer_mobile_no`, `customer_email_id`, `customer_model`, `created_date`,`amount`,`created_time`,`txnid`,`message`) 
		VALUES ('$name','$mobile_no','$email','$model_id','$this->today','$amount','$this->time','$merchant_txn','$message')");
		
		echo $customer_order_id=$this->db->insert_id();

		return $customer_order_id;

	}






	function make_models() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}


public function contact_detail() {

		$this -> db -> select('*');
		$this -> db -> from('tbl_contact_details');
		$this -> db -> where('status', '1');
		$this -> db -> limit(5);
		$query = $this -> db -> get();
		return $query -> result();
	}
	

}

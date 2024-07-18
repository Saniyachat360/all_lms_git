<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class remove_duplicate_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	public function select_lead($id) {

		$this -> db -> select('contact_no');
		$this -> db -> from('lead_master');
		$this -> db -> where('enq_id', $id);
		$query = $this -> db -> get();
		foreach ($query->result() as $fetch) {
			$contact_no = $fetch -> contact_no;

		}
		$this -> db -> select('count(contact_no)as count');
		$this -> db -> from('lead_master');
		$this -> db -> where('contact_no', $contact_no);
		$query1 = $this -> db -> get();
		foreach ($query1->result() as $fetch1) {
			$count = $fetch1 -> count;
		}

		if ($count > 1) {

			$query2 = $this -> db -> query("INSERT INTO lead_master1(enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time)
						SELECT enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time
	FROM lead_master WHERE enq_id = '$id'");

			$del = $this -> db -> query("delete from lead_master where enq_id='$id'") or die(mysql_error());

			echo "<script>alert('Record Successfully Deleted');</script>";
		} else {
			echo "<script>alert('No Duplicate records found');</script>";

		}

	}

}
?>
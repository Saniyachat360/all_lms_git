<?php
$con = mysql_connect("localhost", "autovwsn_test", "autovista1@3$") or die(mysql_error());
if ($con) {
	$db = mysql_select_db("autovwsn_vistacars", $con);
	echo "db connect";
} else {
	echo "could not connect to the Database";
}

//$query2 = mysql_query("INSERT INTO lead_master_lc(enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time)
//						SELECT enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time
	//FROM lead_master WHERE status='4' or status='5'");

	$query=mysql_query("select enq_id from lead_master where status='4' or status='5'") or die(mysql_error());
	echo ("select enq_id from lead_master where status='4' or status='5'");
	while ($fetch=mysql_fetch_array($query)) {
		echo $enq_id=$fetch['enq_id'];
		$query2 = mysql_query("INSERT INTO lead_followup_lc(`id`, `leadid`, `activity`, `comment`, `nextfollowupdae`, `nextfollowuptime`, `assignto`, `contactibility`, `assign_to`, `followupby`, `str_to_time_next_followup_date`, `disposition`, `lost_to_codealer`, `lost_to_other_brand`, `followup_reason`, `transfer_reason`, `date`, `created_date`, `str_to_time_created_date`, `created_time`)
						SELECT `id`, `leadid`, `activity`, `comment`, `nextfollowupdae`, `nextfollowuptime`, `assignto`, `contactibility`, `assign_to`, `followupby`, `str_to_time_next_followup_date`, `disposition`, `lost_to_codealer`, `lost_to_other_brand`, `followup_reason`, `transfer_reason`, `date`, `created_date`, `str_to_time_created_date`, `created_time`
	FROM lead_followup WHERE leadid='$enq_id'");
	//echo ("INSERT INTO lead_followup_lc(`id`, `leadid`, `activity`, `comment`, `nextfollowupdae`, `nextfollowuptime`, `assignto`, `contactibility`, `assign_to`, `followupby`, `str_to_time_next_followup_date`, `disposition`, `lost_to_codealer`, `lost_to_other_brand`, `followup_reason`, `transfer_reason`, `date`, `created_date`, `str_to_time_created_date`, `created_time`)
	//					SELECT `id`, `leadid`, `activity`, `comment`, `nextfollowupdae`, `nextfollowuptime`, `assignto`, `contactibility`, `assign_to`, `followupby`, `str_to_time_next_followup_date`, `disposition`, `lost_to_codealer`, `lost_to_other_brand`, `followup_reason`, `transfer_reason`, `date`, `created_date`, `str_to_time_created_date`, `created_time`)
	//FROM lead_followup WHERE leadid='$enq_id'");
	}
?>
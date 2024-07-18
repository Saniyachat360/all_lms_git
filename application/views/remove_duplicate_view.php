<?php

include 'dbconnect.php';
 $id = $_GET['id'];

$query = mysql_query("select contact_no from lead_master where enq_id='$id' ") or die(mysql_error());

$fetch=mysql_fetch_array($query);
						
$contact_no = $fetch['contact_no'];

echo $location=$_GET['loc'];

$query1 = mysql_query("select count(contact_no) as count from lead_master where contact_no='$contact_no' ") or die(mysql_error());

$fetch1=mysql_fetch_array($query1);
$fetch1['count'];
$count=$fetch1['count'];

if($count > 1)
{ 

	$fetch=mysql_fetch_array($query2);

	$query2=mysql_query("INSERT INTO lead_master1(enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time)
						SELECT enq_id,facebook,lead_source,manual_lead,fb_id,form_id,name,address,email,contact_no,lead_id,enquiry_for,enquiry_source,page_path,assigned_to,assigned_on,updated_on,status,followup_reason,model_id,reg_no,fuel_type,loan_amnt,booking_amount,make_id,manf_year,refname,variant_id,add_date,evaluation_sheet_sr_no,stock_location,buy_status,engine_no,chasis_no,reg_date,current_milage,ownership,km,quoted_price,difference_price,insurance_company,insurance_type,car_loan,exchange,old_make,old_model,color,accidental_claim,insurance_no,insurance_date,new_car_customer_name,new_car_customer_mobile_no,source_of_sale,stock_status,sales_dsename,other_variant,service_date,comment,message,test_drive_date,assignto,location,package_type,package_price,pick_up_date,followupby,assignby,assign_to_telecaller,created_date,str_to_time_created_date,created_time
	FROM lead_master WHERE enq_id = '$id'");
	
$del=mysql_query("delete from lead_master where enq_id='$id'") or die(mysql_error());


}
else
{
	 echo "<script>alert('No Duplicate records found');</script>";

	
}
if($location=='')
{
	header('location:telecaller_lms.php');
	}
else
{
header('location:'.$location.'.php');
}				
				
?>
                    
   

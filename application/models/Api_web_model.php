<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_web_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	    date_default_timezone_set('Asia/Calcutta');
		$this->date = date("Y-m-d");
		$this->time = date("h:i:s A");
		$this->time1=date("H:i:s");
		$this->location = $this->session->userdata('location_web');
	}
    public function select_table($process_id)
	{
		// Get Status
	$status_query=$this->db->query("select nextActionName from tbl_add_default_close_lead_status where process_id='$process_id'")->result();
		if(count($status_query)>0)
		{
			$default_close_lead_status=$status_query[0]->nextActionName;
			//echo $default_close_lead_status;
			$default_close_lead_status=json_decode($default_close_lead_status);
		
		}		
		
		if ($process_id == 6 || $process_id == 7) {
			
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
					`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.esc_level1_resolved ,l.esc_level2_resolved,l.esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark,l.alternate_contact_no
			,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,
			l.buy_make,l.buy_model,
			nm.model_name as new_model_name,nv.variant_name as new_variant_name,
			om1.make_name as old_make_name,	om2.model_name as old_model_name,
			bm1.make_name as buy_make_name,	bm2.model_name as buy_model_name,l.accidental_claim,budget_from,budget_to,evaluation_within_days,
			';
			$lead_master= 'lead_master';
			$lead_followup = 'lead_followup';
			$request_to_lead_transfer= 'request_to_lead_transfer';
			$tbl_manager_remark= 'tbl_manager_remark';
		} 
		elseif ($process_id == 8) {
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement='`tloc`.`location` as `showroom_location`, l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.assign_to_e_exe_date as assign_to_dse_date,l.assign_to_e_exe_time as assign_to_dse_time,l.assign_to_e_tl_date as assign_to_dse_tl_date,l.assign_to_e_tl_time as assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
					`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.alternate_contact_no,l.reg_no,l.quotated_price,l.expected_price
			,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,
			l.buy_make,l.buy_model,
			nm.model_name as new_model_name,nv.variant_name as new_variant_name,
			om1.make_name as old_make_name,	om2.model_name as old_model_name,om3.variant_name as old_variant_name,
			bm1.make_name as buy_make_name,	bm2.model_name as buy_model_name,budget_from,budget_to,evaluation_within_days,
			l.fuel_type,l.reg_no,l.reg_year,l.manf_year,l.color,l.ownership,l.km,l.type_of_vehicle,l.outright,l.old_car_owner_name,l.photo_uploaded,l.hp,l.financier_name,l.accidental_claim,l.accidental_details,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.tyre_conditon,l.engine_work,l.body_work,l.vechicle_sale_category,l.refurbish_cost_bodyshop,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.total_rf,l.price_with_rf_and_commission,l.expected_price,l.selling_price,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,l.agent_name,l.agent_commision_payable,l.expected_date_of_sale,l.refurbish_cost_battery';
			$lead_master = 'lead_master_evaluation';
			$lead_followup = 'lead_followup_evaluation';
			$request_to_lead_transfer = 'request_to_lead_transfer_evaluation';		
			$tbl_manager_remark= 'tbl_manager_remark_evaluation';
		}
		else {
			
			$lead_master_table = 'lead_master_all';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
			$selectElement='csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name,l.alternate_contact_no';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.service_center,l.service_type,l.pickup_required,l.pick_up_date,';
			$lead_master= 'lead_master_all';
			$lead_followup = 'lead_followup_all';
			$request_to_lead_transfer= 'request_to_lead_transfer_all';
			$tbl_manager_remark= 'tbl_manager_remark_all';
		}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table,'tbl_manager_remark'=>$tbl_manager_remark,'select_element'=>$selectElement,'select_element1'=>$selectElement1,'lead_master'=>$lead_master,'lead_followup'=>$lead_followup,'request_to_lead_transfer'=>$request_to_lead_transfer,'default_close_lead_status'=>$default_close_lead_status) ;
		
	}
	public function insert_lead() {
	    $name = $this -> input -> post('name');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phone');
		$enq = $this -> input -> post('enq');
		$path = $this -> input -> post('page_path');
		$model_id = $this -> input -> post('model_id');
		$location = $this -> input -> post('location');
		
        	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		$enq_id=0;

		$msg = '';
		$this -> db -> select("*");
		$this -> db -> from("lead_master");
		$this -> db -> where("contact_no", $phone);
		$this -> db -> where('nextAction !=', 'Close');
		$this -> db -> where("process", 'New Car');
		
		$query1 = $this -> db -> get() -> result();

		if (count($query1) < 1) {

			$this -> db -> query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,customer_location,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '")');
			$enq_id=$this->db->insert_id();
		} else {
			$this -> db -> query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,customer_location,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
		
		}
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = '1';
				$response["enq_id"] = $enq_id;
				// echoing JSON response
			
			} else {
				
				$response["success"] = '0';
				$response["enq_id"] = $enq_id;

			}
				echo json_encode($response);

	}
	

	// Sell your car second function for api
	public function sell_your_car()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$comment = $this->input->post('comment');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$old_make = $this->input->post('make_id');
		$old_model = $this->input->post('model_id');
		$reg_no = $this->input->post('reg_no');
		$location = $this->input->post('location');
		$otp = $this->input->post('otp');

		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		//$this -> db -> where("process", 'POC Purchase');
		$this->db->where('nextAction !=', 'Close');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {

			$this->db->query('insert into lead_master(process,name,email,contact_no,reg_no,old_make ,old_model,enquiry_for,page_path,customer_location,created_date,created_time,ip_address,comment)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $reg_no . '","' . $old_make . '","' . $old_model  . '","' . $enq . '","' . $path  . '","' . $this->location . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '","' . $comment . '")');
			$msg = "success";
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,customer_location,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path  . '","' . $this->location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		//	echo $this->db->last_query();
		return $msg;
	}
	// End Sell your car
	
	
	public function auto_assign_lead($enq_id,$process_id,$lead_source_id)
	{
	    
	    	if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
		//	$table_name1 = 'lead_followup';
		
		}
		elseif ($process_id == 8) {
			$table_name = 'lead_master_evaluation';
		//	$table_name1 = 'lead_followup_evaluation';
		
	
	
		} else {
			$table_name = 'lead_master_all';
		//	$table_name1 = 'lead_followup_all';
		}
	
		    $q1=$this->db->query("select * from tbl_assign_lead_count where process_id='$process_id'")->result();
		    if(count($q1)>0)
		    {
		        echo $count_number=$q1[0]->count_number;
		        echo $from_time=$q1[0]->from_time;
		        echo $to_time=$q1[0]->to_time;
		        echo $this->time1;
		        if($this->time1 > $from_time && $this->time1 < $to_time)
		        {
		            echo "assign";
		            $q=$this->db->query("select * from ".$table_name." where enq_id='$enq_id'")->result();
            		if(count($q)>0)
            		{
            		    echo "lead";
            		    $q2=$this->db->query("select * from tbl_assign_lead_to_user where process_id='$process_id' and date='$this->date'")->result();
                		if(count($q2)>0)
                		{
                		    //echo "lead";
                		}else
                		{
                		    $this->db->query("update tbl_assign_lead_to_user set count=0,date='$this->date' where process_id='$process_id' ");
                		}
                		$q3=$this->db->query("select u.* from tbl_assign_lead_to_user u 
                		join tbl_login_history h on h.user_id=u.user_id where process_id='$process_id' and u.date='$this->date' and h.login_date='$this->date' 
                		and lead_source_id='$lead_source_id' and count < '$count_number' ORDER BY count asc")->result();
                echo	$this->db->last_query();
                		print_r($q3);
                		if(count($q3)>0)
                		{
                		    echo "check leads";
                		    $q4=$this->db->query("select * from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
                		    if(count($q4)>0)
                		    {
                		        $assign_by=$q4[0]->call_center_tl_id;
                		    }
                		    else
                		    {
                		        $assign_by='1';
                		    }
                		    foreach($q3 as $row)
                		    {
                		        echo $user_id= $row->user_id;
                		        $id=$row->id;
                		        $count_n=$row->count +1 ;
                		        $this->db->query ("update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'");
                		        echo "update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'";
			
                		        $this->db->query("update tbl_assign_lead_to_user set count='$count_n' where user_id='$user_id' and process_id='$process_id'");
                		        $this->db->query("INSERT INTO `tbl_assign_lead_to_user_history`(`user_id`, `lead_source_id`, `process_id`, `date`, `count`,created_time,enq_id) 
                		        VALUES ('$user_id','$lead_source_id','$process_id','$this->date','1','$this->time','$enq_id')");
                		        break;
                		    }
                		    
                		}
            		}
		        }
		        else
		        {
		            echo "dont";
		        }
		    }
		
	}
	public function auto_assign_cron($process_id,$process_name)
	{
	    	if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
		//	$table_name1 = 'lead_followup';
		
		}
		elseif ($process_id == 8) {
			$table_name = 'lead_master_evaluation';
		//	$table_name1 = 'lead_followup_evaluation';
		
	
	
		} else {
			$table_name = 'lead_master_all';
		//	$table_name1 = 'lead_followup_all';
		}
	
		    $q1=$this->db->query("select * from tbl_assign_lead_count where process_id='$process_id'")->result();
		    if(count($q1)>0)
		    {
		        echo $count_number=$q1[0]->count_number;
		       /* echo $from_time=$q1[0]->from_time;
		        echo $to_time=$q1[0]->to_time;
		        echo $this->time1;
		        if($this->time1 > $from_time && $this->time1 < $to_time)
		        {*/
		            echo "assign";
		             $q2=$this->db->query("select * from tbl_assign_lead_to_user where process_id='$process_id' and date='$this->date'")->result();
                		if(count($q2)>0)
                		{
                		    //echo "lead";
                		}else
                		{
                		    $this->db->query("update tbl_assign_lead_to_user set count=0,date='$this->date' where process_id='$process_id' ");
                		}
                		$q4=$this->db->query("select * from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
                		    if(count($q4)>0)
                		    {
                		        $assign_by=$q4[0]->call_center_tl_id;
                		    }
                		    else
                		    {
                		        $assign_by='1';
                		    }
		            $q=$this->db->query("select lead_source,enq_id from ".$table_name." where assign_by_cse_tl='0' and process='$process_name' order by enq_id asc limit 10")->result();
            		foreach($q as $row)
            		{
            		    
            		  //  echo "lead";
            		     $lead_source=$row->lead_source;
            		     $enq_id=$row->enq_id;
            		     if($lead_source=='')
            		     {
            		         $lead_source='Web';
            		     }
                		$q3=$this->db->query("select u.* from tbl_assign_lead_to_user u 
                		join tbl_login_history h on h.user_id=u.user_id
                		join lead_source l on l.id=u.lead_source_id
                		where u.process_id='$process_id' and u.date='$this->date' and h.login_date='$this->date' 
                		and lead_source_name='$lead_source' and count < '$count_number' ORDER BY count asc limit 1")->result();
                echo	$this->db->last_query();
                //		print_r($q3);
                		if(count($q3)>0)
                		{
                		    echo "check leads";
                		    
                		    foreach($q3 as $row)
                		    {
                		        echo $user_id= $row->user_id;
                		        $id=$row->id;
                		        $count_n=$row->count +1 ;
                		        $this->db->query ("update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'");
                		        echo "update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'";
			
                		        $this->db->query("update tbl_assign_lead_to_user set count='$count_n' where user_id='$user_id' and process_id='$process_id'");
                		       /* $this->db->query("INSERT INTO `tbl_assign_lead_to_user_history`(`user_id`, `lead_source_id`, `process_id`, `date`, `count`,created_time,enq_id) 
                		        VALUES ('$user_id','$lead_source_id','$process_id','$this->date','1','$this->time','$enq_id')");*/
                		        break;
                		    }
                		    
                		}
            		}
		        /*}
		        else
		        {
		            echo "dont";
		        }*/
		    }
		
	}
	public function check_auto_assign_require($process_id)
	{
	      $q1=$this->db->query("select * from tbl_assign_lead_count where process_id='$process_id'")->result();
		    if(count($q1)>0)
		    {
                $q2=$this->db->query("select * from tbl_assign_lead_to_user where process_id='$process_id' and date='$this->date'")->result();
        		if(count($q2)>0)
        		{
        		   
        		}else
        		{
        		    $this->db->query("update tbl_assign_lead_to_user set count=0,date='$this->date' where process_id='$process_id' ");
        		}
        		$q4=$this->db->query("select * from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
    		    if(count($q4)>0)
    		    {
    		        $assign_by=$q4[0]->call_center_tl_id;
    		    }
    		    else
    		    {
    		        $assign_by='1';
    		    }
    		   
    		    $response["assign_lead"] = $q1;
				$response["assign_by"] = $assign_by;
				echo json_encode($response);
				return $response;
		    }
	}
	/*public function auto_assign_facebook_campaign($process_id,$process_name)
	{
	    $table=$this->select_table($process_id);
	    $auto_assign_req=$this->check_auto_assign_require($process_id);
	     $a=json_decode($auto_assign_req);
        $assign_lead= $a->assign_lead;
	   
	   print_r($auto_assign);
	    //$table['lead_master'].
	}*/
		public function auto_assign_facebook_campaign($process_id,$process_name)
	{
	    /*$table=$this->select_table($process_id);
	    $auto_assign_req=$this->check_auto_assign_require($process_id);
	     $a=json_decode($auto_assign_req);
        $assign_lead= $a->assign_lead;
	   
	   print_r($auto_assign);
	    //$table['lead_master'].
	}
		public function insert_facebook_campaign_lead() {*/
		    $table=$this->select_table($process_id);
	    $name = $this -> input -> post('fullname');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phonenumber');
		$enq = $this -> input -> post('adname');
		$path = $this -> input -> post('page_path');
		$city = $this -> input -> post('city');
		$location = $this -> input -> post('customer_location');
		
		 $lead_source_id='0';
			$lead_source = $this -> input -> post('lead_source');
			if($lead_source=='')
			{
			  $lead_source='Facebook';  
			}
        $string1 = str_replace(' ', '', $phone);
         $contact_no = str_replace('+', '', $string1);
        $result = mb_substr($contact_no, 0, 2);
        if ($result == '91') {
        	 $str2 = substr($contact_no, 2);
        } else {
        	$str2 = $contact_no;
        }
		$this -> db -> select("*");
		$this -> db -> from($table['lead_master']);
		$this -> db -> where("contact_no", $str2);
		$this -> db -> where('nextAction !=', 'Close');
		$this -> db -> where("process", $process_name);
		
		$query1 = $this -> db -> get() -> result();
       
		if (count($query1) < 1) {
           echo  $lead_master=$table['lead_master'];
             $query_ls=$this->db->query("select *  from lead_source where lead_source_name='$lead_source' and process_id='$process_id'")->result();
             echo "select *  from lead_source where lead_source_name='$lead_source' and process_id='$process_id'";
             if(count($query_ls)>0)
             { echo "hi";
                 $lead_source_id=$query_ls[0]->id;
             }
			$this -> db -> query("insert into ".$lead_master."(process,lead_source,name,email,contact_no,enquiry_for,page_path,customer_location,created_date,created_time,address)values
			('$process_name','$lead_source','$name','$email','$str2','$enq','$path','$location',
			'$this->date','$this->time','$city')");
		echo	$enq_id=$this->db->insert_id();
		$this->auto_assign_lead($enq_id,$process_id,$lead_source_id);
		} else {
			$this -> db -> query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,customer_location,created_date,created_time)values
			("'.$process_name.'","' . $name . '","' . $email . '","' . $str2 . '","' . $enq . '","' . $path . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
		
		}
		
		
	/*	if ($this -> db -> affected_rows() > 0) {
		    
			} */

	}
	
	//saniya code for api website
	//  Quotation api code
	public function download_quotation()
	{
	    $name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$model_id = $this->input->post('model_id');
		
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {

			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '")');
			$msg = "success";
			
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		return $msg;
	}
	// End  Quotation api code
	
	
	// Brochure api code
	public function download_broucher()
	{
	    $name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$model_id = $this->input->post('model_id');
		
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {

			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '")');
			$msg = "success";
			
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		return $msg;
	}
	// End Brochure api code
	
	
	// Get in touch api code
	public function get_in_touch()
	{
	    $name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$model_id = $this->input->post('model_id');
		
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {

			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '")');
			$msg = "success";
			
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		return $msg;
	}
	// End Get in touch api code
	
	
	// Sell your car api code
	public function sell_your_car_api()
	{
	    $name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$model_id = $this->input->post('model_id');
		$comment = $this->input->post('comment');
		
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {

			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,created_date,created_time,ip_address,comment)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '","' . $comment . '")');
			$msg = "success";
			
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		return $msg;
	}
	// End Sell your car api code
	
	
	// carniwal invicto banner code
	public function carniwal_data()
	{
	    $name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$lead_source = $this->input->post('lead_source');
		$customer_location = $this->input->post('customer_location');
		$created_date = date("Y-m-d");
		$created_time = date("h:i:sa");
		
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

	    if (count($query1) < 1) {
			$this -> db -> query('insert into lead_master(process,name,email,contact_no,lead_source,customer_location,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $lead_source . '","' . $customer_location  . '","' . $created_date . '","' . $created_time. '","' . $ip_address . '")');
			$msg = "success";
		} else {
			$this -> db -> query('insert into lead_master_repeat(process,name,email,contact_no,lead_source,customer_location,created_date,created_time,ip_address)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $lead_source . '","' . $customer_location  . '","' . $created_date . '","' . $created_time. '","' . $ip_address . '")');
			$msg = "success";
		}	
		return $msg;
	}
	// ENd  carniwal code
	
	//end saniya code for api website
	
	
    // ********* Pratik Code *********
    // Book a test drive
	public function book_a_test_drive()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('contact_no');
		$address = $this->input->post('address');
		$enq = 'Book a Test Drive';
		$path = 'book a test drive page';
		$model_id = $this->input->post('model_id');
		$location = $this->input->post('customer_location');

		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$today = date("Y-m-d");
		$time = date("h:i:s A");

		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {
			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time,ip_address,customer_location)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $address . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '","' . $location . '")');
			$msg = "success";
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,created_date,created_time)values
			("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $address . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		return $msg;
	}
	// End Book a test drive
	
	
	// Book a car service appointment
	public function book_a_car_service()
	{
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$contact = $this->input->post('contact_no');
		$address = $this->input->post('address');
		$service_center = $this->input->post('service_center');
		$model = $this->input->post('model_id');
		$registration_no =  $this->input->post('reg_no');
		$kilometers =  $this->input->post('km');
		$service_type = $this->input->post('service_type');
		$pick_up_date = $this->input->post('pick_up_date');
		$pickup_required = $this->input->post('pickup_required');

		
		$enq = 'Car Service';
		$data = array(
			'process' => 'Service', 'name' => $name, 'email' => $email, 'contact_no' => $contact, 'address' => $address,
			'service_center' => $service_center, 'model_id' => $model, 'reg_no' => $registration_no, 'km' => $kilometers,
			'service_type' => $service_type, 'pick_up_date' => $pick_up_date, 'pickup_required' => $pickup_required,
			'lead_source' => '', 'enquiry_for' => $enq, 'page_path' => 'Car service-Book appointment',
			'created_date' => $this->date,	'created_time' => $this->time, 'ip_address' => $ip_address
		);

		$this->db->select("enq_id");
		$this->db->from("lead_master_all");
		$this->db->where("contact_no", $contact);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'Service');
		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {
			$this->db->insert('lead_master_all', $data);
			$msg = "success";
			$this->db->last_query();
		} else {
			$this->db->insert('lead_master_repeat', $data);
			$msg = "success";
			$this->db->last_query();
		}
		return $msg;
	}
	// End Book a car service appointment
	
	
	// Loan against car
	public function loan_detail()
	{
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$msg = '';
		$path = "Finance-apply for loan";
		$financername = $this->input->post('financename');
		$mobileno = $this->input->post('mobileno');
		$city = $this->input->post('city');
		$email = $this->input->post('email');
		$comment = $this->input->post('comment');
		$model = $this->input->post('model');
		$purches = $this->input->post('purches');
		$loanamount = $this->input->post('loanamount');
		$duration = $this->input->post('duration');
		//$loanamount = $this -> input -> post('loanamount');
		$enq = $this->input->post('enq');

		$this->db->select("*");
		$this->db->from("lead_master_all");
		//$this -> db -> where("name", $name);
		$this->db->where("contact_no", $mobileno);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'Finance');

		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {
			$this->db->query('insert into lead_master_all(process,name,email,contact_no,enquiry_for,page_path,model_id,address,loanamount,created_date,created_time,comment,loanDuration,loanPurchaseTime,ip_address)values
			("Finance","' . $financername . '","' . $email . '","' . $mobileno . '","' . $enq . '","' . $path . '","' . $model . '","' . $city . '","' . $loanamount . '","' . $this->date . '","' . $this->time . '","' . $comment . '","' . $duration . '","' . $purches . '","' . $ip_address . '")');
			$msg = 'success';
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,address,loanamount,created_date,comment,loanDuration,loanPurchaseTime)values
			("Finance","' . $financername . '","' . $email . '","' . $mobileno . '","' . $enq . '","' . $path . '","' . $model . '","' . $city . '","' . $loanamount . '","' . $this->date . '","' . $comment . '","' . $duration . '","' . $purches . '")');
			$msg = 'success';
		}
		return $msg;
	}
	// End Loan against car
	
	
	// Maruti Suzuki 
    public function contact_data()
	{
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$enq = $this->input->post('enq');
		$path = $this->input->post('page_path');
		$model_id = $this->input->post('model_id');
// 		$location = $this->input->post('location');
		$otp = $this->input->post('otp');
		$msg = '';
		$this->db->select("*");
		$this->db->from("lead_master");
		$this->db->where("contact_no", $phone);
		$this->db->where('nextAction !=', 'Close');
		$this->db->where("process", 'New Car');

		$query1 = $this->db->get()->result();

		if (count($query1) < 1) {
			$this->db->query('insert into lead_master(process,name,email,contact_no,enquiry_for,page_path,model_id,customer_location,created_date,created_time,ip_address)values
		("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->location . '","' . $this->date . '","' . $this->time . '","' . $ip_address . '")');
			$msg = "success";
		} else {
			$this->db->query('insert into lead_master_repeat(process,name,email,contact_no,enquiry_for,page_path,model_id,customer_location,created_date,created_time)values
		("New Car","' . $name . '","' . $email . '","' . $phone . '","' . $enq . '","' . $path . '","' . $model_id . '","' . $this->location . '","' . $this->date . '","' . $this->time . '")');
			$msg = "success";
		}
		//	echo $this->db->last_query();
		return $msg;
	}
    // End Maruti Suzuki
    
    
    
    	// service complaint 
	public function service_complaint()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('contact_no');
		$message = $this->input->post('comment');
		$service_center = $this->input->post('service_center');
		$reg_no = $this->input->post('reg_no');
		$model = $this->input->post('model_id');
		$business = $this->input->post('business_area');
		$address = $this->input->post('address');
		$today = $this->input->post('created_date');
		$time = $this->input->post('created_time');
		$job_card_date = $this->input->post('job_card_date');
		$enq = "Web(Car Service Complaint)";

		$msg = '';

		$this->db->query('insert into lead_master_complaint(name,email,contact_no,reg_no,service_center ,model_id,enquiry_for,address,business_area,created_date,created_time,job_card_date,comment)values
			("' . $name . '","' . $email . '","' . $phone . '","' . $reg_no . '","' . $service_center . '","' . $model  . '","' . $enq . '","' . $address . '","' . $business . '","' . $today . '","' . $time . '","' . $job_card_date . '","' . $message . '")');
		$msg = "success";

		//	echo $this->db->last_query();
		return $msg;
	}

	// end service complaint
	
	
	
	// This is a code for Insurance Enq Comming from marutiinsurance website

	// insurance_enq
	public function insurance_enq()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$reg_no = $this->input->post('reg_no');
		$location = $this->input->post('location');
		$today = $this->input->post('created_date');
		$time = $this->input->post('created_time');
		$enq = "Web(Maruti-Insurance)";
		$process="Insurance";

		$msg = '';

		$this->db->query('insert into lead_master_insurance(process,name,email,contact_no,reg_no,customer_location,enquiry_for,created_date,created_time)values
			("' . $process . '","' . $name . '","' . $email . '","' . $phone . '","' . $reg_no . '","' . $location . '","' . $enq . '","' . $today . '","' . $time . '")');
		$msg = "success";

		//	echo $this->db->last_query();
		return $msg;
	}

	// end insurance_enq
	
    //*********** End Pratik Code *********** 	
	
}
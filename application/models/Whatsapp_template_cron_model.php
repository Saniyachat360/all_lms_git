<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whatsapp_template_cron_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			
		date_default_timezone_set('Asia/Kolkata');
		$this->today=date('Y-m-d');
		$this->time=date('h:i:s A');
		$this->user_id=$this->session->userdata('user_id');
	$this -> process_id = $_SESSION['process_id'];
		$this -> process_name = $_SESSION['process_name'];
			
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup';
			$this->selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`,l.quotated_price,l.expected_price,l.edms_booking_id,
				csef.appointment_type as cappointment_type,csef.appointment_date as cappointment_date,csef.appointment_time as cappointment_time,csef.appointment_status as cappointment_status,
				dsef.appointment_type as dappointment_type,dsef.appointment_date as dappointment_date,dsef.appointment_time as dappointment_time,dsef.appointment_status as dappointment_status
				';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation';
			//$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			$this->selectElement='`tloc`.`location` as `showroom_location`,l.assign_to_e_tl as assign_to_dse_tl, `l`.`assign_to_e_exe` as assign_to_dse,l.assign_to_e_exe_date as assign_to_dse_date,l.assign_to_e_exe_time as assign_to_dse_time,l.assign_to_e_tl_date as assign_to_dse_tl_date,l.assign_to_e_tl_time as assign_to_dse_tl_time,`l`.`exe_followup_id` as `dse_followup_id`,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`,l.quotated_price,l.expected_price
				,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status
				
				';
	
	
		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all';
		$this->selectElement='`tloc`.`location` as `showroom_location`, csef.file_login_date,csef.pick_up_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name
		,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,l.pickup_required,l.service_type';

		}
		
	}
	
	 public function sms_type() 
	 {	
	 	
		$this -> db -> select('*');
		$this -> db -> from('tbl_sms_type');	
		$this -> db -> where('stype_status',1);
			$this -> db -> where('process_id',$this->process_id);
			$this -> db -> where('whatsapp',1);
		$query = $this -> db -> get();		
		return $query -> result();
	 }
	
   public function select_fields() 
	 {	
	 	
		$this -> db -> select('*');
		$this -> db -> from('tbl_mail_dynamic_fields');	
		$this -> db -> where('status',1);
			$this -> db -> where('process_id',$this->process_id);
		$query = $this -> db -> get();		
		return $query -> result();
	 }
 public function holiday() 
	 {	
	 	
		$this -> db -> select('*');
		$this -> db -> from('tbl_holiday');	
		$this -> db -> where('status',1);
		$query = $this -> db -> get();		
		return $query -> result();
	 }
	 public function select_templates() 
	 {	
			

		$this -> db -> select('	GROUP_CONCAT( DISTINCT  a.attachment_name ) as attachment_list,m.*,m2.s_desc,m2.time,a1.name,a1.date');//m&m1 are the table name

		$this -> db -> from('tbl_mail_template m');
		$this->db->join('tbl_mail_attachment a','a.t_id=m.t_id','left');
		$this->db->join('tbl_sms_type m2','m2.stype_name=m.sms_type');
			$this->db->join('tbl_holiday a1','a1.holiday_id=m.holiday_id','left');
			$this -> db -> where('m.process_id',$this->process_id);
			$this -> db -> where('m2.process_id',$this->process_id);
			$this -> db -> where('whatsapp',1);
				$this -> db -> where('type','Whatsapp');
		$this->db->group_by('t_id');
		 $this -> db -> order_by('t_id ','desc');

		$query = $this -> db -> get();		
	//	echo $this->db->last_query();
		return $query -> result();

	}
		
	
	
	
	 public function insert_mail_template() 
	{
		echo $description=$this->input->post('product_description');

		echo $name=$this->input->post('name');
		$sms_type=$this->input->post('type');
		echo $subject=$this->input->post('subject');
		$holiday_id=$this->input->post('holiday_id');
		if($holiday_id==''){$holiday_id='0';}
			$query=$this->db->query("select * from tbl_mail_template where sms_type='$sms_type' and type='Whatsapp' and holiday_id='$holiday_id' and process_id='$this->process_id'")->result();

		if(count($query)>0)

         {

			 //deactive la active  karne

			$query1=$this ->db->query("select * from tbl_mail_template where sms_type='$sms_type' and type='Whatsapp' and holiday_id='$holiday_id'  AND status='-1' and process_id='$this->process_id' ")->result(); 

			 if(count($query1)>0)

			 {

			 

			 $query=$this->db->query("update tbl_mail_template  set status='1'   where sms_type='$sms_type' and type='Whatsapp' and holiday_id='$holiday_id' AND status='-1' and process_id='$this->process_id'");

			 $t_id=$query1[0]->t_id;

			 }

			 else{

		//	echo 'if'; 

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			 }

			} 

		else {

				//new record insert karne

			$query=$this->db->query("insert into tbl_mail_template (template_name,subject,description,status,created_time,created_date,process_id,sms_type,type,holiday_id)
			values('$name','$subject','$description','1','$this->time','$this->today','$this->process_id','$sms_type','Whatsapp','$holiday_id')");
			$t_id=$this->db->insert_id();

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Inserted  Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
			if(isset($t_id)){
			 $i=0;
	    $dataid=1;
	    	$images=array();
	     $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
			$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($t_id.$_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
   			/*$check = getimagesize($_FILES["product_image"]["tmp_name"][$i][$j]);
    		if($check !== false) {
       				// echo "File is an image - " . $check["mime"] . ".";
        			$uploadOk = 1;
   				 } else {
      					//  echo "File is not an image.";
      				$uploadOk = 0;
    
				}*/
			echo	$_FILES["product_image"]["size"][$i][$j];
			 if (($_FILES["product_image"]["size"][$i][$j] > 5000000)) { 
			     echo "hi";
       
        	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Please Upload File Less Than 5MB Size ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

    }else{
				if (move_uploaded_file($_FILES["product_image"]["tmp_name"][$i][$j], $target_file1)) {
				 echo $a_name=  $t_id.$_FILES["product_image"]["name"][$i][$j];
	                	 $this->db->query("insert into tbl_mail_attachment (t_id,attachment_name,a_status)
			values('$t_id','$a_name','1')");
      			//  echo "The file ". basename( $_FILES["image1"]["name"]). " has been uploaded.";
    			} else {
    			    echo $_FILES["product_image"]["tmp_name"][$i][$j];
    			     array_push($images,$_FILES["product_image"]["tmp_name"][$i][$j]);
        			//echo "Sorry, File Already Exists.";
   						 }
    }
   						 
   					
		
	}
			}
//	print_r($images);

	}
	public function template_edit($ctype_id) 

	{

		$this -> db -> select('m.*, m1.attachment_name,m1.attach_id,m2.s_desc,a1.name,a1.date');//m&m1 are the table name

		$this -> db -> from('tbl_mail_template m');		
    	$this->db->join('tbl_holiday a1','a1.holiday_id=m.holiday_id','left');
		$this->db->join('tbl_mail_attachment m1','m1.t_id=m.t_id','left');//join query use to join make_id from table name makes. 
		$this->db->join('tbl_sms_type m2','m2.stype_name=m.sms_type','left');//join query use to join make_id from table name makes. 

	$this -> db -> where('m2.process_id',$this->process_id);
		$this -> db -> where('m.t_id',$ctype_id); 

		$query = $this -> db -> get();		

		return $query -> result();

	}
	public function update_template() //update_mod function post model_name,model_id & make_id to db

	{

		echo $ctype_id=$this->input->post('ctype_id');
		echo $description=$this->input->post('product_description');

		echo $name=$this->input->post('name');
		echo $subject=$this->input->post('subject');
		$type=$this->input->post('type');
		 $holiday_id=$this->input->post('holiday_id');
		if($holiday_id==''){$holiday_id='0';}

		$query=$this->db->query("select * from tbl_mail_template where  sms_type='$type' and type='Whatsapp' and holiday_id='$holiday_id'  AND t_id !='$ctype_id' and process_id='$this->process_id'")->result();

		if(count($query)>0)

         {

			 

         $this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');



		} else {

					// update  model name & make_id in db 

			$insert=$this->db->query("UPDATE tbl_mail_template set template_name= '$name', subject= '$subject',holiday_id='$holiday_id', sms_type='$type',description='$description' where t_id= '$ctype_id'");
            	 $i=0;
	    $dataid=1;
	    $t_id=$ctype_id;
	    	$images=array();
	     $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
			$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($t_id.$_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
   			/*$check = getimagesize($_FILES["product_image"]["tmp_name"][$i][$j]);
    		if($check !== false) {
       				// echo "File is an image - " . $check["mime"] . ".";
        			$uploadOk = 1;
   				 } else {
      					//  echo "File is not an image.";
      				$uploadOk = 0;
    
				}*/
				if (move_uploaded_file($_FILES["product_image"]["tmp_name"][$i][$j], $target_file1)) {
				 echo $a_name=  $t_id.$_FILES["product_image"]["name"][$i][$j];
	                	 $this->db->query("insert into tbl_mail_attachment (t_id,attachment_name,a_status)
			values('$t_id','$a_name','1')");
      			//  echo "The file ". basename( $_FILES["image1"]["name"]). " has been uploaded.";
    			} else {
    			    echo $_FILES["product_image"]["tmp_name"][$i][$j];
    			     array_push($images,$_FILES["product_image"]["tmp_name"][$i][$j]);
        			//echo "Sorry, File Already Exists.";
   						 }
   						 
   					
		
	}
	

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Update  Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');



		}

	}
		public function template_delete($ctype_id) 
	{
	
	$insert=$this->db->query("UPDATE tbl_mail_template SET status ='-1' where t_id=$ctype_id ");
	$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
	}


	public function template_action($ctype_id)
	{
  
  $insert=$this->db->query("UPDATE tbl_mail_template SET status='1' where t_id='$ctype_id'");
  $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Activated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

   }
   	public function delete_attachment($attach_id)
	{
  
  $insert=$this->db->query("DELETE FROM `tbl_mail_attachment` where attach_id='$attach_id'");
  $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

   }
   	public function select_lead($enq_id) {
		$this -> db -> select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,
		m.model_id as new_model_id,m.model_name as new_model_name,
		m1.model_name as old_model_name,l.process,
		l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.transfer_process	,l.comment,enquiry_for,l.location,l.eagerness,l.days60_booking,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.ownership,l.old_make,l.old_model,l.assign_to_dse_tl,
		f.id as followup_id,f.activity,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.visit_location,f.visit_booked,f.visit_status,f.visit_booked_date,f.sale_status,f.car_delivered,
		f.td_hv_date,f.feedbackStatus,f.nextAction,l.appointment_type,l.appointment_status,l.appointment_date,f.appointment_rating,f.appointment_time,f.appointment_feedback,f.appointment_address,l.customer_occupation,l.customer_designation,l.customer_corporate_name,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,l.evaluation_location,
		esc_level1_resolved ,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark ,esc_level2_resolved_remark ,esc_level3_resolved_remark ');
		$this -> db -> from($this->table_name);
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		if($_SESSION['role']=='3' || $_SESSION['role']=='2' || $_SESSION['role']=='1'){
		$this -> db -> join($this->table_name1.' f', 'f.id=l.cse_followup_id', 'left');
		}
		else{
		$this -> db -> join($this->table_name1.' f', 'f.id=l.dse_followup_id', 'left');
		}
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		$this -> db -> where('l.enq_id', $enq_id);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
		public function mail_history($company_id,$to,$t_id,$cc,$subject,$a)
	{
	    $this->db->query("insert into tbl_mail_history (`enq_id`, `to_mail`, `t_id`, `created_date`, `created_by`,cc_mail,subject,mail_desc,process_id) 
					VALUES ('$company_id','$to','$t_id','$this->today','$this->user_id','$cc','$subject','$a','$this->process_id')");
					if ($this -> db -> affected_rows() > 0) {

					$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Mail Sent Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				} else {
					$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Mail Not Sent Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

				}
	    
	}

	
	}
?>


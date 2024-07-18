<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_chat360_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	}
	public function select_table($process_id)
	{
		
		if ($process_id == 'New Car' || $process_id == 'POC Sales') {
			
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
					`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.esc_level1_resolved ,l.esc_level2_resolved,l.esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark,l.alternate_contact_no';
			
		} 
		
		else {
			
			$lead_master_table = 'lead_master_all';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
			$selectElement='csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name,l.alternate_contact_no';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table,'select_element'=>$selectElement,'select_element1'=>$selectElement1) ;
		
	}
	public function select_model($make_id)
	{
	    $model_type=$this->input->post('model_type');
		if($make_id=='')
		{
			$make_id=1;
		}
		$this -> db -> select('model_id,model_name,model_url,type');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make_id);
		$this->db->where('status','1');
		if($model_type!=''){
		    		$this -> db -> where('type', $model_type);

		}
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_model_count($make_id)
	{
		 $model_type=$this->input->post('model_type');
		
		if($make_id=='')
		{
			$make_id=1;
		}
		$this -> db -> select('count(model_id) as modelcount');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make_id);
		$this->db->where('status','1');
		if($model_type!=''){
		    		$this -> db -> where('type', $model_type);

		}
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	function model_variant($model_id) {
		$this -> db -> select('v.variant_id,v.variant_name');
		$this -> db -> from('model_variant v');
		$this->db->join('make_models m','m.model_id=v.model_id');
		$this -> db -> where('m.model_name', $model_id);
		$this -> db -> where('m.status', '1');
		$this -> db -> where('v.is_active', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}
		function select_variant_count($model_id) {
		$this -> db -> select('count(v.variant_id) as variantcount');
		$this -> db -> from('model_variant v');
		$this->db->join('make_models m','m.model_id=v.model_id');
		$this -> db -> where('m.model_name', $model_id);
		$this -> db -> where('m.status', '1');
		$this -> db -> where('v.is_active', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	function quotation_location() {
		$this->db->select('location');
	$this->db->from('tbl_onroad_performa_invoice');
	$this->db->group_by('location');
	$query=$this->db->get();
	return $query->result();
	}
	function quotation_location_count() {
		$this->db->select('count(distinct(location)) as locationcount');
	$this->db->from('tbl_onroad_performa_invoice');
	//$this->db->group_by('location');
	$query=$this->db->get();
	return $query->result();
	}
		public function select_quotation_onroad_price(){
$qutotation_model = $this -> input -> post('model_id');
 $quotation_location = $this -> input -> post('location');
$quotation_variant = $this -> input -> post('variant_id');
	$this->db->select('op.*');
	$this->db->from('tbl_onroad_performa_invoice op');
	$this->db->join('model_variant v','v.variant_id=op.variant_id');
	$this->db->join('make_models m','m.model_id=op.model_id');
	$this->db->where('m.model_name',$qutotation_model);
	//$this->db->where('op.variant_id',$quotation_variant);
	$this->db->where('v.variant_name',$quotation_variant);
	$this->db->where('op.location',$quotation_location);
	$this -> db -> where('m.status', '1');
		$this -> db -> where('v.is_active', '1');
	$query=$this->db->get();
	return $query->result();
}



// Insurancecode
	public function select_insurance_table($process_id)
	{
		if ($process_id == 'Insurance') {

			$lead_master_insurance = 'lead_master_insurance';
			$lead_followup_insurance = 'lead_followup_insurance';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement = '`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`,
				`dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1 = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.esc_level1_resolved ,l.esc_level2_resolved,l.esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark,l.alternate_contact_no';
		} else {

			$lead_master_insurance = 'lead_master_insurance';
			$lead_followup_insurance = 'lead_followup_insurance';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
			$selectElement = 'csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name,l.alternate_contact_no';
			$selectElement1 = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		return array('lead_master_insurance' => $lead_master_insurance, 'lead_followup_insurance' => $lead_followup_insurance, 'request_to_lead_transfer_table' => $request_to_lead_transfer_table, 'select_element' => $selectElement, 'select_element1' => $selectElement1);
	}
	// End Insurancecode


// Insurancecode
	public function add_insurance_lead()
	{

// To Access data from JSON
	   $data = $this->input->input_stream(null, true);
	   
	    $decoded = json_decode(key($data), true);
	    
	    $firstmsg = $decoded['firstmsg'];
        $name = $decoded['name'];
        $phone = $decoded['phone'];
        $location = $decoded['location'];
        $type = $decoded['type'];
	    $process = "Insurance";

        // var_dump($data);

// To access data from JSON 
// $data = $this->input->input_stream(null, true);
//     // Get the first (and only) key from the array
//     $key = array_key_first($data);

//     // Convert the string representation of the object into a PHP object
//     $obj = json_decode($key);

//     // Access the properties of the object using the arrow notation
//     $name = $obj->name;
//     $type = $obj->type;
//     $phone = $obj->phone;
//     $firstmsg = $obj->firstmsg;
//     $location = $obj->location;
    // $process = "Insurance";
    
    
    
    
    // to access data comming from body form
// 		$firstmsg = $this -> input ->post('firstmsg');
// 		$name = $this -> input -> post('name');
// 		$phone = $this ->input -> post('phone');
// 		$location = $this -> input -> post('location');
// 		$type = $this -> input -> post('type');
// 		$process = 'Insurance';

// 		echo "Data from API : <br>";
// 		echo $firstmsg . "<br>" . $name . "<br>" . $phone . "<br>" . $location . "<br>" . $type;


	 $table = $this->select_insurance_table($process);
     $phone1 = strlen($phone);


        if ($phone == '' || $phone1 < 10 ) {
            $response["success"] = 0;
            $response["message"] = "Contact No not valid";

            // echoing JSON response
            echo json_encode($response);
        } else {
            $nextaction = "(nextaction!='Close' or nextaction!='Lost')";

            $this->db->select("*");
            $this->db->from('lead_master_insurance');
            $this->db->where('process', $process);
            $this->db->where('contact_no', $phone);
            $this->db->where($nextaction);
            $query = $this->db->get()->result();

            if (count($query) > 0) {
                $lead_id = $query[0]->enq_id;
                $query = $this->db->query("insert into lead_master_insurance_repeat(customer_location, comment,process,insurance_type,name,contact_no,created_date,created_time)
				values('$location','$firstmsg','$process','$type','$name','$phone','$this->today','$this->time')");

                // $response["lead_response"] = array('success' => true, 'id' =>$lead_id,'description'=> 'Already Added');

                // failed to inter row already exists
                $response["success"] = 0;
                $response["id"] = $lead_id;
                $response["message"] = "Customer Already Exists.";

                // echoing JSON response
                echo json_encode($response);
            } else {
                $query = $this->db->query("insert into lead_master_insurance(customer_location, comment,process,insurance_type,name,contact_no,created_date,created_time)
				values('$location','$firstmsg','$process','$type','$name','$phone','$this->today','$this->time')");
                $enq_id = $this->db->insert_id();
                if ($this->db->affected_rows() > 0) {
                    // successfully inserted
                    $response["success"] = 1;
                    $response["id"] = $enq_id;
                    $response["message"] = "Data successfully Inserted.";
                    // echoing JSON response
                    echo json_encode($response);
                } else {
                    // failed to insert row
                    $response["success"] = 0;
                    $response["message"] = "Oops! An error occurred.";
                    // echoing JSON response
                    echo json_encode($response);
                }
            }
		}
	}
	// End Insrancecode
	
public function select_quotation_offer(){
$qutotation_model = $this -> input -> post('model_id');
$quotation_location = $this -> input -> post('location');
$quotation_variant = $this -> input -> post('variant_id');
	$this->db->select('cons_off,offer_id');
	$this->db->from('tbl_onroad_performa_offer op');
$this->db->join('model_variant v','v.variant_id=op.variant_id');
$this->db->join('make_models m','m.model_id=op.model_id');
	//$this->db->where('op.model_id',$qutotation_model);
	//$this->db->where('op.variant_id',$quotation_variant);
	$this->db->where('m.model_name',$qutotation_model);
	$this->db->where('v.variant_name',$quotation_variant);
	$this->db->where('op.location',$quotation_location);
	$this -> db -> where('m.status', '1');
		$this -> db -> where('v.is_active', '1');
	$query=$this->db->get();
	return $query->result();
}


public function add_lead(){
	
	    $name = $this -> input -> post('name');
    	$email = $this -> input -> post('email');
		$contact_no = $this -> input -> post('phone');
		$process = $this -> input -> post('process');
		if($process=='')
		{
			$process='New Car';
		}
		$table=$this->select_table($process);	
	            if($contact_no ==''){
                $response["success"] = 0;
				$response["message"] = "Contact No not valid";

				// echoing JSON response
				echo json_encode($response);

	}else{
	$nextaction="(nextaction!='Close' or nextaction!='Lost')";
	
		$this -> db -> select("*");
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $contact_no);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {
			$lead_id=$query[0]->enq_id;
				$query = $this -> db -> query("insert into lead_master_repeat(process,lead_source,name,contact_no,email,created_date,created_time)
	            values('$process','Chat360 Bot API','$name','$contact_no','$email','$this->today','$this->time')");
	
	            //$response["lead_response"] = array('success' => true, 'id' =>$lead_id,'description'=> 'Already Added');
				$response["success"] = 0;
				$response["id"] = $lead_id;
				$response["message"] = "Customer Already Exists.";

				// echoing JSON response
				echo json_encode($response);
		} else {

			$query = $this -> db -> query("insert into " . $table['lead_master_table'] . "(process,lead_source,name,contact_no,email,created_date,created_time
		)
				values('$process','Chat360 Bot API','$name','$contact_no','$email','$this->today','$this->time'
		)");
			$enq_id = $this -> db -> insert_id();
		
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["id"] = $enq_id;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}
	
			}	
		}
		
		
		function car_service_pickup_details() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select * from lead_master_all where enq_id='$enq_id' and process='Service'")->result();
				if(count($q)>0){


			$location = $this -> input -> post('location');
			$pickup = $this -> input -> post('pickup');
			$date = $this -> input -> post('date');
			$time = $this -> input -> post('time');
			$query = $this -> db -> query("update lead_master_all set pickup_time_slot='$time',pickup_required='$pickup',service_center='$location',pick_up_date='$date' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "Lead id not found";

				echo json_encode($response);
		}

		}
	}
	function car_service_details() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select * from lead_master_all where enq_id='$enq_id' and process='Service'")->result();
				if(count($q)>0){


			$location = $this -> input -> post('location');
			$pickup = $this -> input -> post('pickup');
			$date = $this -> input -> post('date');
			$time = $this -> input -> post('time');
			$service_type = $this -> input -> post('service_type');
			$mcp_offers = $this -> input -> post('mcp_offers');
			$mcp_type = $this -> input -> post('mcp_type');
			$query = $this -> db -> query("update lead_master_all set pickup_time_slot='$time',pickup_required='$pickup',service_center='$location',pick_up_date='$date',mcp_type='$mcp_type',mcp_offers='$mcp_offers',service_type='$service_type' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "Lead id not found";

				echo json_encode($response);
		}

		}
	}
	function test_drive() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select model_id,variant_id from lead_master where enq_id='$enq_id' and process='New Car'")->result();
				if(count($q)>0){

					$appointment_type='Test Drive';
					$model_id=$q[0]->model_id;
			$variant_id=$q[0]->variant_id;
			$car_model = $this -> input -> post('model_id');
			if($car_model !='')
			{
			$car_variant = $this -> input -> post('variant_id');
			$q1=$this->db->query("select model_id from make_models where model_name='$car_model' and status='1'")->result();
			if(count($q1)>0){
				$model_id=$q1[0]->model_id;
			}$q2=$this->db->query("select * from model_variant where variant_name='$car_variant' and model_id='$model_id' and is_active='1'")->result();
			if(count($q2)>0){
				$variant_id=$q2[0]->variant_id;
			}
			$date = $this -> input -> post('test_date');
			$query = $this -> db -> query("update lead_master set model_id='$model_id',variant_id='$variant_id',
				appointment_type='$appointment_type',appointment_date='$date',buyer_type='First' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "Model id not found";

				echo json_encode($response);
		}
			
		}else{
			$response["success"] = 0;
				$response["message"] = "Lead id not found";

				echo json_encode($response);
		}

		}
		
	
	}
	function update_model_details() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select model_id,variant_id from lead_master where enq_id='$enq_id' and process='New Car'")->result();
				if(count($q)>0){

			$model_id=$q[0]->model_id;
			$variant_id=$q[0]->variant_id;
			$car_model = $this -> input -> post('car_model');
			if($car_model !='')
			{			
			$car_variant = $this -> input -> post('car_variant');
			$q1=$this->db->query("select model_id from make_models where model_name='$car_model' and status='1'")->result();
			if(count($q1)>0){
				$model_id=$q1[0]->model_id;
			}$q2=$this->db->query("select * from model_variant where variant_name='$car_variant' and model_id='$model_id' and is_active='1'")->result();
			if(count($q2)>0){
				$variant_id=$q2[0]->variant_id;
			}
			$exchange_choice = $this -> input -> post('exchange_choice');
			if($exchange_choice=='Yes')
			{
				$buyer_type='Exchange with New Car';
			}else{ $buyer_type='First';}
			$book_date = $this -> input -> post('book_date');
			$book_option = $this -> input -> post('book_option');
			if($book_option=='Book a home visit')
			{
				$a_type='Home Visit';
			}
			elseif($book_option=='Book a showroom visit')
			{
				$a_type='Showroom Visit';
			}if($book_option=='Book a test drive')
			{
				$a_type='Test Drive';
			}
			else
			{
				$a_type='';
			}
			$query = $this -> db -> query("update lead_master set model_id='$model_id',variant_id='$variant_id',
				buyer_type='$buyer_type',appointment_type='$a_type',appointment_date='$book_date' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "Model id not found";

				echo json_encode($response);
		}
		}else{
			$response["success"] = 0;
				$response["message"] = "Lead id not found";

				echo json_encode($response);
		}

		}
	}
	function update_poc_details() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select old_make,old_model,buyer_type from lead_master where enq_id='$enq_id' and process='POC Sales'")->result();
				if(count($q)>0){

			$model_id=$q[0]->old_model;
			$make_id=$q[0]->old_make;
			$buyer_type=$q[0]->buyer_type;
			if($buyer_type=='')
			{
				$buyer_type='Sell Used Car';
			}
			$car_model = $this -> input -> post('custom_model');
			if($car_model !='')
			{
			
			$q1=$this->db->query("select model_id,make_id from make_models where model_name='$car_model'")->result();
			if(count($q1)>0){
				$model_id=$q1[0]->model_id;
				$make_id=$q1[0]->make_id;
			}
			$mfg= $this -> input -> post('yor');
			$query = $this -> db -> query("update lead_master set old_model='$model_id',old_make='$make_id',manf_year='$mfg',buyer_type='$buyer_type' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "Model id not found";

				echo json_encode($response);
		}
		}else{
			$response["success"] = 0;
				$response["message"] = "Lead id not found";

				echo json_encode($response);
		}

		}
	}
	function update_finance_details() {
		$enq_id = $this -> input -> post('id');
		if($enq_id=='')
		{
			$response["success"] = 0;
				$response["message"] = "Please provide Lead id";

				echo json_encode($response);
		}

		else{
				$q=$this->db->query("select loan_type from lead_master_all where enq_id='$enq_id' and process='Finance'")->result();
				if(count($q)>0){

			$loan_type=$q[0]->loan_type;
			
			$loan_type = $this -> input -> post('loan_type');
			if($loan_type=='Personal loan')
			{
				$loan_type='Personal Loan';
			}
			elseif($loan_type=='Home loan')
			{
				$loan_type='Home Loan';
			}
			$query = $this -> db -> query("update lead_master_all set loan_type='$loan_type' where enq_id='$enq_id'");
			
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}else{
			$response["success"] = 0;
				$response["message"] = "lead id not found";

				echo json_encode($response);
		}
		}

		
	}

}
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/libraries/RestController.php');
require(APPPATH . '/libraries/Format.php');

use chriskacerguis\RestServer\RestController;
    
    
class Api_insurance extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session', 'email'));
		$this->load->helper('form');
		$this->load->helper('url');
        date_default_timezone_set('Asia/Kolkata');
    }
    
     public function select_insurance_table($process_id)
    {
         $this->today = date('Y-m-d');
        $this->time = date("h:i:s A");
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
    
    public function app_calls_post(){
        
    $data = $this->input->input_stream(null, true);

    var_dump($data);
    // Get the first (and only) key from the array
    $key = array_key_first($data);

    // Convert the string representation of the object into a PHP object
    $obj = json_decode($key);

    // Access the properties of the object using the arrow notation
    $name = $obj->name;
    $type = $obj->type;
    $phone = $obj->phone;
    $firstmsg = $obj->firstmsg;
    $location = $obj->location;
    $process = "Insurance";


        // To fetch the data send in body form data in postman
        
        // $firstmsg = $this->input->post('firstmsg');
        // $name = $this->input->post('name');
        // $contact_no = $this->input->post('phone');
        // $location = $this->input->post('location');
        // $type = $this->input->post('type');
    
        
        $table = $this->select_insurance_table($process);

        if ($phone == '') {
            $response["success"] = 0;
            $response["message"] = "Contact No not valid";

            // echoing JSON response
            echo json_encode($response);
        } else {
            $nextaction = "(nextaction!='Close' or nextaction!='Lost')";

            $this->db->select("*");
            $this->db->from($table['lead_master_insurance']);
            $this->db->where('process', $process);
            $this->db->where('contact_no', $phone);
            $this->db->where($nextaction);
            $query = $this->db->get()->result();

            if (count($query) > 0) {
                $lead_id = $query[0]->enq_id;
                $query = $this->db->query("insert into lead_master_insurance_repeat(customer_location, comment,process,insurance_type,name,contact_no,created_date,created_time)
				values('$location','$firstmsg','$process','$type','$name','$phone','$this->today','$this->time')");

                //$response["lead_response"] = array('success' => true, 'id' =>$lead_id,'description'=> 'Already Added');

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
    
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Duplicate_lead_tracker extends CI_Controller {
private  $process_id;
private $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('duplicate_lead_tracker_model');
		//$this -> load -> model('tracker_model1');
		 $this->process_id=$_SESSION['process_id'];
		  $this->process_name=$_SESSION['process_name'];		}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {

		$this -> session();
		// Get Filter select values
		$data['select_campaign'] = $this -> duplicate_lead_tracker_model -> select_campaign();
		/*$data['select_feedback'] = $this -> duplicate_lead_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> duplicate_lead_tracker_model -> select_next_action();*/
		$data['select_lead_source'] = $this -> duplicate_lead_tracker_model -> select_lead_source();
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		
		// Get All Selected Values
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		$data['process_id']=$this->process_id;
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('duplicate_tracker_with_tob_tab_view.php', $data);
		//$this -> load -> view('duplicate_lead_tracker.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function tracker_dse_filter() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> duplicate_lead_tracker_model -> select_campaign();
		/*$data['select_feedback'] = $this -> duplicate_lead_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> duplicate_lead_tracker_model -> select_next_action();*/
		$data['select_lead_source'] = $this -> duplicate_lead_tracker_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		/*$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');*/
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> duplicate_lead_tracker_model -> select_leads();
		$data['count_lead'] = $this -> duplicate_lead_tracker_model -> select_leads_count();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('duplicate_tracker_with_tob_tab_view.php', $data);
		$this -> load -> view('duplicate_lead_tracker.php', $data);		
		$this -> load -> view('include/footer.php');
	}
// complaint filter when click on search
	public function tracker_dse_filter_complaint() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> duplicate_lead_tracker_model -> select_campaign();
		$data['select_feedback'] = $this -> duplicate_lead_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> duplicate_lead_tracker_model -> select_next_action();
		$data['select_lead_source'] = $this -> duplicate_lead_tracker_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> duplicate_lead_tracker_model -> select_leads_complaint();
		$data['count_lead'] = $this -> duplicate_lead_tracker_model -> select_leads_count_complaint();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_dse_filter_complaint.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function download_data() {

		
		
	
	
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
	$query = $this -> duplicate_lead_tracker_model -> select_lead_download();
	
	
	
			$csv= "Sr No.,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required ,Booking within Days,Customer Location\n";

		$i=0;
	foreach ($query as $fetch) {
		$i++;
		if ($fetch -> lead_source == '') {
							 $lead_soure= "Web  ";
							 
						} else { $lead_source= $fetch -> lead_source;
						}
		
	 				 $csv.=$i.',"'.$lead_source.'","'.$fetch->enquiry_for.'","'. $fetch -> name.'","'. $fetch -> contact_no .'","'. $fetch -> alternate_contact_no.'","'.$fetch -> address.'","'. $fetch -> email.'","'.$fetch -> lead_date.'","'.$fetch -> lead_time.'","'.$fetch -> assistance.'","'. $fetch -> days60_booking.'","'. $fetch -> customer_location.'"'."\n";
					
                   }
$csv_handler = fopen ('tracker.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://autovista.in/all_lms_demo/tracker.csv'); // Read the file's contents
    
        force_download($filename, $data);
	
}






}
?>
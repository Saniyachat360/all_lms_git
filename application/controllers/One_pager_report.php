<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class One_pager_report extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('one_pager_report_model','CSE_reports_model','new_reports_model','reports_model'));
	
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {


		$this->session();
		$data['select_location']=$this -> one_pager_report_model -> select_location();
		$data['select_cse']=$this -> one_pager_report_model -> select_cse();
	
		$data['var']=site_url().'new_reports/search_dse_performance';

		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/one_pager_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function get_dse()
	{
		$location=$this->input->post('location');
		$select_dse=$this -> one_pager_report_model -> select_dse($location);
		?>
		
									<select id="dse_user_id" class="form-control"  name="dse_user_id">
									<option value="">Select DSE Name</option>
									<?php foreach($select_dse as $row) { ?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> dse_name; ?></option>
									<?php } ?>
									
									</select>
								
								<?php
		
	}
	public function get_report()
	{
		$report=$this->input->post('report');
		$location=$this->input->post('location');
		$dse_id=$this->input->post('dse_user_id');
		$cse_id=$this->input->post('cse_user_id');
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$date_type=$this->input->post('date_type');
		if($date_type=='As on Date')
		{
			$to_date=$from_date;
			$from_date='2017-01-01';
		}
		if($report=='CSE Productivity')
		{
			$this->cse_productivity($cse_id,$from_date,$to_date);
		}
		else if($report=='CSE Performance')
		{
			$this->cse_performance($cse_id,$from_date,$to_date);
		}
		else if($report=='DSE Productivity')
		{
			$this->dse_productivity($location,$dse_id,$from_date,$to_date);
		}
		else if($report=='DSE Performance')
		{
			$this->dse_performance($location,$dse_id,$from_date,$to_date);
		}
	}
	public function cse_productivity($cse_id,$from_date,$to_date)
	{
		$this -> session();
		$data['select_leads']=$this->CSE_reports_model->cse_productivity($cse_id,$from_date,$to_date); 
		$this -> load -> view('report/one_pager_cse_productivity_view.php', $data);
	}
	public function cse_performance($cse_id,$from_date,$to_date)
	{
		$this -> session();
		$data['select_leads']=$this->reports_model->cse_performance($cse_id,$from_date,$to_date); 
		$this -> load -> view('report/one_pager_cse_performance_view.php', $data);
	}
	public function dse_productivity($location,$dse_id,$from_date,$to_date)
	{
		$this -> session();
		$data['select_leads']=$this->new_reports_model->dse_productivity($location,$dse_id,$from_date,$to_date); 
		$this -> load -> view('report/one_pager_dse_productivity_view.php', $data);
	}
	public function dse_performance($location,$dse_id,$from_date,$to_date)
	{
		$this -> session();
		//$data['dse_id']=$dse_id;
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['select_leads']=$this->new_reports_model->dse_performance($location,$dse_id,$from_date,$to_date); 
		$this -> load -> view('report/one_pager_dse_performance_view.php', $data);
	}
	public function download_data()
	{
		$report=$this->input->get('report');
		$location=$this->input->get('location');
		$dse_id=$this->input->get('dse_user_id');
		$cse_id=$this->input->get('cse_id');
		$from_date=$this->input->get('from_date');
		$to_date=$this->input->get('to_date');
		$date_type=$this->input->get('date_type');
		if($date_type=='As on Date')
		{
			$to_date=$from_date;
			$from_date='2017-01-01';
		}
		if($report=='CSE Productivity')
		{
			$this->download_cse_productivity($cse_id,$from_date,$to_date,$report);
		}
		else if($report=='CSE Performance')
		{
			$this->download_cse_performance($cse_id,$from_date,$to_date,$report);
		}
		else if($report=='DSE Productivity')
		{
			$this->download_dse_productivity($location,$dse_id,$from_date,$to_date,$report);
		}
		else if($report=='DSE Performance')
		{
			$this->download_dse_performance($location,$dse_id,$from_date,$to_date,$report);
		}
	}
	public function download_cse_productivity($cse_id,$from_date,$to_date,$report)
	{
		echo $cse_id;
		$select_leads=$this->CSE_reports_model->cse_productivity($cse_id,$from_date,$to_date); 
		//print_r($select_leads);
		$csv="SrNo,CSE Name,Total Called,Total Connected,Not Connected,Connected%,Lead Assigned,Sent to Showroom,Allotted Home Visit,Conducted Home Visit,Not Conducted Home Visit,Allotted Showroom Visit,Conducted Showroom Visit,Not Conducted Showroom Visit,Allotted Test Drive,Conducted Test Drive,Not Conducted Test Drive,Allotted Evaluation,Conducted Evaluation,Not Conducted Evaluation\n";
			
			
		$i=0;
	foreach ($select_leads as $row) {
		$i++;
		$cse_name=$row['cse_fname'].' '.$row['cse_lname'];
		$total_call=$row['total_call'];
		$connected=$row['total_connected'];
		if($connected!=0 && $total_call!=0){
					$total_connect=($connected/$total_call)*100; 
								$total_connect=  round($total_connect, 2).'%';
				}else{
					$total_connect= '0%';
				}
		
			 $csv.= $i.',"'. $cse_name.'","'.$row['total_call'].'","'.$row['total_connected'].'","'. $row['total_not_connected'].'","'.$total_connect.'","'.$row['lead_assigned'] .'","'.$row['sent_to_showroom_leads'].'","'. $row['home_visit'].'","'.$row['home_visit_conducted'].'","'. $row['home_visit_not_conducted'].'","'. $row['showroom_visit'].'","'. $row['showroom_visit_conducted'].'","'.$row['showroom_visit_not_conducted'].'","'. $row['test_drive'].'","'. $row['test_drive_conducted'].'","'.$row['test_drive_not_conducted'].'","'. $row['evaluation_allotted'].'","'.$row['evaluation_conducted'].'","'. $row['evaluation_not_conducted'].'"'."\n";
		
		  }
$csv_handler = fopen ('report.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = $report . ' Report '.$from_date . ' - ' . $to_date.'.csv';
    $url_main= base_url();
    $data = file_get_contents($url_main.'/report.csv'); // Read the file's contents
    
        force_download($filename, $data);
				
	
		
	}
	public function download_cse_performance($cse_id,$from_date,$to_date,$report)
	{
				$select_leads=$this->reports_model->cse_performance($cse_id,$from_date,$to_date);
	$csv="SrNo,CSE Name,Lead Assigned,New,Pending New,Pending Followup,Sent To Showroom,Live,Lost,Booked,Conversion%\n";
		
			
		$i=0;
	foreach ($select_leads as $row) {
		$i++;
		
		$cse_name=$row['cse_fname'] . ' ' . $row['cse_lname'];
		if ($row['assign_lead'] == 0) {
		$conversion= "0.00%";
	} else {
		$t = ($row['booked_leads'] / $row['assign_lead']) * 100;
		$conversion =number_format($t, 2) ."%";
	}
		 $csv.= $i.',"'. $cse_name.'","'.$row['assign_lead'].'","'. $row['new_leads'].'","'. $row['pending_new_leads'].'","'.$row['pending_followup_leads'].'","'.$row['sent_to_showroom_leads'].'","'.$row['live_leads'].'","'.$row['close_leads'].'","'.$row['booked_leads'].'","'.$conversion.'"'."\n";

		  }
$csv_handler = fopen ('report.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = $report . ' Report '. $from_date . ' - ' . $to_date.'.csv';
  $url_main= base_url();
    $data = file_get_contents($url_main.'/report.csv'); // Read the file's contents
    
        force_download($filename, $data);
		
		
	}
	function download_dse_productivity($location,$dse_id,$from_date,$to_date,$report){
			$this -> session();
			
			$select_leads=$this->new_reports_model->dse_productivity($location,$dse_id,$from_date,$to_date); 
		
	$csv="SrNo,location,DSE Name,Total Called,Total Connected,Not Connected,Connected%,Lead Assigned,Booked,Conversion%,Home Visit Allocated,Home Visit Conducted,Home Visit Not Conducted,Showroom Visit Allocated,Showroom Visit Conducted,Showroom Visit Not Conducted,Test Drive Allocated,Test Drive Conducted,Test Drive Not Conducted,Evaluation Allocated,Evaluation Conducted,Evaluation Not Conducted\n";
	

		$i=0;
	foreach ($select_leads as $row) {
		$i++;
		$dse_name=$row['dse_fname'].' '.$row['dse_lname'];
		$total_call=$row['total_call'];
		$connected=$row['total_connected'];
		$booked=$row['booked'];
		$assigned=$row['lead_assigned'];
		if($connected!=0 && $total_call!=0){
					$total_connect=($connected/$total_call)*100; 
							$total_connect=	  round($total_connect, 2).'%';
				}else{
					$total_connect= '0%';
				} 
				if($booked>0 && $assigned>0){
				$conversion=($booked/$assigned)*100; 
					$conversion=  round($total_book, 2).'%';
			}else{
					$conversion= '0%';
				}
	 $csv.= $i.',"'.$row['location'].'","'.$dse_name.'","'.$row['total_call'].'","'.$row['total_connected'].'","'. $row['total_not_connected'].'","'.$total_connect.'","'.$row['lead_assigned'].'","'.$row['booked'].'","'.$conversion.'","'.$row['home_visit'].'","'.$row['home_visit_conducted'].'","'.$row['home_visit_not_conducted'].'","'. $row['showroom_visit'].'","'. $row['showroom_visit_conducted'].'","'. $row['showroom_visit_not_conducted'].'","'.$row['test_drive'].'","'.$row['test_drive_conducted'].'","'.$row['test_drive_not_conducted'].'","'. $row['evaluation_allotted'].'","'. $row['evaluation_conducted'].'","'. $row['evaluation_not_conducted'].'"'."\n";
				
		
            }
$csv_handler = fopen ('report.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = $report . ' Report '.  $from_date . ' - ' . $to_date.'.csv';
 $url_main= base_url();
    $data = file_get_contents($url_main.'/report.csv'); // Read the file's contents
        force_download($filename, $data);

	}
public function download_dse_performance($location,$dse_id,$from_date,$to_date,$report)
{
	$select_leads=$this->new_reports_model->dse_performance($location,$dse_id,$from_date,$to_date); 
	//print_r($select_leads);
	$csv="Sr.No,location,DSE Name,Lead Assigned,New,Pending New,Pending Followup,Live,Total Lost,Lost to co-dealer,Lost other,Booked,Conversion%,Escalation Level 1,Escalation Level 1 Resolved,Escalation Level 2,Escalation Level 2 Resolved,Escalation Level 3,Escalation Level 3 Resolved\n";
	
		$i=0;
	foreach ($select_leads as $row) {
		$i++;
		$dse_name=$row['dse_fname'].' '.$row['dse_lname'];
		$assign_leads=$row['assign_lead'];
		$booked_leads=$row['booked_leads'];
		if($assign_leads>0 && $booked_leads>0){
					$conversion=($booked_leads/$assign_leads)*100;
					$conversion= $conversion.'%';
				}else{
					$conversion= '0%';
				}
			 $csv.= $i.',"'.$row['location'].'","'.$dse_name.'","'.$row['assign_lead'].'","'.$row['new_leads'].'","'. $row['pending_new_leads'].'","'. $row['pending_followup_leads'].'","'.$row['live_leads'].'","'.$row['total_lost_leads'].'","'.$row['co_dealer_lost_leads'].'","'.$row['other_lost_leads'].'","'.$row['booked_leads'].'","'.$conversion.'","'. $row['esc_level1_leads'].'","'. $row['esc_level1_resolved_leads'].'","'.$row['esc_level2_leads'].'","'.$row['esc_level2_resolved_leads'].'","'.$row['esc_level3_leads'].'","'.$row['esc_level3_resolved_leads'].'"'."\n";
				
			
		
            }
$csv_handler = fopen ('report.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = $report . ' Report '.  $from_date . ' - ' . $to_date.'.csv';
$url_main= base_url();
    $data = file_get_contents($url_main.'/report.csv'); // Read the file's contents
    
        force_download($filename, $data);
	
}
public function new_dse()
{
	$select_leads=$this->new_reports_model->get_dse();
}
}
?>
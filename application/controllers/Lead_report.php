<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lead_report extends CI_Controller {
public $process_name;
	public $role;
	public $user_id;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('lead_report_model');
		$this->process_name=$this->session->userdata('process_name');
		$this->role=$this->session->userdata('role');
		$this->user_id=$this->session->userdata('user_id');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function index() {
		$this -> session();	
		$data['select_location']=$this->lead_report_model->select_location();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('lead_report_view.php',$data);
		$this -> load -> view('include/footer.php');

	}
	public function total_lead()
	{
		$this -> session();	
		$location_id=$this->input->post('location_id');
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		if ($fromdate == '') {
			$fromdate = "2017-01-01";
		}
		if ($todate == '') {
			$todate = date('Y-m-d');
		}?>
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%"></div>
		
		
			<?php $total_count = $this -> lead_report_model -> total_lead($location_id, $fromdate, $todate,$this->role,$this->process_name,$this->user_id);
			$total_feedback = $this -> lead_report_model -> total_feedback($location_id, $fromdate, $todate,$this->role,$this->process_name,$this->user_id);
			//print_r($total_count);
			if(count($total_count)>0 && count($total_feedback)>0){?>
			<style>
				.table-condensed caption {
					display: none;
				}
			</style>
				<script type="text/javascript">
$(document).ready(function(){
	
	$("table").tableExport({
				headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
				footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
				formats: ["xls"],    // (String[]), filetypes for the export
				fileName: "Lead report",                    // (id, String), filename for the downloaded file
				bootstrap: true,                   // (Boolean), style buttons using bootstrap
				position: "0,0" ,                // (top, bottom), position of the caption element relative to table
				trimWhitespace:true,
				ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file
				ignoreCols: null,                 // (Number, Number[]), column indices to exclude from the exported file
				ignoreCSS: ".tableexport-ignore"   // (selector, selector[]), selector(s) to exclude from the exported file
				
			});

});
</script>
			<h3>Total Leads</h3>
			 
				<table class="table table-bordered datatable" id="xls_data" >
				<thead>
					<tr style="background-color:#ddd">
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>						
							<th><b>Count</b></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Total Leads</td>
						<td><a href="<?php echo site_url('lead_report_tracker/leads/?fromdate='.$fromdate.'&todate='.$todate.'&source=total_all_leads');?>"><?php echo $total_count['total_leads']; ?></a></td>
					</tr>
					<tr>
						<td>2</td>
						<td>Unassigned Leads</td>
						<td><a href="<?php echo site_url('lead_report_tracker/leads/?fromdate='.$fromdate.'&todate='.$todate.'&source=total_unassigned_leads');?>"><?php echo $total_count['total_unassigned_leads']; ?></a></td>
					</tr>
					<tr>
						<td>3</td>
						<td>Pending New Leads</td>
						<td><a href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_pending_new_leads');?>"><?php echo $total_count['total_pending_new_leads']; ?></a></td>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending Followup Leads</td>
						<td><a  href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_pending_followup_leads');?>"><?php echo $total_count['total_pending_followup_leads']; ?></a></td>
					</tr>
					<!--<tr>
						<td>5</td>
						<td>Booking within 30 days</td>
						<td><a  href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_booking_30_leads');?>"><?php echo $total_count['total_booking_30']; ?></a></td>
					</tr>
					<tr>
						<td>6</td>
						<td>Booking within 60 days</td>
						<td><a  href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_booking_60_leads');?>"><?php echo $total_count['total_booking_60']; ?></a></td>
					</tr>
					<tr>
						<td>7</td>
						<td>Booking within >60 days</td>
						<td><a  href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_greater_60_leads');?>"><?php echo $total_count['total_booking_greater_60']; ?></a></td>
					</tr>-->
					<?php $i=5; 
					foreach ($total_feedback as $key => $value) {
						$i++;?>
						<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $key ?></td>
						<td><a  href="<?php echo site_url('lead_report_tracker/leads/?location_id='.$location_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=total_'.strtolower(str_replace('-','_',str_replace(' ', '_', $key))).'_leads');?>"><?php echo $value ?></a></td>
					</tr>
					<?php  }?> 						
					
				</tbody>
			</table>
			<?php 
	}}
//}
	

}

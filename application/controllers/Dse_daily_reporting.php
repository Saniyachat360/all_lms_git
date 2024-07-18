<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dse_daily_reporting extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('dse_daily_reporting_model');
		
		date_default_timezone_set("Asia/Kolkata");
		//$this -> load -> model('tracker_model1');

	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this->session();
		$data['var']=site_url().'dse_daily_reporting/insert_data';
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('dse_daily_reporting_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	 public function insert_data()
	{
		$this->dse_daily_reporting_model->insert_data();
		//redirect('dse_daily_reporting');
	}
 public function show_data()
	{
		$this->session();
		$data['var']=site_url().'dse_daily_reporting/insert_data';
		$data['select_location']=$this->dse_daily_reporting_model->select_location();
		$data['show_data']=$this->dse_daily_reporting_model->show_data();
		$this -> load -> view('include/admin_header.php');
			$this -> load -> view('dse_daily_report_top_tab_view.php',$data);
		$this -> load -> view('dse_daily_report_show_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function show_data_filter()
	{
			$show_data=$this->dse_daily_reporting_model->show_data();
			?>
				<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
					<script type="text/javascript">
$(document).ready(function(){
	
	$("table").tableExport({
				headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
				footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
				formats: ["xls"],    // (String[]), filetypes for the export
				fileName: "DSE Daily Report",                  // (id, String), filename for the downloaded file
				bootstrap: true,                   // (Boolean), style buttons using bootstrap
				position: "0,0" ,                // (top, bottom), position of the caption element relative to table
				trimWhitespace:true,
				ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file
				ignoreCols: null,                 // (Number, Number[]), column indices to exclude from the exported file
				ignoreCSS: ".tableexport-ignore"   // (selector, selector[]), selector(s) to exclude from the exported file
				
			});

});
</script>
	<?php if(count($show_data)>0){?>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>DSE name</b></th>
							<th><b>Date/Time</b></th>
							<th><b>Enquiry</b></th>
							<th><b>Walk in</b></th>
							<th><b>Home visit </b></th>
							<th><b>Test Drive</b></th>
							<th><b>Booking</b></th>
							<th><b>Gatepass</b></th>
							<th><b>Evaluation</b></th>
							<th><b>Delivery </b></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; 
					foreach($show_data as $row){
						$i++; 
						?>
					<tr>
						
						<td><?php echo $i;?></td>
							<th><b><?php echo $row->fname.' '.$row->lname;?></b></th>
							<td><?php echo $row->report_date.' / '.$row->report_time;?></td>
							<td><?php echo $row->enquiry_count;?></td>
								<td><?php echo $row->walk_in_count;?></td>
							<td><?php echo $row->home_visit_count;?></td>	
							<td><?php echo $row->test_drive_count;?></td>
								<td><?php echo $row->booking_count;?></td>
									<td><?php echo $row->gatepass_count;?></td>
									<td><?php echo $row->evaluation_count;?></td>
										<td><?php echo $row->delivery_count;?></td>
										
											
					</tr>
					<?php } ?>
				</tbody>
			</table>
			</div>
	
	<?php } else{
		echo "<div class='text-center'>No Record Found</div>";
	}
	?>
	
</div>
					<?php
	}
}
?>
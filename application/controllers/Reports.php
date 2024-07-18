<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('reports_model');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function lead_sourcewise() {
		$this -> session();
		$data['select_lead_source'] = $this -> reports_model -> select_lead_source();		
	
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('lead_sourcewise_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function lead_sourcewise_filter() {
		$this -> session();
		$campaign_name = $this -> input -> post('campaign_name');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$query=$this -> reports_model -> select_lead_sourcewise_count($campaign_name,$fromdate,$todate);	
		//print_r($q);
		if(!empty($query)){
			?>
				<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
			
							<div class="col-md-12">
							<div class="table-responsive" style='overflow-x: scroll'>
				<table class="table table-bordered datatable" id="table-4">
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Lead Source</th>
							<th>Leads Generated</th>
							<th>Live </th>
							<th>Total Lost</th>
							<th>Lost to Co-dealer</th>
							<th>Lost to Others</th>
							<th>Booked</th>
							<th>Conversion %</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; 
					foreach ($query as $row) {
						$i++;
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php
								if ($row['lead_source'] == '') {
									echo "Web";
								} else {
									echo $row['lead_source'];
								}
						?></td>
							<td><?php echo $row['leads_generated']; ?></td>
							<td><?php echo $row['live_leads']; ?></td>
							<td><?php echo $row['close_leads']; ?></td>
							<td><?php echo $row['lost_to_co_dealer_leads']; ?></td>
							<td><?php echo $row['lost_to_other_leads']; ?></td>
							<td><?php echo $row['booked_leads']; ?></td>
							<td>
								<?php
								$t = ($row['booked_leads'] / $row['leads_generated']) * 100;
								echo number_format($t, 2);
								echo "%";
								//round($t);
								?>
							</td>
							</tr>
					<?php } ?>
				</tbody>
			</table>
			</div>
			</div>
	</div>
			<?php
			}else{
			echo "<center>No Leads Found.</center>";
			}
			}
	public function cse_performance() 
	{
		$this -> session();
		$data['select_cse']=$this -> reports_model -> select_cse();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/cse_performance_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_performance()
	{
			$this -> session();
			$cse_id = $this -> input -> post('cse_id');
		$fromdate = $this -> input -> post('from_date');
		$todate = $this -> input -> post('to_date');
		
		$date_type=$this->input->post('date_type');
		if($date_type=='As on Date')
		{
			$todate=$fromdate;
			$fromdate='2017-01-01';
		}
			$select_leads=$this->reports_model->cse_performance($cse_id,$fromdate,$todate);
			
		?>
		<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		 <div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
		<?php 
		if(count($select_leads)>0){?>
		<div class="col-md-12" style="overflow-x:scroll">
			<table class="table table-bordered datatable" id="xls_data" >
				<thead>
					<tr>
				<th>CSE Name</th>
				<th>Lead Assigned</th>
				<th>New</th>
				<th>Pending New</th>
				<th>Pending Followup</th>
				<th>Sent To Showroom</th>
				<th>Live</th>
				<th>Lost</th>
				<th>Booked</th>
				<th>Conversion%</th>
				</tr>
				</thead>
				<tbody>
			<?php foreach ($select_leads as $row) {?>
				<tr>

				<td><?php 
				$cse_id=$row['cse_id'];
				echo $row['cse_fname'] . ' ' . $row['cse_lname']; ?></td>

			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=assign_leads');?>">
					<?php echo $row['assign_lead']; ?> 
				</a>
			</td>
				
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=new_leads');?>">
					<?php echo $row['new_leads']; ?>
				</a>
			</td>

			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=pending_new_leads');?>">
					<?php echo $row['pending_new_leads']; ?>
				</a>
			</td>

					
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=pending_followup_leads');?>">
					<?php echo $row['pending_followup_leads']; ?>
				</a>
			</td>
					
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=sent_to_showroom_leads');?>">
					<?php echo $row['sent_to_showroom_leads']; ?>
				</a>
			</td>
					
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=live_leads');?>">
					<?php echo $row['live_leads']; ?>
				</a>
			</td>
			
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=close_leads');?>">
					<?php echo $row['close_leads']; ?>
				</a>
			</td>
			
			<td>
				<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$fromdate.'&to_date='.$todate.'&cse_id='.$cse_id.'&source=booked_leads');?>">
					<?php echo $row['booked_leads']; ?>
				</a>
				
			</td>
				
				

				<td><?php
	if ($row['assign_lead'] == 0) {
		echo "0.00%";
	} else {
		$t = ($row['booked_leads'] / $row['assign_lead']) * 100;
		echo number_format($t, 2);
		echo "%";
	}
	?></td>
			</tr>

			<?php } ?>
				</tbody>
			</table>

			</div>

<?php }else {
	echo "<center>No Leads Found.</center>";
	}

	}
	public function locationwise_report() 
	{
		$this -> session();
		$data['select_location']=$this -> reports_model -> select_location();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/locationwise_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_locationwise_report()
	{
		$this -> session();
		$q=$data['select_leads']=$this -> reports_model -> search_locationwise_report(); 
		//print_r($q);
		$this -> load -> view('report/locationwise_filter_report_view.php', $data);
	
	
		
	}

}
?>
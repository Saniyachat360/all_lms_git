
<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Dashboard_dse extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('dashboard_dse_model');		
	}

	public function session()
	{
		$this->session->userdata('process_name');
		// print_r($this->session->all_userdata());
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function ajaxsession()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$this->session();

		$data['select_location'] = $this->dashboard_dse_model->select_location();
		$data['select_tl'] = $this->dashboard_dse_model->fetch_tl();
		$data['var'] = site_url('add_location/insert_location');
		$this->load->view('include/admin_header.php');
		$this->load->view('dashboard_dse_view', $data);
		$this->load->view('include/footer.php');
	}

	public function get_tl()
	{
		$location = $this->input->post('location');
		$select_tl = $this->dashboard_dse_model->select_tl($location);
		?>
		<select id="tl_id" class="form-control" name="tl_id" onchange='get_dse()'>
			<option value="">Select TL</option>
			<?php foreach ($select_tl as $row) { ?>
				<option value="<?php echo $row->id; ?>"><?php echo $row->tl_name; ?></option>
			<?php } ?>
		</select>
		<?php		
	}

	public function get_dse()
	{
		$location = $this->input->post('location');
		$tl_id = $this->input->post('tl_id');

		$select_dse = $this->dashboard_dse_model->select_dse();
		?>
		<select id="user_id" class="form-control" name="user_id">
			<option value="">Select DSE Name</option>
			<?php foreach ($select_dse as $row) { ?>
				<option value="<?php echo $row->id; ?>"><?php echo $row->dse_name; ?></option>
			<?php } ?>
		</select>
	<?php
	}

	public function test_chart()
	{
		
	$this->load->view('dashboard_dse_filter_view');
	$this->load->view('include/footer.php');	
	}
	
	
	public function search_dse_performance(){
		$this->session();
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$date_type = $this->input->post('date_type');
		$tl_id = $this->input->post('tl_id');
		

		if ($date_type == 'As on Date') {
			$to_date = $from_date;
			$from_date = '2017-01-01';
		}

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		$total_lead = $this->dashboard_dse_model->total_leads($from_date, $to_date, $tl_id);
		$assign_lead = $this->dashboard_dse_model->assign_leads($from_date, $to_date, $tl_id);
		$pending_new_leads = $this->dashboard_dse_model->pending_new_leads($from_date, $to_date, $tl_id);
		$pending_followup_leads = $this->dashboard_dse_model->pending_followup_leads($from_date, $to_date, $tl_id);
		$gap_beetween_first_call = $this->dashboard_dse_model->gap_beetween_first_call($from_date, $to_date, $tl_id);
		?>
		
		<?php //if ($_SESSION['process_id'] == 6) { ?>
			<style>
			  * {
				box-sizing: border-box;
			  }
	
			  body {
				font-family: Arial, Helvetica, sans-serif;
			  }
	
			  /* Float four columns side by side */
			  .column {
				float: left;
				width: 25%;
				padding: 0 10px;
			  }
	
			  /* Remove extra left and right margins, due to padding */
			  .row {
				margin: 0 -5px;
			  }
	
			  /* Clear floats after the columns */
			  .row:after {
				content: "";
				display: table;
				clear: both;
			  }
	
			  /* Responsive columns */
			  @media screen and (max-width: 600px) {
				.column {
				  width: 100%;
				  display: block;
				  margin-bottom: 20px;
				}
			  }
	
			  /* Style the counter cards */
			  .card {
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
				padding: 16px;
				text-align: center;
				background-color: #f1f1f1;
			  }
			</style>
			<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
			<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">
	
			<div class="main-content">
			 
			  <div class="container-fluid">
				<div class="header-body">
				  <div class="row">
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Total Leads</h4>
							  <span class="h3 font-weight-bold mb-0"><?php echo $total_lead; ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
								<i class="fas fa-chart-bar"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <?php // } ?>
					</div>
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Leads Assigned</h4>
							  <span class="h3 font-weight-bold mb-0">
								<?php echo $assign_lead; ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
								<i class="fas fa-chart-pie"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Pending New Lead</h4>
							  <span class="h3 font-weight-bold mb-0"><?php echo $pending_new_leads; ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
								<i class="fas fa-users"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Pending Follow Up Leads</h4>
							  <span class="h3 font-weight-bold mb-0"><?php echo $pending_followup_leads; ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-info text-white rounded-circle shadow">
								<i class="fas fa-percent"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<!-- Page content -->
			<br>
			<!-- <div class="main-content" id="gap">
			  <div class="container-fluid">
				<div class="header-body">
				  <div class="row">
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Gap Between Lead Assigned To First Call</h4>
							  <span class="h3 font-weight-bold mb-0"><?php echo $gap_beetween_first_call; ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
								<i class="fas fa-chart-bar"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<div class="col-xl-3 col-lg-6">
					  <div class="card card-stats mb-4 mb-xl-0">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  <h4>Avg Gaps Between Follow-ups</h4>
							  <span class="h3 font-weight-bold mb-0"><?php //echo "cng--".$fuel_type_filter_c; echo "petrol--".$fuel_type_filter_c;
																	  ?></span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
								<i class="fas fa-chart-pie"></i>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
	
				  </div>
				</div>
			  </div>
			</div> -->
			<!-- Page content -->
	
		  </div>
	
		
		
 <?php } } ?>
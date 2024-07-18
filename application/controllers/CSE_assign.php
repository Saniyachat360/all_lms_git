<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CSE_assign extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('CSE_reports_assign_model');
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function lead_sourcewise()
	{
		$this->session();
		$data['select_lead_source'] = $this->reports_model->select_lead_source();

		$this->load->view('include/admin_header.php');
		$this->load->view('lead_sourcewise_report_view.php', $data);
		$this->load->view('include/footer.php');
	}
	public function lead_sourcewise_filter()
	{
		$this->session();
		$campaign_name = $this->input->post('campaign_name');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$query = $this->reports_model->select_lead_sourcewise_count($campaign_name, $fromdate, $todate);
		//print_r($q);
		if (!empty($query)) {
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
							<?php $i = 0;
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
		} else {
			echo "<center>No Leads Found.</center>";
		}
	}
	public function cse_wise_report()
	{
		$this->session();
		$data['select_cse'] = $this->CSE_reports_assign_model->select_cse();
		$this->load->view('include/admin_header.php');
		$this->load->view('report/cse_assign_report_view.php', $data);
		$this->load->view('include/footer.php');
	}

	public function displayData()
	{
		// Retrieve data from session
		$data['fetched_data'] = $this->session->userdata('fetched_data');

		// Load view and pass the data
		$this->load->view('your_view', $data);
	}

	public function search_performance()
	{
		$this->session();
		$cse_id = $this->input->post('cse_id');
		$fromdate = $this->input->post('from_date');
		$todate = $this->input->post('to_date');

		$date_type = $this->input->post('date_type');
		if ($date_type == 'As on Date') {
			$todate = $fromdate;
			$fromdate = '2017-01-01';
		}
		$select_leads = $this->CSE_reports_assign_model->cse_performance($cse_id, $fromdate, $todate);
		//$data['assignments'] = $this->CSE_reports_assign_model->cse_performance($cse_id, $fromdate, $todate);
		//var_dump($data['assignments']);
		?>
		<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<!-- <div class="pull-right">
			<a href="#" class="pull-right" onClick="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
		</div> -->
		</div>





		<?php
		if (count($select_leads) > 0) { ?>
			<div class="col-md-12" style="overflow-x:scroll">
			<?php
if (count($select_leads) > 0) {
    // Collect all unique dates
    $all_dates = [];

    // Collect all unique dates for each category
    $dates_per_category = [
        'assign_lead' => [],
        'total_connected' => [],
        'total_intrested' => [],
        'assign_lead' => [],
        'test_drive' => [],
        'booked_leads' => []
    ];

    foreach ($select_leads as $row) {
        // Collect unique dates for each category
        foreach ($dates_per_category as $key => $dates) {
            $data = json_decode($row[$key], true);
            if (is_array($data) && !empty($data)) {
                foreach ($data as $entry) {
                    if (isset($entry['assign_to_cse_date'])) {
                        $date = htmlspecialchars($entry['assign_to_cse_date']);
                        $all_dates[$date] = $date;
                        $dates_per_category[$key][$date] = $date;
                    }
                }
            }
        }
    }

    // Sort dates
    ksort($all_dates);

    ?>

    <div class="col-md-12" style="overflow-x:scroll">
        <table class="table table-bordered datatable" id="xls_data">
            <thead>
                <tr>
                    <th rowspan="2">CSE Name</th>
                    <?php foreach ($dates_per_category as $key => $dates) { ?>
                        <th colspan="<?php echo count($dates); ?>"><?php echo ucfirst(str_replace('_', ' ', $key)); ?></th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php foreach ($dates_per_category as $key => $dates) { ?>
                        <?php foreach ($dates as $date) { ?>
                            <th><?php echo $date; ?></th>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($select_leads as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['cse_fname'] . ' ' . $row['cse_lname']); ?></td>
                        <?php foreach ($dates_per_category as $key => $dates) { ?>
                            <?php foreach ($dates as $date) { ?>
                                <td>
                                    <?php
                                    $data = json_decode($row[$key], true);
                                    $count = 0;
                                    if (is_array($data) && !empty($data)) {
                                        foreach ($data as $entry) {
                                            if (isset($entry['assign_to_cse_date']) && htmlspecialchars($entry['assign_to_cse_date']) == $date) {
                                                $count = htmlspecialchars($entry['count']);
                                                break;
                                            }
                                        }
                                    }
                                    echo $count;
                                    ?>
                                </td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>


			</div>




<?php } else {
			echo "<center>No Leads Found.</center>";
		}
	}
}
?>
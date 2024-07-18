<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cSE_added_leads extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('cSE_added_leads_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		$this -> session();
		$data['enq']='All';
		$data['select_lead'] = $this -> cSE_added_leads_model -> select_lead();
		$data['select_telecaller']=$this->cSE_added_leads_model->select_telecaller();
		$data['select_status']=$this->cSE_added_leads_model->select_status();
			//$data['select_campaign']=$this->telecaller_lead_model->select_campaign();
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('CSE_added_leads_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	
		public function tl_filter()
	{	
	
		$select_lead=$this->cSE_added_leads_model->select_lead();

?>
<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
<div id="abc">
	<?php $today = date('d-m-Y'); ?>
	<h1 style="text-align:center;">CSE Added Leads</h1>
	<script>
		jQuery(document).ready(function() {
			$('#results').DataTable();
		});
	</script>
	<div class="table-responsive"  style="overflow-x:auto;">
		<table class="table table-bordered datatable table-responsive"" id="results">
		<thead>
		<tr>
		<th>Sr No.</th>
		<th>Interested In</th>
		<th>Name</th>
		<th>Contact</th>
		<!--<th>Email</th>-->
		<th>Lead Date</th>
		<th>Status</th>
		<th>Disposition</th>
		<th>Call Date</th>
		<th>N.F.D</th>
		<th>Added By</th>
		<th>Assign To</th>
		<th>Customer Comment </th>
		<th>Remark</th>
		</tr>
		</thead>
		<tbody>

		<?php
		$i=0;

		foreach($select_lead as $fetch)

		{

		$enq_id=$fetch->enq_id;
		$i++;

		?>

		<tr>
		<td><?php echo $i; ?></td>

		<td><?php echo $fetch -> enquiry_for; ?></td>

		<td><b><a href="<?php echo site_url(); ?>website_leads/lms_details/<?php echo $enq_id; ?> "><?php echo $fetch -> name; ?></a></b></td>

		<td><?php echo $fetch -> contact_no; ?></td>
		<td><?php echo $fetch -> created_date; ?></td>
		<td><?php echo $fetch -> status_name; ?></td>
		<td><?php echo $fetch -> disposition_name; ?></td>
		<td><?php echo $fetch -> date; ?></td>
		<td><?php echo $fetch -> nextfollowupdate; ?></td>
		<td>
		<?php
		echo $fetch -> manual_lead;
		?>
		</td>

		<td><?php
		echo $fetch -> fname . " " . $fetch -> lname;
		?>
			</td>

			<td>

			<?php
			// echo $fetch->comment;

			$comment = $fetch -> comment;

			$string = strip_tags($comment);

			if (strlen($string) > 25) {

				// truncate string
				$stringCut = substr($string, 0, 25);

				// make sure it ends in a word so assassinate doesn't become ass...

				$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
			}
			echo $string;
		?>

</td>

<td><?php
$comment1 = $fetch -> remark;

$string = strip_tags($comment1);

if (strlen($string) > 25) {

	// truncate string
	$stringCut = substr($string, 0, 25);

	// make sure it ends in a word so assassinate doesn't become ass...

	$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
}
echo $string;
?>
			</td>

			</tr>
			<?php } ?>
			</tbody>
		</table>
		<br />
	</div>
</div>

<?php 	}

	}
?>

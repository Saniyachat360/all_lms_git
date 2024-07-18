<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class edit_customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('edit_customer_model');
		date_default_timezone_set("Asia/Kolkata");

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		$this -> session();
		$query = $this -> edit_customer_model -> fetch_data();
		//print_r($query);
		$data['count_data'] =$query2 = $this -> edit_customer_model -> count_data();
		$data['select_table'] = $query;
		//$data['select_process'] = $this -> add_user_model -> select_process();
		//$data['select_location'] = $this -> add_user_model -> select_location();		
		//$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_customer_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	public function paging_next() {
		$this -> session();
		$query = $this -> edit_customer_model -> fetch_data();
		$data['count_data'] =$query2 = $this -> edit_customer_model -> count_data();
		$data['select_table'] = $query;
		//$data['select_process'] = $this -> add_user_model -> select_process();
		//$data['select_location'] = $this -> add_user_model -> select_location();		
		//$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_customer_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	public function edit_user()
	{
		$this -> session();
		$id = $this -> input -> get('id');
		
		$query = $this -> edit_customer_model -> edit_user($id);
		
		$data['edit_user'] = $query;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('act_edit_customer_view.php', $data);
		$this -> load -> view('include/footer.php');
		
	}
	
	function update_user() {

		 $id = $this -> input -> post('id');
		
		
		//print_r($group_id);
		
	$name = $this -> input -> post('name');
	$contact = $this -> input -> post('contact');
		
	$email = $this -> input -> post('email');
		
	$address = $this -> input -> post('address');

	

		$q = $this -> edit_customer_model -> update_user($id, $name, $contact, $email, $address);
	
	redirect('edit_customer');
	}
function duplicate_record()
{
	$id = $this -> input -> get('id');
	$contact = $this -> input -> get('con');
	$q = $this -> edit_customer_model -> duplicate_user($id, $contact);
	
	redirect('edit_customer');
	
	
	
}


public function search() {
		
	$this->session();
	$select_lead=$data['select_lead'] = $this -> edit_customer_model -> select_lead_dse();
//	$lc_data=$data['lc_data'] = $this -> search_customer_model -> lc_data_dse();

	//$lost_data=$data['lost_data'] = $this -> search_customer_model -> lost_data_dse();

//print_r($a);
?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var $results = jQuery("#results");
					$results.DataTable({
						dom : 'Bfrtip',
						buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
					});
				});
</script> 
<div class="table-responsive" >
					<table class="result table table-bordered datatable table-responsive" id="results">
			<thead>
				<tr>
					<th>Sr No.</th>

					<th>Name</th>
					
					<th>Contact</th>
					<th>Email</th>
					<th>Address</th>
					<!--<th>Lead Status</th>-->
					<th>Action</th>
					

					
				</tr>
			</thead>
			
			
			<tbody>

				<?php
				
	$insert = $_SESSION['insert'];
				$i=0;
				foreach($select_lead as $fetch)
				{
				$i++;
				?>
			
				<tr>

					<td> <?php echo $i; ?> </td>

					<td>
					<?php echo $fetch ->name; ?>
					</td>

					<td>
					<?php echo $fetch ->contact_no; ?>
					</td>
					
					
					<td>
					<?php echo $fetch ->email; ?>
					</td>
					
					
						<td>
					<?php echo $fetch ->address; ?>
					</td>
				
					<td>
					<?php if($insert[57]==1) {?>
					<a href="<?php echo site_url();?>edit_customer/edit_user?id=<?php echo $fetch ->enq_id;?>">Edit </a> 
						<?php } ?>
				
					<!--<a href="<?php echo site_url();?>edit_customer/duplicate_record?id=<?php echo $fetch ->enq_id;?>&con=<?php echo $fetch ->contact_no; ?>">Remove Duplicate </a>--> 
					
					
					
					</td>
					
				</tr>
				<?php } ?>
			</tbody>
</table>
</div>
<?php
}




	
}

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lms_user extends CI_Controller {
	private $process_id;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('lms_user_model');
		$this->process_id=$_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function index() {
		$this -> session();
		//echo $this->process_id; 
		//$query = $this -> lms_user_model -> lms_user_data();

		//fetch data from lmsuser table
		//fetch data only for dse details
		//$data['dse_data'] = $query;
		//fetch data only for tl details
		$data['tl_data'] = $this -> lms_user_model -> lms2_user_data($this->process_id);
		$data['count_data'] = $query2 = $this -> lms_user_model -> user();
		//fetch data from mapdse table
		$data['all_data'] = $this -> lms_user_model -> fetch_all_data($this->process_id);
		

		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	function paging_next() {
		$this -> session();

		//$query = $this -> lms_user_model -> lms_user_data();

		//fetch data from lmsuser table
		//fetch data only for dse details
		//$data['dse_data'] = $query;
		//fetch data only for tl details
		$data['tl_data'] = $this -> lms_user_model -> lms2_user_data();
		$data['count_data'] = $query2 = $this -> lms_user_model -> user();
		//fetch data from mapdse table
		$data['all_data'] = $this -> lms_user_model -> fetch_all_data();
		

		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	// insert map_lms_user data
	function add() {
		//we are getting the values from view

		//$tlname = $this -> input -> post('tlname');
		//$dsename = $this -> input -> post('dsename');

		$query = $this -> lms_user_model -> insert_map();

		redirect('lms_user');

	}
	
	
	/*function locationwise_dse() {
		//we are getting the values from view

		$tlname = $this -> input -> post('tlname');
		

		$query = $this -> lms_user_model -> locationwise_dse($tlname);

		redirect('lms_user');

	}*/
	
	
	function locationwise_dse() {
		//we are getting the values from view

		$tlname = $this -> input -> post('tlname');
		
		
		$query = $this -> lms_user_model -> locationwise_dse($tlname);
		//echo $count_query=count($query);
		
		$query5 = $this -> lms_user_model -> mapwise_dse($tlname);
		//print_r($query);
		//print_r($query5);
		foreach($query as $location_id){
			
			$location = $location_id->location;
			$query2 = $this -> lms_user_model -> locationwise_dse_name($location,$this->process_id);
		}
		if(count(isset($query2))<=0 || $tlname=='')
		{
			?><div id="group_div" class="col-md-12">
				<p style="text-align: center;margin-top: 10px;margin-bottom: 20px;">No Executive Found</p>
			</div>
		<?php	
		}
		else{
		//print_r($query2);
		?><div id="group_div" class="col-md-12">
							<table class="table table-bordered datatable" id="results"> 
					<thead>
						<tr>
							<th>Sr.No</th>
							<th>Check</th>
							<th>DSE Name</th>
							
						</tr>	
					</thead>
					<tbody>
				
					<?php 
					$i=0;
					foreach($query2 as $row)
					{
						$i++;
						$dse_id = $row->id;
						?>
						
						<tr>
						<td><?php echo $i; ?></td>
						
						<td><input type="checkbox" name="dse_name[]" id="dse_name" value="<?php echo $row->id ?>"
						<?php 
					
					foreach($query5 as $fetch)
					{
						
						$map_id = $fetch->dse_id;
						
						if($dse_id==$map_id){
							?>
						checked
						<?php }else{} ?>
						
					<?php } ?>
						>
						
						</td>
						<td> <?php echo $row->fname ?>  <?php echo $row->lname ?> </td>
						
						</tr>
						
					<?php } ?>
					</tbody>
					
					</table>

						</div>
							
							
							<?php
		
		
		
		//redirect('lms_user');
		}
	}
	

	//delete record from the database
	function delete_map_lms() {
		//we are getting the values from the view
		$id = $this -> input -> get('id');

		$q = $this -> lms_user_model -> delete_map_lms($id);

		redirect('lms_user');

	}

	//edit record from the
	function edit_map_lms() {

		// get id from the edit view page
		$id1 = $this -> input -> get('id1');

		$query1 = $this -> lms_user_model -> lms_user_data();
		$data['dse_data'] = $query1;
		$data['tl_data'] = $this -> lms_user_model -> lms2_user_data();
		//here we are  passing the id to edit map lms
		$data['edit_map_data'] = $this -> lms_user_model -> edit_map_lms($id1);
		;

		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_map_lms_view.php', $data);
		$this -> load -> view('include/footer.php');

	}

	function update_map_lms() {

		$id2 = $this -> input -> post('id1');
		$tlname = $this -> input -> post('tlname');
		$dsename = $this -> input -> post('dsename');

		$query = $this -> lms_user_model -> update_map_lms($tlname, $dsename, $id2);

		redirect('lms_user');
	}
	
	public function searchlocation()
	{ 
		$data['all_data'] = $this -> lms_user_model -> select_lms();
		//$data['select_location']=$query1;
		$this -> load -> view('lms_user_filter_view.php',$data);
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Add_rights_report extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_rights_report_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {   
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();
		$data['select_location'] = $this -> add_rights_report_model -> select_location();
		$data['var'] = site_url('add_rights_report/insert_rights_report');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_rights_report_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function checkRights() {
		$this -> session();
		$data['username']=$username= $this -> input -> post('username');
		$data['select_right_data'] =$q= $this -> add_rights_report_model -> checkRights();
		$data['copy_user_rights'] = $this -> add_rights_report_model -> copy_user_rights();
	
	
		if(count($q)>0)
		{
			
			$this -> load -> view('edit_check_rights_report_view.php', $data); 
		}
		else
		{
			$this -> load -> view('add_check_rights_report_view.php', $data);
		}
		
	}
	
	public function insert_rights_report() {
		$this -> add_rights_report_model -> insert_rights_report();
		redirect('add_rights_report');
	}

	
	public function checkUser() {
		$q=$this -> add_rights_report_model -> checkUser(); 
	
		?>
		<div  id="userrr">
		<div class="col-md-4 col-sm-4 col-xs-12">
												<select class="filter_s col-md-12 col-xs-12 form-control" id="username" name="username" required>
											<option value=""> Please Select </option>
											<?php 
											foreach ($q as $fetch) {
											
														?>	
											<option value="<?php echo $fetch -> id; ?>"><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></option>
                                            <?php
													
												 } ?>
                                         </select>
                                         </div>
                                         </div>
		<?php
		
		
		
	}
	public function cpyright() {
		$this -> session();
		$data['username']=$username= $this -> input -> post('username');
		
		$data['select_right_data'] =$q= $this -> add_rights_report_model -> cpyRights();
		//print_r($q);
		
		$this -> load -> view('edit_check_rights_report_view.php', $data);
		
	}
	
	
	/*public function delete_rights() {
		$this -> add_rights_model -> delete_rights(); 
		redirect('add_right');
	}

	public function delete_all_rights($id) {
		$this -> add_rights_model -> delete_all_rights($id);
		redirect('add_right');
	}*/
	
	
		

	

}

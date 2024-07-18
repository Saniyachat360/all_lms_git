<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Add_right extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('add_rights_model');
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$this->session();
		$data['select_location'] = $this->add_rights_model->select_location();
		$data['var'] = site_url('add_right/insert_rights');
		$this->load->view('include/admin_header.php');
		$this->load->view('add_rights_view.php', $data);
		$this->load->view('include/footer.php');
	}
	public function checkRights()
	{
		$this->session();
		$data['username'] = $username = $this->input->post('username');
		$data['select_right_data'] = $q = $this->add_rights_model->checkRights();
		$data['copy_user_rights'] = $this->add_rights_model->copy_user_rights();


		if (count($q) > 0) {
			$data['select_right_fin'] = $q = $this->add_rights_model->select_right_fin();
			$this->load->view('edit_check_rights.php', $data);
		} else {
			$this->load->view('add_check_rights_view.php', $data);
		}
	}

	public function insert_rights()
	{
		$this->add_rights_model->insert_right();
		redirect('add_right');
	}


	public function checkUser()
	{
		$q = $this->add_rights_model->checkUser();

?>
		<div id="userrr">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<select class="filter_s col-md-12 col-xs-12 form-control" id="username" name="username" required>
					<option value=""> Please Select </option>
					<?php
					foreach ($q as $fetch) {

					?>
						<option value="<?php echo $fetch->id; ?>"><?php echo $fetch->fname . ' ' . $fetch->lname; ?></option>
					<?php

					} ?>
				</select>
			</div>
		</div>
<?php



	}


	/*public function copyRights() {
		//echo "hi";
		$q = $this -> add_rights_model -> checkRights();
		if (count($q) > 0) {
			$id = $q[0] -> userId;
			$data['userId'] = $id;
			$data['select_right_data'] = $this -> add_rights_model -> select_right_data($id);
			
			$this -> load -> view('master/edit_rights_view.php', $data);
		} else {
			
			$this -> load -> view('master/edit_rights_view.php', $data);
		}

	}*/

	public function cpyright()
	{
		$this->session();
		$data['username'] = $username = $this->input->post('username');

		$data['select_right_data'] = $this->add_rights_model->cpyRights();
		$data['select_right_fin'] = $this->add_rights_model->select_right_fin();
		$data['copy_user_rights'] = $this->add_rights_model->copy_user_rights();
		$this->load->view('edit_check_rights.php', $data);
	}
	/*public function edit_right($id) {
		$this -> session();
		$data['select_right_data'] = $this -> add_rights_model -> select_right_data($id);
		$data['copy_user_rights'] = $this -> add_rights_model -> copy_user_rights();
		
		$data['var'] = site_url('add_right/delete_rights');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_rights.php', $data);
		$this -> load -> view('include/footer.php');
	}*/


	public function delete_rights()
	{
		$this->add_rights_model->delete_rights();
		redirect('add_right');
	}

	public function delete_all_rights($id)
	{
		$this->add_rights_model->delete_all_rights($id);
		redirect('add_right');
	}

	/*public function paging_next() {
		$this -> session();
		$data['select_user'] = $this -> add_rights_model -> select_user();
		$data['select_rights_user'] = $this -> add_rights_model -> select_rights_user();
	//	print_r($data['select_rights_user']);
		$data['select_data'] = $this -> add_rights_model -> select_data();
		$query2 = $this -> add_rights_model -> select_rightsuser();
		$data['count_data']=count($query2);
		$data['var'] = site_url('add_right/insert_rights');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_rights_view.php', $data);
		$this -> load -> view('include/footer.php');

	}*/
	public function complaint()
	{
		$this->session();
		$data['select_location'] = $this->add_rights_model->select_location();
		$data['var'] = site_url('add_right/insert_rights_complaint');
		$this->load->view('include/admin_header.php');
		$this->load->view('add_rights_complaint_view.php', $data);
		$this->load->view('include/footer.php');
	}
	public function checkComplaintRights()
	{
		$this->session();
		$data['username'] = $username = $this->input->post('username');
		$data['select_right_data'] = $q = $this->add_rights_model->checkComplaintRights();
		$data['copy_user_rights'] = $this->add_rights_model->copy_user_rights_complaint();


		if (count($q) > 0) {

			$this->load->view('edit_check_rights_complaint_view.php', $data);
		} else {
			$this->load->view('add_check_rights_complaint_view.php', $data);
		}
	}
	public function insert_rights_complaint()
	{
		$this->add_rights_model->insert_rights_complaint();
		redirect('add_right/complaint');
	}
	public function cpyrightComplaint()
	{
		$this->session();
		$data['username'] = $username = $this->input->post('username');

		$data['select_right_data'] = $q = $this->add_rights_model->cpyrightComplaint();

		$this->load->view('edit_check_rights_complaint_view.php', $data);
	}




	//PoC Tracking
	public function pocTrackingRights()
	{
		$this->session();
		$data['select_location'] = $this->add_rights_model->select_location();
		$data['var'] = site_url('add_right/insert_poc_tracking_rights');


		$this->load->view('include/admin_header.php');
		$this->load->view('poc_tracking_rights_view.php', $data);
		$this->load->view('include/footer.php');
	}

	public function checkPOCTrackingRights()
	{

		$this->session();
		$data['username'] = $username = $this->input->post('username');
		$data['select_right_data'] = $q = $this->add_rights_model->poc_tracking_check_rights();
		$data['copy_user_rights'] = $this->add_rights_model->copy_poc_tracking_rights();

		//print_r($q);

		if (count($q) > 0) {

			$this->load->view('edit_poc_tracking_check_rigths_view.php', $data);
		} else {
			$this->load->view('add_poc_tracking_check_rights_view.php', $data);
		}
	}


	public function insert_poc_tracking_rights()
	{
		$this->add_rights_model->insert_poc_tracking_rights();
		redirect('add_right/pocTrackingRights');
	}
	public function cpypocTright()
	{
		$this->session();
		$data['username'] = $username = $this->input->post('username');

		$data['select_right_data'] = $q = $this->add_rights_model->cpypocTRights();
		//print_r($q);

		$this->load->view('edit_poc_tracking_check_rigths_view.php', $data);
	}
	/*******************/
}

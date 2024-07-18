<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All_Accessories_Followup extends CI_Controller {

	public $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Accessories_followup_model');
		date_default_timezone_set('Asia/Kolkata');
		$this->process_name=$_SESSION['process_name'];

	}

	public function index() {
		$data['enq']='Website';
		$data['select_lead'] = $this -> Accessories_followup_model -> select_lead($this->process_name);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('show_accessories_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

}
?>

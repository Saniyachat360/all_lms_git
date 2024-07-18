<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Op_cse_productivity_tracker extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('op_cse_productivity_tracker_model');
		$this -> process_id = $_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function leads() {
		$this -> session();
		
		$from_date= $data['from_date']= $this -> input -> get('from_date');
		$to_date=$data['to_date']= $this -> input -> get('to_date');
		$source=$data['source']=$this -> input -> get('source');
		$cse_id =$data['cse_id']= $this -> input -> get('cse_id');
		$query = $this -> op_cse_productivity_tracker_model -> $source($from_date,$to_date,$cse_id);
		$source_count=$source.'_count';
		$data['select_lead'] = $query;
		$data['count_lead']=$this -> op_cse_productivity_tracker_model -> $source_count($from_date,$to_date,$cse_id);
		$data['id']=$cse_id;
		$enq = $source;
		$data['enq'] = ucwords((str_replace('_', ' ', $enq)));
		$data['tracker_name']='Op_cse_productivity_tracker';
		$this -> load -> view('include/admin_header.php');
		
		$this -> load -> view('report/one_pager_report_leads_view.php', $data);
		$this -> load -> view('include/footer.php');
	
	}
	
	}
?>
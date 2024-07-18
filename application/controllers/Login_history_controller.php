<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_history_controller extends CI_Controller {
	function __construct() {
		parent::__construct();
			$this -> today = date('Y-m-d');
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('login_history_model'));
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}
	public function index() {
		$this -> session();
		
		
		
		$data['users'] = $this -> login_history_model -> users();
			
		$this -> load -> view('include/admin_header');
		$this -> load -> view('login_history_view',$data);
		$this -> load -> view('include/footer');
	}
	public function filter_daily() {
		$this -> session();
	
	$type=$this->input->post('type');

		if ($type =='Daily')
		{
			$sd=$this -> today;
			$ed=$this -> today;
		}
		elseif($type=='Weekly')
		{
		$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;		 
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		    $sd = date("Y-m-d",$monday);
		    $ed = date("Y-m-d",$sunday);
		}
		elseif($type=='Monthly')
		{
		 $sd = date('Y-m-01'); 
		 $ed = date('Y-m-t');	
		}
		elseif($type=='Custom')
		{
			$sd=$this->input->post('from_date');
			$ed=$this->input->post('to_date');
		}
		$data['summery_counts']= $test= $this -> login_history_model -> summery_counts($sd,$ed);
		$data['sd']=$sd;
    	$data['ed']=$ed;
		$this -> load -> view('login_history_filter', $data);
		
	}
	

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('Feedback_status_model');
		$this->load->add_package_path(APPPATH . 'third_party/rabbitmq');
		$this->load->library('rabbitmq');
		$this->load->remove_package_path(APPPATH . 'third_party/rabbitmq');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function a()
	{
		$this->rabbitmq->push('hello_queue', 'Hello World !');
	}
	public function background()
	{
		$this->load->library('backgroundProcess');
		$this->backgroundprocess->setCmd("curl -o /www/application/logs/log_background_process.log" . site_url('background/run'));
		//Please don't use "true" argument in a production, This will fill your storage if you not clean all the logs.
	echo	$this->backgroundprocess->start(true);
		$pid = $this->backgroundprocess->getProcessId();
		echo $this->backgroundprocess->get_log_paths();
		//echo $this->background->query;
		echo $pid . "\n";
	}
	public function index() 
	{
		$this->session();
		$query1=$this->Feedback_status_model->select_feedback_status();
		$data['select_feedback_status']=$query1;
		$data['select_process']=$this->Feedback_status_model->select_process();
		$data['var']=site_url('Feedback_status/insert_feedback_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('feedback_status_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	
	
	

	}
?>
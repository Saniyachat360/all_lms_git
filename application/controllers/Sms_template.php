<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sms_template extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('sms_template_model');
		//	$this -> load -> model('calling_task_model');

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}



	public function index() {
		$this -> session();
		
		$data['select_fields'] = $this -> sms_template_model -> select_fields();
		$data['select_templates']=$this-> sms_template_model->select_templates(); 
			$data['sms_type']=$this-> sms_template_model->sms_type(); 
			$data['holiday']=$this-> sms_template_model->holiday();
		$data['var'] = site_url('sms_template/insert_sms_template');
		$this -> load -> view('include/admin_header.php', $data);
		$this -> load -> view('sms_template_view.php');
		$this -> load -> view('include/footer.php');

	}

	public function insert_sms_template() {
		$this -> session();
	
	
		$this -> sms_template_model -> insert_sms_template();
		
		redirect('sms_template');
	}
	public function template_edit($ctype_id) // edit model_id from db 
	
	{
			$data['select_fields'] = $this -> sms_template_model -> select_fields();
		$mod=$data['template_edit']=$this-> sms_template_model->template_edit($ctype_id);
		//print_r($mod);
			$data['sms_type']=$this-> sms_template_model->sms_type(); 
			$data['holiday']=$this-> sms_template_model->holiday();
		$data['var']=site_url('sms_template/update_template'); 
		$this->load->view('include/admin_header.php');
		$this -> load ->view('edit_sms_template_view.php',$data);
		$this->load->view('include/footer.php');

	}
	public function update_template()// update data 
	{
	    $this-> sms_template_model->update_template();
		redirect('sms_template');
	}
	

	public function template_delete($ctype_id) {
		$this -> session();
		//echo $map_id;
		$this -> sms_template_model -> template_delete($ctype_id);
		redirect('sms_template');
	}

	public function template_action($ctype_id) {
		$this -> session();

		$this -> sms_template_model -> template_action($ctype_id);
		redirect('sms_template');
	}

}
?>
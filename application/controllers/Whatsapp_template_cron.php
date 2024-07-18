<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whatsapp_template_cron extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('whatsapp_template_cron_model');
		//	$this -> load -> model('calling_task_model');

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}



	public function index() {
		$this -> session();
		
		$data['select_fields'] = $this -> whatsapp_template_cron_model -> select_fields();
		$data['select_templates']=$this-> whatsapp_template_cron_model->select_templates(); 
		$data['sms_type']=$this-> whatsapp_template_cron_model->sms_type(); 
		$data['holiday']=$this-> whatsapp_template_cron_model->holiday();
		$data['var'] = site_url('whatsapp_template_cron/insert_mail_template');
		$this -> load -> view('include/admin_header.php', $data);
		$this -> load -> view('whatsapp_template_cron_view.php');
		$this -> load -> view('include/footer.php');

	}

	public function insert_mail_template() {
		$this -> session();
		$i=0;
		  $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
		echo	$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		
			echo	$_FILES["product_image"]["size"][$i][$j];
			 if (($_FILES["product_image"]["size"][$i][$j] > 5000000)) { 
			     echo "hi";
       
        	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Please Upload File Less Than 5MB Size ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
redirect('whatsapp_template_cron');

    }					 
   					
		
	}
		$this -> whatsapp_template_cron_model -> insert_mail_template();
		
		redirect('whatsapp_template_cron');
	}
	public function template_edit($ctype_id) // edit model_id from db 
	
	{
			$data['select_fields'] = $this -> whatsapp_template_cron_model -> select_fields();
		$mod=$data['template_edit']=$this-> whatsapp_template_cron_model->template_edit($ctype_id);
			$data['sms_type']=$this-> whatsapp_template_cron_model->sms_type();
			$data['holiday']=$this-> whatsapp_template_cron_model->holiday();
		//print_r($mod);
		$data['var']=site_url('whatsapp_template_cron/update_template'); 
		$this->load->view('include/admin_header.php');
		$this -> load ->view('edit_whatsapp_template_cron_view.php',$data);
		$this->load->view('include/footer.php');

	}
	public function update_template()// update data 
	{
	    	$i=0;
		  $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
			$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($t_id.$_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		
			echo	$_FILES["product_image"]["size"][$i][$j];
			 if (($_FILES["product_image"]["size"][$i][$j] > 5000000)) { 
			     echo "hi";
       
        	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Please Upload File Less Than 5MB Size ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
redirect('whatsapp_template_cron');

    }					 
   					
		
	}
		$this-> whatsapp_template_cron_model->update_template();
		redirect('whatsapp_template_cron');
	}
	

	public function template_delete($ctype_id) {
		$this -> session();
		//echo $map_id;
		$this -> whatsapp_template_cron_model -> template_delete($ctype_id);
		redirect('whatsapp_template_cron');
	}

	public function template_action($ctype_id) {
		$this -> session();

		$this -> whatsapp_template_cron_model -> template_action($ctype_id);
		redirect('whatsapp_template_cron');
	}
	public function delete_attachment($attach_id,$t_id) {
		$this -> session();

		$this -> whatsapp_template_cron_model -> delete_attachment($attach_id);
		redirect('whatsapp_template_cron/template_edit/'.$t_id);
	}

}
?>
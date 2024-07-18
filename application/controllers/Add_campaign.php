<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_campaign extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table','form_validation','session'));
		$this->load->helper(array('form','url'));
				
		$this->load->model('add_campaign_model');
		
		
	}
	
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
		}
 public function index()
{
	
		$this->session();
		
		$query1=$this->add_campaign_model->select_campaign();
		$data['select_campaign']=$query1;

		$query2=$this->add_campaign_model->select_grp();
		$data['select_grp']=$query2;


	$data['var']=site_url('add_campaign/add');
	$this->load->view('include/admin_header.php');
	$this->load->view('add_campaign_view.php',$data);
	$this->load->view('include/footer.php');
	
	
} 	

public function add()

{
	$campaign_name=$this->input->post('campaign_name');
	$group_id=$this->input->post('group_id');
	
	$query=$this->add_campaign_model->add_campaign($campaign_name,$group_id);
	
	
	redirect('add_campaign');

	
}


public function edit_campaign($id)

{
	$this->session();
		
	$query=$this->add_campaign_model->select_campaign_id($id);
	$data['select_campaign_id']=$query;
	
	$query2=$this->add_campaign_model->select_grp();
	$data['select_grp']=$query2;
			
	$data['var']=site_url('add_campaign/update_campaign');
	$this->load->view('include/admin_header.php');
	$this -> load -> view('edit_campaign_view',$data);
	$this -> load -> view('include/footer');

	
}

public function update_campaign()

{
		
	
	$id=$this->input->post('id');
	
	$campaign_name=$this->input->post('campaign_name');
	echo $group_id=$this->input->post('group_id');
	
	
	$q=$this->add_campaign_model->update_campaign($id,$campaign_name,$group_id);
	
	redirect('add_campaign');
	
	
}



public function delete_campaign($id)

{
	
	
	
	//echo $id;
	
	$q=$this->add_campaign_model->delete_campaign($id);
	
	redirect('add_campaign');
	
}
public function test_send2(){
   // Configure email library
	// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("jamil.shaikh50@gmail.com","My subject",$msg);

    				$this->load->helper('path');

    		$this->load->library('encrypt');
    	//	            ini_set("SMTP","ssl://smtp.gmail.com");
$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'mahiroid78@gmail.com',
    'smtp_pass' => 'Mahesh78$',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1'
);
$this->load->library('email', $config);
$this->email->set_newline("\r\n");


         $msg="Hiidgiii";
	  $this->email->from('mahiroid78@gmail.com', 'Mahesh Adhari');
	$this->email->to('jamil.shaikh50@gmail.com');
	$this->email->subject('Your ACTM2021 Login Details');
	$this->email->message($msg);  
    $this->email->send();
   show_error($this->email->print_debugger());
 $msg = "First line of text\nSecond line of text";


}


}
?>
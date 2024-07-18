<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_call_center_tl extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('add_call_center_tl_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->add_call_center_tl_model->select_tl();
		$data['select_cse_tl']=$query1;
		
		$query2=$this->add_call_center_tl_model->select_table_tl();
		//print_r ($query2);
		$data['select_table_tl']=$query2;
		
		$data['var']=site_url('add_call_center_tl/insert_tl');
		$this->load->view('include/admin_headero.php');
		$this -> load -> view('add_call_center_tl_view.php',$data);
		$this->load->view('include/footer.php');
		
	
	}
	public function insert_tl()
	{
		
		$call_center_tl_id=$this->input->post('call_center_tl_id');
		
		$this->add_call_center_tl_model->insert_tl($call_center_tl_id);
		redirect('add_call_center_tl');
		
	}
	public function auto_assign()
	{
	    $this->session();
		$data['select_count']=$this->add_call_center_tl_model->select_count();
	    $data['select_user']=$this->add_call_center_tl_model->select_user();
		$data['lead_source']=$this->add_call_center_tl_model->lead_source();
		$query2=$this->add_call_center_tl_model->select_table_data();
	//	print_r ($query2);
		$data['select_table_data']=$query2;
		
		$data['var']=site_url('add_call_center_tl/insert_auto_assign');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_auto_assign_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function check_lead_source()
	{
	    $q=$this->add_call_center_tl_model->check_lead_source();
	   // print_r($q);
	    	$lead_source=$this->add_call_center_tl_model->lead_source();
	    	?>
	    	     <div class="form-group"  >
                                        
											 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lead Source</label>
                                            
											<div class="col-md-9 col-sm-9 col-xs-12" style='height:500px;overflow-x:scroll'>
												
												
											<?php $i=0; 
											
											foreach($lead_source as $row) {
											    $checked='';
												$i++;
												foreach($q as $row1){
													if($row1->lead_source_id==$row->id)
													{
													  //  echo "hi";
													   $checked="checked";
													    break;
													}
													}
												?>
											
													<input id="<?php echo 'a-'.$i;?>" class="finance" type="checkbox"
													<?php ?>
													name="lead_source[]" value="<?php echo $row->id ;?>" <?php echo $checked;?>> 
													<?php echo $row->lead_source_name ;?><br>
											<?php 
										
											}?>
											</div>
											</div>
	    	<?php
	}
		public function insert_auto_assign()
	{
		
	
		
		$this->add_call_center_tl_model->insert_auto_assign();
		redirect('add_call_center_tl/auto_assign');
		
	}
	public function auto_assign_lead($enq_id=null,$process_id=null,$lead_source_id=null)

    {
        if(isset($enq_id) && isset($process_id) && isset($lead_source_id))
        {
            $this->add_call_center_tl_model->auto_assign_lead($enq_id,$process_id,$lead_source_id);
        }
        
    }	
	
	

	}
?>
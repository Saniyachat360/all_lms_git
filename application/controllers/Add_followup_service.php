<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_followup_service extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_service_model');
		date_default_timezone_set('Asia/Kolkata');

	}

	public function detail($enq_id,$enq) {
		$data['enq_id']=$enq_id;
		$data['enq']=$enq;
		$data['lead_detail'] =$lead_detail= $this -> Add_followup_service_model -> select_lead($enq_id);
		$data['select_followup_lead']=$this->Add_followup_service_model -> select_followup_lead($enq_id);
		$data['select_model']=$this->Add_followup_service_model->select_model();
		$data['select_feedback_status']=$this->Add_followup_service_model->select_feedback_status();
		$data['select_login_status']=$this->Add_followup_service_model->select_login_status();
		$data['process'] = $this -> Add_followup_service_model -> process();
		$data['get_location1'] = $query1 = $this -> Add_followup_service_model -> select_location();
		if(isset($lead_detail[0])){
			$data['selectNextAction']=$this->Add_followup_service_model->select_next_action($lead_detail[0]->feedbackStatus);
		}
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('Add_followup_service_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function select_next_action()
	{
		$feedbackStatus=$this->input->post('feedbackStatus');
		$selectNextAction=$this->Add_followup_service_model->select_next_action($feedbackStatus);
		?>
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="nextAction"  id="nextaction" class="form-control"  onchange='check_nfd(this.value);' required >
                                					<option value="">Please Select</option>
                                					<?php foreach ($selectNextAction as $row) {?>
														<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
													<?php } ?>
	                                			</select>
                                            </div>
 <?php
	}
	function select_transfer_location()
{
		
		
		
		$tprocess=$this->input->post('tprocess');
	$user_id=$this -> session -> userdata('user_id');
	 $check_user_process12 = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id' and mp.process_id ='$tprocess' ");
									
	
	$check_user_process1=$check_user_process12->result();

		if(($check_user_process12->num_rows())> 0){
			
			
		$get_location1=$this->Add_followup_service_model->select_transfer_location($tprocess); ?>
		
		<div class="form-group">
    	                 <label class="col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required   onchange="select_assign_to()">
                                        <option value="">Please Select </option>  
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                             <?php
		}else{?>
			<div class="form-group" style="display: none">
    	                 <label class="col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control"    onchange="select_assign_to()">
                                        <option value="">Please Select </option>  
								
                       					</select>
                                   </div>
                             </div>
	
		<?php
}
}
	// Select Transfer user name using Transfer Location
public function select_assign_to(){
		$location=$this->input->post('tlocation1');
		$tprocess=$this->input->post('tprocess');
		$select_assign=$this->Add_followup_service_model->lmsuser($location,$tprocess);?>
	<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
                        <select name="transfer_assign" required id="tassignto1" class="form-control"  >
                              <option value="">Please Select </option> 
                              <?php foreach($select_assign as $row){?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . ' ' . $row -> lname; ?> </option> 
							<?php } ?>
                        </select>
				<!--	</div>
				</div>-->

<?php
}
	public function insert_followup()
	{
		$this->Add_followup_service_model -> insert_followup();
		redirect('website_leads/telecaller_leads');
	}

}
?>

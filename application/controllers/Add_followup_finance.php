<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Add_followup_finance extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_finance_model');
		date_default_timezone_set('Asia/Kolkata');

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function detail($enq_id,$enq) {
		$this->session();
		$data['enq_id']=$enq_id;
		$data['enq']=$enq;
		$data['lead_detail'] =$lead_detail= $this -> Add_followup_finance_model -> select_lead($enq_id);
		$data['select_followup_lead']=$this->Add_followup_finance_model -> select_followup_lead($enq_id);
		$data['select_model']=$this->Add_followup_finance_model->select_model();
		$data['process'] = $this -> Add_followup_finance_model -> process();
		$data['get_location1'] = $query1 = $this -> Add_followup_finance_model -> select_location();
		$data['select_feedback_status']=$this->Add_followup_finance_model->select_feedback_status();
		$data['select_login_status']=$this->Add_followup_finance_model->select_login_status();
		if(isset($lead_detail[0])){
			$data['selectNextAction']=$this->Add_followup_finance_model->select_next_action($lead_detail[0]->feedbackStatus);
		}
			$data['select_loan_type']=$this->Add_followup_finance_model->select_loan_type();
			$data['reject_reason']=$this->Add_followup_finance_model->reject_reason();
			$data['emp_type']=$this->Add_followup_finance_model->emp_type();
			$data['bank']=$this->Add_followup_finance_model->bank();
			$data['prof_type']=$this->Add_followup_finance_model->prof_type();
			$data['docs_history']=$this->Add_followup_finance_model->docs_history($enq_id);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('Add_followup_finance_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	
	
	public function select_next_action()
	{
		$feedbackStatus=$this->input->post('feedbackStatus');
		$selectNextAction=$this->Add_followup_finance_model->select_next_action($feedbackStatus);
		?>
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="nextAction"  id="nextAction" class="form-control" required onchange='check_nfd(this.value);' >
                                					<option value="">Please Select</option>
                                					<?php foreach ($selectNextAction as $row) {?>
														<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
													<?php } ?>
	                                			</select>
                                            </div>
 <?php
	}
	public function select_reject_reason()
	{
		$loan_status=$this->input->post('loan_status');
		$q=$this->Add_followup_finance_model->select_login_status($loan_status);
		if(count($q)>0){
		    if($q[0]->close_status=='1')
		    {
		        	$reject_reason=$this->Add_followup_finance_model->reject_reason();
		        ?>
		        <div class="form-group" >
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Reject Reason:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                  <select class="form-control" id="reject_reason" name="reject_reason" >
												<option value="">Please Select</option>		
												<?php foreach ($reject_reason as $row) {?>
													<option value="<?php echo $row->r_reason_name;?>"><?php echo $row->r_reason_name;?></option>	
												<?php } ?>
												
												</select>
                                         	</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Reject Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                         		<input type="text"  placeholder="Enter Reject Date"  name='reject_date' id="reject_date"  class="datett form-control"  readonly style="background:white; cursor:default;right: 0 !important;" />
                                         
                                         	</div>
                                      </div>
		        <?php
		    }
		}
		?>
		
 <?php
	}
// Select Transfer user name using Transfer Location
public function select_assign_to(){
		$location=$this->input->post('tlocation1');
		$tprocess=$this->input->post('tprocess');
		$select_assign=$this->Add_followup_finance_model->lmsuser($location,$tprocess);?>
		<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">
                        <select name="transfer_assign" id="tassignto1" class="form-control" required >
                              <option value="">Please Select </option> 
                              <?php foreach($select_assign as $row){?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . ' ' . $row -> lname; ?> </option> 
							<?php } ?>
                        </select>
					</div>
				</div>
<?php
}
function select_transfer_location()
{
	$tprocess=$this->input->post('tprocess');
		$get_location1=$this->Add_followup_finance_model->select_transfer_location($tprocess);?>
		<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required   onchange="select_assign_to()">
                                        <option value="">Please Select </option>  
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
<?php
}
	
	public function insert_followup()
	{
		$this->Add_followup_finance_model -> insert_followup();
		redirect('website_leads/telecaller_leads');
	}
	public function show_docs()
	{
		$loan_id=$this->input->post('loan_id');
		$docs=$this->Add_followup_finance_model->show_docs($loan_id);
		?>
		<input type='hidden' name='doc_count' id='doc_count' value='<?php echo count($docs);?>'>
		 <br>
                  <br>
		 <table class="table table-bordered datatable" id="results"> 
                    	<thead>
                    		<tr>
                    			<th>Sr.No </th>
                          <th>Document Name</th>
                          <th>Document Number</th>
                    			<th>Action</th>		
                    			
                    		</tr>	
                    	</thead>
                    <tbody>
                        <?php $i=0;
	foreach($docs as $row){ $i++;
	     $checked='';
	     $c='';
	     if($row->mandatory=='Yes')
													{
													  //  echo "hi";
													   $checked="checked";
													   $c='required';
													}
	?>
	<tr>
	    <td><?php echo $i;?></td>
	    <td>
	  <input type='checkbox' name='docid-<?php echo $i;?>' id='docid-<?php echo $i;?>' onclick="ad_req('docid-<?php echo $i;?>','docn-<?php echo $i;?>')" class='finance' value='<?php echo $row->document_id;?>' 
	  <?php echo $checked;?> ><?php echo $row->document_name;?>
				</td>
				<td>
	  	<div class="form-group">
	
							<input id="docn-<?php echo $i;?>" class="form-control" placeholder="Enter Document Number" name="docn-<?php echo $i;?>" type="text"  <?php echo $c;?>/>
							
							</div>
				</td>
				 <td>
	  	<div class="form-group">
	
							<input id="doc-<?php echo $i;?>" class="btn btn-info"  name="doc-<?php echo $i;?>" type="file" />
							
							</div>
				</td>
				
				</tr>				    
 <?php
	}?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success" >Submit </button>
                    <script>
                    
function ad_req(doc_id,doc)
{
    
    if(document.getElementById(doc_id).checked==true)
    {
       var theInput = document.getElementById(doc).setAttribute("required","true");
    }
    else
    {
        var theInput = document.getElementById(doc);
       theInput.removeAttribute("required");
		    
    }
    
}
                    </script>
                    <?php
		
	}
		public function insert_document()
	{
	   $enq_id=$this->input->post('booking_id');
		$this->Add_followup_finance_model -> insert_document();
		redirect('add_followup_finance/detail/'.$enq_id.'/All');
	}

}
?>

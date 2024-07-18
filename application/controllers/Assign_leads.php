<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Assign_leads extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('assign_leads_model');
		date_default_timezone_set("Asia/Kolkata");
		$this -> process_id = $_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();	
		//echo $this->time=date("h:i:s A");
		$data['location'] = $this -> assign_leads_model -> location();
		$data['leads'] = $this -> assign_leads_model -> leads();
		$data['all_count'] = $this -> assign_leads_model -> all_count();
		//$data['user_name']=$this->assign_leads_model->select_user();
		$data['var1'] = site_url('assign_leads/assigned1');
		$this -> load -> view('include/admin_header.php');
		if($this->process_id=='1')
		{
		    $this -> load -> view('assign_leads_finance_view.php', $data);
		}else
		{
		 $this -> load -> view('assign_leads_view.php', $data);   
		}
		
		$this -> load -> view('include/footer.php');
	}
    function select_type()
	{
	   $lead_type=$this->input->post('lead_type');
	    if($lead_type==1)
	    {
	        $leads = $this -> assign_leads_model -> leads();
	    	$all_count = $this -> assign_leads_model -> all_count();
	    	?>
	    		<div class="form-group">
                                                               	
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										 Total (<?php  echo $all_count[0] -> acount; ?>)</label>
								</div>
								<?php 	$i=0;	foreach ($leads as $row) {		$i++;	?>
							 <div class="form-group">
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php 
										if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?> (<?php echo $row->wcount; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
									<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
									</div>
								</div>
								<?php } ?>
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($leads);?>" >
	    	<?php
	    }
	    else if($lead_type==2)
	    {
	        $leads = $this -> assign_leads_model -> leads_loan();
	    	$all_count = $this -> assign_leads_model -> all_count_loan();
	    	?>
	    		<div class="form-group">
                                                               	
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										 Total (<?php  echo $all_count[0] -> acount; ?>)</label>
								</div>
								<?php 	$i=0;	foreach ($leads as $row) {		$i++;	?>
							 <div class="form-group">
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php 
										 echo $row->loan_type ;?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php  echo $row->loan_type ;?> (<?php echo $row->wcount; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
									<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
									</div>
								</div>
								<?php } ?>
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($leads);?>" >
	    	<?php
	        
	    }
	    else if($lead_type==3)
	    {
	        $leads = $this -> assign_leads_model -> leads_sublead();
	    	$all_count = $this -> assign_leads_model -> all_count_sublead();
	    	?>
	    		<div class="form-group">
                                                               	
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										 Total (<?php  echo $all_count[0] -> acount; ?>)</label>
								</div>
								<?php 	$i=0;	foreach ($leads as $row) {		$i++;	?>
							 <div class="form-group">
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php 
										 echo $row->enquiry_for ;?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php  echo $row->lead_source.':'.$row->enquiry_for ;?> (<?php echo $row->wcount; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
									<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
									</div>
								</div>
								<?php } ?>
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($leads);?>" >
	    	<?php
	        
	    }
	}
	function select_cse()
	{
		$dse_name=$this->assign_leads_model->select_user();					
		if(count($dse_name)>0)
		{
			?>
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> Assign To</label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<?php
					$i=0;
				foreach($dse_name as $row)
				{
					$i++;
					?>
					<input type="checkbox" id="cse_name" name="cse_name[]" value='<?php echo $row -> id; ?>'>
					<?php echo $row -> fname . " " . $row -> lname; ?>
					<br>
					<?php } ?>
			</div>
			<?php
			}
			else {
			?>
			<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> </label>
			<div class="col-md-9 col-sm-9 col-xs-8">
				No Records Found
			</div>
			<?php
			
			}
	}
    
	function assigned1() {
		$this -> session();
		//$groupWiseCond=$this -> assign_leads_model -> checkUserCountRights();
		if($_SESSION['process_id']==8){
		//$query=$this -> assign_leads_model -> assign_data_evaluation();
		$query=$this -> assign_leads_model -> assign_data_evaluation_data();
		}else{
			$query=$this -> assign_leads_model -> assign_data();
		}
		if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead assigned successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead can not assign successfully ...!</strong>');
			
		}
		redirect('assign_leads');
	}
/* complain function*/
	public function complaint() {
		$this -> session();	
		//echo $this->time=date("h:i:s A");
		$data['location'] = $this -> assign_leads_model -> location();
		$data['leads'] = $this -> assign_leads_model -> complaint_leads();
		$data['all_count'] = $this -> assign_leads_model -> complaint_all_count();
		//$data['user_name']=$this->assign_leads_model->select_user();
		$data['var1'] = site_url('assign_leads/assigned_complaint');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('assign_leads_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
function assigned_complaint() {
		$this -> session();
		
			$query=$this -> assign_leads_model -> assign_data_complaint();
		
		if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead assigned successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead can not assign successfully ...!</strong>');
			
		}
		redirect('assign_leads/complaint');
	}

}
?>
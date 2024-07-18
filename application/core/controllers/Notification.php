<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('new_notification_model_1');	
		$this->load->model('complaint_notification_model');	
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function ajaxsession() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
			
		}
	}
	
	public function index() 
	{
		$this->session();
		
		$data['select_location']=$this->new_notification_model_1->select_location();
		//$data['location_data']=$this->new_notification_model_1->select_all_location_count();
		
		$data['var']=site_url('add_location/insert_location');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('new_notification_view_1.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function all_notification_counts()
	{
		$this->session();
		$location_name = $this -> input -> post('location_name');
			$user = $this -> input -> post('user');
			//echo $_SESSION['role_name'];
		//	echo $user;
		if($user == ''){
			$role_array=array(3,4,8,10,12,14,16);
			if(in_array($_SESSION['role'],$role_array)){
				$user='DSE';
			}
		}
		?>
		<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		
		<?php
		
		if($location_name!='')
		{
			$location_data=$this->new_notification_model_1->location_data($location_name);	
			
			$data['location_data']=$location_data;	
				
			//$location_data=$this->new_notification_model_1->location_wise_data($location_name);		
				if($user==''){
			$data['select_leads']=$this->new_notification_model_1->location_data($location_name);	
					//print_r($data['select_leads']);
					$this -> load -> view('new_notification_manager_view.php',$data);
		
		}else{
			if(!empty($location_data)){
			?>
			<div class="col-md-12">
				
				<!--	<a href="<?php echo site_url();?>notification/send_mail/<?php echo $location_name;?>" class="btn btn-success pull-right">
								Notify GM
				</a>-->
							</div>
							<div class="col-md-12">
							<div class="table-responsive" style='overflow-x: scroll'>
				<table class="table table-bordered datatable" id="table-4">
					<thead>
						<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<?php foreach ($location_data as $row) {?>
							<th><b><?php
								if ($row['fname'] != '') {echo '(' . $row['fname'] . ' '.$row['lname'] . ')';
								}
								?>
								</b>
							</th>
							<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<tr>
					
						<td>1</td>
						<td>Unassigned Leads</td>
						<?php  foreach ($location_data as $row) { ?>
						<td><a target='_blank' href="<?php echo site_url('unassign_leads/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['unassigned_leads']; ?></a>
							
						</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('new_lead/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['new_leads']; ?></a>
						
						</td>
		
						<?php } ?>
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
		
						<td><a target='_blank' href="<?php echo site_url('today_followup/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['call_today']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('pending/telecaller_leads_not_attended/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_new_leads']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('pending/telecaller_leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_followup']; ?></a>
						
		
						<?php } ?>
					</tr>
					<?php if($_SESSION['process_id']==6 ||$_SESSION['process_id']==7  ||$_SESSION['process_id']==8)
					{ 
				if( $_SESSION['process_id']!=8){
					?>
					<tr>
						<td>6</td>
						<td>Home Visits For Today </td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('home_visit/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['home_visit_count']; ?></a>
						
		
						<?php } ?>
					</tr>
					<tr>
						<td>7</td>
						<td>Showroom Visits For Today </td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('showroom_visit/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['showroom_visit_count']; ?></a>
						
		
						<?php } ?>
					</tr>
					<tr>
						<td>8</td>
						<td>Test Drives For Today </td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('test_drive/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['test_drive_count']; ?></a>
						
		
						<?php } ?>
					</tr>
					<tr>
						<td>9</td>
						<td>Evaluations For Today </td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('evaluation/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['evaluation_count']; ?></a>
						
		
						<?php } ?>
					</tr>
					<?php } ?>
					<tr>
						<td>10</td>
						<td>Escalation Level 1</td>		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('unassign_leads/escalation_level1/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['escalation_level_1']; ?></a>
						</td>		
						<?php } ?>
					</tr>
					<tr>
						<td>11</td>
						<td>Escalation Level 2</td>		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('unassign_leads/escalation_level2/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['escalation_level_2']; ?></a>
						</td>		
						<?php } ?>
					</tr>
					<tr>
						<td>12</td>
						<td>Escalation Level 3</td>		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('unassign_leads/escalation_level3/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['escalation_level_3']; ?></a>
						</td>		
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			</div>
			</div>
			<?php
			}else{
				echo "<center>No User Found For Selected Location.</center>";
			}
		}
		}
		else
		{			
			echo "<center>Please Select Location</ceneter>";
		}
				
	}
function send_mail($location_name){
$location_data=$data['location_data']=$this->new_notification_model_1->location_wise_data($location_name);		
$msg=$this->load->view('send_mail_gm.php',$data,TRUE);

$config = Array(       
         
            'mailtype'  => 'html'
          
        );
   $this->load->library('email', $config);
  
$config = array();  
$config['protocol'] = 'smtp';  
$config['smtp_host'] = 'autovita.in';  
 $config['smtp_user'] = 'info@autovista.in';  
$config['smtp_pass'] = 'autovista1@3$';  
$config['smtp_port'] = 25;  
$this->email->initialize($config);  
  
$this->email->set_newline("\r\n");  
    $this->email->from('info@autovista.in', 'Admin');
    $this->email->to('pereira_irwin@autovista.in');
	 $this->email->bcc('snehal@autovista.in');
    $this->email->subject("LMS ".$location_data[0]['location_name']." Dashboard Report");
    $this->email->message($msg);

   $this->email->send();
     
redirect('new_notification');
	}

/****************************************** Complaint Functions *******************************************/
	public function all_notification_complaint_counts()
	{
		$this->session();
		$location_name = $this -> input -> post('location_name');
			$user = $this -> input -> post('user');
			//echo $_SESSION['role_name'];
		//	echo $user;
		if($user == ''){
			$role_array=array(3,4,8,10,12,14,16);
			if(in_array($_SESSION['role'],$role_array)){
				$user='DSE';
			}
		}
		?>
		<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		
		<?php
		
		if($location_name!='')
		{
			$location_data=$this->complaint_notification_model->location_data($location_name);	
			
			$data['location_data']=$location_data;	
				
			//$location_data=$this->new_notification_model_1->location_wise_data($location_name);		
				if($user==''){
			$data['select_leads']=$this->complaint_notification_model->location_data($location_name);	
					?>
					<div class="col-md-12">
				
					<!--<a href="<?php echo site_url();?>notification/send_mail/<?php echo $location_name;?>" class="btn btn-success pull-right">
								Notify GM
					</a>-->
					
							</div>
							<div class="col-md-12">
							<div class="table-responsive" style='overflow-x: scroll'>
				<table class="table table-bordered datatable" id="table-4">
					<thead>
						<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<?php foreach ($location_data as $row) {?>
							<th><b>Count
								</b>
							</th>
							<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<tr>
					
						<td>1</td>
						<td>Unassigned Leads</td>
						<?php  foreach ($location_data as $row) { ?>
						<td><?php echo $row['unassigned_leads']; ?>	</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><?php echo $row['new_leads']; ?></td>
		
						<?php } ?>
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
		
						<td><?php echo $row['call_today']; ?></td>
						
						<?php } ?>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><?php echo $row['pending_new_leads']; ?></td>
						
						<?php } ?>
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><?php echo $row['pending_followup']; ?></td>
		
						<?php } ?>
					</tr>
				
				</tbody>
			</table>
			</div>
			</div>
		<?php
		}else{
			if(!empty($location_data)){
			?>
			<div class="col-md-12">
				
			<!--		<a href="<?php echo site_url();?>notification/send_mail/<?php echo $location_name;?>" class="btn btn-success pull-right">
								Notify GM
				</a>-->
							</div>
							<div class="col-md-12">
							<div class="table-responsive" style='overflow-x: scroll'>
				<table class="table table-bordered datatable" id="table-4">
					<thead>
						<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<?php foreach ($location_data as $row) {?>
							<th><b><?php
								if ($row['fname'] != '') {echo '(' . $row['fname'] . ' '.$row['lname'] . ')';
								}
								?>
								</b>
							</th>
							<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<tr>
					
						<td>1</td>
						<td>Unassigned Leads</td>
						<?php  foreach ($location_data as $row) { ?>
						<td><a target='_blank' href="<?php echo site_url('unassign_leads/complaint/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['unassigned_leads']; ?></a>
							
						</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('new_lead/complaint/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['new_leads']; ?></a>
						
						</td>
		
						<?php } ?>
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
		
						<td><a target='_blank' href="<?php echo site_url('today_followup/complaint/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['call_today']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('pending/complaint_not_attended/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_new_leads']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a target='_blank' href="<?php echo site_url('pending/complaint_attended/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_followup']; ?></a>
						
		
						<?php } ?>
					</tr>
				
				</tbody>
			</table>
			</div>
			</div>
			<?php
			}else{
				echo "<center>No User Found For Selected Location.</center>";
			}
		}
		}
		else
		{			
			echo "<center>Please Select Location</ceneter>";
		}
				
	}
/**********************************************************************************************************/
}
?>
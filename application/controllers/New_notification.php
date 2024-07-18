<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_notification extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('new_notification_model');	
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->new_notification_model->select_location();
		
		$data['select_location']=$query1;
		
		$data['var']=site_url('add_location/insert_location');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('new_notification_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function all_notification_counts()
	{
		$location_name = $this -> input -> post('location_name');
		?>
		<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
	
		<?php
		if($location_name!='')
		{
			$location_data=$this->new_notification_model->location_data($location_name);	
			//$location_data=$this->new_notification_model->location_wise_data($location_name);		
				
			if(!empty($location_data)){
			?>
			<div class="col-md-12">
					<a href="<?php echo site_url();?>new_notification/send_mail/<?php echo $location_name;?>" class="btn btn-success pull-right">
								Notify GM
							</a>
				<table class="table table-bordered datatable" id="table-4">
					<thead>
						<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<?php foreach ($location_data as $row) {?>
							<th><b>Count <?php
								if ($row['fname'] != '') {echo '(' . $row['fname'] . ')';
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
						<td><a href="<?php echo site_url('unassign_leads/leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['unassigned_leads']; ?></a>
							
						</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a href="<?php echo site_url('new_lead/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['new_leads']; ?></a>
						
						</td>
		
						<?php } ?>
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
		
						<td><a  href="<?php echo site_url('today_followup/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['call_today']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a  href="<?php echo site_url('pending/telecaller_leads_not_attended/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_new_leads']; ?></a>
						
						<?php } ?>
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a  href="<?php echo site_url('pending/telecaller_leads/?id='.$row['id'].'&role='.$row['role']);?>"><?php echo $row['pending_followup']; ?></a>
						
		
						<?php } ?>
					</tr>
				</tbody>
			</table>
			</div>
			<?php
			}else{
				echo "<center>No User Found For Selected Location.</center>";
			}
		}
		else
		{			
			echo "<center>Please Select Location</ceneter>";
		}
				
	}
function send_mail($location_name){
$location_data=$data['location_data']=$this->new_notification_model->location_wise_data($location_name);		
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


}
?>
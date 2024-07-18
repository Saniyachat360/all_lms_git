<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_history extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('notification_history_model','add_location_model'));
	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}
	public function index() 
	{
		$this->session();
		$query1=$this->add_location_model->select_location();
		$data['select_location']=$query1;
		$data['var']=site_url('add_location/insert_location');
		$this->load->view('include/admin_header1.php');
		$this -> load -> view('add_location_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function all_notifications()
	{
		/*$data['select_product'] = $this -> notification_model -> select_notifications();
		//$data['var'] = site_url('add_collateral_type');
		$this -> load -> view('include/headerdemo.php', $data);
		$this -> load -> view('master/collateral_type_view.php');
		$this -> load -> view('include/footerdemo.php');*/
	}
	public function change_status_and_redirect()
	{
		$this->notification_model->change_status_and_redirect();

	}
	public function remove_old_notification()
	{
		$this ->notification_model ->remove_old_notification();
	}


	public function view_more_notification()
	{
		$limit_from=$this->input->post('limit_from');
		$limit_count=$this->input->post('limit_count');
		$this->view_more_notificationdiv($limit_from,$limit_count);
	}
	public function view_more_notificationdiv($limit_from,$limit_count)
	{
		$user_id=$this->session->userdata('user_id');
		$q=$this->db->query("select * from tbl_notifications where notification_status !='2' and user_id='$user_id' and process_id='$process_id'   order by notification_id desc limit $limit_from")->result();					
					$qcount=count($q);
							
		$q1=$this->db->query("select count(notification_id) as ncount from tbl_notifications where notification_status ='-1' and user_id='$user_id' and process_id='$process_id'  ")->result();
		
		 ?>
		 <?php if($q1[0]->ncount!='0')
						{ ?>
								<p style='padding-left: 10px;   border-bottom: 1px solid #ced4da;    padding-bottom: 4px;    margin-bottom: 5px;'>You have <?php echo $q1[0]->ncount;?> new notifications</p><?php } ?>
							<?php $n=0; foreach($q as $nrow)
								{ $n++; ?>
                           <a href="#" onclick="change_status_and_redirect('<?php echo $nrow->notification_id?>','<?php echo $nrow->notification_url?>')" class="dropdown-item check_a" style='<?php if($n!=1){ ?>border-top: 1px solid #ced4da;<?php }?>	<?php if($nrow->notification_status =='-1')
                           	{
                           		?> background-color:#0089ff2e; <?php
                           	}?>
                            '
                            >
                           	<i class="entypo-dot" style="font-size: 18px;"></i> <?php echo $nrow->notification_name;?><br>
<span style="  font-size: 11px;    float: right;    color: #999999;padding-top: 3px;"> <?php echo date("d M", strtotime($nrow->notification_created_date));?> <?php echo date("h:i A", strtotime($nrow->notification_created_time));?></span></a>						
						<?php }

if($qcount==$limit_count)
{
?>
<p style='padding-left: 10px;
    border-top: 1px solid #ced4da;    margin-top: 13px;    margin-bottom: 0px;'><a  href='#' style='float: right;
    padding-right: 15px;padding: 7px;' onclick="view_more_notification('<?php echo $limit_from + $limit_from;?>','<?php echo $limit_count;?>')">View More</a></p>
<?php
} 
						 ?>

<script>
		$(document).ready(function() {          
            var v = document.getElementById("cdrop"); 
            v.className += " open"; 
        });			
    </script>  
<?php
	}
	public function calling_task_pending_notification()
	{
		$this ->notification_model ->calling_task_pending_notification();
		$this->notificationdiv();
	}
public function get_pending_notification()
	{
		 $time = date('h:i A');	
		$time1 = strtotime($time);
		  $startTime = date("h:i A", strtotime('-30 minutes', $time1));
		 $endTime = date("h:i A", strtotime('+30 minutes', $time1));
		//echo "<br>";
		 $s=substr($startTime,0, 1);
		if($s=='0')
		{
			$startTime =substr($startTime, 1);
		}
		 $s1=substr($endTime,0, 1);
		if($s1=='0')
		{
			$endTime =substr($endTime, 1);
		}

		$leads_count = $this -> notification_model -> notification_leads_count($startTime,$endTime);
		 $l_count= $leads_count[0]->count_lead ;
		if($l_count >0)
		{
			$notification_name=$l_count." New followup in queue";
			$notification_url='calling_task/todays_calls?startTime='.$startTime.'&endTime='.$endTime;
			$this->notification_model->insert_notification($notification_name,$notification_url);			
		}
		$this->notificationdiv();
	}
	public function notificationdiv()
	{

	?>
		<li class="nav-item dropdown" id='notificationsdiv'>
          	<?php 
          		$user_id=$this->session->userdata('user_id');
          		$limit_count='10';
          		$limit_from='10';
          	$q=$this->db->query('select * from tbl_notifications where notification_status !="2" and user_id="'.$user_id.'" order by notification_id desc limit 10')->result();
					$q1=$this->db->query('select count(notification_id) as ncount from tbl_notifications where notification_status ="-1" and user_id="'.$user_id.'"')->result();
					$qcount=count($q);
					if(count($q)>0){?>
						<a class="nav-link" data-toggle="dropdown" href="#"> <i class="fa fa-bell " aria-hidden="true" style="font-size: 20px;color: #3c8dbc; "></i>	
						<?php if($q1[0]->ncount!='0')
						{ ?>
						 <span class="label label-warning" style="position: absolute; top: 1px; right: 11px; background-color: red; padding-right: 2px;
    padding-left: 2px;    font-size: 10px;    color: #fff;  border-radius: 4px;"><?php echo $q1[0]->ncount;?></span>
<?php } ?>
						   </a>
						    <div id='viewmorediv'>
						<div class="dropdown-menu lg dropdown-menu-right " style='width: 300px; overflow-y: scroll;'>
							<?php if($q1[0]->ncount!='0')
						{ ?>
								<p style='padding-left: 10px;   border-bottom: 1px solid #ced4da;    padding-bottom: 4px;    margin-bottom: 5px;'>You have <?php echo $q1[0]->ncount;?> new notifications</p><?php } ?>
								<?php $n=0; foreach($q as $nrow)
								{$n++;?>
                           <a href="#" onclick="change_status_and_redirect('<?php echo $nrow->notification_id?>','<?php echo $nrow->notification_url?>')" class="dropdown-item" style='<?php if($n!=1){ ?>border-top: 1px solid #ced4da;<?php }?>
                           	<?php if($nrow->notification_status =='-1')
                           	{
                           		?>background-color:#0089ff2e; <?php
                           	}?>
                            '>
                           	<i class="far fa-circle nav-icon"></i> <?php echo $nrow->notification_name;?><br>
<span style="  font-size: 11px;    float: right;    color: #999999;"> <?php echo date("d M", strtotime($nrow->notification_created_date));?> <?php echo date("h:i A", strtotime($nrow->notification_created_time));?></span></a>						
						<?php }
						if($qcount==$limit_count)
{
?>
<p style='padding-left: 10px;
    border-top: 1px solid #ced4da;    margin-top: 13px;    margin-bottom: 0px;'><a  href='#' style='float: right;
    padding-right: 15px;' onclick="view_more_notification('<?php echo $limit_from + $limit_from;?>','<?php echo $limit_count;?>')">View More</a></p>
<?php
} ?>
				</div></div>
<?php } ?>
					</li>
	<?php
	}
	


}
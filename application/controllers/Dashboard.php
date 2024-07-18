<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ob_start();
class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url','download'));
		$this -> load -> model('dashboard_model');
		date_default_timezone_set("Asia/Kolkata");
			$this->load->dbutil();
			

	}
	
	

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	function details()
	{
		 
		$data['select_lead']=$this->dashboard_model->tracker_new();
			$data['select_lead_lc']=$this->dashboard_model->tracker_new1();
		/*$name="lms_data.csv";
		force_download($name,$data);*/
		$data['file_name']='LMS Details';
		$this -> load -> view('include/admin_header.php');
		$this->load->view('tracker_list.php',$data);
	}
	public function admin() {
		
		$this -> session();
		/*$month = date('m');
		$year = date('Y');
		$from = $year . "-" . $month . "-" ."01" ;
		$to =  $year. "-" . $month . "-" . "31";
		$from_year = "$year-01-01";
		$to_year = "$year-12-31";
		// All Lead Count Monthly and Yearly
		$data['all_m_live'] = $this -> dashboard_model -> all_y_live($from, $to);
		$data['all_m_postponed'] = $this -> dashboard_model -> all_y_postponed($from, $to);
		$data['all_m_convert'] = $this -> dashboard_model -> all_y_convert($from, $to);
		$data['all_m_lost'] = $this -> dashboard_model -> all_y_lost($from, $to);
		$data['all_y_live'] = $this -> dashboard_model -> all_y_live($from_year, $to_year);
		$data['all_y_postponed'] = $this -> dashboard_model -> all_y_postponed($from_year, $to_year);
		$data['all_y_convert'] = $this -> dashboard_model -> all_y_convert($from_year, $to_year);
		$data['all_y_lost'] = $this -> dashboard_model -> all_y_lost($from_year, $to_year);
		//All Lead count monthly and yearly (lost and converted)
		$data['all_m_lost_lc'] = $this -> dashboard_model -> all_y_lost_lc($from, $to);
		$data['all_m_convert_lc'] = $this -> dashboard_model -> all_y_convert_lc($from, $to);
		$data['all_y_lost_lc'] = $this -> dashboard_model -> all_y_lost_lc($from_year, $to_year);
		$data['all_y_convert_lc'] = $this -> dashboard_model -> all_y_convert_lc($from_year, $to_year);
		//Get new assign leads
		$source='All';
		$data['all_new_lead']=$this -> dashboard_model -> all_new($from_year, $to_year,$source);	
		//Get pending attended leads
		$data['all_pending']=$this ->dashboard_model ->all_pending_attened($from, $to,'All');	
		$data['all_pending_y']=$this ->dashboard_model ->all_pending_attened($from_year, $to_year,'All');	
		//Get pending not attened leads
		$data['all_not_attended_pending']=$this ->dashboard_model ->all_pending_not_attened($from, $to,'All');
		$data['all_not_attended_pending_y']=$this ->dashboard_model ->all_pending_not_attened($from_year, $to_year,'All');
		//Website Lead Count Monthly and Yearly
		$data['web_m'] = $this -> dashboard_model -> web_m($from, $to);
		$data['web_m_live'] = $this -> dashboard_model -> web_m_Live($from, $to);
		$data['web_m_postponed'] = $this -> dashboard_model -> web_m_postponed($from, $to);
		$data['web_m_lost'] = $this -> dashboard_model -> web_m_lost($from, $to);
		$data['web_m_converted'] = $this -> dashboard_model -> web_m_converted($from, $to);
		
		
		$data['web_y'] = $this -> dashboard_model -> web_m($from_year, $to_year);
		$data['web_y_live'] = $this -> dashboard_model -> web_m_Live($from_year, $to_year);
		$data['web_y_postponed'] = $this -> dashboard_model -> web_m_postponed($from_year, $to_year);
		$data['web_y_lost'] = $this -> dashboard_model -> web_m_lost($from_year, $to_year);
		$data['web_y_converted'] = $this -> dashboard_model -> web_m_converted($from_year, $to_year);
		
		//Website Lead count monthly and yearly (lost and converted)
		$data['web_m_lost_lc'] = $this -> dashboard_model -> web_m_lost_lc($from, $to);
		$data['web_m_convert_lc'] = $this -> dashboard_model -> web_m_convert_lc($from, $to);
		$data['web_y_lost_lc'] = $this -> dashboard_model -> web_m_lost_lc($from_year, $to_year);
		$data['web_y_convert_lc'] = $this -> dashboard_model -> web_m_convert_lc($from_year, $to_year);
		//Get new assign leads
		$data['web_new_lead']=$this -> dashboard_model -> all_new($from_year, $to_year,'web');	
		//Get pending attended leads
		$data['web_pending']=$this ->dashboard_model ->all_pending_attened($from, $to,'web');	
		$data['web_pending_y']=$this ->dashboard_model ->all_pending_attened($from_year, $to_year,'web');	
		//Get pending not attened leads
		$data['web_not_attended_pending']=$this ->dashboard_model ->all_pending_not_attened($from, $to,'web');
		$data['web_not_attended_pending_y']=$this ->dashboard_model ->all_pending_not_attened($from_year, $to_year,'web');
		// select CSE Name
		$st=$this->dashboard_model->checkUserCountRights();
		$data['select_cse']=$this->dashboard_model->select_cse($st);
		//Select Group Name
		$data['select_grp']=$this->dashboard_model->select_grp($st);
		//Select Campaign Name
		$data['select_campaign']=$this->dashboard_model->select_campaign1();
		//Select LMS user
		//$data['lmsuser'] = $this -> dashboard_model -> lmsuser();
	*/
		$this -> load -> view('include/admin_header.php');
	//	$this -> load -> view('dashboard_admin_view.php', $data);
	//	$this -> load -> view('include/footer.php');
	}
	public function telecaller() {
		$this -> session();
		/*$month = date('m');
		$year = date('Y');
		$from = $year . "-" . $month . "-" ."01" ;
		$to =  $year. "-" . $month . "-" . "31";
		$from_year = "$year-01-01";
		$to_year = "$year-12-31";
		
		// All Lead Count Monthly and Yearly
		$data['all_m_live'] = $this -> dashboard_model -> all_y_live($from, $to);
		$data['all_m_postponed'] = $this -> dashboard_model -> all_y_postponed($from, $to);
		$data['all_m_convert'] = $this -> dashboard_model -> all_y_convert($from, $to);
		$data['all_m_lost'] = $this -> dashboard_model -> all_y_lost($from, $to);
		$data['all_y_live'] = $this -> dashboard_model -> all_y_live($from_year, $to_year);
		$data['all_y_postponed'] = $this -> dashboard_model -> all_y_postponed($from_year, $to_year);
		$data['all_y_convert'] = $this -> dashboard_model -> all_y_convert($from_year, $to_year);
		$data['all_y_lost'] = $this -> dashboard_model -> all_y_lost($from_year, $to_year);
		//All Lead count monthly and yearly (lost and converted)
		$data['all_m_lost_lc'] = $this -> dashboard_model -> all_y_lost_lc($from, $to);
		$data['all_m_convert_lc'] = $this -> dashboard_model -> all_y_convert_lc($from, $to);
		$data['all_y_lost_lc'] = $this -> dashboard_model -> all_y_lost_lc($from_year, $to_year);
		$data['all_y_convert_lc'] = $this -> dashboard_model -> all_y_convert_lc($from_year, $to_year);
		//Get new assign leads
		$data['all_new_lead']=$this -> dashboard_model -> all_new($from_year, $to_year,'All');	
		//Get pending attended leads
		$data['all_pending']=$this ->dashboard_model ->all_pending_attened($from, $to,'All');	
		$data['all_pending_y']=$this ->dashboard_model ->all_pending_attened($from_year, $to_year,'All');	
		//Get pending not attened leads
		$data['all_not_attended_pending']=$this ->dashboard_model ->all_pending_not_attened($from, $to,'All');
		$data['all_not_attended_pending_y']=$this ->dashboard_model ->all_pending_not_attened($from_year, $to_year,'All');
		
		
	
		$data['select_campaign']=$this->dashboard_model->select_campaign_cse();
	*/
		$this -> load -> view('include/admin_header.php');
		//$this -> load -> view('dashboard_telecaller_view.php', $data);
		//$this -> load -> view('include/footer.php');
	}
	public function select_table()
	{
	$this -> session();
	$month = date('m');
	$year = date('Y');
	$from = $year . "-" . $month . "-" . "01";
	$to = $year . "-" . $month . "-" . "31";
	$from_year = "$year-01-01";
	$to_year = "$year-12-31";
	$campaign_name=$this->input->post('campaign_name');
	$data['campaign_name']='campaign';
	//Get live,Postponed,lost,converted leads
	$data['campaign_m_live']= $this -> dashboard_model -> campaign_m_live($from, $to,$campaign_name);
	$data['campaign_m_lost']= $this -> dashboard_model -> campaign_m_lost($from, $to,$campaign_name);
	$data['campaign_m_postponed']= $this -> dashboard_model -> campaign_m_postponed($from, $to,$campaign_name);
	$data['campaign_m_convert']= $this -> dashboard_model -> campaign_m_convert($from, $to,$campaign_name);
	
	$data['campaign_y_live']=$this -> dashboard_model -> campaign_m_live($from_year, $to_year,$campaign_name);
	$data['campaign_y_lost']=$this -> dashboard_model -> campaign_m_lost($from_year, $to_year,$campaign_name);
	$data['campaign_y_postponed']=$this -> dashboard_model -> campaign_m_postponed($from_year, $to_year,$campaign_name);
	$data['campaign_y_convert']=$this -> dashboard_model -> campaign_m_convert($from_year, $to_year,$campaign_name);
	
	//Get Lead count monthly and yearly (lost and converted)
	$data['campaign_m_lost_lc']= $this -> dashboard_model -> campaign_m_lost_lc($from, $to,$campaign_name);
	$data['campaign_m_convert_lc']= $this -> dashboard_model -> campaign_m_convert_lc($from, $to,$campaign_name);
	$data['campaign_y_lost_lc']=$this -> dashboard_model -> campaign_m_lost_lc($from_year, $to_year,$campaign_name);
	$data['campaign_y_convert_lc']=$this -> dashboard_model -> campaign_m_convert_lc($from_year, $to_year,$campaign_name);
	//Get new assign leads
	$data['campaign_new']=$this -> dashboard_model -> campaign_new($from_year, $to_year,$campaign_name);	
	//Get pending attended leads
	$data['campaign_pending']=$this ->dashboard_model ->campaign_pending_attened($from, $to,$campaign_name);	
	$data['campaign_pending_y']=$this ->dashboard_model ->campaign_pending_attened($from_year, $to_year,$campaign_name);	
	//Get pending not attened leads
	$data['campaign_not_attended_pending']=$this ->dashboard_model ->campaign_pending_not_attened($from, $to,$campaign_name);
	$data['campaign_not_attended_pending_y']=$this ->dashboard_model ->campaign_pending_not_attened($from_year, $to_year,$campaign_name);
	$this->load->view('filter_dashboard_admin_view.php',$data);
	}
	public function select_cse_leads()

	{
		$this -> session();
		$month = date('m');
		$year = date('Y');
		$from = $year . "-" . $month . "-" . "01";
		$to = $year . "-" . $month . "-" . "31";
		$from_year = "$year-01-01";
		$to_year = "$year-12-31";
		$cse_id=$this->input->post('cse_name');
		$data['campaign_name']='CSE';
		$all_leads=$this->input->post('all_leads');
		
		//Get live,Postponed,lost,converted leads
	$data['campaign_m_live']= $this -> dashboard_model -> cse_m_live($from, $to,$cse_id);
	$data['campaign_m_lost']= $this -> dashboard_model -> cse_m_lost($from, $to,$cse_id);
	$data['campaign_m_postponed']= $this -> dashboard_model -> cse_m_postponed($from, $to,$cse_id);
	$data['campaign_m_convert']= $this -> dashboard_model -> cse_m_convert($from, $to,$cse_id);
		
	$data['campaign_y_live']=$this -> dashboard_model -> cse_m_live($from_year, $to_year,$cse_id);
	$data['campaign_y_lost']=$this -> dashboard_model -> cse_m_lost($from_year, $to_year,$cse_id);
	$data['campaign_y_postponed']=$this -> dashboard_model -> cse_m_postponed($from_year, $to_year,$cse_id);
	$data['campaign_y_convert']=$this -> dashboard_model -> cse_m_convert($from_year, $to_year,$cse_id);
	
	//Get Lead count monthly and yearly (lost and converted)
	$data['campaign_m_lost_lc']= $this -> dashboard_model -> cse_m_lost_lc($from, $to,$cse_id);
	$data['campaign_m_convert_lc']= $this -> dashboard_model -> cse_m_convert_lc($from, $to,$cse_id);
	$data['campaign_y_lost_lc']=$this -> dashboard_model -> cse_m_lost_lc($from_year, $to_year,$cse_id);
	$data['campaign_y_convert_lc']=$this -> dashboard_model -> cse_m_convert_lc($from_year, $to_year,$cse_id);
		//Get new assign leads
		$data['campaign_new']=$this -> dashboard_model -> cse_new($from_year, $to_year,$cse_id);	
		//Get pending attended leads
		$data['campaign_pending']=$this ->dashboard_model ->cse_pending_attened($from, $to,$cse_id);	
		$data['campaign_pending_y']=$this ->dashboard_model ->cse_pending_attened($from_year, $to_year,$cse_id);	
		//Get pending not attened leads
		$data['campaign_not_attended_pending']=$this ->dashboard_model ->cse_pending_not_attened($from, $to,$cse_id);
		$data['campaign_not_attended_pending_y']=$this ->dashboard_model ->cse_pending_not_attened($from_year, $to_year,$cse_id);
		$data['campaign_today_followup']=$this ->dashboard_model ->campaign_today_followup($from, $to,$cse_id);
		$this->load->view('filter_dashboard_cse_view.php',$data);
	
			
	}
	
public function team_leader() {
		$this -> session();
		$month = date('m');
		$year = date('Y');
		$from_month = "01" . "-" . $month . "-" . $year;
		$from_month1 = strtotime($from_month);
		$to_month = "31" . "-" . $month . "-" . $year;
		$to_month1 = strtotime($to_month);
		$from_year = "01-01-$year";
		$from_year1 = strtotime($from_year);
		$to_year = "31-12-$year";
		$to_year1 = strtotime($to_year);
		$data['all_m'] = $this -> dashboard_model -> all_m($from_month, $to_month);
		$data['all_m_live'] = $this -> dashboard_model -> all_m_live($from_month, $to_month);
		$data['all_m_postponed'] = $this -> dashboard_model -> all_m_postponed($from_month, $to_month);
		$data['all_m_lost'] = $this -> dashboard_model -> all_m_lost($from_month, $to_month);
		$data['all_m_converted'] = $this -> dashboard_model -> all_m_live($from_month, $to_month);
		$data['all_m_nf'] = $this -> dashboard_model -> all_m_live($from_month, $to_month);

		$data['all_y'] = $this -> dashboard_model -> all_y($from_year, $to_year);
		$data['all_y_live'] = $this -> dashboard_model -> all_y_live($from_year, $to_year);
		$data['all_y_postponed'] = $this -> dashboard_model -> all_y_postponed($from_year, $to_year);
		$data['all_y_lost'] = $this -> dashboard_model -> all_y_lost($from_year, $to_year);
		$data['all_y_converted'] = $this -> dashboard_model -> all_y_converted($from_year, $to_year);
		$data['all_y_nf'] = $this -> dashboard_model -> all_y_nf($from_year, $to_year);

		$data['web_m'] = $this -> dashboard_model -> web_m($from_month, $to_month);
		$data['web_m_live'] = $this -> dashboard_model -> web_m_live($from_month, $to_month);
		$data['web_m_postponed'] = $this -> dashboard_model -> web_m_postponed($from_month, $to_month);
		$data['web_m_lost'] = $this -> dashboard_model -> web_m_lost($from_month, $to_month);
		$data['web_m_converted'] = $this -> dashboard_model -> web_m_converted($from_month, $to_month);
		$data['web_m_nf'] = $this -> dashboard_model -> web_m_nf($from_month, $to_month);


	


		$data['web_y'] = $this -> dashboard_model -> web_y($from_year, $to_year);
		$data['web_y_live'] = $this -> dashboard_model -> web_y_live($from_year, $to_year);
		$data['web_y_postponed'] = $this -> dashboard_model -> web_y_postponed($from_year, $to_year);
		$data['web_y_lost'] = $this -> dashboard_model -> web_y_lost($from_year, $to_year);
		$data['web_y_converted'] = $this -> dashboard_model -> web_y_converted($from_year, $to_year);
		$data['web_y_nf'] = $this -> dashboard_model -> web_y_nf($from_year, $to_year);


	$data['select_cse']=$this->dashboard_model->select_cse();
		$data['select_grp']=$this->dashboard_model->select_grp();
		$data['select_campaign']=$this->dashboard_model->select_campaign1();
		$data['lmsuser'] = $this -> dashboard_model -> lmsuser();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('dashboard_admin_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	
public function telecaller1() {
		$this -> session();
		$month = date('m');
		$year = date('Y');
		echo $from_month = $year. "-" . $month . "-" ."01"  ;
		echo $to_month =  $year. "-" . $month . "-" ."31" ;
		$from_year = "$year-01-01";
		$to_year = "$year-12-31";
		$query = $this -> dashboard_model -> all_y($from_month, $to_month);
		$data['all_m']=$query;
		$data['all_y'] = $this -> dashboard_model -> all_y($from_year, $to_year);
		
		

	
		$query_w= $this -> dashboard_model -> web_m($from_month, $to_month);
			$data['web_m'] =$query_w;
		/*$data['web_m_live'] = $this -> dashboard_model -> web_m_live($from_month, $to_month);
		$data['web_m_postponed'] = $this -> dashboard_model -> web_m_postponed($from_month, $to_month);
		$data['web_m_lost'] = $this -> dashboard_model -> web_m_lost($from_month, $to_month);
		$data['web_m_converted'] = $this -> dashboard_model -> web_m_converted($from_month, $to_month);
		$data['web_m_nf'] = $this -> dashboard_model -> web_m_nf($from_month, $to_month);
		 */

		$data['web_y'] = $this -> dashboard_model -> web_y($from_year, $to_year);
		/*$data['web_y_live'] = $this -> dashboard_model -> web_y_live($from_year, $to_year);
		$data['web_y_postponed'] = $this -> dashboard_model -> web_y_postponed($from_year, $to_year);
		$data['web_y_lost'] = $this -> dashboard_model -> web_y_lost($from_year, $to_year);
		$data['web_y_converted'] = $this -> dashboard_model -> web_y_converted($from_year, $to_year);
		$data['web_y_nf'] = $this -> dashboard_model -> web_y_nf($from_year, $to_year);*/
		
		$data['select_campaign']=$this->dashboard_model->select_campaign();
	
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('dashboard_telecaller_view.php', $data);
		$this -> load -> view('include/footer.php');
	}



	

	function updatetable() {
		$assign_to_telecaller=$this->input->post('assign' );
		$today_followup=$this->dashboard_model->today_followup($assign_to_telecaller);
		$new_lead=$this->dashboard_model->new_lead($assign_to_telecaller);
		$pending_attended=$this->dashboard_model->pending_attended($assign_to_telecaller);		
		$pending_not_attended=$this->dashboard_model->pending_not_attended($assign_to_telecaller);
		
	?>
	<table class="table table-striped table-bordered table-responsive">
                         <tbody>
					<tr>
                           <th>New Leads</th>
                           
                            <th>Todays followup</th>
                         
							<th>Pending (Not Attended)</th>
							   <th>Pending (Attended)</th>
						

                        </tr>
                             <tr>
                            
                              <td><?php
							if (count($new_lead) > 0) {
								echo $new_lead[0] -> newleadcount;
							} else {
								echo "0";
							}
							?></td>
							<td><?php
							if (count($today_followup) > 0) {
								echo $today_followup[0] -> todaycount;
							} else {
								echo "0";
							}
							?></td>
							
							<td><?php
							if (count($pending_not_attended) > 0) {
								echo $pending_not_attended[0] -> p_not_attendedcount;
							} else {
								echo "0";
							}
							?></td>
							<td><?php
							if (count($pending_attended) > 0) {
								echo $pending_attended[0] -> p_attendedcount;
							} else {
								echo "0";
							}
							?></td>
							
                             </tr>
                             
                     
                      
                         </tbody>
                    </table>
	<?php
	}

	function campaign_name_filter()
	{
	$this -> session();
	echo $cname=$this->input->post('campaign_name' );
	$month = date('m');
	$year = date('Y');
	$from_month = $year . "-" . $month . "-" . "01";
	$to_month = $year. "-" . $month . "-" ."31"  ;
	$from_year = "$year-01-01";
	$to_year = "$year-12-31";
	$all_m = $this -> dashboard_model -> all_m_filter($from_month, $to_month,$cname);
	$all_m_filter1 = $this -> dashboard_model -> all_m_filter1($from_month, $to_month,$cname);
	$all_y = $this -> dashboard_model -> all_y_filter($from_year, $to_year,$cname);
	$all_y_filter1 = $this -> dashboard_model -> all_y_filter1($from_year, $to_year,$cname);
	$c=count($all_m_filter1);
	$c1=count($all_y_filter1);
	?>
   <div class="table-responsive">
               <table class="table table-striped table-bordered table-responsive">
                         <tbody>
					<tr>
                           <th></th>
                            <th>Live</th>                           
							<th>Postponed</th>
							 <th>Lost</th>
							<th>Converted</th>
							<th>Not Followed Up</th>
							<th>Total Leads</th>

                        </tr>
                             <tr>
                           
                              <th>MTD</th>
                              
                              <?php if($c > 0)
                              {
                              	?>
                              	<td>
								<?php
								foreach ($all_m_filter1 as $row) {
									if ($row -> status == '2') {
										echo $row -> lcount;
									}
								}
									 ?>
							</td>
							<td>
								<?php
								foreach ($all_m_filter1 as $row) {
									if ($row -> status == '3') {
										echo $row -> lcount;
									}
								}
									 ?></td>
							<td><?php
							foreach ($all_m_filter1 as $row) {
								if ($row -> status == '4') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_m_filter1 as $row) {
								if ($row -> status == '5') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_m_filter1 as $row) {
								if ($row -> status == '1') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_m as $row) {

								echo $row -> lcount;

							}
	 ?>
							 </td>
                              	<?php
								}
								else
								{
                              	?>
                              	<td>
								
							</td>
							<td>
								</td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							 </td>
                              	<?php

								}
							?>
							
							
							
                             </tr>
                              <tr>
                           
                              <th>YTD</th>
                              
                              <?php if($c1 > 0)
                              {
                              	?>
                              	<td>
								<?php
								foreach ($all_y_filter1 as $row) {
									if ($row -> status == '2') {
										echo $row -> lcount;
									}
								}
									 ?>
							</td>
							<td>
								<?php
								foreach ($all_y_filter1 as $row) {
									if ($row -> status == '3') {
										echo $row -> lcount;
									}
								}
									 ?></td>
							<td><?php
							foreach ($all_y_filter1 as $row) {
								if ($row -> status == '4') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_y_filter1 as $row) {
								if ($row -> status == '5') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_y_filter1 as $row) {
								if ($row -> status == '1') {
									echo $row -> lcount;
								}
							}
									 ?></td>
							<td><?php
							foreach ($all_y as $row) {

								echo $row -> lcount;

							}
	 ?>
							 </td>
                              	<?php
								}
								else
								{
                              	?>
                              	<td>
								
							</td>
							<td>
								</td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							 </td>
                              	<?php

								}
							?>
							
							
							
                             </tr>
                   
                      
                         </tbody>
                    </table>
                    
</div>

<?php
}
public function test_header()
{
$this->load->view('include/test_header');
$this->load->view('include/footer');

}
public function data($all_m_live)
{
	$ecount=count($all_m_live);
	 
	for($i=0;$i<=$ecount;$i++)
	{
		echo $all_m_live[$i];
	}
}
	
public function select_campaign()

{
$group_id=$this->input->post('group_id');
//echo $group_id;
$query3=$this->dashboard_model->refresh_campaign($group_id);
?>	
<select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name" onchange="select_leads();" name="campaign_name" required>
	<option value=""> Please Select </option>
		<?php 
			foreach($query3 as $fetch){ ?>
				<option value="<?php echo $fetch -> campaign_name; ?>"><?php echo $fetch -> campaign_name; ?></option>
        <?php } ?>
  </select>
<?php }



	}
?>

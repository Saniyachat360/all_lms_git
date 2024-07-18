<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class add_new_customer extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_new_customer_model');
		
		date_default_timezone_set("Asia/Kolkata");	

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		
		$this->session();
	
		
		$data['select_customer']  = $this -> add_new_customer_model -> select_customer();
		
		
		$data['select_location'] = $this -> add_new_customer_model -> select_location();
		$data['select_process'] = $this -> add_new_customer_model -> select_process();
		//$data['select_lead_source']=$this->add_new_customer_model->select_lead_source();
		//$data['select_user']  = $this -> add_new_customer_model -> select_lms_user($this->process_id);
		
		//print_r($data['select_process']);
		$data['var'] = site_url('add_new_customer/add_customer');
		
		$this -> load -> view('include/admin_header.php');	
		$this -> load -> view('add_new_customer_view.php', $data);
		$this -> load -> view('include/footer.php');

	}

	public function add_customer() {

		$fname = $this -> input -> post('fname');
		$lname = $this -> input -> post('lname');

		$email = $this -> input -> post('email');
		$address = $this -> input -> post('address');
		$assign = $this -> input -> post('assign');

		$pnum = $this -> input -> post('pnum');
		//$location = $this -> input -> post('location');
		$comment = $this -> input -> post('comment');

		$dept = $this -> input -> post('dept');
		//print_r($dept);
		
		$lead_source = $this -> input -> post('lead_source');
		$sub_lead_source = $this -> input -> post('sub_lead_source');
		$process_id = $this -> input -> post('process_id');
		$location = $this -> input -> post('location');
		print_r($lead_source);
		
		if($lead_source=='Web')

{
	$lead_source='';
	
}
if($process_id == 8){
			$query = $this -> add_new_customer_model -> add_customer_evaluation_new($fname, $email, $address, $pnum, $comment, $assign, $dept,$lead_source,$sub_lead_source,$process_id,$location);

}elseif($process_id == 9){
	
			$query = $this -> add_new_customer_model -> add_customer_complaint($fname, $email, $address, $pnum, $comment, $assign, $dept,$lead_source,$process_id,$location);

}else{
		$query = $this -> add_new_customer_model -> add_customer($fname, $email, $address, $pnum, $comment, $assign, $dept,$lead_source,$sub_lead_source,$process_id,$location);
}
	redirect('add_new_customer');
	
	
	}

	public function edit_customer() {

		$id = $this -> input -> get('id');

		//echo $id;

		$query = $this -> add_new_customer_model -> edit_customer($id);
		$data['edit_customer'] = $query;
		$data['select_location'] = $this -> add_new_customer_model -> select_location();
		$data['select_lead_source']=$this->add_new_customer_model->select_lead_source();
		//print_r($query);

		//$query2=$this->add_group_model->select_process();
		//$data['select_process']=$query2;

		$data['var1'] = site_url('add_new_customer/update_grp');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_new_customer_view', $data);
		$this -> load -> view('include/footer');

	}

	public function update_grp() {


		$this -> session();

		$enq_id = $this -> input -> post('enq_id');
		$fname = $this -> input -> post('fname');
		$email = $this -> input -> post('email');
		$pnum = $this -> input -> post('pnum');
		$address = $this -> input -> post('address');
		$location = $this -> input -> post('location');
		 $assign = $this -> input -> post('assign');
		$comment = $this -> input -> post('comment');
		$dept = $this -> input -> post('dept');
		//	print_r($dept);

		$q = $this -> add_new_customer_model -> update_grp($enq_id, $fname, $email, $pnum, $address, $assign, $location, $comment, $dept);

		redirect('add_new_customer');

	}
		function select_cse()
	{
		$process_id=$this->input->post('process_id');
		$location = $this -> input -> post('location');
		$select_user=$this->add_new_customer_model->select_user($location,$process_id);
	
		$select_location = $this -> add_new_customer_model -> select_location1($location);
		?>
		<input type='hidden' name='location' value='<?php echo $select_location[0] -> location; ?>'>
			<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" >Assign To: </label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<select name="assign" id="assign" class="form-control" required >
										
											
							                      <option   value=""> Please Select </option>
							                      <?php
													foreach($select_user as $fetch)
													{
														?>
											<option value="<?php echo $fetch -> id; ?>"><?php echo $fetch -> fname; ?><?php " "?> <?php echo $fetch -> lname; ?></option>
                   	<?php } ?>
                   	</select>
									</div>
								</div>
	
	<?php
	}
/* select lead source as per selected process*/
	function lead_source()
	{
		$lead_source=$this->add_new_customer_model->lead_source();
		$select_location = $this -> add_new_customer_model -> select_location();
		?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" >Lead Source: </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select name="lead_source" id="lead_source" class="form-control" required onchange='select_sub_lead_source()'>
					<option value="">Please Select </option>
					<?php foreach($lead_source as $row){			?>
					<option value="<?php echo $row->lead_source_name;?>"><?php echo $row->lead_source_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<?php
	
	}
public function sub_lead_source()
{
	$sub_lead_source=$this->add_new_customer_model->sub_lead_source();
			$select_location = $this -> add_new_customer_model -> select_location();
		?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" >Sub Lead Source: </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select name="sub_lead_source" id="sub_lead_source" class="form-control" > 
					<option value="">Please Select </option>
					<?php foreach($sub_lead_source as $row){			?>
					<option value="<?php echo $row->sub_lead_source_name;?>"><?php echo $row->sub_lead_source_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
			<?php $data_array=array('3','4','8','10','12','14');
											if(in_array($_SESSION['role'],$data_array)){}else{?>
											<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Location: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="location1" id="location1" class="form-control" required onchange='select_cse()'>
										<option value="">Please Select </option>
										<?php 
										foreach($select_location as $row)
										{
											?>
											<option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
											<?php
										}
										?>
									
									</select>
								</div>
							</div>
		<?php
	}
	
}
	function select_loc()
	{

	$location = $this -> input -> post('location');

	$select_user=$this->add_new_customer_model->select_user($location);
		?>
		
		
									
										<select name="assign" id="assign" class="form-control" required>
										
											
							                      <option   value=""> Please Select </option>
							                      <?php
													foreach($select_user as $fetch)
													{
														?>
											<option value="<?php echo $fetch -> id; ?>"><?php echo $fetch -> fname; ?><?php " "?> <?php echo $fetch -> lname; ?></option>
                   	<?php } ?>
                 </select>
									
								
	
	<?php
	}

	public function del_customer() {

	$this -> session();
	$enq_id = $this -> input -> get('id');

	//echo $enq_id;

	$q = $this -> add_new_customer_model -> del_customer($enq_id);

	redirect('add_new_customer');

	}
	
	
	public function select_contact() {

	//echo "hi";
	
	
	$select_lead = $this -> add_new_customer_model -> select_contact();
	
	if (count($select_lead)>0)
	
	{
	?>
	
	<div id="duplicate" ><div class="table-responsive"  style="overflow-x:auto;">
	<table class="table table-bordered datatable table-responsive" id="table-4"> 
		
				<thead>
					
						<tr>
							
						
							<th><b>Sr No.</b></th>
							<th><b>Lead Source</b></th>
							<th><b>Customer Name</b></th>
							<th><b>Mobile Number</b></th>
							<th><b>Email ID</b></th>
							<th><b>Lead Date</b></th>
							<!--<th><b>Showroom Location</b></th>-->
							
							<th><b>CSE Name</b></th>
							<th><b>CSE Call Date</b></th>
							
							<th><b>CSE Feedback</b></th>
							<th><b>CSE Next Action</b></th>
							<th><b>CSE Remark</b></th>	
							<th><b>CSE NFD</b></th>
							<th><b>CSE TD/HV Date</b></th>
							
							<th><b>Booking within Days</b></th>
							
							<th><b>DSE Name</b></th>
							<th><b>DSE Call Date</b></th>
							
							<th><b>DSE Feedback</b></th>
							<th><b>DSE Next Action</b></th>
							<th><b>DSE Remark</b></th>	
							<th><b>DSE NFD</b></th>
							<th><b>DSE TD/HV Date</b></th>
								
						
							
							<th><b>Buyer Type</b></th>
							<th><b>Model/Variant</b></th>
							<th><b>Exchange Make/Model</b></th>
							<th><b>Manufacturing Year</b></th>
							
						
							
							
					
							</tr>
					
						
						
						
					</thead>
							<tbody>
				
							<?php
					$i=0;
					
					foreach($select_lead as $fetch)
					{
						 $enq_id=$fetch->enq_id;
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
					<td><?php
						if ($fetch -> lead_source == '') {
							echo "Website";
						
						} else {
							echo $fetch -> lead_source;
						}
					?></td>
					<td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?>
                    	<a href="<?php site_url(); ?>search_customer/leads_flow?id=<?php echo $fetch -> enq_id; ?>" target="_blank"> Check Flow </a> 
                    	
                    </td>
                    <td><?php echo $fetch -> email; ?></td>
                     <td><?php echo $fetch -> created_date; ?></td>
                     <!--<td><?php echo $fetch -> location; ?></td>-->
							
							 <!--- CSE Information -->
							<td><?php echo $fetch->cse_fname .' '. $fetch->cse_lname; ?></td>
							<td><?php echo $fetch->cse_call_date ;?></td>
							
							<td><?php echo $fetch->cse_feedbackStatus ;?></td>
							<td><?php echo $fetch->cse_nextaction ;?></td>
							<td><?php echo $fetch->cse_comment ;?></td>
							<td><?php echo $fetch->cse_nfd ;?></td>
							<th><?php echo $fetch->cse_td_hv_date; ?></th>
							
							<td><?php echo $fetch->days60_booking; ?></td>
							
							  <!--- DSE Information -->
 							<td><?php echo $fetch->dse_fname .' '. $fetch->dse_lname; ?></td>
							<td><?php echo $fetch->dse_call_date ;?></td>
							
							<td><?php echo $fetch->dse_feedbackStatus ;?></td>
							<td><?php echo $fetch->dse_nextaction ;?></td>
							<td><?php echo $fetch->dse_comment ;?></td>
							<td><?php echo $fetch->dse_nfd ;?></td>
							<th><?php echo $fetch->dse_td_hv_date; ?></th>
							 <!-- Car Information -->
					
                  	<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			 <td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
                    <td><?php echo $fetch -> manf_year; ?></td>
                
				
				
							
						</tr>	
					<?php }
							$i=count($select_lead);

						/*	foreach($lc_data as $fetch)
							{
							$enq_id=$fetch->enq_id;
							$i++;
 ?>
							<tr>
					<td><?php echo $i; ?></td>
					<td><?php
						if ($fetch -> lead_source == '') {
							echo "Web";
						} elseif ($fetch -> lead_source == 'Facebook') {
							echo $fetch -> enquiry_for;
						} elseif ($fetch -> lead_source == 'Carwale') {
							echo $fetch -> enquiry_for;
						} else {
							echo $fetch -> lead_source;
						}
					?>
						
						</td>
					<td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?>
                    	<a href="<?php site_url(); ?>search_customer/leads_flow?id=<?php echo $fetch -> enq_id; ?>"> Check Flow </a> 
                    </td>
                    <td><?php echo $fetch -> email; ?></td>
                     <td><?php echo $fetch -> created_date; ?></td>
                     <td><?php echo $fetch -> location; ?></td>
							 <!--- CSE Information -->
                    
                      <!--- CSE Information -->
                     
                     	  <?php $query_cse1 = $this -> db -> query("SELECT l.lname as cse_lname,l.fname as cse_fname from request_to_lead_transfer_lc r join lmsuser l on  r.assign_by_id=l.id  where  lead_id='$enq_id' and (role = 3 or role=2)") -> result(); ?> 
                 	<?php if($fetch->transfer_id==0 && ($fetch->role==3 || $fetch->role==2))
					{?>
					<td><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></td>
					<?php }else{ ?>
						<td><?php
						if (isset($query_cse1[0])) { echo $query_cse1[0] -> cse_fname . ' ' . $query_cse1[0] -> cse_lname;
						}
					?></td>
					<?php } ?>
					 <?php $query_cse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate FROM  lead_followup_lc f LEFT JOIN tbl_disposition_status d ON d.disposition_id =f.disposition join request_to_lead_transfer_lc r on r.assign_by_id=f.assign_to  join lmsuser l on  r.assign_by_id=l.id where f.leadid='$enq_id'  and assign_to='$fetch->assign_by_id' and (role = 3 or role=2) ORDER BY f.id DESC  limit 1") -> result(); ?>
                    <?php if($fetch->transfer_id==0 && ($fetch->role==3 || $fetch->role==2) )
					{?>
						<td><?php echo $fetch -> date; ?></td>
						<td><?php echo $fetch -> disposition_name; ?></td>
						<td><?php echo $fetch -> comment; ?></td>
						<td><?php echo $fetch -> nextfollowupdate; ?></td>
						<?php } else{ ?>
                     	<td><?php
							if (count($query_cse) > 0) {echo $query_cse[0] -> date;
							}
 ?></td>
                   		<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> disposition_name;
							}
						?></td>
                    	<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> comment;
							}
						?></td>  
                  	  	<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> nextfollowupdate;
							}
						?></td>
						<?php } ?>	
                     	  <?php $query_dse1 = $this -> db -> query("SELECT l.lname as dse_lname,l.fname as dse_fname from request_to_lead_transfer_lc r join lmsuser l on  r.assign_to_telecaller=l.id  where  lead_id='$enq_id'  order by request_id desc") -> result(); ?> 
                 	<?php if($fetch->transfer_id!=0 && ($fetch->role==4 || $fetch->role==5))
					{?>
					
						<td><?php echo $query_dse1[0] -> dse_fname . ' ' . $query_dse1[0] -> dse_lname; ?></td>
					<?php }else{
							if($fetch->transfer_id==0 && ($fetch->role==4 || $fetch->role==5)){
						?>
						<td><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></td>
						<?php }else{ ?>
						<td></td>
						<?php } } ?>
					 <?php $query_dse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate FROM  lead_followup_lc f  JOIN tbl_disposition_status d ON d.disposition_id =f.disposition  where f.leadid='$enq_id'  and assign_to='$fetch->assign_to_telecaller' ORDER BY f.id DESC  limit 1") -> result(); ?>
                   	<?php if($fetch->transfer_id!=0 && ($fetch->role==4 || $fetch->role==5))
					{?>
                     <td><?php
						if (count($query_dse) > 0) {echo $query_dse[0] -> date;
						}
 ?></td>
                      <td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> disposition_name;
						}
					?></td>
                     
                    
                  	<td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> comment;
						}
					?></td>  
                  	<td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> nextfollowupdate;
						}
					?></td>
					<?php }else
						{
						if($fetch->transfer_id==0 && ($fetch->role==4 || $fetch->role==5)){
					?>
							<td><?php echo $fetch -> date; ?></td>
						<td><?php echo $fetch -> disposition_name; ?></td>
						<td><?php echo $fetch -> comment; ?></td>
						<td><?php echo $fetch -> nextfollowupdate; ?></td>
						<?php }else{ ?> 
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							
							<?php } } ?>		
								
							 <!-- Car Information -->
                  	<td><?php echo $fetch -> status_name; ?></td>
                  	<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			 <td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
                    <td><?php echo $fetch -> manf_year; ?></td>
                    <td><?php echo $fetch -> color; ?></td>
                    <td><?php echo $fetch -> km; ?></td>
					<td><?php echo $fetch -> ownership; ?></td>
					<td><?php echo $fetch -> accidental_claim; ?></td>
				
					<td><?php echo $fetch -> buy_status; ?></td>
							
						</tr>	
						<?php }*/ ?>
						
					
					
						
						<?php
						
						
									$i1=count($select_lead);
									//$i2=count($lc_data);
									//$i=$i1+$i2;
									
					/*		foreach($lost_data as $fetch)
							{
							$enq_id=$fetch->enq_id;
							$i++;
 ?>
							<tr>
					<td><?php echo $i; ?></td>
					<td><?php
						if ($fetch -> lead_source == '') {
							echo "Web";
						} elseif ($fetch -> lead_source == 'Facebook') {
							echo $fetch -> enquiry_for;
						} elseif ($fetch -> lead_source == 'Carwale') {
							echo $fetch -> enquiry_for;
						} else {
							echo $fetch -> lead_source;
						}
					?>
						
						</td>
					<td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?>
                    	<a href="<?php site_url(); ?>search_customer/leads_flow?id=<?php echo $fetch -> enq_id; ?>"> Check Flow </a> 
                    </td>
                    <td><?php echo $fetch -> email; ?></td>
                     <td><?php echo $fetch -> created_date; ?></td>
                     <td><?php echo $fetch -> location; ?></td>
							 <!--- CSE Information -->
                    
                      <!--- CSE Information -->
                     
                     	  <?php $query_cse1 = $this -> db -> query("SELECT l.lname as cse_lname,l.fname as cse_fname from request_to_lead_transfer_lost r join lmsuser l on  r.assign_by_id=l.id  where  lead_id='$enq_id' and (role = 3 or role=2)") -> result(); ?> 
                 	<?php if($fetch->transfer_id==0 && ($fetch->role==3 || $fetch->role==2))
					{?>
					<td><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></td>
					<?php }else{ ?>
						<td><?php
						if (isset($query_cse1[0])) { echo $query_cse1[0] -> cse_fname . ' ' . $query_cse1[0] -> cse_lname;
						}
					?></td>
					<?php } ?>
					 <?php $query_cse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate FROM  lead_followup_lost f LEFT JOIN tbl_disposition_status d ON d.disposition_id =f.disposition join request_to_lead_transfer_lc r on r.assign_by_id=f.assign_to  join lmsuser l on  r.assign_by_id=l.id where f.leadid='$enq_id'  and assign_to='$fetch->assign_by_id' and (role = 3 or role=2) ORDER BY f.id DESC  limit 1") -> result(); ?>
                    <?php if($fetch->transfer_id==0 && ($fetch->role==3 || $fetch->role==2) )
					{?>
						<td><?php echo $fetch -> date; ?></td>
						<td><?php echo $fetch -> disposition_name; ?></td>
						<td><?php echo $fetch -> comment; ?></td>
						<td><?php echo $fetch -> nextfollowupdate; ?></td>
						<?php } else{ ?>
                     	<td><?php
							if (count($query_cse) > 0) {echo $query_cse[0] -> date;
							}
 ?></td>
                   		<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> disposition_name;
							}
						?></td>
                    	<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> comment;
							}
						?></td>  
                  	  	<td><?php
							if (count($query_cse) > 0) { echo $query_cse[0] -> nextfollowupdate;
							}
						?></td>
						<?php } ?>	
                     	  <?php $query_dse1 = $this -> db -> query("SELECT l.lname as dse_lname,l.fname as dse_fname from request_to_lead_transfer_lost r join lmsuser l on  r.assign_to_telecaller=l.id  where  lead_id='$enq_id'  order by request_id desc") -> result(); ?> 
                 	<?php if($fetch->transfer_id!=0 && ($fetch->role==4 || $fetch->role==5))
					{?>
					
						<td><?php echo $query_dse1[0] -> dse_fname . ' ' . $query_dse1[0] -> dse_lname; ?></td>
					<?php }else{
							if($fetch->transfer_id==0 && ($fetch->role==4 || $fetch->role==5)){
						?>
						<td><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></td>
						<?php }else{ ?>
						<td></td>
						<?php } } ?>
					 <?php $query_dse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate FROM  lead_followup_lost f  JOIN tbl_disposition_status d ON d.disposition_id =f.disposition  where f.leadid='$enq_id'  and assign_to='$fetch->assign_to_telecaller' ORDER BY f.id DESC  limit 1") -> result(); ?>
                   	<?php if($fetch->transfer_id!=0 && ($fetch->role==4 || $fetch->role==5))
					{?>
                     <td><?php
						if (count($query_dse) > 0) {echo $query_dse[0] -> date;
						}
 ?></td>
                      <td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> disposition_name;
						}
					?></td>
                     
                    
                  	<td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> comment;
						}
					?></td>  
                  	<td><?php
						if (count($query_dse) > 0) { echo $query_dse[0] -> nextfollowupdate;
						}
					?></td>
					<?php }else
						{
						if($fetch->transfer_id==0 && ($fetch->role==4 || $fetch->role==5)){
					?>
							<td><?php echo $fetch -> date; ?></td>
						<td><?php echo $fetch -> disposition_name; ?></td>
						<td><?php echo $fetch -> comment; ?></td>
						<td><?php echo $fetch -> nextfollowupdate; ?></td>
						<?php }else{ ?> 
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							
							<?php } } ?>		
								
							 <!-- Car Information -->
                  	<td><?php echo $fetch -> status_name; ?></td>
                  	<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			 <td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
                    <td><?php echo $fetch -> manf_year; ?></td>
                    <td><?php echo $fetch -> color; ?></td>
                    <td><?php echo $fetch -> km; ?></td>
					<td><?php echo $fetch -> ownership; ?></td>
					<td><?php echo $fetch -> accidental_claim; ?></td>
				
					<td><?php echo $fetch -> buy_status; ?></td>
							
						</tr>	
						
						
						
						<?php }*/ ?>
							
						
						
						
						
						
						
					</tbody>
					
					</table>
					</div></div>
	
	<?php
	
	}
	
	
	}
	
	

	}
?>

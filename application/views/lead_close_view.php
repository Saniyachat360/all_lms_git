<?php
	$page = $this -> uri -> segment(4);
	if (isset($page)) {
		$page = $page + 1;
	
	} else {
		$page = 0;
	
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_lead);
	//echo $c;
?>
<script>
function show_transfer_button()
{
   var company_id = [];
      // name.push(name1);
       $("input:checkbox[name=company_checkbox]:checked").each(function(){
    company_id.push($(this).val());
  });
       if(company_id !='')
        { 
            document.getElementById("transfer_button").style.display='inline-block';
         }else
         {
           document.getElementById("transfer_button").style.display='none';
         }

}
function update_checked_data()
{
  var company_id = [];     
       $("input:checkbox[name=company_checkbox]:checked").each(function(){
    company_id.push($(this).val());
});
      // alert(company_id);
       document.getElementById('company_id_transfer').value=company_id;
       $("#transfer_modal").modal();
  
}
</script>
<div class="row" id="leaddiv">
	<div id='replacediv'>
		<?php
		$today = date('d-m-Y');	
		?>	<h1 style="text-align:center;">Lost Lead Approval</h1>			
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
		</div>
		
		<!--- Fetch Table Data -->
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('message'); ?>		</div>
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('msg1'); ?>		</div>
		 <div class="row">
		  	<div class="panel panel-primary">
				<div class="panel-body">
					<?php 

					if(isset($_SESSION['view'])){
                  $view=$_SESSION['view'];
                 }
                  if(isset($_SESSION['insert'])){
                  $insert=$_SESSION['insert'];
                  
           ?>  
            
                    <?php  } ?>
					<?php if ($id == '') 
					{
						?>
						<div class="col-md-offset-7 col-md-1">
							<div class="form-group">
								<a class="col-md-12 col-xs-12 btn btn-info" id='transfer_button' href="#" onclick="update_checked_data()" style='display: none;'> Action </a>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<div class="col-md-5 col-xs-12">
									<input type="text"  placeholder="Search Contact"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='contact_no'  required >
								</div>
								<a class="btn btn-success col-md-2 col-xs-12"  onclick="return searchcontact()" ><i class="entypo-search"></i></a>
								<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>
							</div>
						</div>
						<?php 
					} ?>
					<br><br>	
					<div id='searchdiv'>
						<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
										<th>Sr</th>
										<th>Interested In</th>											
										<th>Name</th>
										<th>Contact</th>
										<th>Lead Date</th>
										
										<th>Feedback Status</th>
										<th>Next Action</th>											
										<th>Current User</th>
										<th>Call Date</th>
										<th>N.F.D</th>		
											<th>N.F.T</th>															
										<th>Remark</th>
											
								<th>Action</th>						
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										 	$enq_id=$fetch->enq_id;
										
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
											<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
											<input type="hidden" value="<?php echo $fetch->enquiry_for; ?>" id="select_enq">
											<td><?php echo $i; ?>
												<input type='checkbox' class='checkbox2' id='sr_no_<?php echo $i;?>' name='company_checkbox' value='<?php echo $fetch->enq_id;?>' onclick='show_transfer_button()'>
											</td>
											<td>
												<?php 
												if($fetch->lead_source == '')
												{
												  $lead_source= "Web"; 
												}
								
												else
												{
													 $lead_source=$fetch->lead_source;
												}?>
												<?php echo $lead_source;
												if($fetch->enquiry_for != ''){ echo " (" . $fetch->enquiry_for.")"; } ?>
											</td>
											<td><b>
												
												<?php if($_SESSION['process_id']==5)
												{
													?><a href="<?php echo site_url(); ?>add_followup_accessories/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==4)
												{
													?><a href="<?php echo site_url(); ?>add_followup_service/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
											/*	else if($_SESSION['process_id']=='Insurance')
												{
													?><a href="<?php echo site_url(); ?>add_followup_insurance/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}*/
												else if($_SESSION['process_id']==1)
												{
													?><a href="<?php echo site_url(); ?>add_followup_finance/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==6)
												{
													?><a href="<?php echo site_url(); ?>add_followup_new_car/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==7)
												{
													?><a href="<?php echo site_url(); ?>add_followup_used_car/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==8)
												{
													if($_SESSION['sub_poc_purchase']==2){?>
															<a href="<?php echo site_url(); ?>add_followup_evaluation_tracking/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details">
											
														<?php }else{ ?>
																<a href="<?php echo site_url(); ?>add_followup_evaluation/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details">
											
															<?php } ?>
														<?php
												}
												else
												{
													?><a href="<?php echo site_url(); ?>add_followup/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												?>
												<?php echo $fetch -> name;
																	
													?>
												</a></b>
											</td>
											<td><?php echo $fetch -> contact_no; ?></td>
											<td><?php echo $fetch -> created_date; ?></td>
								<?php	if($_SESSION['role'] ==3 && $enq =='New')
								{
									}
									else
									{?>
								
								<td><?php echo $fetch -> feedbackStatus; ?></td>
								<td><?php echo $fetch -> nextAction; ?></td>
							<?php if($fetch->assign_to_dse!=0){?>
									<td><?php echo $fetch -> dse_fname.' '.$fetch -> dse_lname; ?></td>
								<?php }elseif($fetch->assign_to_dse_tl!=0 && $fetch->assign_to_dse==0){ ?>
									<td><?php echo $fetch -> dsetl_fname.' '.$fetch -> dsetl_lname; ?></td>
									<?php }elseif($fetch->assign_to_dse_tl==0 && $fetch->assign_to_dse==0){ ?>
									<td><?php echo $fetch -> cse_fname.' '.$fetch -> cse_lname; ?></td>
									<?php }else{ ?>
										<td><?php echo $fetch -> csetl_fname.' '.$fetch -> csetl_lname; ?></td>
								<?php } ?>
							
									<?php  if($fetch->dse_followup_id == 0){?>
								<td><?php echo $fetch -> cse_date; ?></td>
								<td><?php echo $fetch -> cse_nfd; ?></td>
									<td><?php echo $fetch -> cse_nftime; ?></td>
								<td><?php $comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
											 ?></td>
											 <?php }else{ ?>
											 	<td><?php echo $fetch -> dse_date; ?></td>
								<td><?php echo $fetch -> dse_nfd; ?></td>
									<td><?php echo $fetch -> dse_nftime; ?></td>
								
								<td><?php $comment = $fetch -> dse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
											 ?></td>
								<?php
								}
											 } ?>
							
								
								 <?php if($view[10]==1){?>
								 <td><a href="<?php echo site_url();?>manager_remark/leads/<?php echo $fetch->enq_id ;?>/<?php echo $enq ;?>">Add Auditor Remark</a></td>
											 <?php } ?>
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php


	

	$url='lead_close/leads/';
	$total_record=$all_count_lead[0]->count_lead;

	

//$lead_cou = $count_lead_dse_lc+$count_lead_dse;
echo 'Total Records :';
echo '<b>' . $total_record . '</b>';
//print_r($count_lead);
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
	$pages = $total_record / 100;
	echo '<b>' . $total_page = ceil($pages) . '</b>';
 ?>
 
    </div>

<div class="col-md-6  form-group">
 
     
	
		
	<?php

			if ($c < 100) {
				$last = $page - 2;
				if ($last != -2) {
					//echo "1";
					echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() .$url."page/".$last."/?id=".$id."&role=".$role.">
<i class='fa fa-angle-left'></i>   Previous   </a>";
					echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() .$url."/?id=".$id."&role=".$role.">First  
<i class='fa fa-angle-right'></i></a>";
					$last1 = $total_page - 2;
					echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() .$url. "page/".$last1."/?id=".$id."&role=".$role.">Last  
<i class='fa fa-angle-right'></i></a>";
				}
			} else if ($page == 0) {
				//echo"2";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() .$url. "page/".$page."/?id=".$id."&role=".$role.">Next  
<i class='fa fa-angle-right'></i></a>";
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url()  .$url."/?id=".$id."&role=".$role.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() .$url."page/".$last1."/?id=".$id."&role=".$role.">Last  
<i class='fa fa-angle-right'></i></a>";
			} else {
				//echo "3";
				$last = $page - 2;
				echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() .$url. "page/".$last."/?id=".$id."&role=".$role.">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() .$url. "page/".$page."/?id=".$id."&role=".$role.">Next  
<i class='fa fa-angle-right'></i></a>";

				echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() .$url. "/?id=".$id."&role=".$role.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() .$url. "page/".$last1."/?id=".$id."&role=".$role.">Last  
<i class='fa fa-angle-right'></i></a>";

			}

			 $page1 = $page + 1;
		?>
		

       <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;" >Page No</label>
         <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
         <input class="col-md-pull-1  col-md-1  btn btn-danger "  style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
        
    	</div>
		</div>
	</div>    
        
        
        <script>
	function go_on_page(){
        
         		var pageno= document.getElementById("pageNo").value;
         		var total_page='<?php echo $total_page;?>';
         		var total_page=parseInt(total_page);
         		if(pageno >total_page){
         			alert('Please Enter Page No. Less Than Total No. of Pages');
         			return false;
         		}else{
         	//	alert(pageno);
         		var pageno1=pageno-2;
         		
         		var id="<?php echo $id ;?>";
         		window.location="<?php echo site_url() . $url ; ?>page/" + pageno1 +"/?id="+id;
         	}
         	
         	}
         </script>
         <script>	
	function searchcontact()
	{
		var contact_no=document.getElementById("contact_no").value;		
		if(contact_no ==''){
			alert("Please enter contact number for search");
			return false;
		}
		var enq="<?php echo $enq2; ?>";
		if(enq == 'All'){
			var s="website_leads/search_contact";
		}else if(enq =='New'){
			var s="new_lead/search_new";
		} else if(enq == 'Today Followup'){
			var s="today_followup/search_today";
		}else if(enq == 'Pending New'){
			var s="pending/search_pending_new";
		}else if(enq == 'Pending Followup'){
			var s="pending/search_pending_followup";
		}
		$.ajax(
			{
				url: "<?php echo site_url();?>"+s,
		type:"POST",
		data:{contact_no:contact_no}, 
	success: function(result){
       $("#searchdiv").html(result)
   } });
	}
	function reset()
	{
		var enq="<?php echo $enq2; ?>";
		if(enq == 'All'){
			var s="website_leads/telecaller_leads";
		}else if(enq =='New'){
			var s="new_lead/leads";
		}else if(enq == 'Today Followup'){
			var s="today_followup/leads";
		}else if(enq == 'Pending New'){
			var s="pending/telecaller_leads_not_attended";
		}else if(enq == 'Pending Followup'){
			var s="pending/telecaller_leads";
		}else if(enq == 'Home Visit Today'){
			var s="home_visit/leads";
		}else if(enq == 'Showroom Visit Today'){
			var s="Showroom_visit/leads";
		}else if(enq == 'Test Drive Today'){
			var s="test_drive/leads";
		}else if(enq == 'Evaluation Today'){
			var s="evaluation/leads";
		}
		window.location="<?php echo site_url()?>"+s;
	}
	
</script>
<script>
	$(document).ready(function() {
		var enq ="<?php echo $enq ; ?>";
		if($("#example").width()>1308){
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
		}else{
				var table = $('#example').DataTable({
				searching:false,
				scrollY : "400px",
				scrollX : false,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
				
			}
	}); 
</script>
        </div>        
        </div>
	<!-- /page content -->
<div id="transfer_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h3>Lead Lost Operation</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
         <form action="<?php echo site_url();?>/lead_close/mass_lead_lost" method="post">
      <div class="modal-body">
      	<div class="row">
				
				 <div class="col-md-12" style="margin-top:20px">
											<div class="panel panel-primary">
						<div class="panel-body">
        <input type="text" id="company_id_transfer" name="company_id_transfer">
       <div class="col-md-6">
					
                      
					   <div class="form-group">
                            <!--label for="field-1" class="control-label">Type</label-->
                           <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;margin-bottom:10px">
                                        	 <input type="radio" value="lost" id="type1"  name="lost_type" onclick='call_status_nfd();'> Lost &nbsp;&nbsp;
							<input type="radio" value="assign" id="type2"  name="lost_type" onclick='call_status_nfd();'> Continue<br>
         
                                          </div>
                                                                             </div>
                                   <div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Follow Up Date & Time:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                               <input type="text"  placeholder="Enter Next Follow Up Date" id="datett" autocomplete="off" name='followupdate'  class="form-control" required  tabindex="7" style="cursor:default;" />
                                           
                                            </div>
                                       
                                                               </div>
                                       
										</div>	
										<br>
                                   <div class="form-group" >
                                    <button type="submit" class="btn btn-info">Submit</button>           
                                </div>
                               </div>
                      <div class="col-md-6">
                           	 <div class="form-group" >
                                   <label for="field-1" class="control-label"> Remark:</label>
                                      
                                                <textarea placeholder="Enter Remark" id='escalation_remark' name='escalation_remark'  class="form-control"  required /></textarea>
                                          
                                </div>
                             
						  </div>
       
       
                  </div></div>
                  </div></div>
      </div>
      <div class="modal-footer">
            <!--button type="submit" class="btn btn-info" >Submit</button-->
      </div>
    </div>

  </div>
</div>
<script>
function call_status_nfd()
{	

var nfdDiv = document.getElementById("nfd");
if(document.getElementById('type1').checked == true)
{
		document.getElementById("datett").disabled = true;
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("datett").disabled = false; 
	}
}
$(document).ready(function() {
		//alert(new Date());
		$('#datett').daterangepicker({
			singleDatePicker : true,
			minDate : new Date(),
			format : 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		});
</script>
<style>
.daterangepicker{
	z-index: 100000;
}
</style>
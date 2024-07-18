<?php
	$page = $this -> uri -> segment(6);
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


<div class="row" id="leaddiv" style="min-height: 700px;">
	<div id='replacediv'>
		<?php
		$today = date('d-m-Y');	
		
			?>	<h1 style="text-align:center;">All Leads</h1>			
			
		
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
		</div>
		
		<!--- Fetch Table Data -->
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('message'); ?>		</div>
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('msg1'); ?>		</div>
		 <div class="row">
		  	<div class="panel panel-primary">
				<div class="panel-body">
				
					<br><br>	
					<div id='searchdiv'>
						<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->						
										<th>Sr</th>
										<th>Process</th>														<th>Name</th>
										<th>Contact</th>
										<th>Lead Date</th>	
										<th>Feedback Status</th>
										<th>Next Action</th>										<!--<th>Current User</th>
										<th>Call Date</th>
										<th>N.F.D.T.</th>	-->
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
											<td><?php echo $i; ?></td>
											<td>
												<?php echo $fetch -> process; ?>
											</td>
											<td><a href="<?php echo site_url();?>sign_up/lms_details/<?php echo $fetch->enq_id;?>/<?php echo $fetch->process;?>" target="_blank"><b><?php echo $fetch -> name;?></b></a></td>
											<td><?php echo $fetch -> contact_no; ?></td>
											<td><?php echo $fetch -> created_date; ?></td>
											<td><?php echo $fetch -> feedbackStatus; ?></td>
											<td><?php echo $fetch -> nextAction; ?></td>
											
										<?php /*if($fetch->assign_to_dse!=0){?>
											<td><?php echo $fetch -> dse_fname.' '.$fetch -> dse_lname; ?></td>
											<?php }elseif($fetch->assign_to_dse_tl!=0 && $fetch->assign_to_dse==0){ ?>
											<td><?php echo $fetch -> dsetl_fname.' '.$fetch -> dsetl_lname; ?></td>
											<?php }elseif($fetch->assign_to_dse_tl==0 && $fetch->assign_to_dse==0){ ?>
											<td><?php echo $fetch -> cse_fname.' '.$fetch -> cse_lname; ?></td>
											<?php }else{ ?>
											<td><?php echo $fetch -> csetl_fname.' '.$fetch -> csetl_lname; ?></td>
											<?php } */?>
							
											<?php  if($fetch->dse_followup_id == 0){?><!--
											<td><?php echo $fetch -> cse_date; ?></td>
											<td><?php echo $fetch -> cse_nfd.' '.$fetch -> cse_nftime; ?></td>
									-->
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
											 <?php }else{ ?><!--
											 	<td><?php echo $fetch -> dse_date; ?></td>
												<td><?php echo $fetch -> dse_nfd.' '.$fetch -> dse_nftime; ?></td>
												-->
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
											
								<?php } ?>
								<?php 	/*$insert =$_SESSION['insert_cross_lead'] ;
										if($insert[1]==1){*/
											?>
						 <td>	<a href="#"  data-toggle="modal" data-target="#modal-6" onclick ="get_modal_data('<?php echo $fetch->enq_id;?>','<?php echo $fetch->process;?>','<?php echo $fetch->cross_lead_escalation_remark;?>')" >Add Escalation</a>
								</td>
								<?php // } ?>
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php


	$url='sign_up/all_lead/'.$id.'/'.$process.'/'.$name;
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
					echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() .$url."page/".$last.">
<i class='fa fa-angle-left'></i>   Previous   </a>";
					echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() .$url.">First  
<i class='fa fa-angle-right'></i></a>";
					$last1 = $total_page - 2;
					echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() .$url. "page/".$last1.">Last  
<i class='fa fa-angle-right'></i></a>";
				}
			} else if ($page == 0) {
				//echo"2";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() .$url. "page/".$page.">Next  
<i class='fa fa-angle-right'></i></a>";
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() .">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() .$url."page/".$last1.">Last  
<i class='fa fa-angle-right'></i></a>";
			} else {
				//echo "3";
				$last = $page - 2;
				echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() .$url. "page/".$last.">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() .$url. "page/".$page.">Next  
<i class='fa fa-angle-right'></i></a>";

				echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() .$url.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() .$url. "page/".$last1.">Last  
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
         		
         		window.location="<?php echo site_url() . $url ; ?>page/" + pageno1;
         	}
         	
         	}
         	function get_modal_data(enq_id,process,escalation_data){
         		document.getElementById('escalation_enq_id').value=enq_id;
         		document.getElementById('escalation_process_id').value=process;
         		if(escalation_data!=''){
         		var esc_data=	'<h4><b>Escalation Details:</b></h4><p>'+escalation_data+'</p>';
         		}else{
         			var esc_data="";
         		}
         			
         		document.getElementById('escalation_data').innerHTML=esc_data;
         		
         	}
         </script>
         <script>	

	function reset()
	{
			var id='<?php echo id;?>';
			var name='<?php echo name;?>';
			var process='<?php echo process;?>';		
			var s="sign_up/dashboard_show_data/"+id+"/"+process+"/"+name;
		
		window.location="<?php echo site_url()?>"+s;
	}
	
</script>

<script>
	$(document).ready(function() {
	
		if($("#example").width()>1308){
		var table = $('#example').DataTable({
	
			searching:false,
				scrollY : "400px",
				scrollX : true,
				scrollY: true,
			
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
	<div class="modal fade" id="modal-6">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Escalation Details</h3> </div>
            <div class="modal-body">
                <div class="row">
				
				 <div class="col-md-12" style="margin-top:20px">
											<div class="panel panel-primary">
						<div class="panel-body">
						<div id="escalation_data"></div>
													<form action="<?php echo site_url();?>sign_up/insert_escalation_detail" method="post">
               <input type="hidden" name="enq_id" id="escalation_enq_id">
                <input type="hidden" name="process_name" id="escalation_process_id">
								 <div class="form-group" >
                                   <label for="field-1" class="control-label">Escalation Remark:</label>
                                      
                                                <textarea placeholder="Enter Remark" id='cross_lead_escalation_remark' name='cross_lead_escalation_remark'  class="form-control"  required /></textarea>
                                          
                                </div>
                                  <div class="form-group" >
                                    <button type="submit" class="btn btn-info">Submit</button>           
                                </div>
                                </form>
				 	</div>
				 	</div>
				 	</div>
				 	</div>
				 	</div>
				 	</div>
				 	</div>
					</div>
					<style>
	table.dataTable tbody th,
table.dataTable tbody td {
    white-space: nowrap;
}
</style>
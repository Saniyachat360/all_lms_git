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
<div class="row" id="leaddiv">
	<div id='replacediv'>
		<?php
		$today = date('d-m-Y');	
		if (strpos($enq, '%23') !== false) 
		{ 	
			$enq1=explode('%23',$enq);	
			$enq2=$enq1[1]; 	
		}
		else {
			$enq2=$enq;
		}	
		$enq2=str_replace('%20', ' ', $enq2);
		if($enq2 =='All')
		{
			?>	<h1 style="text-align:center;">All Complaints</h1>			<?php 
		}
		else
		{
			?><h1 style="text-align:center;"><?php echo $enq2; ?> Complaints</h1>	
			<?php if ($enq == 'Today Followup') {
				
	?>
	<a href="<?php echo site_url('')?>today_followup/complaint?id=<?php echo $id;?>&name=current"  >
    <i class="btn btn-info entypo-doc-text-inv">  Current Followup</i>
 </a>
 <a  href="<?php echo site_url('')?>today_followup/complaint?id=<?php echo $id;?>" >
    <i class="btn btn-primary entypo-doc-text-inv">  Today Followup</i>
 </a>
	
 <?php }
?>  
			
			
			<?php 
		} 
					?>
		
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
		</div>
		
		<!--- Fetch Table Data -->
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('message'); ?>		</div>
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('msg1'); ?>		</div>
		 <div class="row">
		  	<div class="panel panel-primary">
				<div class="panel-body">
				
						<div class="col-md-offset-8 col-md-4">
							<div class="form-group">
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search Contact"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='contact_no'  required >
								</div>
								<a class="btn btn-success col-md-2 col-xs-12"  onclick="return searchcontact()" ><i class="entypo-search"></i></a>
								<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>
							</div>
						</div>
					
					<br><br>	
					<div id='searchdiv'>
						<div class="table-responsive">	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
										<th>Sr</th>		
										<th>Lead Source</th>									
										<th>Name</th>
										<th>Contact</th>
										<th>Complaint Date</th>
										<th>Service Center</th>
										<th>Customer Remark</th>						
										<th>Feedback Status</th>
										<th>Next Action</th>
										<th>Current User</th>
										<th>Call Date</th>
										<th>N.F.D</th>
										<th>N.F.T</th>
										<th>Remark</th>				
											 <?php $view=$_SESSION['view']; if($view[10]==1){?>							
										<th>Action</th>
										<?php } ?>				
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										
										
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
										
											<td><?php echo $i; ?></td>
												<td><?php  if($fetch->lead_source==''){ echo 'Web'; }else{ echo $fetch->lead_source ; } echo '-'.$fetch->business_area; ?></td>						
										<td><b><a href="<?php echo site_url();?>add_followup_complaint/detail/<?php echo $fetch->complaint_id ;?>/<?php echo $enq ;?>"><?php echo $fetch->name; ?></b></td>
										<td><?php echo $fetch->contact_no; ?></td>
										<td><?php echo $fetch->created_date; ?></td>
										<td><?php echo $fetch->service_center; ?></td>
										<td><?php
											$comment = $fetch -> comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
												?></td>								
										
										<td><?php echo $fetch->feedbackStatus; ?></td>
										<td><?php echo $fetch->nextAction; ?></td>
										<td><?php echo $fetch->cse_name; ?></td>
										<td><?php echo $fetch->date; ?></td>
										<td><?php echo $fetch->nextfollowupdate; ?></td>
										<td><?php echo $fetch->nextfollowuptime; ?></td>
										<td><?php
											$comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
												?></td>											
									
								<!--<td><?php /*$comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;*/
											 ?></td>
									-->
							
									 <?php if($view[10]==1){?>
								
								 <td><a href="<?php echo site_url();?>manager_remark/leads/<?php echo $fetch->complaint_id ;?>/<?php echo $enq ;?>">Add Auditor Remark</a></td>
								<?php } ?>		
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php

if($enq =='New'){
	$url='new_lead/complaint/';
	$total_record=$new_count_lead[0]->count_lead;
}else if($enq == 'Pending New'){
	$url='pending/complaint_not_attended/';
	$total_record=$pending_new_count_lead[0]->count_lead;
}else if($enq == 'Pending Followup'){
	$url='pending/complaint_attended/';
	$total_record=$pending_f_count_lead[0]->count_lead;
}else if($enq == 'Today Followup'){
	$url='today_followup/complaint/';
	$total_record=$today_count_lead[0]->count_lead;
}else if($enq == 'Unassigned'){
	$url='unassign_leads/complaint/';
	$total_record=$unassign_count_lead[0]->count_lead;
}

else{
	$url='website_leads/complaint/';
	$total_record=$select_lead_count[0]->lead_count;
}
	

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
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url()  .$url.">First  
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
         		
         	
         		window.location="<?php echo site_url() . $url ; ?>page/" + pageno1 ;
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
			var s="website_leads/search_complaint";
		}else if(enq =='New'){
			var s="new_lead/search_complaint";
		} else if(enq == 'Today Followup'){
			var s="today_followup/search_complaint";
		}else if(enq == 'Pending New'){
			var s="pending/search_complaint_new";
		}else if(enq == 'Pending Followup'){
			var s="pending/search_complaint";
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
			var s="website_leads/complaint";
		}else if(enq =='New'){
			var s="new_lead/complaint";
		}else if(enq == 'Today Followup'){
			var s="today_followup/complaint";
		}else if(enq == 'Pending New'){
			var s="pending/complaint_not_attended";
		}else if(enq == 'Pending Followup'){
			var s="pending/complaint_attended";
		}
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

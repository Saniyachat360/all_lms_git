

<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
echo $c = count($select_table);
		?></script>
<div class="panel panel-primary">

			<div class="panel-body">
				<div class=" col-md-2">
	
	
 <a href="<?php echo site_url();?>add_lms_user/download_data?id=1" target="_blank" class="btn btn-success">Download</a>


	</div>
		
	
<div class="col-md-offset-6 col-md-4">
	<div class="form-group">
							
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search user"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='userName'  required >
	</div>
	
	 
<a class="btn btn-success col-md-2 col-xs-12"  onclick="searchuser()" ><i class="entypo-search"></i></a>
		<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>

	</div>
		
	</div>
	<br><br>		
		<div id="searchuserDiv">
	<div class="table-responsive"  style="overflow-x:auto;">
	<?php 
	 $modify=$_SESSION['modify'];
	 $delete=$_SESSION['delete'];  
	 $form_name=$_SESSION['form_name'];  
	 ?>
	<table id="example"  class="table " style="width:auto;" cellspacing="0">
				<thead> 
					<tr> 
							<th>Sr No.</th>
							<th> Emp Id</th>
							<th> Name</th>
							<th>Email Id</th>	
							<th>Password</th>			
                            <th>Contact</th>		
							<th>Role</th>
								<th>TL Name</th>
							<th>Process</th>
					
							<th>Location</th>
							
							<th>Status</th>
							
							
 </tr>
</thead> 


<tbody>


					 <?php 
					 $i=$offset1;
						foreach($select_table as $fetch) 
						{
							$i++;
						?>

						<tr>
						
						<td>	<?php echo $i;
									?> 		
							</td>
						
						
						<td>
							<?php echo $fetch ->empId;
							?>
							</td>
							<td>
							<?php echo $fetch ->fname.' '.$fetch->lname ;
							?>
							</td>
								
							<td>
							<?php echo $fetch ->email;
							?>
							</td>	
							<td><?php echo $fetch->password;?></td>
							<td>
							<?php echo $fetch ->mobileno;
							?>
							</td>
								<td><?php echo $fetch ->role_name;		?>			</td>
									<td>
							<?php echo $fetch->tl_fname.' '.$fetch->tl_lname;
							?>
							</td>		
							<td>
							<?php echo $fetch->process_name;
							?>
							</td>			
										
							<td>
							<?php echo $fetch ->location;
							?>
							</td>	
									
						
							<td>
							
							
							<?php 
							
							if ($fetch->status == 1) {
											echo 'Active';
										} elseif ($fetch->status == 2) {
											echo 'View Only';

										} elseif($fetch->status==-1) {
											echo 'Deactive';
										} 
							
							
							?>
							
							
							</td>
						   
						</tr>
						 <?php }?>
					</tbody>
 
 </table> 
 
<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php echo 'Total Records :';
  // echo count($count_data);
   echo '<b>'.$total_record =count($count_data).'</b>';
			//foreach ($count_data as $booking) {echo '<b>'.$total_record = $booking -> lmscount.'</b>';
			//}
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
		$pages = ceil($total_record) / 100;
		$total_page = ceil($pages);
		echo '<b>'.$total_page .'</b>';
 ?>
 
    </div>

<div class="col-md-6  form-group">
 
     
		
	<?php	
	
	if ($c < 100) {
	$last = $page - 2;
	if ($last != -2) {
		echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a>";
		echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . "Add_lms_user/paging_next/page1/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
	}
} else if ($page == 0) {
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . "Add_lms_user/paging_next1/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";
	echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
} else {
	$last = $page - 2;
	echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a> ";
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . "Add_lms_user/paging_next1/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";

	echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . "Add_lms_user/paging_next1>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next1/page/$last1>Last  
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
        <script>
         							function go_on_page(){
         		var pageno= document.getElementById("pageNo").value;
				var total_page='<?php echo $total_page ?>';
				//alert(total_page);
         	//alert(pageno);
			if(pageno > total_page){
			alert('Please select page No. less than total page');
			return false;
			}
         		var pageno1=pageno-2;
         		window.location="<?php echo site_url(); ?>Add_lms_user/paging_next1/page/"+pageno1;
         	
         	
         	}
         </script>
<script src="<?php echo base_url();?>assets/js/campaign.js"></script>

<script>	
	function searchuser()
	{
		var userName=document.getElementById("userName").value;		
		$.ajax(
			{
				url: "<?php echo site_url();?>add_lms_user/searchuser1",
		type:"POST",
		data:{userName:userName}, 
		success: function(result){
        $("#searchuserDiv").html(result)
   } });
	}
	function reset()
	{
		window.location="<?php echo site_url('add_lms_user/download_lms_user')?>";
	}
	
</script>


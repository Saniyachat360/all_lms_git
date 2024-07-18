<style>
	th{
		white-space: nowrap;
	}
</style>
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
<div class="table-responsive"  style="overflow-x:auto;">
	<?php 
	 $modify=$_SESSION['modify'];
	 $delete=$_SESSION['delete'];  
	  $form_name=$_SESSION['form_name'];  
	 ?>
	<table id="example"  class="table " style="width:100%;" cellspacing="0">
				<thead> 
					<tr> 
							<th>Sr No.</th>
							<th> Emp Id</th>
							<th> Name</th>
							<th>Email Id</th>				
                            <th>Contact</th>		
								<th>Role</th>
									<th>TL Name</th>
							<th>Process</th>
					
							<th>Location</th>
						
							<th>Status</th>
							<?php if($modify[2]==1 || $delete[2]==1)  {?>
							<th>Action</th>
							<?php }?>
							
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
						
							<td>
							<?php echo $fetch ->mobileno;
							?>
							</td>
								
								<td>
							
							
							<?php echo $fetch ->role_name;
						
							?>
							
							
							</td>
									
										
							<td>
							<?php echo $fetch ->tl_fname.' '.$fetch->tl_lname;
							?>
							</td>		
									
					
							<td>
							<?php echo $fetch ->process_name;
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
												
					
                               
						      <?php if($modify[2]==1 || $delete[2]==1)  {
						    	
									?>
									
							
							<td>
								<?php if($modify[2]==1) {?>
								<a href="<?php echo site_url();?>add_lms_user/edit_user?id=<?php echo $fetch ->id;?>">Edit </a> &nbsp;&nbsp;
								<?php }   ?>
								
							</td>
							
							<?php 
								
							} ?>
						</tr>
						 <?php }?>
					</tbody>
 
 </table> 
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
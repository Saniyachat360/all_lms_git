<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({
			searching: false, 
			scrollY : "400px",
			//scrollX : true,
			//scrollCollapse : true,

			fixedColumns : {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
</script>

<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify'];
		$delete = $_SESSION['delete'];
		$form_name = $_SESSION['form_name'];
		?>
<div class="table-responsive">
<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
					<thead>
						<tr>
						<th>Sr.No</th>
							<th>TL Name</th>
							<th>DSE Name</th>
							<?php if($modify[8]==1 || $delete[8]==1) {?>
							
						<!--	<th>Action</th>-->
						
							<?php } ?>
						</tr>	
					</thead>
					<tbody>
				
					<?php 
					$i=0;
					foreach($all_data as $row)
					{
						$i++;
						?>
						<tr>
						<td><?php echo $i; ?> </td>
						<td> <?php echo $row->tlfname ?> <?php echo $row->tllname ?></td>
							<td> <?php echo $row->fname ?> <?php echo $row->lname ?></td>
							
							
							<?php if($modify[8]==1 || $delete[8]==1) {?>
							<!--<td>
									<?php if($modify[8]==1) {
					?>
								<a href="<?php echo site_url(); ?>lms_user/edit_map_lms?id1=<?php echo $row -> map_id; ?>" >Edit </a> &nbsp;&nbsp;
							<?php }
						if($delete[8]==1) {
					?>
							<a href="<?php echo site_url(); ?>lms_user/delete_map_lms?id=<?php echo $row -> map_id; ?>" onclick="return getConfirmation();"> Delete </a>
							<?php } ?>
						</td>-->
						<?php } ?>	
						</tr>	
					<?php } ?>
					</tbody>
					
					</table>



</div> 





</div>
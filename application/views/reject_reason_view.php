<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	}); 
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert_finance'];
	if($insert[1]==1)
	{?>
	<h1 style="text-align:center; ">Add Reject Reason</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							
								<!--div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Month: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
								<select name="loan_id" class="form-control" required="" >
								    <option value="">Please Select </option>
                         			<?php	for ($m=1; $m<=12; $m++) {
                         			$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                         			?>
											<option value="<?php echo $m;?>"><?php echo $month;?></option>
						            	<?php	} ?>
									
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div-->
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Reject Reason Name: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="scheme_name" required name="scheme_name">
								</div>
							</div>
							
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-4">
							<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>
						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div>
			</div>
		</div>
		</form>
	</div>
<?php } ?>
</div>
<div class="row" >
	<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify_finance'];
		$delete = $_SESSION['delete_finance'];	
		?>
		<div class="table-responsive"  >
			<table id="example"  class="table " style="width: 100%" > 
			<thead>
				<tr>
					<th>Sr No.</th>
				
					<th>Reject Reason</th>
					<?php if($modify[1]==1 || $delete[1]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_login_status as $fetch)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
					
					<td>
						<?php echo $fetch -> r_reason_name; ?>
					</td>
				
						<?php
					if($fetch->status=='-1')
					{
						?>
						<td>
							Deactive
						</td>
						<?php
						
						
					}
					else {
					if($modify[1]==1 || $delete[1]==1)  {
					?>
					<td>
					<?php if($modify[1]==1) {
					?>
					<a href="<?php echo site_url(); ?>reject_reason/edit_l_status/<?php echo $fetch -> r_reason_id; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[1]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>reject_reason/delete_l_status/<?php echo $fetch -> r_reason_id; ?>">Delete </a>
					<?php } ?>
					</td>
					<?php }
					} ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>
<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
    <script>
    
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	var editor_config = {
    height: "150px"
};

CKEDITOR.replace('scheme', editor_config );
	
	 /*CKEDITOR.replace('product_description');
	 CKEDITOR.replace( 'Resolution', {
        height: 100
    } );
	*/
		
  })
</script> 
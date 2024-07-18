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
	if($insert[3]==1)
	{?>
	<h1 style="text-align:center; ">Add Script</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Loan Type: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
								<select name="loan_id" class="form-control" required="" >
								    <option value="">Please Select </option>
                         					<?php foreach ($select_loan_type as $row) {?>
											<option value="<?php echo $row->loan_id;?>"><?php echo $row->loan_name;?></option>
						            	<?php	} ?>
									
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Script: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<textarea type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="script" required name="script"></textarea>
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
					<th>Loan Name</th>
					<th>Script</th>
					<?php if($modify[3]==1 || $delete[3]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_script as $fetch)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
					<td>
						<?php echo $fetch -> loan_name; ?>
					</td>
					<td>
						<?php echo $fetch -> script_desc; ?>
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
					if($modify[3]==1 || $delete[3]==1)  {
					?>
					<td>
					<?php if($modify[3]==1) {
					?>
					<a href="<?php echo site_url(); ?>scripts/edit_script/<?php echo $fetch -> script_id; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[3]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>scripts/delete_script/<?php echo $fetch -> script_id; ?>">Delete </a>
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

CKEDITOR.replace('script', editor_config );
	
	 /*CKEDITOR.replace('product_description');
	 CKEDITOR.replace( 'Resolution', {
        height: 100
    } );
	*/
		
  })
</script> 
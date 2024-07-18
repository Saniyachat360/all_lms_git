<script>
$(document).ready(function() {
		//alert(new Date());
		$('#datett').daterangepicker({
			singleDatePicker : true,
		//	minDate : new Date(),
			format : 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	
		
	});
	</script>
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
	if($insert[0]==1)
	{?>
	<h1 style="text-align:center; ">Add Occassion</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Occassion Name: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text" placeholder="Enter Occassion Name" onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="occassion_name" required name="occassion_name">
								</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Occassion Date: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text" placeholder="Enter Occassion Date"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="datett" required name="occassion_date">
								</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Description: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									 <textarea placeholder="Enter Description" id='description' name='description'  class="form-control"  ></textarea>
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
				
					<th>Occassion Name</th>
					<th>Date</th>
					<th>Description</th>
					<?php if($modify[0]==1 || $delete[0]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_data as $fetch)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
					
					<td><?php echo $fetch -> name; ?></td>
						<td><?php echo $fetch -> date; ?></td>
							<td><?php echo $fetch -> description; ?></td>
				
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
					if($modify[0]==1 || $delete[0]==1)  {
					?>
					<td>
					<?php if($modify[0]==1) {
					?>
					<a href="<?php echo site_url(); ?>holiday/edit_data/<?php echo $fetch -> holiday_id; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[0]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>holiday/delete_data/<?php echo $fetch -> holiday_id; ?>">Delete </a>
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
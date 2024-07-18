<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "100px",
			//scrollX : true,
			//scrollCollapse : true,

			fixedColumns : {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[0]==1)
	{?>
	<h1 style="text-align:center; ">Add Default Call Center TL (CSE TL)</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary" style="height:120px;">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								
							</div>
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Call Center TL: </label>

							<div class="col-md-5 col-sm-5 col-xs-12">
								<select name="call_center_tl_id" class="form-control" required="" >
									<option value="">Please Select</option>
									<?php foreach($select_cse_tl as $row) {?>
									<option value="<?php echo $row->id ;?>"><?php echo $row->fname .' '. $row->lname;?></option>
									
									<?php } ?>                                					
								</select></div></div>

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

<div class="row" >
	<div class="col-md-12">
		<div class="table-responsive">
			<table id="example"  class="table " style="width: 100%" > 
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Process</th>
					<th>Default Active TL Name </th>
					
					
					
					
					<?php ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_table_tl as $fetch)
				{
				$i++;
				?>

				<tr>
				
				
					<td> <?php echo $i; ?> </td>
					
					
					<td>
						<?php echo $fetch -> process_name; ?>
					</td>
					<td>
						<?php echo $fetch -> fname.' '. $fetch -> lname; ?>
					</td>
					
				
					
					
				
					<?php } 
					 ?>
					 
					 
					 
					 
					
				</tr>
				<?php ?>
			</tbody>
		</table>
	</div>
		
	</div>
</div>
</div>


<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({
         searching : false ,
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
<script>
	function select_nextaction_feedback() {
	  alert(process_id);
	  $.ajax({
	  	url:"<?php echo site_url();?>Map_next_action_to_feedback/select_status",
	  	type:'POST',
	  	data:{ process_id:process_id },
	  	success:function(reponse){
	  		 $("#status_div").html(reponse);
	  	}
	  });
	}
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[14]==1)
	{?>
	<h1 style="text-align:center; ">Map Next Action To Feedback Status</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Process Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="process_id" class="form-control" required="" onchange="select_nextaction_feedback(this.value)" >
							<option value="<?php echo $_SESSION['process_id'];?>"><?php echo $_SESSION['process_name'];?></option>
												
                                				</select>
								</div>
							</div>
							<div id="status_div">
						<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							<select type="text" class="form-control" id="feedback" name="feedback" required><span class="glyphicon">&#xe252;</span>
                                            <option value="">Please Select</option> 
											<?php
											
											foreach($select_feedback_status as $row)
											{
												
											?>
											 <option value="<?php echo $row -> feedbackStatusName; ?>"><?php echo $row ->feedbackStatusName; ?></option> 
											
											<?php } ?>
											</select>   

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select type="text" class="form-control" id="nextaction" name="nextaction" required ><span class="glyphicon">&#xe252;</span>
                                            <option value="">Please Select</option> 
											<?php
											
											foreach($select_next_action_status as $row)
											{
												
											?>
											 <option value="<?php echo $row -> nextActionName; ?>"><?php echo $row ->nextActionName; ?></option> 
											
											<?php } ?>
											</select> 

								</div>
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

	<div class="panel panel-primary">

			<div class="panel-body">
<div class="col-md-offset-8 col-md-4">
	<div class="form-group">
							
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search Status" onkeypress="return alpha(event)" autocomplete="off" class="form-control col-md-4 col-xs-12" id='locationName'  required >
	</div>
<a class="btn btn-success col-md-2 col-xs-12"  onclick="searchLocation()" ><i class="entypo-search"></i></a>
		<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>

	</div>
		
	</div>
	<br><br>
	<div class="row" id='searchLocationDiv'>
	<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify'];
		$delete = $_SESSION['delete'];
		// $form_name = $_SESSION['form_name'];
	
		?>
		<table id="example"  class="table " style="width:auto;" cellspacing="0">
			<thead>
				<tr>
					<th><b>Sr No.</b></th>

					<th><b>Feedback Status</b></th>
					<th><b>Next Action Status</b></th>
						<th><b>Process Name</b></th>
					<?php if($modify[14]==1 || $delete[14]==1) {?>
					<th><b>Action</b></th>

					<?php } ?>
				</tr>
			</thead>

			<tbody>

				<?php
				$i=0;
				foreach($map_nxta_to_feed as $fetch)
				{
				$i++;
				?>

				<tr>

					<td> <?php echo $i; ?> </td>

					<td>
					<?php echo $fetch -> feedbackStatusName; ?>
					</td>
					
					<td>
					<?php echo $fetch -> nextActionName; ?>
					</td>
<td>
					<?php echo $fetch -> process_name; ?>
					</td>

					<?php if($fetch->map_next_to_feed_status == 'Active'){
						 if($modify[14]==1 || $delete[14]==1)  {
					?>
					<td>
					<?php 
						if($delete[14]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>Map_next_action_to_feedback/delete_next_action_to_feedback_status/<?php echo $fetch -> mapId; ?>">Delete </a>
					<?php } ?>
					</td>
					<?php }}else{ ?>
						<td>Deactive</td>
						<?php } ?>
				</tr>
				<?php } ?>
			</tbody>

		</table>

	</div>

</div>
<script>	
	function searchLocation()
	{
		var locationName=document.getElementById("locationName").value;		 
		$.ajax(
			{
				url: "<?php echo site_url();?>Map_next_action_to_feedback/searchlocation",
		type:"POST",
		data:{locationName:locationName}, 
		success: function(result){
        $("#searchLocationDiv").html(result)
   } });
	}
	function reset()
	{
		window.location="<?php echo site_url('Map_next_action_to_feedback')?>";
	}
	
</script>
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>
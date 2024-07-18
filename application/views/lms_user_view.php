
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
<script>
function locationwise_dse()
{
	var tlname=document.getElementById("tlname").value;
	
	$.ajax({url: "<?php echo site_url();?>lms_user/locationwise_dse",
	type:"POST",
	data:{tlname:tlname}, 
	success: function(result){
        $("#group_div").html(result)
   } });

}
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>	
	<h1 style="text-align:center; ">Map DSE to DSE Team Leader</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form class="form-horizontal form-label-left" action="<?php echo site_url()?>/lms_user/add" method="post">

				
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">TL Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									
									<select onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="tlname"  onchange="locationwise_dse()" required name="tlname">
 
									<option value="">Please select </option>
 
									 <?php foreach($tl_data as $row) 
									{
										?>
									  <option value="<?php echo $row->id ?>"><?php echo $row->fname ?> <?php echo $row->lname ?> </option>
									 
									  <?php
									}
									?>
 
							</select>
								</div>
							</div>

						</div>
					
				
						<div id="group_div" class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">DSE Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									
									<select  autocomplete="off" class="form-control" id="dsename" required name="dsename">
												<option value="">Please select </option>
 <!--
<?php foreach($dse_data as $fetch) 
{
	?>
  <option value="<?php echo $fetch->id ?>"> <?php echo $fetch->fname ?>  <?php echo $fetch->lname ?> </option>
 
  <?php
}
?>
 -->
</select>
								</div>
							</div>

						</div>
					
					<div class="form-group">
						<div class="col-md-2 col-md-offset-4">

							<input type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12" value='Submit'>
								
						</div>

						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>

						</div>
					</div>
					</form>
			</div>
		</div>
		
	</div>

</div>
<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
echo $c = count($all_data);
		?></script>
		<div class="panel panel-primary">

			<div class="panel-body">
<div class="col-md-offset-8 col-md-4">
	<div class="form-group">
							
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search Location" onkeypress="return alpha(event)" autocomplete="off" class="form-control col-md-4 col-xs-12" id='locationName'  required >
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


<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   
  
    	 <?php echo 'Total Records :';
			foreach ($count_data as $booking) {echo '<b>'.$total_record = $booking -> lmscount.'</b>';
			}
		?>&nbsp;&nbsp;
	  <?php echo 'Total Pages :';
		$pages = $total_record / 100;
		echo '<b>'.$total_page = ceil($pages).'</b>';
 		?>
		
    </div>

<div class="col-md-6  form-group">
 
     
		
	<?php	
	
	if ($c < 100) {
	$last = $page - 2;
	if ($last != -2) {
		echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . "lms_user/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a>";
		echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . "lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . "lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
	}
} else if ($page == 0) {
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . "lms_user/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";
	echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
} else {
	$last = $page - 2;
	echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . "lms_user/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a> ";
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . "lms_user/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";

	echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . "lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";

}

$page1 = $page + 1;
		?>

       <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;" >Page No</label>
         <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
         <input class="col-md-pull-1  col-md-1  btn btn-danger "  style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
        </div>
        
        </div>
   <script>
         							function go_on_page(){
         		var pageno= document.getElementById("pageNo").value;
         	//	alert(pageno);
         		var pageno1=pageno-2;
         		window.location="<?php echo site_url(); ?>lms_user/paging_next/page/"+pageno1;
         	
         	
         	}
         </script>


</div> 

</div>
<script>	
	function searchLocation()
	{
		var locationName=document.getElementById("locationName").value;		 
		$.ajax(
			{
				url: "<?php echo site_url();?>lms_user/searchlocation",
		type:"POST",
		data:{locationName:locationName}, 
		success: function(result){
        $("#searchLocationDiv").html(result)
   } });
	}
	function reset()
	{
		window.location="<?php echo site_url('lms_user')?>";
	}
	
</script>
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>
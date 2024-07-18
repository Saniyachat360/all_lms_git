<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

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
function test()
{

 var s=document.getElementById("customer_name").value;
//alert(s);

				$.ajax(
					{
					url:"<?php echo site_url('edit_customer/search'); ?>",
							type:'POST',
							data:{customer_name:s},
							success:function(response)
							{$("#replace_table").html(response);}
							});

}

   
  
   </script>

<?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
$c = count($select_table);
		?>
   	<div class="row">
   		
                        
                            <div class="x_panel">
                         
						<div class="col-md-10 col-md-offset-2">
							<div class="col-md-8">
							<div class="form-group">
							
							<label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name" style="margin-top:5px;"> Search Name or Contact : </label>
								<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="text" placeholder=" e.g Ravi Patil or 8888807738 " onkeyup="test()" autocomplete="off" class="form-control" id="customer_name" required name="customer_name">

								</div>
							</div>
							</div>
						
						</div>
				
				
                     
                               
                              
								<div class="col-md-12">
									<div class="col-md-7 col-md-offset-4">
									<label class="control-label col-md-9 col-sm-9 col-xs-12 text-center" for="first-name" style=" margin-top: 13px; margin-bottom: 20px;"><b style="color:red;font-size:12px;"> *** Please Enter Full Name or Correct Contact number for exact result *** </b> </label>
									</div>
								</div>
		 </div></div>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/datatables/datatables.css" id="style-resource-1">-->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		$table4.DataTable({
			dom : 'Bfrtip',
			buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
		});
	}); 
</script> 
<!--- Fetch Table Data -->

	



<script>  
jQuery(document).ready(function(){
 $('#results').DataTable();});
</script>
<div class="row " id="replace_table" class="col-md-12">
<?php echo $this -> session -> flashdata('message'); ?>

					
					
					<div class="table-responsive" >
					<table  id="example"  class="table " style="width:auto;" cellspacing="0">
			<thead>
				<tr>
					<th>Sr No.</th>

					<th>Name</th>
					
				<th>Contact</th>
					
					
					<th>Email</th>
					<th>Address</th>
					
					<!--<th>Lead Status</th>-->
					<th>Action</th>
					

					
				</tr>
			</thead>
			
			
			<tbody>

				<?php
				
	$insert = $_SESSION['insert'];
				$i=$offset1;
				foreach($select_table as $fetch)
				{
				$i++;
				?>
			
				<tr>

					<td> <?php echo $i; ?> </td>

					<td>
					<?php echo $fetch ->name; ?>
					</td>

					<td>
					<?php echo $fetch ->contact_no; ?>
					</td>
					
					
					<td>
					<?php echo $fetch ->email; ?>
					</td>
					
					
						<td>
					<?php echo $fetch ->address; ?>
					</td>
					
					
				
					<td>
					<?php if($insert[57]==1) {?>
					<a href="<?php echo site_url();?>edit_customer/edit_user?id=<?php echo $fetch ->enq_id;?>">Edit </a> 
						<?php } ?>
				
				<!--	<a href="<?php echo site_url();?>edit_customer/duplicate_record?id=<?php echo $fetch ->enq_id;?>&con=<?php echo $fetch ->contact_no; ?>">Remove Duplicate </a>--> 
					
					
					
					</td>
					
				</tr>
				<?php } ?>
			</tbody>
</table>
</div>
<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php echo 'Total Records :';
			foreach ($count_data as $booking) {echo '<b>'.$total_record = $booking -> total_count.'</b>';
			}
		?>
   &nbsp;&nbsp;
  
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
		echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . "edit_customer/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a>";
		echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . "edit_customer/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . "edit_customer/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
	}
} else if ($page == 0) {
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . "edit_customer/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";
	echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "edit_customer/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "edit_customer/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
} else {
	$last = $page - 2;
	echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . "edit_customer/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a> ";
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . "edit_customer/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";

	echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . "edit_customer/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "edit_customer/paging_next/page/$last1>Last  
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
         	//	alert(pageno);
         		var pageno1=pageno-2;
         		window.location="<?php echo site_url(); ?>edit_customer/paging_next/page/"+pageno1;
         	
         	
         	}
         </script>



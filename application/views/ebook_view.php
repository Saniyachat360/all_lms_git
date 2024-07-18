
<div class="row" id="leaddiv">

		<h1 style="text-align:center;"><?php echo $enq; ?> Leads</h1>	
			
			
			
			
		
		
		<!--- Fetch Table Data -->
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('message'); ?>		</div>
		<div class="col-md-12">	<?php echo $this -> session -> flashdata('msg1'); ?>		</div>
		 <div class="row">
		 
		  	<div class="panel panel-primary" id="ebook_filter_div">
			
			<div class="control-group" id="blah" style="margin:0% 30% 1% 50%"></div>
			<?php
	$page = $this -> uri -> segment(4);
	if (isset($page)) {
		$page = $page + 1;
	
	} else {
		$page = 0;
	
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_lead);
	//echo $c;
	$today = date('d-m-Y');	
?>
			
				<div class="panel-body">
					<div class="col-md-offset-8 col-md-4">
							<div class="form-group">
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search Contact"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='contact_no'  required >
								</div>
								<a class="btn btn-success col-md-2 col-xs-12"  onclick="return searchcontact()" ><i class="entypo-search"></i></a>
								<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>
							</div>
						</div>
					<br><br>	
					<div id='searchdiv'>
						<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
										<th>Sr</th>
																
										<th>Name</th>
										<th>Contact</th>
										<th>Email ID</th>
										<th>Model </th>
										<th>Variant </th>
										 <?php if($lead_source !='Insurance')
											{?>
										    <th>Color </th>
											<th>Location</th>
										      <?php } else{

										      	?>
										     <th>Registration No</th>
										      <?php 
										      }?>
										<th>Amount</th>
										
										<th>Payment Date/Time</th>
										<th>Payment Id</th>
										<th>Order ID</th>
										<th>Payment Status</th>
										
										<th>Paid Status</th>
										
										<?php if($lead_source !='Insurance')
											{?>
										<th>EDMS ID</th>
									<th>Action</th>
									<?php } ?>
															
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										 	
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
											<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
										
											<td><?php echo $i; ?></td>
										
											<td><b><?php echo $fetch -> name;?></b>
											</td>
											<td><?php echo $fetch -> contact_no; ?></td>
											<td><?php echo $fetch -> email; ?></td>
										    <td><?php echo $fetch -> model_name; ?></td>
										    <td><?php echo $fetch -> variant_name; ?></td>
										    <?php if($lead_source !='Insurance')
											{?>
										     <td><?php echo $fetch -> color_name; ?></td>
										  
										      <td><?php echo $fetch -> showroom_location; ?></td>
										      <?php } else{

										      	?>
										     <td><?php echo $fetch -> customer_reg_no; ?></td>
										      <?php 
										      }?>
										     <td><?php echo $fetch -> amount; ?></td>
											<td><?php echo $fetch -> created_date.' '.$fetch->created_time; ?></td>
											<td><?php echo $fetch -> razorpay_payment_id; ?></td>
											<td><?php echo $fetch -> razorpay_order_id; ?></td>
											<td><?php echo $fetch -> payment_status; ?></td>
											
										<td><?php if($fetch -> status=='captured'){ echo "Paid";} ?></td>
										
											<?php if($lead_source !='Insurance')
											{?>
											 <td><?php echo $fetch -> edbms_id; ?></td>
								<td>
								<a class="btn btn-primary" data-toggle="modal" data-target="#search_model" onclick="get_data('<?php echo $fetch->customer_id ;?>','<?php echo $fetch->edbms_id;?>')">Add EDMS ID</a>
								</td>
								<?php } ?>
								
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php


	$url='website_leads/ebook_leads/';
	$total_record=count($select_lead_count);

	

//$lead_cou = $count_lead_dse_lc+$count_lead_dse;
echo 'Total Records :';
echo '<b>' . $total_record . '</b>';
//print_r($count_lead);
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
	$pages = $total_record / 100;
	echo '<b>' . $total_page = ceil($pages) . '</b>';
 ?>
 
    </div>

<div class="col-md-6  form-group">
 
     
	
		
	<?php

			if ($c < 100) {
				$last = $page - 2;
				if ($last != -2) {
					//echo "1";
					echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() .$url."page/".$last."/?lead_source=".$lead_source.">
<i class='fa fa-angle-left'></i>   Previous   </a>";
					echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() .$url."/?lead_source=".$lead_source.">First  
<i class='fa fa-angle-right'></i></a>";
					$last1 = $total_page - 2;
					echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() .$url. "page/".$last1."/?lead_source=".$lead_source.">Last  
<i class='fa fa-angle-right'></i></a>";
				}
			} else if ($page == 0) {
				//echo"2";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() .$url. "page/".$page."/?lead_source=".$lead_source.">Next  
<i class='fa fa-angle-right'></i></a>";
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url()  .$url."/?lead_source=".$lead_source.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() .$url."page/".$last1."/?lead_source=".$lead_source.">Last  
<i class='fa fa-angle-right'></i></a>";
			} else {
				//echo "3";
				$last = $page - 2;
				echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() .$url. "page/".$last."/?lead_source=".$lead_source.">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() .$url. "page/".$page."/?lead_source=".$lead_source.">Next  
<i class='fa fa-angle-right'></i></a>";

				echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() .$url. "/?lead_source=".$lead_source.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() .$url. "page/".$last1."/?lead_source=".$lead_source.">Last  
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
        
        

        </div>
        
        </div>
		</div>
		</div>
		</div>
		        <script>
	function go_on_page(){
        		var lead_source='<?php echo $lead_source;?>';
         		var pageno= document.getElementById("pageNo").value;
         		var total_page='<?php echo $total_page;?>';
         		var total_page=parseInt(total_page);
         		if(pageno >total_page){
         			alert('Please Enter Page No. Less Than Total No. of Pages');
         			return false;
         		}else{
         	//	alert(pageno);
         		var pageno1=pageno-2;
         		
         		var id="<?php echo $id ;?>";
         		window.location="<?php echo site_url() . $url ; ?>page/" + pageno1 +"/?lead_source="+lead_source;
         	}
         	
         	}
         </script>
      
<script>
	$(document).ready(function() {
		var enq ="<?php echo $enq ; ?>";
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
	function get_data(customer_id,edbms_id){
	    document.getElementById('cust_id').value= customer_id;
		 document.getElementById('edbms_id').value= edbms_id;
	}

</script>
		
	<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="search_model" tabindex="-1"  aria-hidden="true" style='top:30%'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add EDMS ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form action="<?php echo site_url();?>website_leads/insert_edbms" method="post">
      <div class="modal-body">
   

    <input type="hidden" name="customer_id" id="cust_id">
    <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="alternate_contact">EDMS ID:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input placeholder="Enter EDMS ID"  name="edbms_id" id="edbms_id" class="form-control" type="text">
                                            </div>
                                        </div>
      </div>
      <div class="modal-footer" style="margin-top: 50px;">
     
        <button type="submit" class="btn btn-primary">Save </button>
      </div>
      </form>
    </div>
  </div>
</div>
 <script>	
	function searchcontact()
	{
		var contact_no=document.getElementById("contact_no").value;	
var lead_source='<?php echo $lead_source;?>';		
		if(contact_no ==''){
			alert("Please enter contact number for search");
			return false;
		}
		
		$.ajax(
			{
				 url: "<?php echo site_url();?>website_leads/ebook_filter",
		type:"POST",
		data:{contact_no:contact_no,'lead_source':lead_source}, 
	success: function(result){
       $("#searchdiv").html(result)
   } });
	}
	function reset()
	{
		
		window.location="<?php echo site_url()?>website_leads/ebook_leads";
	}
	
</script>
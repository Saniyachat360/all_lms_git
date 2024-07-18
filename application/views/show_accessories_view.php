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
</script>

<div class="row" id="leaddiv">
	<div id='replacediv'>
<?php
$today = date('d-m-Y');
?>

<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
		

<!--- Fetch Table Data -->
			<div class="col-md-12">
			<?php echo $this -> session -> flashdata('message'); ?>
			</div>
		  <div class="row">
		  	
		  	<div class="panel panel-primary">

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
								<th>Interested In</th>
								
									
								<th>Name</th>
								<th>Contact</th>
								<th>Lead Date</th>
						
								
							</tr>
						</thead>
						<tbody>
								<?php
				
				
				if (!empty($select_lead)) 
					{
					foreach($select_lead as $fetch)
					{
						//print_r($fetch);
						  $enq_id=$fetch->enq_id;
					?>
							
						
						
							<tr >
								<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
								<input type="hidden" value="<?php echo $fetch->enquiry_for; ?>" id="select_enq">
								
								
								<td></td>
								<td>	<?php if($fetch->lead_source == '')
						{
						 $lead_source= "Web"; 
						}
					elseif($fetch->lead_source == 'Facebook')
						{
	 						$lead_source= $fetch->enquiry_for;
					}elseif($fetch->lead_source == 'Carwale')
						{
	 						$lead_source=$fetch->enquiry_for;
						}
						else
						{
							 $lead_source=$fetch->lead_source;
						}?><?php echo $lead_source; ?></td>
								
								<td><b><a href="<?php echo site_url(); ?>add_followup_accessories/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php echo $fetch -> name;
								if($fetch->days60_booking=='90' || $fetch->days60_booking=='>60')
								{?>
									<span class="label label-success"><?php echo $fetch->days60_booking;?>&nbsp;Days</span>
									<?php }
									else if($fetch->days60_booking=='30'){?><span class="label label-danger"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php }
									else if($fetch->days60_booking=='60'){?><span class="label label-warning"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php }
									
								else{?><span class="label label-success"><?php echo $fetch->days60_booking;?></span> <?php }
								
								?></a></b>
								</td>
								<td><?php echo $fetch -> contact_no; ?></td>
								<td><?php echo $fetch -> created_date; ?></td>
								
							
								
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		

	</div>    
        
        
     
        </div>
        
        </div>
	<!-- /page content -->



<!--<ol class="breadcrumb bc-3" > <li> 
	
		<a href=""><i class="fa fa-home"></i>Home</a>
	
	<li class="active"> <strong>Lead Management System</strong> </li> </ol>-->
	
    <div class="container body" style="width: 100%;">


        <div  id="leaddiv" class="main_container">





                    <div id="abc">
<?php
$today = date('d-m-Y');
?>
 <script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		$table4.DataTable({
			dom : 'Bfrtip',
			buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
		});
	}); 
</script>

                       <h1 style="text-align:center;">
                       	
                       	CSE Added Leads</h1>
                       <div class="table-responsive"  style="overflow-x:auto;"> 
				<table class="table table-bordered datatable table-responsive" id="table-4"> 
						<thead>
						<tr>
							<th>Sr No.</th>
							<th>Interested In</th>
                            <th>Name</th>							
							<th>Contact</th>			
							<th>Email</th>
							<th>Lead (Date/Time)</th>
                            <th>Status</th>
                            	 <th>Added By</th>
							<th>Assign To</th>
							<th>Comment </th>
								<th>Remark</th>
							<th>Action</th>
					</thead>
					<tbody>
						<?php
						$i=0;
						if(isset($select_lead)){
					foreach ($select_lead as $fetch) {
						
							
							$enq_id=$fetch->enq_id;
							$i++;
						?>
						<tr>
							<td><?php echo $i; ?></td>
						
								<td><?php echo $fetch->enquiry_for; ?></td>
                                <td><b><a href="<?php echo site_url();?>website_leads/lms_details/<?php echo $enq_id;?>"><?php echo $fetch->name; ?></a></b></td>
								<td><?php echo $fetch->contact_no; ?></td>
								<td><?php echo $fetch->email; ?></td>
							
								<td><?php echo $fetch->created_date; ?></td>
								
                                <td>
                                	<?php $status = $fetch->status;

									if ($status == 1) {
										echo "Not Yet";
									}

									if ($status == 2) {
										echo "Live";
									}
									if ($status == 3) {
										echo "Postpone";
									}
									if ($status == 4) {
										echo "Lost";
									}
									if ($status == 5) {
										echo "Convert";
									}
                                	?>
                                </td>
                              <td>
									<?php 
									echo $fetch->manual_lead;
									?>
								</td>
								<td>
									<?php 
									echo $fetch->fname . " " . $fetch->lname;
									?>
								</td>
								  <td><?php echo $fetch->comment; ?></td>
								  <td>
								  	
									<?php 
									
								
									
									$query=$this->db->query('select comment from lead_followup where leadid='.$enq_id);
									
									foreach($query->result() as $fetch1)
									{
										
										echo $fetch1->comment ;	
									}
									
								
									?>
								</td>
					
					
								<td><a href="edit_leads/<?php echo $fetch->enq_id;?>">Edit</a></td>
					
		
						</tr>
						<?php } }?>
					</tbody>
					
					
				</table>
                   <br />
 </div> 
          </div> 
         
                    


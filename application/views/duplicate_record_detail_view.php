<script>
	function change(j){
$("#followup_div_"+j).toggle();
		 
		
	}
</script>
<h2 class="text-center">Duplicate Customer Details</h2>
	<?php $i=0;
        	foreach ($lead_details as $row) {
        		$i++; ?>


<div class="panel panel-primary">
    
     <div class="panel-body"> <h3><?php echo $i;?></h3>
     	
					  <div class="col-md-6">
					 
					  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Name: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->name; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Email: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->email; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                               <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Alternate Contact: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->alternate_contact_no; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                    	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Feed Back Status: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->feedbackStatus; ?></b>
                                            </div>
                                                           </div><br>   
														   <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Buyer Type: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->buyer_type; ?></b>
                                            </div>
                                                           </div><br>   
                                                           </div>
                                                            <div class="col-md-6">
										
										
										 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Contact: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->contact_no; ?></b>
                                            </div>
                                                               </div>
											<br>				   
											 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Address: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->address; ?></b>
                                            </div>
                                                               </div>
											<br>	

               									
											 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Next Action: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $row->nextAction; ?></b>
                                            </div>
                                                               </div>
                  <br>
                  </div>
                  <div class="panel panel-primary">
    
     <div class="panel-body">
     <a onclick="change('<?php echo $i;?>')">
     		<div class="col-md-12" style="border-bottom: 1px solid #ddd">
     				
     	<h4 class="pull-left" style="font-weight: bold;">Follow up Details</h4>
     	<h3 class="pull-right">+</h3>
     	
     	</div>
     </a>
     	<div id="followup_div_<?php echo $i;?>" style="display: none">
  
     		<?php $query=$this->db->query("SELECT `u`.`fname`, `u`.`lname`, `f`.`contactibility`, `f`.`feedbackStatus`, `f`.`nextAction`, `f`.`assign_to`, `f`.`date` as `c_date`, `f`.`created_time`, `f`.`nextfollowuptime`, `f`.`comment` as `f_comment`, `f`.`nextfollowupdate`, `f`.`pick_up_date`, `f`.`visit_status`, `f`.`visit_location`, `f`.`visit_booked`, `f`.`visit_booked_date`, `f`.`sale_status`, `f`.`car_delivered`, `f`.`appointment_type`, `f`.`appointment_status`, `f`.`appointment_date`, `f`.`appointment_time` FROM `lead_master` `l` LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` JOIN `lead_followup` `f` ON `f`.`leadid`=`l`.`enq_id` LEFT JOIN `lmsuser` `u` ON `u`.`id`=`f`.`assign_to` WHERE `f`.`leadid` = '$row->enq_id' ORDER BY `f`.`id` DESC")->result(); 
     					 if(count($query)>0)
{?>
<div class="col-md-12 table-responsive" style="overflow-x:scroll">        
	<table class="table table-bordered datatable" id="results1"> 
	
					<thead>
						<tr>
							<th>Sr No</th>
						
							<th>Follow Up By</th>
							<th>Call Status</th>		
							<th>Call Date Time</th>
															
								<th>Feedback Status</th>
							<th>Next Action</th>	
						
							<th>N.F.D.T.</th>
							<th>Appointment Type</th>	
							<th>Appointment Date Time</th>	
							<th>Appointment Status </th>									
							<th>Remark</th>	
						<!--	<th>Escalation Type</th>
						<th>Escalation Remark</th>	-->							
						</tr>	
					</thead>
					<tbody>
						<?php
						$j=0;
						foreach($query as $row)
						{
							
							$j++;
						
						?>
						<tr>
						<td><?php echo $j ;?></td>
					
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> contactibility; ?></td>
							<td><?php echo $row -> c_date.' '.$row -> created_time; ?></td>
							<td><?php echo  $row  -> feedbackStatus; ?></td>
							<td><?php echo   $row  -> nextAction; ?></td>	
							
							<td><?php echo $row -> nextfollowupdate .' '.$row -> nextfollowuptime ?></td>
								<td><?php echo $row -> appointment_type ?></td>
								<td><?php echo $row -> appointment_date.' '.$row -> appointment_time  ?></td>
								<td><?php echo $row -> appointment_status ?></td>
							<td><?php echo $row -> f_comment; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>		                        
				</div>
				<?php } else{?><br>
					<div class="col-md-12"><h4>No Data Avaliable</h4></div>
					<?php
									} ?>
     
     
     	</div>
     </div></div>
     
               </div></div>
<?php } ?>



<!--<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
               <th>Sr No</th>
				<th>Lead Source</th>
				<th>Name</th>
				<th>Contact No</th>		
				<th>Email ID</th>
				<th>Address</th>	
            </tr>
        </thead>
      
 </table>
    -->
    <style>
    td.details-control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
    	
    </style>			
				
				
	<script>
		/* Formatting function for row details - modify as you need */
function format_t (myObj) {
var myObj,i, x = "";
//alert(myObj);
myObj=JSON.parse(myObj);
//myObj ={"get_details":[{"name":"tef","lead_source":"","contact_no":"8087535078","email":"","address":""}]};


	//alert('jiiiiii');
var tab_data='';
tab_data +='<table id="example1" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<thead><tr>'+
            '<th>Lead Source</th>'+
             '<th>Name</th>'+
             '<th>Contact No</th>'+
              '<th>Email ID</th>'+
              '<th>Address</th>'+
             
         '</tr>';
           for (i in myObj.get_details) {
         tab_data +=  	  '<tr>'+
         
         '<td>'+myObj.get_details[i].lead_source+'</td>'+
             '<td>'+myObj.get_details[i].name+'</td>'+
             '<td>'+myObj.get_details[i].contact_no+'</td>'+
              '<td>'+myObj.get_details[i].email+'</td>'+
              '<td>'+myObj.get_details[i].address+'</td>'+
         '<tr>';
         }
   tab_data += '</thead>'+
         '</table>';
    // `d` is the original data object for the row
    return tab_data ;
       
         	
       
     
       
   
}
 
$(document).ready(function() {
	
    var table = $('#example').DataTable( {
        "ajax": "<?php echo site_url();?>/add_followup_new_car/get_data/<?php echo $enq_id;?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
           
            { "data": "lead_source" },
             { "data": "name" },
            { "data": "contact_no" },
            { "data": "email" },
             { "data": "address" }
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
          console.log('hii');
           console.log(row.data().enq_id);
            console.log(row.data[0]);

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
        	var id=row.data().enq_id;
        	 $.ajax({
         	url:  "<?php echo site_url();?>add_followup_new_car/get_data1/"+id,
    		 success: function(result){
            // Open this row
          
            row.child( format_t(result) ).show();
            tr.addClass('shown');
             }
    });
        }
      
    } );
} );
	</script>		
				
				
				
				
				
				
				
				
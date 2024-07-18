<script>
$(document).ready(function () {
    $('#checkBtn').click(function() {
     
    
    
 		checked1 = $("input:checkbox[class=finance]:checked").length;
 		 if(!checked1) {
        alert("You must check at least one Lead Source .");
        return false;
      }
    
    });
});
	



</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.min.css">

<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[61]==1)
	{?>
	<h1 style="text-align:center; ">Auto Assign Lead Set Up</h1>
	<div class="col-md-12" >
		
				<form name="submit" action="<?php echo $var;?>" method="post" onsubmit="return validate_form()">           
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="panel panel-primary">
   							<div class="panel-body">
						<div class="col-md-12">
                         <div class="col-md-6">
                         	<div class="form-group">
                            	<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Lead Assign Count: </label>
                                <div class="col-md-8 col-sm-9 col-xs-12">
                                	<?php if(count($select_count)>0 )
                                	{
                                        $maxIdNew=$select_count[0]->count_number;
										
									}
									else 
									{
										$maxIdNew="";
									}
                                   ?>
                                   <input type="text" required class="form-control" value='<?php echo $maxIdNew;?>' id="count_number" name="count_number" placeholder='Enter Assign Lead Count'>
                                   
                              </div>
                          </div>
                          	<div class="form-group">
                            	<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Lead Assign Time(From & To): </label>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                	<?php if(count($select_count)>0 )
                                	{
                                        $maxIdNew=$select_count[0]->from_time;
										
									}
									else 
									{
										$maxIdNew="";
									}
                                   ?>
                                  
                                     <input class="form-control "  data-template="dropdown" id="timet1"  value='<?php echo $maxIdNew;?>'  autocomplete="off" placeholder="Enter From Time" type="text"  name="from_time" > 
                                   
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                	<?php if(count($select_count)>0 )
                                	{
                                        $maxIdNew=$select_count[0]->to_time;
										
									}
									else 
									{
										$maxIdNew="";
									}
                                   ?>
                                   <input type="text" data-template="dropdown" required class="form-control" value='<?php echo $maxIdNew;?>' id="timet2" name="to_time" placeholder="Enter To Time">
                                   
                              </div>
                          </div>
                          
                         
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">User Name: 
                                            </label>
                                                   <div class="col-md-8 col-sm-9 col-xs-12">
                                          <select name="userid" required id="userid" class="form-control" onchange="return checkeddata()" >
												<option value="">Please Select </option>
											
											
												<?php 
												 foreach($select_user as $row) {
												 ?>
												<option value="<?php echo $row->id;?>"><?php echo $row->fname.' '.$row->lname;?></option>
												<?php } ?> 
												</select>
												</div>
                                                               </div>
                         
									
                               
                                        
                                 </div>
                                 <div class="col-md-6">
                                     	  <div id="leadsourcediv">
                                        <div class="form-group"  >
                                        
											 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lead Source</label>
                                            
											<div class="col-md-9 col-sm-9 col-xs-12" style='height:500px;overflow-x:scroll'>
												
												
											<?php $i=0; foreach($lead_source as $row) {
												$i++;
												?>
											
													<input id="<?php echo 'a-'.$i;?>" class="finance" type="checkbox" name="lead_source[]" value="<?php echo '1#'.$row->id ;?>" >   <?php echo $row->lead_source_name ;?><br>
											<?php 
										
											}?>
											</div>
											</div>
							   </div>
                                 
                                      
                                          
                                 </div>
                                 </div>
                                 
                                   <div class="form-group col-md-12">
                     <div class="col-md-2 col-md-offset-4">
                    	
						
                    <button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
                         </div>
                       
                        <div class="col-md-2">
                            <input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
                        
                        </div>
                    </div>
                                 </div>
                                 </div>
                                
                  </div>
                </form>
            </div>
            </div>
<?php } ?>
<script src="<?php echo base_url();?>assets/js/campaign.js?v=00001" ></script>
<script>

function checkeddata(){
	
	
				//optionVal.push(checkedValue);
				var userid=document.getElementById("userid").value;
			//	alert(userid);
			
				
		
	
		$.ajax({url: "<?php echo site_url();?>add_call_center_tl/check_lead_source",
		type:"POST",
		data:{userid:userid}, 
		success: function(result){
        $("#leadsourcediv").html(result)
   } });
	
					  
}
</script>
<script>  
jQuery(document).ready(function(){
 $('#results').DataTable();});
</script>		
<script>
	$(document).ready(function() {
			if($("#example").width()>1308){
		var table = $('#example').DataTable({
			searching:true,
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
				searching:true,
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

<div class="panel panel-primary">

			<div class="panel-body">
<!--div class="col-md-offset-8 col-md-4">
	<div class="form-group">
							
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search user"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='userName'  required >
	</div>
<a class="btn btn-success col-md-2 col-xs-12"  onclick="searchuser()" ><i class="entypo-search"></i></a>
		<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>

	</div>
		
	</div-->
	<br><br>		
		<div id="searchuserDiv">
	<div class="table-responsive"  style="overflow-x:auto;">
	<?php 
	 $modify=$_SESSION['modify'];
	 $delete=$_SESSION['delete'];  
	 $form_name=$_SESSION['form_name'];  
	 ?>
	<table id="example"  class="table " style="width:auto;" cellspacing="0">
				<thead> 
					<tr> 
							<th>Sr No.</th>
						
							<th> Name</th>
							<th>Lead Source</th>
							
 </tr>
</thead> 


<tbody>


					 <?php 
					 $i=0;
						foreach($select_table_data as $fetch){
							$i++;
						?>

						<tr>
						
						<td>	<?php echo $i;
									?> 		
							</td>
						
						
					
							<td>
							<?php echo $fetch['username'] ;
							?>
							</td>
								
							<td>
							<?php $t=$fetch['lead_source'];
						//	print_r($t);
							foreach($t as $l)
							{
							    echo $l->lead_source_name.',';
							}
							?>
							</td>	
						
						
							
						
						</tr>
						 <?php }?>
					</tbody>
 
 </table> 

<script>

	$(document).ready(function(){
    $('#timet2').timepicker({
        timeFormat: 'HH:mm:ss',
       // minTime: '11:45:00', // 11:45:00 AM,
       // maxHour: 20,
      // maxMinutes: 30,
       scrollbar: true,
        startTime: new Date(0,0,0,0,0,0), // 3:00:00 PM - noon
        interval: 30 // 15 minutes
    });
     $('#timet1').timepicker({
        timeFormat: 'HH:mm:ss',
       // minTime: '11:45:00', // 11:45:00 AM,
       // maxHour: 20,
      // maxMinutes: 30,
       scrollbar: true,
        startTime: new Date(0,0,0,0,0,0), // 3:00:00 PM - noon
        interval: 30 // 15 minutes
    });

});
</script>




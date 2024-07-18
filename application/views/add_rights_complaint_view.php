
<script >

  function checkUser1()
  {
  		var locationId=$("#location").val();
  		$.ajax({url: "<?php echo site_url(); ?>add_right/checkUser",
		type:"POST",
		data:{"locationId":locationId},
		success: function(result){
		$("#userrr").html(result)
		} });
  		
  }
  
   function checkRights()
  {
  	
  	var username=document.getElementById("username").value;
  	var location=document.getElementById("location").value;
  	if(location==''){
  		alert("Please Select Location and User Name");
  		return false;
  	}
  	if(username==''){
  		alert("Please Select User Name ");
  		return false;
  	}
	$.ajax({
    			url : '<?php echo site_url('add_right/checkComplaintRights'); ?>',
               	data:{"username":username},
        		type: 'POST',
				success: function(result){
          		if(result=='No User Found') 
				{
			
					alert("Please assign Rights");
					return false();
				}
				else
				{
					$("#checkRightsDiv").html(result);
				}
       		 }
    });
  }
  
  
   function copyRights()
  {
  	
  	var cpyuser=document.getElementById("cpyright").value;
  	var username=document.getElementById("username").value;
  	
  	if(username==''){
  		alert("Please Select User For Assigning Rights");
  		return false();
  	}
  //	var location=document.getElementById("location").value;
  	//var dept=document.getElementById("dept").value;
 // alert(username);
  		$.ajax({
    		url : '<?php echo site_url('add_right/cpyrightComplaint'); ?>',
               data:{"cpyuser":cpyuser,"username":username},
        type: 'POST',
		
        success: function(result){
          if(result=='No User Found') 
		{
			
			alert("Please assign Rights");
			return false();
		}
		else
		{
			$("#checkRightsDiv").html(result);
		}
        }
    });
  }
  
  </script>
<div class="row" >
<div><?php echo $this -> session -> flashdata('message'); ?></div>
<?php $insert=$_SESSION['insert'];
if($insert[8]==1)
{?>
<h1 style="text-align:center; ">Add Complaint Rights</h1>
	<div class="col-md-12" >
			<div class="panel panel-primary">
				<div class="panel-body">
					<form action="<?php echo $var; ?>" method="post">
						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-2" ></div>
                                    <div class="col-md-3" >
             <select type="text" class="form-control" id="location" name="location" onChange='checkUser1()' ><span class="glyphicon">&#xe252;</span>
                                            <option value=""> Select Location</option> 
											<?php
											
											foreach($select_location as $row)
											{
												
											?>
											 <option value="<?php echo $row -> location_id; ?>"><?php echo $row ->location; ?></option> 
											
											<?php } ?>
											</select>   
 
  

                                     </div>
                                        <div id="userrr">
										<div class="col-md-4 col-sm-4 col-xs-12" >
										<!--	<input class="form-control" name='username' id='username'  Placeholder ='Username' required>-->
											<select class="filter_s col-md-12 col-xs-12 form-control" id="username" name="username" required>
											<option value=""> Please Select </option>
								
                                         </select>
                                         </div>
                                         </div>
                                         <div class="col-md-2" style="margin-bottom: 20px">                                                     
                                  
									  <!--<div class="pull-middle  ">-->
                                        
                                        <button  class="btn btn-info" type="button" onClick="return checkRights();"><i class="entypo-search"></i>  </button>        
										
                                    <!--</div>--> 
									
									</div>
                                    </div>
                                </div>
							</div><br><br><br>
							<div id='checkRightsDiv' >
							
						</div>
						
				
					</div>
				</div>
			</div>
	<?php } ?>
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
<script src="<?php echo base_url();?>assets/js/campaign.js"></script>
   	</div>
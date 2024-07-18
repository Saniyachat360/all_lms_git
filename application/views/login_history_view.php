 
<!--<ol class="breadcrumb bc-3" > <li> <a href=""><i class="fa fa-home"></i>Home</a> </li><li class="active"> <strong>Report</strong> </li> </ol>-->

<!-- Filter-->

<div class="row" >
  
                          
                            <div class="x_panel">
                        
                            <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               <select  class="filter_s col-md-12 col-xs-12 form-control"   name="type"  id="type"  onchange="custom1();" required>
                    	
                    	
                       <option value="">Select Type</option>    
                          
                     <option value="Daily">Daily</option>
                     <option value="Weekly">Weekly</option>
                      <option value="Monthly">Monthly</option>
                       <option value="Custom" >Custom</option>
                                       
                     </select> 
                                             
											  
                                            </div>
                            </div>
                             
                                  <!--div id="disposition_div" class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="feedback" name="feedback" onchange="select_next_action(this.value);">
											
													 <option value="">Feedback</option>
                                             
											<?php foreach($select_feedback as $row)
									{?>
										<option value="<?php echo $row -> feedbackStatusName; ?>"><?php echo $row -> feedbackStatusName; ?></option>
								<?php } ?>
                                               
                                                </select>
                                               
                                                </select>
											  
                                            </div>
                            </div>
                                        
                                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group" id="next_action_div">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="nextaction" name="nextaction" >
											<option value="">Next Action</option>
										
											
											<?php foreach($select_next_action as $row)
									{?>
										<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
								<?php } ?>
                                               
                                                </select>
											  
                                            </div>
                            </div--> 
                                    
                                    
                       
							
                                     
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; "  id='crdiv' style="display: none">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="from_date" value="<?php //echo date('Y-m-d'); ?>" class="datett filter_s col-md-12 col-xs-12 form-control"  placeholder="From Date" name="from_date" readonly style="cursor:default;">
										
                                        </div>
                         
                              </div>
                                    
                                    
                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;" id='crdiv1' style="display:none">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="to_date" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="To Date"   name="to_date" readonly style="cursor:default;">
										
                                        </div>
                            </div>
                              
                                    
                                  
                            <div class="col-md-offset-4 col-lg-offset-4 col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                           
											
                                            
                             
                           
                         <button type="button" class="btn btn-info" ><i class="entypo-search" onclick='filter_daily()'> Search</i></button>
                         
                              <!--a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a-->
                             	
                          
                                 <a onclick="reset()" > <i class="btn btn-success entypo-ccw"> Reset</i></a>
                                        </div>
                            </div>
                                     
                    
                                </div>
                                 <div class="col-md-12" id="filter_daily">
             	
             	
            </div>
                                </div>
                              <!-- <a class="pull-right" onclick="download_data()" > <i class="btn btn-info entypo-search">Download</i></a>-->
    <!-- date script -->
                    <script>
							function clear() {
								document.getElementById("status").innerHTML = 'All';

								document.getElementById("fromdate").innerHTML = '';
								document.getElementById("assign_to").innerHTML = '';

								document.getElementById("todate").innerHTML = '';
								test();

							}
    </script>
                   <script type="text/javascript">
						$(document).ready(function() {
							$('.datett').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							$('#fromdate').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							$('#todate').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							//Code for Hide & Show for select control

						});						

						function Lead_Date_disabled() {

							document.getElementById("lead_date").disabled = true;

						}

						function from_Date_disabled() {

							document.getElementById("fromdate").disabled = true;

						}

                    </script>
					
<script>
	$(document).ready(function() {
		$("#fromdate1").click(function() {
			$("#leaddate1").toggle();
		});
	}); 
</script>
 
 					
<script>
	$(document).ready(function() {
		$("#leaddate1").click(function() {
			$("#fromdate1").toggle();
		});
	}); 
function select_next_action(feedback){
	
    $.ajax({url: "<?php echo site_url();?>new_tracker/select_next_action",
    type:'POST',
    data:{feedback:feedback} ,
    success: function(result){
        $("#next_action_div").html(result);
    }});
}
</script>
 
                    <!-- date script -->

<!--Filter Ends-->                    
 <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">
  <style> .select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: 
#17a2b8;
border-color:
#17a2b8;
color:
    #fff;
}
.select2-container .select2-selection--single {
  
    height: auto;
   }
</style><!--div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
       
            <h1>Login History</h1>
          </div>        
        </div>
      </div>
    </section>
    
    
    <section class="content">

      <div class="row">

        <div class="col-12">
  <?php echo $this -> session -> flashdata('message'); ?>
          <div class="card">

           
           
            <div  class="card-body">
              
            <div class="row">
              <div class="col-md-3">
                 <div class="form-group row">                   
                      <div class="col-sm-12">
                      	 
                    <select class="form-control select2"  name="type"  id="type"  onchange="custom1();" required>
                    	
                    	
                       <option value="">Select Type</option>    
                          
                     <option value="Daily">Daily</option>
                     <option value="Weekly">Weekly</option>
                      <option value="Monthly">Monthly</option>
                       <option value="Custom" >Custom</option>
                                       
                     </select>
                   </div>
                  </div>
                   </div>
                    <?php if($_SESSION['role']==4 || $_SESSION['role']==5){
                 ?>
                       <div  id="user_name"></div>   
                   <?php }else{?>
                    <div class="col-md-3">
                 <div class="form-group row">                   
                      <div class="col-sm-12">
                      	<div class="select2-purple">
                    <!-select class="form-control select2"  multiple="multiple" name="user_name"  id="user_name" data-dropdown-css-class="select2-purple" data-placeholder="Select User" style="width: 100%;">
                    
                    	 <option value="ALL">ALL</option>
                         
                          <?php
                    foreach($users as $row){    ?>   
                     <option value="<?php echo $row->id;?>"><?php echo $row->user_name;?></option>
                           <?php } ?>               
                     </select->
                     </div>
                    
                   </div>
                  </div>
                   </div>
                   <?php } ?>
                 
                    <div  id='crdiv' style="display: none" class="col-md-2">
                   <div class="form-group row">                    
                      <div class="col-sm-12">
                     <input type="text" name="from_date" id="from_date" disabled required class="date_user form-control" >
                  </div>
            </div>
              </div>
         
              <div id='crdiv1' style="display:none" class="col-md-2">
                   <div class="form-group row">                    
                    <div class="col-sm-12">
                    <input type="text" class="date_user form-control float-right" disabled name="to_date" id="to_date">
                   
                  </div>
            </div>
              </div>
          
        

            <div class="col-md-2" >
            <div class="form-group row"> 
              <div class="col-sm-12">
                <input type="button"  class="btn btn-primary"  value="Submit"  onclick='filter_daily()'>
                <input type="reset" class="btn btn-default" value="Cancel"  ><br>
              </div>
            </div>
             </div>
              </div>
               </div>
            
            
       

   


      </div>

     

    </section>
    </div-->
    <script>
                      	 $(function () {

   var today = new Date(); 
    var dd = today.getDate(); 
    var mm = today.getMonth()+1; //January is 0! 
    var yyyy = today.getFullYear(); 
    if(dd<10){ dd='0'+dd } 
    if(mm<10){ mm='0'+mm } 
    var today = yyyy+'-'+mm+'-'+dd; 
    $('.date_user_disable').daterangepicker({
			singleDatePicker : true,
			showDropdowns: true,
			minDate:today,
			calender_style : "picker_1",
			locale: {
     format : 'YYYY-MM-DD'
  
    }
		}, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
  });
  
    $('.date_user').daterangepicker({
			singleDatePicker : true,
			showDropdowns: true,
			calender_style : "picker_1",
			locale: {
     format : 'YYYY-MM-DD'
  
    }
		}, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
  });
    });
                      </script>
    <script>

          function custom1()
          {
          var type= document.getElementById("type").value;
          // alert (type);
          if 	(type=='Custom')	
          { 
          	$("#crdiv").show();
			$("#crdiv1").show();
          	 document.getElementById("from_date").disabled = false;
          	 document.getElementById("to_date").disabled = false;
		
		 // alert ('hit');
			
          }
          else
          {
          	
          	 document.getElementById("from_date").disabled = true;
          	 document.getElementById("to_date").disabled = true;
		
		$("#crdiv").hide();
		$("#crdiv1").hide();
          }
          }

  function filter_daily() 
{
    var type= document.getElementById("type").value;
     var user_name= $('#user_name').val();
  
     var from_date= document.getElementById("from_date").value;
      var to_date= document.getElementById("to_date").value;
      if(type==''){
      	alert ('Please Select Type');
      }else{
     
   	
    $.ajax({

                url:'<?php echo site_url('login_history_controller/filter_daily')?>
                ',
                type:'POST',
                data:{type:type,user_id:user_name,from_date:from_date,to_date:to_date},
                success:function(response)
                {$("#filter_daily").html(response);
               
            }
                });
    }

} 
 
 $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    });    </script>

	<!-- Select2 -->
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>  

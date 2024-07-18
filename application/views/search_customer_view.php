    
   <script>
   function test()
{

 var s=document.getElementById("customer_name").value;
 if(document.getElementById("reg_no")!=null){
  var r=document.getElementById("reg_no").value;
 }else{
 	var r='';
 }
 
 <?php if($_SESSION['process_id']==9){ 
 	$url= site_url('search_customer/search_complaint'); 
 }else{
 	$url= site_url('search_customer/search'); 
 }
 ?>
//alert(s);

					$.ajax(
					{
					url:"<?php echo $url; ?>",
							type:'POST',
							data:{customer_name:s,reg_no:r},
							success:function(response)
							{$("#replace_table").html(response);}
							});

}

   
   
   </script>


   	<div class="row">
   		
                        
                            <div class="x_panel">
                         
						<div class="col-md-10 col-md-offset-2">
							<div class="col-md-8">
							<div class="form-group">
							
							<label class="control-label col-md-4 col-sm-5 col-xs-12" for="first-name" style="margin-top:5px;"> Search Name or Contact : </label>
								<div class="col-md-6 col-sm-7 col-xs-12">
								<input type="text" placeholder=" e.g Ravi Patil or 8888807738 "  autocomplete="off" class="form-control" id="customer_name" required name="customer_name">

								</div>
								<div class="col-md-2" style="margin-bottom: 20px">                                                     
                                  
									  <!--<div class="pull-middle  ">-->
                                        
                                        <button  class="btn btn-info" type="button" onClick="return test();"><i class="entypo-search"></i>  </button>        
										
                                    <!--</div>--> 
									
									</div>
							</div>
							</div>
							
						</div>
						<?php if($_SESSION['process_id']==8){ ?>
				<div class="col-md-10 col-md-offset-2">
							<div class="col-md-8">
							<div class="form-group">
				<label class="control-label col-md-4 col-sm-5 col-xs-12" for="first-name" style="margin-top:5px;"> Search Registration Number : </label>
								<div class="col-md-6 col-sm-7 col-xs-12">
								<input type="text" placeholder=" e.g MH12GH1233"  autocomplete="off" class="form-control" id="reg_no" required name="reg_no">

                     </div>
                     </div>
                     </div>
                     </div>
                               
                           <?php } ?>   
								<div class="col-md-12" style="margin-top: 10px;margin-bottom: 5px;">
									<div class="col-md-7 col-md-offset-4">
									<label class="control-label col-md-9 col-sm-9 col-xs-12 text-center" for="first-name"><b style="color:red;font-size:12px;"> *** Please Enter Full Name or Correct Contact number for exact result *** </b> </label>
									</div>
								</div>
		 </div></div>


	<div class="row " id="replace_table" class="col-md-12" >
		
		
			
	

		
	</div>

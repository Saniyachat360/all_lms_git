
<div class="row" style="margin-left:0px;margin-right: 0px;">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('msg');?>
		<?php  $msg_error = $this->session->flashdata('msg_error'); if(isset($msg_error)){?>
				<div class="alert alert-success text-center col-md-offset-3 col-md-6">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>
				<p style="text-align:left">Error found in <?php
$t=15;
for($i=0;$i<count($msg_error);$i++){ ?><?php 
echo $msg_error[$i];
if(count($msg_error)-1 == $i){}else{ echo ','; }


if($t==$i){
	echo "<br>";
	$t=$t+15;
}
 } ?></p></strong></div>
				<?php } ?></div>
		<div class="col-md-12" >
				<h1 style="text-align:center;">Upload Stock </h1>
			    
                    
                     <div class="row">
                    <div id="abc">

                 <div class="col-md-8">
 <div class="panel panel-primary ">
    
     <div class="panel-body">
     
              <form name='import' action="<?php echo $var; ?>" method="post"  enctype="multipart/form-data">
              
						
                     	
						
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                     	
                     	
                     	
	           <div class="form-group">
	           	<label class="control-label col-md-4 col-sm-4 col-xs-12">Stock Type: </label>
	           		<div class="col-md-5 col-sm-5 col-xs-12">
                    <select class="filter_s col-md-12 col-xs-12 form-control" id="stocktype" name="stocktype"  required>
                    	<option value="">Please Select</option>
						<!--option value="New Car">New Car</option-->
						<option value="Used Car">Used Car</option>
                                
                    </select>
                   </div>

					 </div>
            
  <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<label class="control-label "><font color="red">Please upload only .xls file</font></label>
								</div>
							</div>
    <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Upload File:</label>
								<div class="col-md-5 col-sm-5 col-xs-12" id='select_file'>
									<input type="file"  class="btn btn-info"  name="file" id="file" required >
								</div>
							</div>
<div class="form-group">
						<div class="col-md-2 col-md-offset-4">

							<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>

						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div>
</div>
</form>

                    </div>
                    
                    </div>
                    </div>
                  
	
	<div class="col-md-4">
                     <div class="panel panel-primary">
    
     <div class="panel-body">
     	<a href="https://www.autovista.in/all_lms/upload_poc_stock_xls_format.xls" class="btn btn-info">Poc Stock Upload Format</a><br><br>
     		<!--<a href="https://www.autovista.in/all_lms/upload_followup_xls_format.xls" class="btn btn-primary">Followup Leads Upload Format</a>-->
     </div>
     </div>
      </div>
           </div>
             

                        </div>
                      
                    </div>       
            </div>
      



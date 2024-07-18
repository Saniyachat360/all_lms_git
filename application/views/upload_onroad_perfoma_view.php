<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="row" style="margin-left:0px;margin-right: 0px;">
	<div class="col-md-12" >
		<div><?php echo $this -> session -> flashdata('message'); ?>
			</div>
		<h1 style="text-align:center;">Upload Web Quotation</h1>
	
		
		<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-body">
				<form name='import' action="<?php echo $var; ?>" method="post"  enctype="multipart/form-data">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!--div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location:</label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								  <select class="filter_s col-md-12 col-xs-12 form-control" id="location" name="location" required >
                                              	    	 	 <option value="">Please Select  </option>
										                       		<option value="Mumbai">Mumbai</option>
								                        			
								                        			<option value="Pune">Pune</option>
                                              	        </select>
							</div>
						</div-->
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<label class="control-label "><font color="red">Please upload only .xls file</font></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Upload File:</label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<input type="file"  class="btn btn-info"  name="file" id="file" required  >
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
						<br>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<label class="control-label "><font color="red">Note:Same quotation changes reflect on Autovista Website</font></label>
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
     	<div class="col-md-12" style="padding: 10px;">
     		<div class="form-group">
     	  <a target="_blank" onclick="download_old_data()">
                            
                <i class="btn btn-primary entypo-download col-md-12 col-xs-12 col-sm-12">  Download Quotation Old Data Format</i></a>
                  </div>
                </div>
                 <!--div class="col-md-12" style="padding: 10px;">
                 	<div class="form-group">
                  <a target="_blank" onclick="backup_old_data()" >
                            
                <i class="btn btn-info entypo-download col-md-12 col-xs-12 col-sm-12">Backup Quotation</i></a>
                </div>
                 </div>
                 <div class="col-md-12" style="padding: 10px;">
                <form action='<?php echo site_url('upload_web_quotation/restorebackup')?>' method='post' onsubmit='return confirmrestore()'>
                	<button type="submit" class="btn btn-success entypo-cw col-md-12 col-xs-12 col-sm-12" >
								Restore Quotation
								</button-->
								<br>
								<p style='text-align:center;margin-top: 26px;'><?php if(count($backup_date)>0)
                	{
                		echo "(Last Updated:".$backup_date[0]->date.")";
                	}
                	else
                	{
                		echo "(Not Found)";
                	}?></p>
                	</form>
                	 </div>
     <!--	<a href="<?php echo base_url();?>upload_web_quotation.xls" class="btn btn-info">Upload Quotation Format</a><br><br>   
     		<a href="<?php echo base_url();?>upload_followup_xls_format.xls" class="btn btn-primary">Followup Leads Upload Format</a>-->
     </div>   
     </div>    
      </div>          
	</div>
            
  	</div>                  
                    
      <script>
function download_old_data()
{
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"upload_web_quotation/download_old_data_performa");
}
function backup_old_data()
{
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"upload_web_quotation/backup_old_data");
}
function confirmrestore()
{
	
    job=confirm("Are you sure to restore permanently?");
    if(job!=true)
    {
        return false;
    }

}
</script>      


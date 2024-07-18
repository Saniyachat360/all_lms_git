<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	}); 

    function checkvalue() {
      	checked1 = $("input:checkbox[class=finance]:checked").length;
 		 if(!checked1) {
        alert("You must check at least one loan type .");
        return false;
    }
    }

</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[5]==1)
	{?>
	<h1 style="text-align:center; ">Edit Document</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
			     <?php
					if(count($document)>0) 
						{?>
				<form action="<?php echo $var; ?>" method="post" onsubmit='return checkvalue()'>
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
						
							
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Document Name: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="document" required name="document" 	value="<?php echo $document[0]->document_name ;?>">
								</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Loan Type: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
								    <?php 
								   
								    foreach ($select_loan_type as $row) {   $checked='';?>
								      
								    <?php foreach($document as $row1)
								    {
								        if($row1->loan_id==$row->loan_id)
													{
													  //  echo "hi";
													   $checked="checked";
													    break;
													}
								    }?>
								    <input type='checkbox' name='loan_id[]' id='loan_id'  class='finance' value='<?php echo $row->loan_id;?>' <?php echo $checked;?> ><?php echo $row->loan_name;?>
								    	<?php	} ?>
							
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Mandatory: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
								   
								    <input type='checkbox' name='mandatory' id='mandatory'  <?php if($document[0]->mandatory=='Yes') { echo "checked";}?>>
								    
							
								</div>
							</div>
						
						</div>
					</div>
						<input type="hidden" class="form-control" value="<?php echo $document[0]->document_id;?>"  name="document_id" >
					<div class="form-group">
						<div class="col-md-2 col-md-offset-4">
							<button type="submit" id='checkBtn' class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>
						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div>
			</div>
		</div>
		</form>
		<?php } ?>
	</div>
<?php } ?>
</div>

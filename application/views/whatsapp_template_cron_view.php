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
</script>
 <script>
                   function sendtodesc(X)
                   {
                         var a1=CKEDITOR.instances['product_description'].getData();
                         
                       //  alert(a1);
                         var imageSrcUrl=a1+X;
                   
                       CKEDITOR.instances['product_description'].setData(imageSrcUrl);
                    
                   }
                   </script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[5]==1)
	{?>
	<h1 style="text-align:center; ">Add Whatsapp Template</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post" enctype="multipart/form-data">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Template Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<input type="text" id="name" placeholder="Enter Template Name" required name="name" 
                  autocomplete="off" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Whatsapp Type: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="type" class="form-control" id='type' required="" onchange='hodiday()' >
								    <option value="">Please Select </option>
                         					<?php foreach ($sms_type as $row) {?>
											<option value="<?php echo $row->stype_name;?>"><?php echo $row->stype_name.' / '.$row->s_desc;?></option>
						            	<?php	} ?>
									</select>
								</div>
							</div>
								<div class="form-group" id='holidaydiv' style='display:none'>
								<label class="control-label col-md-4 col-sm-4 col-xs-12">Occasion: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="holiday_id" class="form-control" id='holiday_id' required disabled>
								    <option value="">Please Select </option>
                         					<?php foreach ($holiday as $row) {?>
											<option value="<?php echo $row->holiday_id;?>"><?php echo $row->name.' / '.$row->date;?></option>
						            	<?php	} ?>
									</select>
								</div>
							</div>
							<!--div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Subject: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							 <input type="text" id="subject" placeholder="Enter Subject" required name="subject" 
                   autocomplete="off" class="form-control" >	</div>
							</div-->
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							 <textarea id="product_description" name="product_description" rows="10" cols="80">
                                           
                    </textarea>
								</div>
							</div>
							
							
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Fields: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							 <?php foreach($select_fields as $frow)
                        {
                            ?>
                             <a onclick="sendtodesc('<?php echo $frow->field_value;?>')" href='#'><?php echo $frow->field_name;?> </a> &nbsp; &nbsp;
                            <?php
                        }?>
								</div>
							</div>
							
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Attachment: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							<input id="fileupload" class="btn btn-info"  name="product_image[0][]" type="file" multiple="multiple" accept="application/pdf" />
								</div>
							</div>
							
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
		</div>
		</form>
	</div>
<?php } ?>
</div>
<div class="row" >
	<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify'];
		$delete = $_SESSION['delete'];	
		?>
		<div class="table-responsive"  >
			<table id="example"  class="table " style="width: 100%" > 
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Name</th>
						<th>Whatsapp Type</th>
				
					<th>Description</th>
					<th>Attachment</th>
						<th>Status</th>
					<?php if($modify[5]==1 || $delete[5]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_templates as $row)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
				<td><?php echo $row -> template_name; ?></td>
				 <td><?php echo $row -> sms_type.' / '.$row->s_desc;
                  if($row->time !=''){
                      echo ' / '.$row->time;
                  }if($row->sms_type=='Occassion'){ echo ' ('.$row->name.':'.$row->date.') ';}
                  ?></td>
                 
                  <td><?php echo $row -> description; ?></td>
                     <td><?php  if($row -> attachment_list !='')
                   {
                       $a=explode(',',$row -> attachment_list);
                     //  print_r($a);
                       $c=count($a);
                       for($k=0;$k<$c;$k++)
                       {
                          // echo $a[$k];
                            ?>
                            <a href="<?php echo base_url()?>/assets/mail_attachment/<?php echo $a[$k];?>" target='_blank'> 
                       <?php echo $a[$k];?>
                   </a><br>
                            <?php
                       }
                   }; ?></td>
                    <td><?php  if($row ->status=='1'){?>Active <?php }else{ ?> Deactive <?php } ?></td>
                <td> <?php if($row ->status=='1'){?>
                  <?php 
        if(isset($modify[5]))
        {if($modify[5]==1){?>
                <a href="<?php echo site_url(); ?>/whatsapp_template_cron/template_edit/<?php echo $row ->t_id; ?>">Edit </a><?php }  } ?> &nbsp;&nbsp; <!--go to function edit_user in add_my user_controller when click on edit link (3)-->
                <?php if(isset($delete[5]))
        {if($delete[5]==1){?>
                <a onclick="return getConfirmation()" href="<?php echo site_url(); ?>/whatsapp_template_cron/template_delete/<?php echo $row ->t_id; ?>">Delete </a>
                 <?php }  } ?>
          <?php }
      else
      {
            ?>
            <a onclick="return getActionConfirmation()" href="<?php echo site_url(); ?>/whatsapp_template_cron/template_action/<?php echo $row ->t_id; ?>">Active</a> &nbsp;&nbsp;
            <?php
      }
    ?></td>
                 
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>

 <script>
 function hodiday()
  { var a=document.getElementById("type").value;
  
      if(a=='Occassion')
      {
          document.getElementById('holidaydiv').style.display = "block";
          document.getElementById("holiday_id").disabled = false; 
      }else
      {
          document.getElementById("holiday_id").disabled = true; 
          document.getElementById('holidaydiv').style.display = "none";
      }
  }
  function getConfirmation() {
    var retVal = confirm("Do you want to continue ?");
    if (retVal == true) {

      return true;
    } else {

      return false;
    }
  }
function getActionConfirmation() {
    var retVal = confirm("Do you want to Active ?");
    if (retVal == true) {

      return true;
    } else {

      return false;
    }
  }
</script>

<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
    <script>
    
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	var editor_config = {
    height: "150px"
};

CKEDITOR.replace('product_description', editor_config );
	
	 /*CKEDITOR.replace('product_description');
	 CKEDITOR.replace( 'Resolution', {
        height: 100
    } );
	*/
		
  })
</script> 
   <script type="texta/javascript">function() {
   	$('#lower').keyup(function(){

  $(this).val($(this).val().toLowerCase());
});
}</script>

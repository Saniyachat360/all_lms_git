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
	<h1 style="text-align:center; ">Edit Mail Template</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
			        <?php if(count($template_edit)>0){
       ?> 
				<form action="<?php echo $var; ?>" method="post" enctype="multipart/form-data">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Template Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							 <input type="text" id="name" placeholder="Enter Template Name" required name="name" 
                   autocomplete="off" value="<?php echo $template_edit[0]->template_name;?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Subject: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							  <input type="text" id="subject" placeholder="Enter Subject" required name="subject" 
                   autocomplete="off" class="form-control" value="<?php echo $template_edit[0]->subject;?>" >
	</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							 <textarea id="product_description" name="product_description" rows="10" cols="80">
                                <?php echo $template_edit[0]->description;?>            
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
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Attachment: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
						<?php foreach($template_edit as $frow)
                        {
                            if($frow->attachment_name !=''){
                            ?>
                            <a href="<?php echo base_url()?>/assets/mail_attachment/<?php echo $frow->attachment_name?>" target='_blank'> 
                       <?php echo $frow->attachment_name?>
                   </a>&nbsp; <a style='color:red' onclick="return getActionConfirmation()" href='<?php echo site_url(); ?>/mail_template/delete_attachment/<?php echo $frow ->attach_id; ?>/<?php echo $template_edit[0]->t_id;?>'>X</a> &nbsp; &nbsp;
                            <?php
                       } }?>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="ctype_id" value="<?php echo $template_edit[0]->t_id;?>" name="ctype_id" >
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
		<?php } ?>
	</div>
<?php } ?>
</div>
 <script>
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
   
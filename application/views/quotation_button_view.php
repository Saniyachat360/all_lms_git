<div class="container" style="width: 100%;">
	<div class="row">
	
		<h1 style="text-align:center;">Confirm Details</h1> <br/>
		<form action="<?php echo site_url(); ?>new_quotation_send/send_quotation_via" method="post">
			<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        <?php if(count($quotation_data)>0){ ?>

        <input type='hidden' name='customer_name' value='<?php echo $quotation_data[0]->name;?>'>
        <input type='hidden' name='contact_no' value='<?php echo $quotation_data[0]->contact_no;?>'>
        <input type='hidden' name='email' value='<?php echo $quotation_data[0]->email;?>'>
        <input type='hidden' name='enq_id' value='<?php echo $quotation_data[0]->enq_id;?>'>
         <input type='hidden' name='h_code' value='<?php echo $quotation_data[0]->confirmation_code;?>'>
         <input type='hidden' name='model_name' value='<?php echo $quotation_data[0]->model_name;?>'>
         <input type='hidden' name='variant_name' value='<?php echo $quotation_data[0]->variant_name;?>'>
          <?php } ?>
				<input type='hidden' name='quotation_id' value='<?php echo $quotation_id;?>'>
			<div class="panel panel-primary">
 							<div class="panel-body">
				<div class="col-md-4">
			<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Send On Mail: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="mail" name="mail" ></label>
                                     	</div>
                                    </div> 
                                    </div> 
                                    <div class="col-md-4">
			<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Send On SMS: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="sms" name="sms" ></label>
                                     	</div>
                                    </div> 
                                    </div> 
                                    <div class="col-md-4">
			<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Send On Whatsapp: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="whatsapp" name="whatsapp" ></label>
                                     	</div>
                                    </div> 
                                    </div> 
                                    <div class="form-group">
      <div class="col-md-2 col-md-offset-5">
          <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
     </div>
     <div class="col-md-2">
          <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Cancel</button>
     </div>
    </div>
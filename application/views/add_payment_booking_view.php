<?php //phpinfo()
?>

<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php $insert = $_SESSION['insert'];
	if ($insert[0] == 1) { ?>
		<h1 style="text-align:center; ">Add Booking Form</h1>
		<div class="col-md-12">
			<div class="panel panel-primary">

				<div class="panel-body">
					<!-- <form action="<?php echo site_url() ?>/add_payment_booking/insert_booking?api_name=initiate_payment" method="post" > -->
					<form action="<?php echo site_url() ?>/add_payment_booking/easycollect?api_name=easycollect_payment" method="post">
						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" required autocomplete="off" class="form-control" id="name" required name="name" placeholder="Customer Name">

									</div>
								</div>

							</div>
						</div>

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email Id: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" class="form-control" id="email" required name="email" placeholder="Customer Email">

									</div>
								</div>

							</div>
						</div>

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Phone Number: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" id="phone" required name="phone" placeholder="Customer Phone Number">

									</div>
								</div>

							</div>
						</div>

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Model: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select name="model_id" id="new_model" required class="form-control">
											<option value="">Please Select </option>
											<?php foreach ($select_model as $row4) { ?>
												<option value="<?php echo $row4->model_id; ?>"><?php echo $row4->model_name; ?></option>
											<?php } ?>
										</select>
									</div>

								</div>
							</div>

						</div>


						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Amount: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 1)" autocomplete="off" class="form-control" id="amt" required name="amount" placeholder="Enter Amount e.g.10.00">

									</div>
								</div>

							</div>
						</div>

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="message_regarding_booking">Message: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<textarea class="form-control" id="message" required name="message" placeholder="Enter Message "></textarea>

									</div>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-2 col-md-offset-4">
								<input type="hidden" id="surl" class="form-control" name="surl" value="https://autovista.in/all_lms_dev/add_payment_booking/response">
								<input type="hidden" id="furl" class="form-control" name="furl" value="https://autovista.in/all_lms_dev/add_payment_booking/response">
								<input type="hidden" id="merchant_txn" class="merchant_txn" name="merchant_txn" value="<?php echo rand(0, 1000000); ?>">
								<!-- <input type="hidden" id="productinfo" class="productinfo" name="productinfo" value="1"> -->
								<input type="hidden" id="sub_merchant_id" class="sub_merchant_id" name="sub_merchant_id" value="S58858AVJK">
								<input type="hidden" id="udf1" class="udf1" name="udf1" value="MH00000">
								<input type="hidden" id="udf2" class="udf2" name="udf2" value="udf">
								<button type="submit" name='submit' value="Pay" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
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

<script>
	$(function() {
		$('#name').keydown(function(e) {
			if (e.shiftKey || e.ctrlKey || e.altKey) {
				e.preventDefault();
			} else {
				var key = e.keyCode;
				if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
				}
			}
		});
	});

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
	}
</script>
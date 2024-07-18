
//Show and hide div using buyer type
function select_buyer_type () {
	if(document.getElementById('buyer_type').value=='Exchange' )
	{
	document.getElementById('first_div').style.display = "block";
	document.getElementById('exchange_div').style.display = "block";
	}else if(document.getElementById('buyer_type').value=='First' )
	{
		document.getElementById('first_div').style.display = "block";
		document.getElementById('exchange_div').style.display = "none";
	}else{
		document.getElementById('first_div').style.display = "none";
		document.getElementById('exchange_div').style.display = "none";
	}
}

//Show and hide transfer div
function get_transfer()
{
	//document.getElementById('first_div').style.display = "none";
	//document.getElementById('exchange_div').style.display = "none";
	if(document.getElementById('transfer_div').style.display=="none")
	{
	document.getElementById('transfer_div').style.display = "block";
	}else
	{
	document.getElementById('transfer_div').style.display = "none";	
	}

}

//Show and hide manager remark div
function get_remark_div()
{
	document.getElementById('add_remark').style.display = "block";
	document.getElementById('add_followup').style.display = "none";
	document.getElementById('exchange_div').style.display = "none";
	document.getElementById('first_div').style.display = "none";
		
} 

//show and hide followup div
function get_followup_div()
{
	document.getElementById('add_followup').style.display = "block";
	document.getElementById('add_remark').style.display = "none";
	var buyer=document.getElementById("buyer_type").value ;
	if(buyer=='Exchange')
	{
		document.getElementById('exchange_div').style.display = "block";
		document.getElementById('first_div').style.display = "block";
	}
	else if(buyer == 'First')
	{
		document.getElementById('first_div').style.display = "block";
	}
}
	$(document).ready(function() {
							$('.datett').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});					
});
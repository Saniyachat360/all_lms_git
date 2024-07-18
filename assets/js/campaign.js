$(document).ready(function() {
							$('.datett').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});					
});
 //add_campaign delete record
 function getConfirmation(){
               var retVal = confirm("Do you want to continue ?");
               if( retVal == true ){
                
			return true;
               }
               else{
				   
                return false;
               }
            }
 jQuery(document).ready(function(){
 $('#results').DataTable();});
 
//For add new customer view,add new lms user
function validate_form() {
	
		//var dept_count = ($('[name="dept[]"]:checked').length);
		//alert(dept_count);

		var phone1 = document.forms["submit"]["pnum"].value;
		var x = document.forms['submit']['email'].value;
		if (x != '') {
			var atpos = x.indexOf("@");
			var dotpos = x.lastIndexOf(".");
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {

				alert("Not a valid e-mail address!");
				return false;
				
			}
		}
		var no = /^\d{10}$/;

		if (no.test(phone1)) {
			//	return true;
		} else {
			alert("Phone Number must be 10 Digit!");

			return false;
			
		}
	/*	if (dept_count == 0) {
			alert("Please Select Atleast One Department");
			return false;
		}*/

	}

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

	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
	}


	$(document).ready(function() {
		$("#fname").keypress(function(event) {
			var inputValue = event.which;
			// allow letters and whitespaces only.
			if ((inputValue > 47 && inputValue < 58) && (inputValue != 32)) {
				event.preventDefault();
			}
		});
	});
//For Add Right View	
function select_checkbox(){
	//alert("hii");
	var select_all = document.getElementById("select_all"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	//select all checkboxes
	select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) {checkboxes[i].checked = select_all.checked;}
    });
	for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
    select_all.checked = false;
    }
   	//check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
    select_all.checked = true;
    }
   });
   }
}
//For Add Right View
function select_checkbox1(){
	//alert("hii");
	var select_all = document.getElementById("select_all1"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox1"); //checkbox items
	//select all checkboxes
	select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) {checkboxes[i].checked = select_all.checked;}
    });
	for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
    select_all.checked = false;
    }
   	//check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
    select_all.checked = true;
    }
   });
   }
}
//For add Right view
function select_checkbox2(){
	//alert("hii");
	var select_all = document.getElementById("select_all2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	//select all checkboxes
	select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) {checkboxes[i].checked = select_all.checked;}
    });
	for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
    select_all.checked = false;
    }
   	//check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
    select_all.checked = true;
    }
   });
   }
}
//For Add Right View
function select_checkbox3(){
	//alert("hii");
	var select_all = document.getElementById("select_all3"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox3"); //checkbox items
	//select all checkboxes
	select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) {checkboxes[i].checked = select_all.checked;}
    });
	for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
    select_all.checked = false;
    }
   	//check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
    select_all.checked = true;
    }
   });
   }
}

//For assign lead
function validate_button()
{
	if(document.getElementById('user_location').value=='')
	{
		alert("Please Select Location");
		return false;
	}
	
 var fields = $("input[id='cse_name']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Select At least One CSE Name'); 
        // cancel submit
        return false;
    } 
   
var x=0;
var web_count=document.getElementById('all_count').value;
for(var i=1 ; i<=web_count;i++)
{
if(document.getElementById('web-'+i).checked) 
{
x++;
} 
}
/*var lead_count=document.getElementById('campaign_name_count').value;

for(var i=1 ; i<=lead_count;i++)
{
if(document.getElementById('c'+i).checked) 
{
x++;
} 
}*/
if(x==0)
{
alert('Please Select At least One Campaign');
return false;
}

}
//For assign transferred lead
function validate_transferred_button()
{
	
	if(document.getElementById('fromLocation').value=='')
	{
		alert("Please Select From Location");
		return false;
	}
	if(document.getElementById('toLocation').value=='')
	{
		alert("Please Select To Location");
		return false;
	}
	

   var lead_type=document.getElementById('lead_type').value;
   if(lead_type=='source'){
var x=0;
var web_count=document.getElementById('all_count').value;

for(var i=1 ; i<=web_count;i++)
{
if(document.getElementById('web-'+i).checked) 
{
x++;
} 
}

if(x==0)
{
alert('Please Select At least One Campaign');
return false;
}
}else{
	var new_lead=document.getElementById('new_lead_radio').checked;
	var today_followup_lead=document.getElementById('today_followup_lead_radio').checked;
	var pending_new_lead=document.getElementById('pending_new_lead_radio').checked;
	var pending_followup_lead=document.getElementById('pending_followup_lead_radio').checked;
	//alert(new_lead);
	
	if(new_lead=='' && today_followup_lead=='' && pending_new_lead=='' && pending_followup_lead==''){
		alert("Please select Aleast One status");
		return false;
	}
	
	
}
 var fields = $("input[id='cse_name']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Select At least One CSE Name'); 
        // cancel submit
        return false;
    } 

}
//For assign Lead view
	function hidefbcamp() {
				document.getElementById('campaign_name').disabled = true;
				$("#fbcampaign").hide();
			}
//For assign Lead view
			function showfbcamp(x) {
				if (document.getElementById(x).checked == true) {
					$("#fbcampaign").show();
					document.getElementById('campaign_name').disabled = false;
				} else {
					document.getElementById('campaign_name').disabled = true;
					$("#fbcampaign").hide();
				}
			}
//For assign Lead view
			function hideleads(y) {

				if (document.getElementById(y).checked == true) {
					document.getElementById('lnum').disabled = true;
					$("#noleaddiv").hide();
				} else {
					$("#noleaddiv").show();
					document.getElementById('lnum').disabled = false;
				}
			}
			//For assign Lead view
function show_excel(x) {
			if (document.getElementById(x).checked == true) {
				$("#excel_lead").show();
				document.getElementById('excel_name').disabled = false;
			} else {
				document.getElementById('excel_name').disabled = true;
				$("#excel_lead").hide();
			}
		}

//For assign Lead view
		function hide_excel_leads(y) {

			if (document.getElementById(y).checked == true) {
				document.getElementById('lnum').disabled = true;
				$("#noleaddiv").hide();
			} else {
				$("#noleaddiv").show();
				document.getElementById('lnum').disabled = false;
			}
		}
//For assign Lead view
		function get_web(x,y,z)
				{
					
				var count=document.getElementById('all_count').value;
			
				for(var j=1;j<=count;j++)
				{
				if(document.getElementById(y).checked == true )
				{
				
				document.getElementById('web_count-'+j).disabled = true;
				document.getElementById('w_count-'+j).disabled = true;
				
				
				}
				else{

				document.getElementById('web_count'+j).disabled = false;
				document.getElementById('w_count'+j).disabled = false;
				
				}

				}
				document.getElementById(x).disabled = false;
				document.getElementById(z).disabled = false;

				}
				//For assign Lead view
				function get_campaign(x,y,z)
				{
					
					

				var count=document.getElementById('campaign_name_count').value;
				for(var j=1;j<=count;j++)
				{
				if(document.getElementById(y).checked == true )
				{

				document.getElementById('l'+j).disabled = true;
				document.getElementById('cc'+j).disabled = true;
				var count1=document.getElementById('all_count').value;
				for(var i=1;i<=count1;i++)
				{
				
				document.getElementById('web_count-'+i).disabled = true;
				document.getElementById('w_count-'+i).disabled = true;
				document.getElementById('web-'+ i).checked = false;
				}
				}
				else{

				document.getElementById('l'+j).disabled = false;
				document.getElementById('cc'+j).disabled = false;
				for(var i=1;i<=count1;i++)
				{
				
				document.getElementById('web_count-'+i).disabled = false;
				document.getElementById('w_count-'+i).disabled = false;
				}
				}

				}
				document.getElementById(x).disabled = false;
				document.getElementById(z).disabled = false;

				}
				//For assign Lead view
				function check_count(x,y)
				{
				
				var count1=document.getElementById(x).value;
				var v=document.getElementById(y).value;
			
				var v1=parseInt(count1);
				var v2=parseInt(v);
					
				if(v1<v2)
				{
				alert(v2 +' is greater then Available Leads');
				document.getElementById(y).value='';
				}
				

				}
				//For assign Lead view
				function check_count(x,y)
				{

				var count1=document.getElementById(x).value;
				var v=document.getElementById(y).value;
				var v1=parseInt(count1);
				var v2=parseInt(v);
				if(v1<v2)
				{
				alert(v2 +' is greater then Available Leads');
				document.getElementById(y).value='';
				}

				}
function transfer_lead() {

	if (document.getElementById('transfer').checked == true) {
		
		$("#tlocation").show();
			$("#tassignto").show();
			$("#tprocess").show();
			$("#evaluation_location").show();
			$("#evaluation_assign_to").show();
		document.getElementById("tlocation1").disabled = false;
		document.getElementById("tassignto1").disabled = false;
		document.getElementById("tprocess").disabled = false;
		document.getElementById("evaluation_location").disabled = false;
		document.getElementById("evaluation_assign_to").disabled = false;
			document.getElementById("lead_status1").disabled = false;
		document.getElementById("lead_status2").disabled = false;
		//document.getElementById("transfer_reason").disabled = false;
			
} else {
	document.getElementById("tlocation1").disabled = true;
	document.getElementById("tassignto1").disabled = true;
	document.getElementById("tprocess").disabled = true;
	document.getElementById("evaluation_location").disabled = true;
		document.getElementById("evaluation_assign_to").disabled = true;
			document.getElementById("lead_status1").disabled = true;
		document.getElementById("lead_status2").disabled = true;
	//document.getElementById("transfer_reason").disabled = true;
			$("#tlocation").hide();
			$("#tassignto").hide();
			$("#tprocess").hide();
			$("#evaluation_location").hide();
			$("#evaluation_assign_to").hide();
			
	}
}
function send_quotation() {
	
if (document.getElementById('quotation').checked == true) {
		document.getElementById("qlocation").disabled = false;
		document.getElementById("description").disabled = false;
		document.getElementById("model_name").disabled = false;
		
			$("#quotation1").show();
} else {
	document.getElementById("qlocation").disabled = true;
	document.getElementById("description").disabled = true;
	document.getElementById("model_name").disabled = true;
		
			$("#quotation1").hide();
	}
		
	}
	//Show and hide Exchange Div
	function check_buyer(val) {
	
	if (val == 'Exchange') {
	$("#exchange").show();
	document.getElementById("model").disabled = false;
	document.getElementById("make").disabled = false;
	//document.getElementById("color").disabled = false;
	document.getElementById("mfg").disabled = false;
	document.getElementById("km").disabled = false;
	document.getElementById("ownership").disabled = false;
//	document.getElementById("claim").disabled = false;
	$("#additional_btn").hide();
	
	$("#first_div").show();
	document.getElementById("new_model").disabled = false;
	document.getElementById("new_variant").disabled = false;
	//document.getElementById("book").disabled = false;
	
	
	document.getElementById("buy_make").disabled = true;
	document.getElementById("buy_model").disabled = true;
	document.getElementById("budget_to").disabled = true;
	document.getElementById("budget_from").disabled = true;
	/*document.getElementById("visit_status").disabled = true;
	document.getElementById("visit_location_div").disabled = true;
	document.getElementById("visit_booked_div").disabled = true;
	document.getElementById("visit_booked_date_div").disabled = true;
	document.getElementById("sales_status").disabled = true;
	document.getElementById("car_delivered").disabled = true;*/

	$("#buy_used_car").hide();
	
	} else if(val == 'Buy Used Car'){
	
		
	document.getElementById("model").disabled = true;
	document.getElementById("make").disabled = true;
	//document.getElementById("color").disabled = true;
	document.getElementById("mfg").disabled = true;
	document.getElementById("km").disabled = true;
	document.getElementById("ownership").disabled = true;
//	document.getElementById("claim").disabled = true;
	$("#first_div").hide();
	document.getElementById("new_model").disabled = true;
	document.getElementById("new_variant").disabled = true;
	//document.getElementById("book").disabled = true;
	$("#exchange").hide();
	
	$("#buy_used_car").show();
	document.getElementById("buy_make").disabled = false;
	document.getElementById("buy_model").disabled = false;
	document.getElementById("budget_to").disabled = false;
	document.getElementById("budget_from").disabled = false;
	/*document.getElementById("visit_status").disabled = false;
	document.getElementById("visit_location_div").disabled = false;
	document.getElementById("visit_booked_div").disabled = false;
	document.getElementById("visit_booked_date_div").disabled = false;
	document.getElementById("sales_status").disabled = false;
	document.getElementById("car_delivered").disabled = false;*/

	
	}else if(val == 'Sell Used Car'){
		$("#exchange").show();
	document.getElementById("model").disabled = false;
	document.getElementById("make").disabled = false;
	//document.getElementById("color").disabled = false;
	document.getElementById("mfg").disabled = false;
	document.getElementById("km").disabled = false;
	document.getElementById("ownership").disabled = false;
//	document.getElementById("claim").disabled = false;
	$("#additional_btn").hide();
	
	
	
	document.getElementById("new_model").disabled = true;
	document.getElementById("new_variant").disabled = true;
	//document.getElementById("book").disabled = true;
	$("#first_div").hide();
	
	document.getElementById("buy_make").disabled = true;
	document.getElementById("buy_model").disabled = true;
	document.getElementById("budget_to").disabled = true;
	document.getElementById("budget_from").disabled = true;
	/*document.getElementById("visit_status").disabled = true;
	document.getElementById("visit_location_div").disabled = true;
	document.getElementById("visit_booked_div").disabled = true;
	document.getElementById("visit_booked_date_div").disabled = true;
	document.getElementById("sales_status").disabled = true;
	document.getElementById("car_delivered").disabled = true;*/
	$("#buy_used_car").hide();
	
	}else if(val =='First')
	{
		$("#first_div").show();
	document.getElementById("new_model").disabled = false;
	document.getElementById("new_variant").disabled = false;
	//document.getElementById("book").disabled = false;
			
	document.getElementById("model").disabled = true;
	document.getElementById("make").disabled = true;
	//document.getElementById("color").disabled = true;
	document.getElementById("mfg").disabled = true;
	document.getElementById("km").disabled = true;
	document.getElementById("ownership").disabled = true;
	//document.getElementById("claim").disabled = true;
	$("#exchange").hide();
	
	
	document.getElementById("buy_make").disabled = true;
	document.getElementById("buy_model").disabled = true;
	document.getElementById("budget_to").disabled = true;
	document.getElementById("budget_from").disabled = true;
	/*document.getElementById("visit_status").disabled = true;
	document.getElementById("visit_location_div").disabled = true;
	document.getElementById("visit_booked_div").disabled = true;
	document.getElementById("visit_booked_date_div").disabled = true;
	document.getElementById("sales_status").disabled = true;
	document.getElementById("car_delivered").disabled = true;*/
		$("#buy_used_car").hide();
		
	}
		else if(val =='Additional')
	{
		$("#first_div").show();
	document.getElementById("new_model").disabled = false;
	document.getElementById("new_variant").disabled = false;
	//document.getElementById("book").disabled = false;
			
	
	document.getElementById("model").disabled = true;
	document.getElementById("make").disabled = true;
	//document.getElementById("color").disabled = true;
	document.getElementById("mfg").disabled = true;
	document.getElementById("km").disabled = true;
	document.getElementById("ownership").disabled = true;
//	document.getElementById("claim").disabled = true;
	$("#exchange").hide();
	$("#additional_btn").show();
	
	
	document.getElementById("buy_make").disabled = true;
	document.getElementById("buy_model").disabled = true;
	document.getElementById("budget_to").disabled = true;
	document.getElementById("budget_from").disabled = true;
	/*document.getElementById("visit_status").disabled = true;
	document.getElementById("visit_location_div").disabled = true;
	document.getElementById("visit_booked_div").disabled = true;
	document.getElementById("visit_booked_date_div").disabled = true;
	document.getElementById("sales_status").disabled = true;
	document.getElementById("car_delivered").disabled = true;*/
		$("#buy_used_car").hide();
	
		}
		else if (val == 'Exchange With Old Car') 
		{
	$("#exchange").show();
	document.getElementById("model").disabled = false;
	document.getElementById("make").disabled = false;
	//document.getElementById("color").disabled = false;
	document.getElementById("mfg").disabled = false;
	document.getElementById("km").disabled = false;
	document.getElementById("ownership").disabled = false;
	//document.getElementById("claim").disabled = false;
	$("#additional_btn").hide();
	
	$("#buy_used_car").show();
	document.getElementById("buy_make").disabled = false;
	document.getElementById("buy_model").disabled = false;
	document.getElementById("budget_to").disabled = false;
	document.getElementById("budget_from").disabled = false;
	/*document.getElementById("visit_status").disabled = false;
	document.getElementById("visit_location_div").disabled = false;
	document.getElementById("visit_booked_div").disabled = false;
	document.getElementById("visit_booked_date_div").disabled = false;
	document.getElementById("sales_status").disabled = false;
	document.getElementById("car_delivered").disabled = false;*/
	
	document.getElementById("new_model").disabled = true;
	document.getElementById("new_variant").disabled = true;
	//document.getElementById("book").disabled = true;
	$("#first_div").hide();
	
	
	
	} else{
	
	
	document.getElementById("model").disabled = true;
	document.getElementById("make").disabled = true;
	//document.getElementById("color").disabled = true;
	document.getElementById("mfg").disabled = true;
	document.getElementById("km").disabled = true;
	document.getElementById("ownership").disabled = true;
	//document.getElementById("claim").disabled = true;
	$("#exchange").hide();
	
	document.getElementById("new_model").disabled = true;
	document.getElementById("new_variant").disabled = true;
	//document.getElementById("book").disabled = true;
	$("#first_div").hide();
	
	document.getElementById("buy_make").disabled = true;
	document.getElementById("buy_model").disabled = true;
	document.getElementById("budget_to").disabled = true;
	document.getElementById("budget_from").disabled = true;
	/*document.getElementById("visit_status").disabled = true;
	document.getElementById("visit_location_div").disabled = true;
	document.getElementById("visit_booked_div").disabled = true;
	document.getElementById("visit_booked_date_div").disabled = true;
	document.getElementById("sales_status").disabled = true;
	document.getElementById("car_delivered").disabled = true;*/
	$("#buy_used_car").hide();
	
	}
	}
	
	
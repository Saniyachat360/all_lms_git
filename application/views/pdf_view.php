<?php if(count($quotation_data)>0){ 

	//print_r($quotation_data);
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
	
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css?version=00001" id="style-resource-2">
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/new/custom.css?version=00001"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css?version=00002" id="style-resource-4">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css?version=00001" id="style-resource-5">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css?version=00001" id="style-resource-6">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/color.css?version=00001">

	</head>
	<body style="background-color:#fff">
	
		<div style="border:3px solid #000;margin:30px;margin-top:30px">
<table class="table" style="text-align:center;border-spacing:0;border-collapse:collapse;margin-top:30px">
<tr>
<td style="border:1px solid #000;">Dealer Code:Autovista</td>
<td style="border:1px solid #000;text-align:center;"><b>QUOTATION</b></td>
<td style="border:1px solid #000;">Customer Copy</td>

</tr>
<tr>
<td style="vertical-align: middle;"><img src="https://www.autovista.in/assets/images/autovista-logo-fixed.png"></td>
<td style="vertical-align: middle;">Autovista PVT LTD<br>1-8, Aditya Planet, Sec - 10, Mumbai-Pune Highway Kopra-Kharghar,Navi Mumbai - 410210<br>Phone No.:+91-9209200071<br>Email ID:info@autovista.in</td>
<td style="vertical-align: middle;"> Qtn No.:<?php echo $quotation_data[0]->customer_quotation_id;?><br>Date:<?php echo date('d-m-Y')?></td>
</tr>

</table>


<table class="table " id="details" style="border-spacing:0;border-collapse:collapse;width:100%">
<tr>
<td style="border:1px solid #000;">Model:<?php echo $quotation_data[0]->model_name?></td>
<td colspan='2' style="border:1px solid #000;"> Variant:<?php echo $quotation_data[0]->variant_name?></td>
<!--td style="border:1px solid #000;"> COLOUR:Metallic Glistening Grey</td-->
</tr>
<tr><td colspan="5" style="text-align:center;border:1px solid #000"><b>DETAILS</b></td>

</tr>
<tr><td style="border:1px solid #000">Ex-Showroom Price</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->ex_showroom?></td>
</tr>
<tr>

	<?php if($quotation_data[0]->customer_type=='corporate')
	{
		$rtotax=$quotation_data[0]->rto;	
		$insu=$quotation_data[0]->insurance;	
	}else{
	$rtotax=$quotation_data[0]->rto;
	$insu=$quotation_data[0]->insurance; } ?><td style="border:1px solid #000">RTO Tax	& Other Charges</td><td style="border:1px solid #000"><?php echo $rtotax?></td><td><b>Name of Customer</b></td>
</tr>
<tr><td style="border:1px solid #000">Registration</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->registration?></td><td><u><?php echo ucfirst($quotation_data[0]->name);?></u></td>
</tr>
<!--tr><td style="border:1px solid #000">AMC TAX</td><td style="border:1px solid #000">343</td>
</tr-->
<tr><td style="border:1px solid #000">Insurance</td><td style="border:1px solid #000"><?php echo $insu?></td><td><b>Address</b></td>
</tr>

<tr><td style="border:1px solid #000">Auto Card</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->auto_card?></td><td><u><?php echo $quotation_data[0]->address?></u></td>
</tr>
<tr><td style="border:1px solid #000">3rd, 4th & 5th yr Extended Warranty</td><td style="border:1px solid #000"> <?php echo $quotation_data[0]->warranty?></td>

</tr>
<tr><td style="border:1px solid #000">Accessories</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->accessories?></td><td><b>Phone Number</b></td>
</tr>
<tr><td style="border:1px solid #000"><b>On Road Price</b></td><td style="border:1px solid #000"><?php echo $quotation_data[0]->on_road_price?></td><td><u><?php echo $quotation_data[0]->contact_no?></u></td>
</tr>
<tr><!--td colspan="2" style="border:1px solid #000">CORPORATE/RURAL OFFER</td-->
</tr>
<!--<tr><td><b>NET PAYABLE AMOUNT</b></td><td></td><td></td>
</tr>
<tr><td><b>Amount in words Rs.</b></td><td></td><td></td>
</tr>-->
<?php /*if($quotation_data[0]->customer_type=='corporate')
	{
		?>
		<tr><td style="border:1px solid #000">Corporate Offer </td><td style="border:1px solid #000"><?php echo $quotation_data[0]->corporate_offer?></td><td><b>Email ID</b><br></td>
</tr>
<tr><td style="border:1px solid #000"></td><td style="border:1px solid #000"></td><td><u><?php echo $quotation_data[0]->email?></u></td>
</tr>
		<?php	
	}else{*/
		?>
		<tr><td style="border:1px solid #000">Consumer Offer </td><td style="border:1px solid #000"><?php echo $quotation_data[0]->consumer_offer?></td><td><b>Email ID</b><br></td>
</tr>
<tr><!--td style="border:1px solid #000">Consumer Offer - Dealer</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->cons_offdlr?></td-->
	<td style="border:1px solid #000">Corporate Offer </td><td style="border:1px solid #000"><?php echo $quotation_data[0]->corporate_offer?></td><td><u><?php echo $quotation_data[0]->email?></u></td>
</tr>
		<?php
	//}
	 ?>

<!--tr><td style="border:1px solid #000">Consumer Offer </td><td style="border:1px solid #000"><?php echo $quotation_data[0]->cons_off?></td><td><b>Email ID</b><br></td>
</tr>
<tr><td style="border:1px solid #000">Consumer Offer - Dealer</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->cons_offdlr?></td><td><u><?php echo $quotation_data[0]->email?></u></td>
</tr-->
<tr><!--td style="border:1px solid #000">EARLY BIRD</td><td style="border:1px solid #000">2131</td-->
	<td style="border:1px solid #000"><b>Any Other Offer</b></td><td style="border:1px solid #000"><?php echo $quotation_data[0]->additional_offer?></td>
	<td><b>Remark</b></td>
</tr>
<tr ><td style="border:1px solid #000" colspan="2"><b>Exchange Details</b></td><td rowspan="4" style="border:1px solid #555;"><p >

<?php echo $quotation_data[0]->remark?>
</p></td>
</tr>
<!--tr>
</tr-->
<tr><td style="border:1px solid #000;">
    Exchange Make Model
</td>
><td style="border:1px solid #000;padding:10px">
    <?php echo ucfirst($quotation_data[0]->old_make).' '. ucfirst($quotation_data[0]->old_model);?>
</td>
<!--td style="border:1px solid #000">Exchange Car Price</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->variant_name?></td-->
</tr>
<tr><td style="border:1px solid #000">Exchange Bonus</td><td style="border:1px solid #000"><?php echo $quotation_data[0]->exchange_bonus?></td>
</tr>
<!--<tr><td>TOTAL</td><td></td><td></td>
</tr>-->
<tr><td></td><td></td>
</tr>
</table>
<?php 
$bank_name1='';$bank_name2='';$bank_name3='';$tenure1='';$tenure2='';$tenure3='';
$loan_amount1='';$loan_amount2='';$loan_amount3='';
$margin_money1='';$margin_money2='';$margin_money3='';
$advance_emi1='';$advance_emi2='';$advance_emi3='';
$processing_fee1='';$processing_fee2='';$processing_fee3='';
$stamp_duty1='';$stamp_duty2='';$stamp_duty3='';
$emi_per_month1='';$emi_per_month2='';$emi_per_month3='';
$down_payment1='';$down_payment2='';$down_payment3='';
foreach($quotation_finance_data as $row)
{
	if($row->scheme_type==1)
	{
		$bank_name1=$row->bank_name;
		$tenure1=$row->tenure;
		$loan_amount1=$row->loan_amount;
		$margin_money1=$row->margin_money;
		$advance_emi1=$row->advance_emi;
		$processing_fee1=$row->processing_fee;
		$stamp_duty1=$row->stamp_duty;
		$emi_per_month1=$row->emi_per_month;
		$down_payment1=$row->down_payment;
	}
	elseif($row->scheme_type==2)
	{
		$bank_name2=$row->bank_name;
		$tenure2=$row->tenure;
		$loan_amount2=$row->loan_amount;
		$margin_money2=$row->margin_money;
		$advance_emi2=$row->advance_emi;
		$processing_fee2=$row->processing_fee;
		$stamp_duty2=$row->stamp_duty;
		$emi_per_month2=$row->emi_per_month;
		$down_payment2=$row->down_payment;
	}
	elseif($row->scheme_type==3)
	{
		$bank_name3=$row->bank_name;
		$tenure3=$row->tenure;
		$loan_amount3=$row->loan_amount;
		$margin_money3=$row->margin_money;
		$advance_emi3=$row->advance_emi;
		$processing_fee3=$row->processing_fee;
		$stamp_duty3=$row->stamp_duty;
		$emi_per_month3=$row->emi_per_month;
		$down_payment3=$row->down_payment;
	}
}?>
<table class="table " style="border-spacing:0;border-collapse:collapse;width:100%">
<tr><td style="border:1px solid #000;"><b>FINANCE</b></td><td style="border:1px solid #000;"><b>SCHEME-I</b></td><td style="border:1px solid #000;"><b>SCHEME-II</b></td><td style="border:1px solid #000;"><b>SCHEME-III</b></td>
</tr>
<tr><td style="border:1px solid #000;">Name of the Bank</td><td style="border:1px solid #000;"><?php echo $bank_name1;?></td>
	<td style="border:1px solid #000;"><?php echo $bank_name2;?></td><td style="border:1px solid #000;"><?php echo $bank_name3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Tenure</td><td style="border:1px solid #000;"><?php echo $tenure1;?></td><td style="border:1px solid #000;"><?php echo $tenure2;?></td><td style="border:1px solid #000;"><?php echo $tenure3;?></td>
</tr>
<tr><td style="border:1px solid #000;">On Road Price/Net Payable Amount </td><td style="border:1px solid #000;"> <?php echo $quotation_data[0]->on_road_price; ?></td><td style="border:1px solid #000;"><?php echo $quotation_data[0]->on_road_price; ?></td><td style="border:1px solid #000;"><?php echo $quotation_data[0]->on_road_price; ?></td>
</tr>
<tr><td style="border:1px solid #000;">Loan Amount</td><td style="border:1px solid #000;"> <?php echo $loan_amount1;?></td><td style="border:1px solid #000;"><?php echo $loan_amount2;?></td><td style="border:1px solid #000;"><?php echo $loan_amount3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Margin Money</td><td style="border:1px solid #000;"> <?php echo $margin_money1;?></td><td style="border:1px solid #000;"><?php echo $margin_money2;?></td><td style="border:1px solid #000;"><?php echo $margin_money3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Advance EMI</td><td style="border:1px solid #000;"> <?php echo $advance_emi1;?></td><td style="border:1px solid #000;"><?php echo $advance_emi2;?></td><td style="border:1px solid #000;"><?php echo $advance_emi3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Processing Fees</td><td style="border:1px solid #000;"> <?php echo $processing_fee1;?></td><td style="border:1px solid #000;"><?php echo $processing_fee2;?></td><td style="border:1px solid #000;"><?php echo $processing_fee3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Stamp Duty & HPA Charges</td><td style="border:1px solid #000;"> <?php echo $stamp_duty1;?></td><td style="border:1px solid #000;"><?php echo $stamp_duty2;?></td><td style="border:1px solid #000;"><?php echo $stamp_duty3;?></td>
</tr>
<tr><td style="border:1px solid #000;">Total Down Paynent</td><td style="border:1px solid #000;"> <?php echo $down_payment1;?></td><td style="border:1px solid #000;"><?php echo $down_payment2;?></td><td style="border:1px solid #000;"><?php echo $down_payment3;?></td>
</tr>
<tr><td style="border:1px solid #000;">EMI Per Month</td><td style="border:1px solid #000;"> <?php echo $emi_per_month1;?></td><td style="border:1px solid #000;"><?php echo $emi_per_month2;?></td><td style="border:1px solid #000;"><?php echo $emi_per_month3;?></td>
</tr>
<!--tr><td style="border:1px solid #000;">LIKELY DATE OF DELIVERY</td><td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
</tr--></table>

<table class="table " style="border-spacing:0;border-collapse:collapse;">
<tr><td style="border:1px solid #000;height:50px" colspan="2" >Sign. of DSE</td>
	<td style="border:1px solid #000;height:50px" colspan="2" >Sign of Customer</td>
</tr>
<tr><td style="border:1px solid #000;" colspan="2">Name of DSE: <?php echo ucfirst($quotation_data[0]->fname).' '.ucfirst($quotation_data[0]->lname);?>
<br>
</td>
	<td style="border:1px solid #000;" colspan="2">Name of Customer: <?php echo ucfirst($quotation_data[0]->name);?></td>
</tr>
<tr><td style="border:1px solid #000;" colspan="2">Note:Anything Handwritten on this invoice is not valid.</td><td style="border:1px solid #000;" colspan="2"><b>I HAVE READ OVERLEAF FOR DOCUMENTS AND <br>TEARMS & CONDITIONS.I ABIDE BY THE SAME. </b></td>
</tr>
</table>		
</div>
<div style="margin:2%">
		<h3 class="text-center"><b><u>Required Document</u></b></h3>
		<div style="margin-left:3%;margin-right:3%">
		<h4><b>For Salaried Person:-</b></h4>
		<ul style="font-size:12px">
		<li>Last two year Form no:16-A/I.T.Return & Statement of Income</li>
		<li>Three Months Latest Salary Slip </li>
		<li>Identity Proof(Licence/Passport/Company's ID Card/PAN Card)</li>
		<li>Passport Size Photo</li>
		<li>Address Proof (Electricity Bill/Telephone Bill/Voter I.D. Card)</li>
		<li>Latest six Months Bank Statement</li>
		<li>Signature Verification</li>
		</ul>
		<h4><b>Proprietorship Firm:-</b></h4>
		<ul style="font-size:12px">
		<li>Last Two Year's I.T. Return with statement of Total Income</li>
		<li>Bank Statement of Last Six Months</li>
		<li>Sign verification</li>
		<li>Resitant proof/Office Proof (Electricity Bill/Telephone Bill/Voter I.D. Card)</li>
		<li>Identity Proof(Licence/Passport/Company's ID Card/PAN Card)</li>
		<li>Photograph</li></ul>
		<h4><b>Ltd./Pvt Ltd. Company/Partnership Firm</b></h4>
		<ul style="font-size:12px">
		<li>Last Two year's Audited Balance Sheet/P&L A/C with I.T. Return and Audit Report</li>
		<li>Resi. proof of Authorised Director/Partner</li>
		<li>Idetity Proof of Authorised Director/Partner</li>
		<li>Photograph of Authorised Director/Partner</li>
		<li>M/A of Association of Pvt Ltd/Ltd Company/Partnership deed in Partnership Firm </li>
		<li>Bank Statement of Last Three Months</li>
		<li>Sign. verification of Authorised Director/Partner & Firm/Company</li>
		<li>Office Proof</li>
		<li>Board Of Resolution in Ltd./ Pvt Ltd./Partner's Authority Letter in Partnership Firm</li>
		</ul>
		</div>
		<h3 class="text-center"><b><u>Terms and Condition</u></b></h3>
		<ol style="list-style-type:decimal;margin-left:3%;margin-right:3%">
			<li>Payment 100% Advance / Along with order.</li>
			<li>Price prevailling at the time of Allotment / Invoicing shall be applicable.</li>
			<li>Allotment of vehicle on Seniority of payment (F.O.R. Price / Colour Choice).</li>
			<li>Delivery Subject to availability of Stock & colour with Manufacture.</li>
			<li>The above offer is Valid Till <?php echo date('M Y')?></li>
			<li>DD / P.O/CHEQUE IN FAVOUR OF 'EXCELL AUTOVISTA PVT. LTD.</li>
			
		<!--li>Price are subject to change without prior notice and will be charged as applicable at the time of delivery</li>
		<li>Consumer/Corporate/Rural/Exchange or any other offer is subject to change without prior notice and will be applicable at the time of delivery </li>
		<li>If Booking is Cancelled (For two whatsover reason )Rs.1500/- will be deducted from customer's Booking Amount.</li>
		<li>If the Cheque is dishonoreedor Returned by the Banker for any reason,a penalty of Rs.450/- will be charged from the customer as cheque return charges alon with cheque Amount + Cheque return charges. The Company is also empowered tto take legal action in case of payment defult or take back the possession of th car from the Customer/Custodian.</li>
		<li>Any disputeor claims arising out of this Invoice will be subject to the jurisdiction of courtin Mumbai only </li>
		<li>Any Payment due paid through Cheque must be cleared with Three(3) days failing which interest @ 24% shall be charged from the due date. </li>
		<li>The sale of the above is governed by the warranty & Service Booklet supplied with each new car and will be applicable as per the Policy & terms & Conditions of Maruti Suzuki India Pvt Ltd</li>
		<li>The Price,Excise Duty and other statutory Duties and Taxes would be charged as applicable and charged at the time of Delivery .</li>
		<li>Force Majeure clause would be applicable to all deliveries.</li>
		<li>Delivery Ex-Showroom</li>
		<li>E. & O.E.</li>
		<li>For Delivery of Car,Customer are requested to come personally along with I.D proof to take the delivery of his/her Car. In case Customer is sending his/her Driver/Relative/Friend or any other person to take the Delivery in that case Company shall not be responsible for any Damages , Loss or Missing Parts/Accessories. </li>
		<li>Payment will strictly be made by Cheque/DD/RTGS in favour of Autovista PVT LTD payable at Mumbai . No cash will be given to any Employee of our Dealership else company will not be responnsible.</li>
		<li>Delivery of vechicle is subect to availability, if there is any delay in availability or supply of vechicles due to Natural Calamitites like Earthquack ,Floods, Draught,Landslide,Riots,rallies etc or any unforeseen circumstancesin such cases Neither Maruti suzuki India PVT LTD nor Autovista PVT LTD will be held responnsible.</li>
		<li>In case of vechicle Registration In Name of Corporate/trust/PVT LTD company/H.U.F./Partnership-The RTO Tax will be charged double as per RTO Rules.</li-->
		</ol>
		</div>
		<?php } ?>
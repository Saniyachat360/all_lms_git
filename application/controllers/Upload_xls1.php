<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Upload_xls1 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('upload_xls_model1');
		date_default_timezone_set('Asia/Kolkata');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {

		$this -> session();

		$data['var'] = site_url('upload_xls1/upload');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('upload_xls_view1.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function test() {

		$this -> session();

		$data['var'] = site_url('upload_xls1/upload');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('upload_xls_poc_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function upload() {

		$this -> session();
		$stocktype = $this -> input -> post('stocktype');
		echo $stocktype;

		//$campaign_name=$this->input->post('campaign_name');
		//$group_id=$this->input->post('group_name');
		$date = date('Y-m-d:H:i:A');

		if ($_FILES["file"]["error"] > 0) {
			echo "Error: " . $_FILES["file"]["error"] . "<br>";
		} else {
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			"Type: " . $_FILES["file"]["type"] . "<br>";
			"Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			"Stored in: " . $_FILES["file"]["tmp_name"];
			"<br>";
		}

		move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/' . $date . '_' . $_FILES["file"]["name"]);

		$file = 'upload/' . $date . '_' . $_FILES["file"]["name"];
		echo $file;
		require_once 'Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data -> setOutputEncoding('CP1251');
		$data -> read($file);
echo $stocktype;
	/*	if ($stocktype == 'New Car') {
			for ($x = 3; $x <= count($data -> sheets[0]["cells"]); $x++) {

				//echo $outlet_name = $data -> sheets[0]["cells"][$x][2];

				if (isset($data -> sheets[0]["cells"][$x][2])) {
					echo $outlet_name = $data -> sheets[0]["cells"][$x][2];

				} else {
					$outlet_name = '';
				}

				echo "<br>";

				//echo $supplier_category = $data -> sheets[0]["cells"][$x][3];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][3])) {
					echo $supplier_category = $data -> sheets[0]["cells"][$x][3];

				} else {
					$supplier_category = '';
				}

				//echo $supplier = $data -> sheets[0]["cells"][$x][4];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][4])) {
					echo $supplier = $data -> sheets[0]["cells"][$x][4];

				} else {
					$supplier = '';
				}

				//echo $model = $data -> sheets[0]["cells"][$x][5];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][5])) {
					echo $model = $data -> sheets[0]["cells"][$x][5];

				} else {
					$model = '';
				}

				//echo $sub_model_code = $data -> sheets[0]["cells"][$x][6];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][6])) {
					echo $sub_model_code = $data -> sheets[0]["cells"][$x][6];

				} else {
					$sub_model_code = '';
				}

				//echo $submodel = $data -> sheets[0]["cells"][$x][7];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][7])) {
					echo $submodel = $data -> sheets[0]["cells"][$x][7];

				} else {
					$submodel = '';
				}

				//echo $color_code = $data -> sheets[0]["cells"][$x][8];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][8])) {
					echo $color_code = $data -> sheets[0]["cells"][$x][8];

				} else {
					$color_code = '';
				}

				//echo $color = $data -> sheets[0]["cells"][$x][9];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][9])) {
					echo $color = $data -> sheets[0]["cells"][$x][9];

				} else {
					$color = '';
				}

				//echo $fuel_type = $data -> sheets[0]["cells"][$x][10];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][10])) {
					echo $fuel_type = $data -> sheets[0]["cells"][$x][10];

				} else {
					$fuel_type = '';
				}

				//echo $chassis_number = $data -> sheets[0]["cells"][$x][11];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][11])) {
					echo $chassis_number = $data -> sheets[0]["cells"][$x][11];

				} else {
					$chassis_number = '';
				}

				//echo $engine_number = $data -> sheets[0]["cells"][$x][12];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][12])) {
					echo $engine_number = $data -> sheets[0]["cells"][$x][12];

				} else {
					$engine_number = '';
				}

				if (isset($data -> sheets[0]["cells"][$x][13])) {
					echo $key_no = $data -> sheets[0]["cells"][$x][13];
				} else {
					$key_no = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][14])) {
					echo $dealer_vin_no = $data -> sheets[0]["cells"][$x][14];

				} else {
					$dealer_vin_no = '';
				}echo "<br>";

				//echo $vehicle_status = $data -> sheets[0]["cells"][$x][15];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][15])) {
					echo $vehicle_status = $data -> sheets[0]["cells"][$x][15];

				} else {
					$vehicle_status = '';
				}echo "<br>";

				//echo $acc_issued_amount = $data -> sheets[0]["cells"][$x][16];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][16])) {
					echo $acc_issued_amount = $data -> sheets[0]["cells"][$x][16];

				} else {
					$acc_issued_amount = '';
				}echo "<br>";

				//echo $quality_status = $data -> sheets[0]["cells"][$x][17];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][17])) {
					echo $quality_status = $data -> sheets[0]["cells"][$x][17];

				} else {
					$quality_status = '';
				}echo "<br>";

				//echo $octroi = $data -> sheets[0]["cells"][$x][18];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][18])) {
					echo $octroi = $data -> sheets[0]["cells"][$x][18];

				} else {
					$octroi = '';
				}echo "<br>";

				//echo $manuf_fin_number = $data -> sheets[0]["cells"][$x][19];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][19])) {
					echo $manuf_fin_number = $data -> sheets[0]["cells"][$x][19];

				} else {
					$manuf_fin_number = '';
				}echo "<br>";

				//echo $manuf_fin_date = $data -> sheets[0]["cells"][$x][20];

				if (isset($data -> sheets[0]["cells"][$x][20])) {
					echo $manuf_fin_date = $data -> sheets[0]["cells"][$x][20];

				} else {

					//convert value in date format
					$phpexcepDate = $manuf_fin_date - 25569;
					//to offset to Unix epoch
					$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					$manuf_fin_date = date('Y-m-d', $date);
				}
				echo "<br>";

				//echo $gp_number = $data -> sheets[0]["cells"][$x][21];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][21])) {
					echo $gp_number = $data -> sheets[0]["cells"][$x][21];

				} else {
					$gp_number = '';
				}echo "<br>";

				//echo $veh_order_cat = $data -> sheets[0]["cells"][$x][22];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][22])) {
					echo $veh_order_cat = $data -> sheets[0]["cells"][$x][22];

				} else {
					$veh_order_cat = '';
				}echo "<br>";

				//echo $INF_financier = $data -> sheets[0]["cells"][$x][23];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][23])) {
					echo $INF_financier = $data -> sheets[0]["cells"][$x][23];

				} else {
					$INF_financier = '';
				}echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][24])) {
					echo $receipt_number = $data -> sheets[0]["cells"][$x][24];

				} else {
					$receipt_number = '';
				}

				//echo $receipt_date = $data -> sheets[0]["cells"][$x][25];

				if (isset($data -> sheets[0]["cells"][$x][25])) {
					echo $receipt_date = $data -> sheets[0]["cells"][$x][25];

				} else {

					//convert value in date format
					$phpexcepDate = $receipt_date - 25569;
					//to offset to Unix epoch
					$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					$receipt_date = date('Y-m-d', $date);
				}

				//echo $order_number = $data -> sheets[0]["cells"][$x][26];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][26])) {
					echo $order_number = $data -> sheets[0]["cells"][$x][26];

				} else {
					$order_number = '';
				}echo "<br>";

				//	echo $customer_name = $data -> sheets[0]["cells"][$x][27];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][27])) {
					echo $customer_name = $data -> sheets[0]["cells"][$x][27];

				} else {
					$customer_name = '';
				}echo "<br>";

				//echo $alloted_date = $data -> sheets[0]["cells"][$x][28];

				if (isset($data -> sheets[0]["cells"][$x][28])) {
					echo $alloted_date = $data -> sheets[0]["cells"][$x][28];

				} else {

					//convert value in date format
					$phpexcepDate = $alloted_date - 25569;
					//to offset to Unix epoch
					$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					$alloted_date = date('Y-m-d', $date);
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][29])) {
					echo $rto_invoiceNo = $data -> sheets[0]["cells"][$x][29];

				} else {
					$rto_invoiceNo = '';
				}

				echo "<br>";

				//$rto_invoice_date = $data -> sheets[0]["cells"][$x][30];

				if (isset($data -> sheets[0]["cells"][$x][30])) {

					echo $rto_invoice_date = $data -> sheets[0]["cells"][$x][30];

				} else {
					//convert value in date format
					$phpexcepDate = $rto_invoice_date - 25569;
					//to offset to Unix epoch
					$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					$rto_invoice_date = date('Y-m-d', $date);
				}
				echo "<br>";

				//echo $purchase_price = $data -> sheets[0]["cells"][$x][31];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][31])) {
					echo $purchase_price = $data -> sheets[0]["cells"][$x][31];

				} else {
					$purchase_price = '';
				}

				//echo $stock_location = $data -> sheets[0]["cells"][$x][32];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][32])) {
					echo $stock_location = $data -> sheets[0]["cells"][$x][32];

				} else {
					$stock_location = '';
				}

				echo $assigned_location = $data -> sheets[0]["cells"][$x][33];

				echo "<br>";

				if ($assigned_location != '') {

					$t = explode(" ", $assigned_location);

					$assigned_location = $t[0];

				}
				if ($assigned_location == 'Nexa') {
					$assigned_location = 'Thane';

				}

				if (isset($data -> sheets[0]["cells"][$x][34])) {
					echo $bin_no = $data -> sheets[0]["cells"][$x][34];

				} else {
					$bin_no = '';
				}
				echo "<br>";

				//echo $dse_executive = $data -> sheets[0]["cells"][$x][35];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][35])) {
					echo $dse_executive = $data -> sheets[0]["cells"][$x][35];

				} else {
					$dse_executive = '';
				}

				//echo $team_leader = $data -> sheets[0]["cells"][$x][36];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][36])) {
					echo $team_leader = $data -> sheets[0]["cells"][$x][36];

				} else {
					$team_leader = '';
				}

				//echo $purchase_remarks = $data -> sheets[0]["cells"][$x][37];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][37])) {
					echo $purchase_remarks = $data -> sheets[0]["cells"][$x][37];

				} else {
					$purchase_remarks = '';
				}

				//echo $damage_remarks = $data -> sheets[0]["cells"][$x][38];
				//	echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][38])) {
					echo $damage_remarks = $data -> sheets[0]["cells"][$x][38];

				} else {
					$damage_remarks = '';
				}

				//echo $year_of_mfr_invoice = $data -> sheets[0]["cells"][$x][39];
				//echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][39])) {
					echo $year_of_mfr_invoice = $data -> sheets[0]["cells"][$x][39];

				} else {
					$damage_remarks = '';
				}

				echo $rebilled = $data -> sheets[0]["cells"][$x][40];

				if (isset($data -> sheets[0]["cells"][$x][40])) {
					echo $rebilled = $data -> sheets[0]["cells"][$x][40];

				} else {
					$rebilled = '';
				}

				if (isset($data -> sheets[0]["cells"][$x][41])) {
					$gate_pass_no = $data -> sheets[0]["cells"][$x][41];

				} else {
					$gate_pass_no = '';
				}
				echo "<br>";

				//echo $gate_pass_date = $data -> sheets[0]["cells"][$x][42];

				if (isset($data -> sheets[0]["cells"][$x][42])) {

					$gate_pass_date = $data -> sheets[0]["cells"][$x][42];

				} else {

					//convert value in date format
					$phpexcepDate = $gate_pass_date - 25569;
					//to offset to Unix epoch
					$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					//echo $gate_pass_date = date('Y-m-d', $date);
				}echo "<br>";

				//echo $ageing = $data -> sheets[0]["cells"][$x][43];

				if (isset($data -> sheets[0]["cells"][$x][43])) {
					echo $ageing = $data -> sheets[0]["cells"][$x][43];

				} else {
					$ageing = '';
				}

				$query = $this -> upload_xls_model1 -> upload($outlet_name, $supplier_category, $supplier, $model, $sub_model_code, $submodel, $color_code, $color, $fuel_type, $chassis_number, $engine_number, $key_no, $dealer_vin_no, $vehicle_status, $acc_issued_amount, $quality_status, $octroi, $manuf_fin_number, $manuf_fin_date, $gp_number, $veh_order_cat, $INF_financier, $receipt_number, $receipt_date, $order_number, $customer_name, $alloted_date, $rto_invoiceNo, $rto_invoice_date, $purchase_price, $stock_location, $assigned_location, $bin_no, $dse_executive, $team_leader, $purchase_remarks, $damage_remarks, $year_of_mfr_invoice, $rebilled, $gate_pass_no, $gate_pass_date, $ageing);

			}
		} else {*/
			$error=array();

$outlet_name=array();
$make=array();
$model=array();
$submodel=array();
$color=array();
$fuel_type=array();
$rto_no=array();
$reg_date=array();
$chassis_number=array();
$engine_number=array();
$mfg_year=array();
$mfg_month=array();
$owner=array();
$odo_meter=array();

$insurance_type=array();
$insurance_expiry_date=array();
$category=array();
$rc_status=array();
$quality_status=array();
$expt_selling_price=array();
$ageing=array();
$stock_location=array();
$mileage=array();
$transmission=array();
			
			for ($x = 4; $x <= count($data -> sheets[0]["cells"]); $x++) {
				
				if (isset($data -> sheets[0]["cells"][$x][2])) {
					 $data -> sheets[0]["cells"][$x][2];
				
					
							array_push($outlet_name,$data->sheets[0]["cells"][$x][2]);
						
					
				} else {
					
				
					array_push($outlet_name,'');
				}
				
				if (isset($data -> sheets[0]["cells"][$x][3])) {
				//	if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][3])) ){
							array_push($make,$data->sheets[0]["cells"][$x][3]);
						/*}else{
							array_push($error,'C'.$x);
						}*/
					
				} else {
					
					array_push($make,'');
				}
			//	echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][4])) {
				//if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][4]))){
							array_push($model,$data->sheets[0]["cells"][$x][4]);
						/*}else{
							array_push($error,'D'.$x);
						}*/
					
				} else {
					array_push($model,'');
				}
				
//echo $data -> sheets[0]["cells"][$x][5];
				if (isset($data -> sheets[0]["cells"][$x][5])) {
				    
				//	if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][5])) ){
							array_push($submodel,$data->sheets[0]["cells"][$x][5]);
						/*}else{
							array_push($error,'E'.$x);
						}*/
					
				} else {
					array_push($submodel,'issue');
				}
		//	echo $submodel;
				if (isset($data -> sheets[0]["cells"][$x][6])) {
				//	if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][6])) ){
							array_push($color,$data->sheets[0]["cells"][$x][6]);
					/*	}else{
							array_push($error,'F'.$x);
						}*/
					
				} else {
					array_push($color,'');
				}
			
				

				if (isset($data -> sheets[0]["cells"][$x][9])) {
					//if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][9]))){
							array_push($fuel_type,$data->sheets[0]["cells"][$x][9]);
						/*}else{
							array_push($error,'G'.$x);
						}*/
					
				
				} else {
				array_push($fuel_type,'');
				}
					if (isset($data -> sheets[0]["cells"][$x][10])) {
					//if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][10]))){
							array_push($transmission,$data->sheets[0]["cells"][$x][10]);
					/*	}else{
							array_push($error,'H'.$x);
						}*/
					
				} else {
					array_push($transmission,'');
				}
			
				if (isset($data -> sheets[0]["cells"][$x][11])) {
				//	if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][11]))){
							array_push($rto_no,$data->sheets[0]["cells"][$x][11]);
						/*}else{
							array_push($error,'H'.$x);
						}*/
					
				} else {
					array_push($rto_no,'');
				}
				

				if (isset($data -> sheets[0]["cells"][$x][12])) {
					  $reg_date1 = $data -> sheets[0]["cells"][$x][12];
					//$phpexcepDate = $reg_date1 - 25569;
			//	$date = strtotime("+$reg_date1 days", mktime(0, 0, 0, 1, 1, 1970));
					 $reg_date1 = date('Y-m-d', strtotime($reg_date1));
					array_push($reg_date,$reg_date1);
			
				} else {
					array_push($reg_date, '');
				}
				

				if (isset($data -> sheets[0]["cells"][$x][13])) {
				//	if(ctype_alnum(str_replace(' ', '',$data -> sheets[0]["cells"][$x][13])) ){
							array_push($chassis_number,$data->sheets[0]["cells"][$x][13]);
						/*}else{
							array_push($error,'J'.$x);
						}*/
					
				} else {
					array_push($chassis_number,'');
				}
			

				if (isset($data -> sheets[0]["cells"][$x][14])) {
					//if(ctype_digit($data -> sheets[0]["cells"][$x][14]) ){
							array_push($engine_number,$data->sheets[0]["cells"][$x][14]);
					/*	}else{
							array_push($error,'K'.$x);
						}*/
					
				} else {
					array_push($engine_number,'');

				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][15])) {
					//if(ctype_digit($data -> sheets[0]["cells"][$x][15]) ){
							array_push($mfg_year,$data->sheets[0]["cells"][$x][15]);
					/*	}else{
							array_push($error,'L'.$x);
						}*/
					
				} else {
					array_push($mfg_year,'');
				}
			


				if (isset($data -> sheets[0]["cells"][$x][16])) {
					 $data -> sheets[0]["cells"][$x][16];
				//	if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][16])) ){
					//	echo "dfgdfg";
							array_push($mfg_month,$data->sheets[0]["cells"][$x][16]);
					/*	}else{
								echo "eee";
							array_push($error,'M'.$x);
						}*/
					
				} else {
					array_push($mfg_month,'');
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][17])) {
				//	if(ctype_digit($data -> sheets[0]["cells"][$x][17]) ){
							array_push($owner,$data->sheets[0]["cells"][$x][17]);
					/*	}else{
							array_push($error,'N'.$x);
						}*/
					
				} else {
					array_push($owner,'');
				}
					if (isset($data -> sheets[0]["cells"][$x][18])) {
					//if(ctype_digit($data -> sheets[0]["cells"][$x][18]) ){
							array_push($mileage,$data->sheets[0]["cells"][$x][18]);
					/*	}else{
							array_push($error,'N'.$x);
						}*/
					
				} else {
					array_push($mileage,'');
				}
			
//print_r($mileage);
				if (isset($data -> sheets[0]["cells"][$x][19])) {
					//if(ctype_digit($data -> sheets[0]["cells"][$x][19]) ){
							array_push($odo_meter,$data->sheets[0]["cells"][$x][19]);
						/*}else{
							array_push($error,'O'.$x);
						}*/
					
				} else {
						array_push($odo_meter,'');
				}
				
				
				if (isset($data -> sheets[0]["cells"][$x][21])) {
					//	if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][21])) ){
							array_push($insurance_type,$data->sheets[0]["cells"][$x][21]);
					/*	}else{
							array_push($error,'P'.$x);
						}*/
					
				} else {
				array_push($insurance_type,'');

				}
				
				if (isset($data -> sheets[0]["cells"][$x][22])) {
					$insurance_expiry_date1 = $data -> sheets[0]["cells"][$x][22];
					//$phpexcepDate = $insurance_expiry_date1 - 25569;
				//	$date = strtotime("+$phpexcepDate days", mktime(0, 0, 0, 1, 1, 1970));
					$insurance_expiry_date1 = date('Y-m-d', strtotime($insurance_expiry_date1));
					array_push($insurance_expiry_date,$insurance_expiry_date1);
					
				} else {
					array_push($insurance_expiry_date,'000-00-00');
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][23])) {
					//if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][23]) )){
							array_push($category,$data->sheets[0]["cells"][$x][23]);
					/*	}else{
							array_push($error,'R'.$x);
						}*/
				
				} else {
					array_push($category,'');
				}
				
				if (isset($data -> sheets[0]["cells"][$x][25])) {
					//if(ctype_alpha(str_replace(' ', '',$data -> sheets[0]["cells"][$x][25])) ){
							array_push($rc_status,$data->sheets[0]["cells"][$x][25]);
					/*	}else{
							array_push($error,'S'.$x);
						}*/
				
				} else {
					array_push($rc_status,'');
				}
				
			if (isset($data -> sheets[0]["cells"][$x][27])) {
					
							array_push($quality_status,$data->sheets[0]["cells"][$x][27]);
						
				
				} else {
					array_push($quality_status,'');
				}
				
				
			
			


				if (isset($data -> sheets[0]["cells"][$x][34])) {
					//if(ctype_digit($data -> sheets[0]["cells"][$x][34]) ){
							array_push($expt_selling_price,$data->sheets[0]["cells"][$x][34]);
						/*}else{
							array_push($error,'U'.$x);
						}*/
					
				} else {
					array_push($expt_selling_price,'');
				}
				
				if (isset($data -> sheets[0]["cells"][$x][46])) {
				//	if(ctype_digit($data -> sheets[0]["cells"][$x][46])){
							array_push($ageing,$data->sheets[0]["cells"][$x][46]);
						/*}else{
							array_push($error,'V'.$x);
						}*/
					
				} else {
						array_push($ageing,'');
				}
				
				if (isset($data -> sheets[0]["cells"][$x][47])) {
				
							array_push($stock_location,$data->sheets[0]["cells"][$x][47]);
					
					
				} else {
						array_push($stock_location,'');
				}
				

				
				
				
				
	if(count($error)>0){
			print_r($error);	
		//for($r=0;$r<count($error);$r++){
			 $this -> session -> set_flashdata('msg_error', $error);
			// echo "<br>";
 //redirect('upload_xls1');
	///	}
	}
}

				$query = $this -> upload_xls_model1 -> upload2($outlet_name, $make, $model, $submodel, $color, $fuel_type, $rto_no, $reg_date, $chassis_number, $engine_number, $mfg_year, $mfg_month, $owner, $odo_meter,$insurance_type, $insurance_expiry_date, $category, $rc_status, $quality_status, $expt_selling_price,$ageing, $stock_location);
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Uploaded successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File not Uploaded successfully ...!</strong>');
			
		}
			
			


	//	}
	
redirect('upload_xls1');
}




}
?>
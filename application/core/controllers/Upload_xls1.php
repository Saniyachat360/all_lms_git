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

		if ($stocktype == 'New Car') {
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
		} else {


				$stock_location = $this -> input -> post('stock_location');
			//echo "hi";
			for ($x = 4; $x <= count($data -> sheets[0]["cells"]); $x++) {

				if (isset($data -> sheets[0]["cells"][$x][2])) {
					echo $outlet_name = $data -> sheets[0]["cells"][$x][2];
				} else {
					echo $outlet_name = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][3])) {
					echo $make = $data -> sheets[0]["cells"][$x][3];
				} else {
					echo $make = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][4])) {
					echo $model = $data -> sheets[0]["cells"][$x][4];
				} else {
					echo $model = '';
				}
				echo "<br>";

				/*	if (isset($data -> sheets[0]["cells"][$x][5])) {
				 echo $sub_model_code = $data -> sheets[0]["cells"][$x][5];
				 } else {
				 echo $sub_model_code = '';
				 }
				 echo "<br>";
				 */

				if (isset($data -> sheets[0]["cells"][$x][5])) {
					echo $submodel = $data -> sheets[0]["cells"][$x][5];
				} else {
					echo $submodel = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][6])) {
					echo $color = $data -> sheets[0]["cells"][$x][6];
				} else {
					echo $color = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][7])) {
					echo $source = $data -> sheets[0]["cells"][$x][7];
				} else {
					echo $source = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][8])) {
					echo $emission = $data -> sheets[0]["cells"][$x][8];
				} else {
					echo $emission = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][9])) {
					echo $fuel_type = $data -> sheets[0]["cells"][$x][9];
				} else {
					echo $fuel_type = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][10])) {
					echo $rto_no = $data -> sheets[0]["cells"][$x][10];
				} else {
					echo $rto_no = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][11])) {
					echo $reg_date = $data -> sheets[0]["cells"][$x][11];
				} else {
					echo $reg_date = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][12])) {
					echo $chassis_number = $data -> sheets[0]["cells"][$x][12];
				} else {
					echo $chassis_number = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][13])) {
					echo $engine_number = $data -> sheets[0]["cells"][$x][13];
				} else {
					echo $engine_number = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][14])) {
					echo $mfg_year = $data -> sheets[0]["cells"][$x][14];
				} else {
					echo $mfg_year = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][15])) {
					echo $mfg_month = $data -> sheets[0]["cells"][$x][15];
				} else {
					echo $mfg_month = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][16])) {
					echo $owner = $data -> sheets[0]["cells"][$x][16];
				} else {
					echo $owner = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][17])) {
					echo $mileage = $data -> sheets[0]["cells"][$x][17];
				} else {
					echo $mileage = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][18])) {
					echo $odo_meter = $data -> sheets[0]["cells"][$x][18];
				} else {
					echo $odo_meter = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][19])) {
					echo $financier = $data -> sheets[0]["cells"][$x][19];
				} else {
					echo $financier = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][20])) {
					echo $insurance_type = $data -> sheets[0]["cells"][$x][20];
				} else {
					echo $insurance_type = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][21])) {
					echo $insurance_expiry_date = $data -> sheets[0]["cells"][$x][21];
				} else {
					echo $insurance_expiry_date = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][22])) {
					echo $category = $data -> sheets[0]["cells"][$x][22];
				} else {
					echo $category = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][23])) {
					echo $ntv_reason = $data -> sheets[0]["cells"][$x][23];
				} else {
					echo $ntv_reason = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][24])) {
					echo $rc_status = $data -> sheets[0]["cells"][$x][24];
				} else {
					echo $rc_status = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][25])) {
					echo $vehicle_status = $data -> sheets[0]["cells"][$x][25];
				} else {
					echo $vehicle_status = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][26])) {
					echo $quality_status = $data -> sheets[0]["cells"][$x][26];
				} else {
					echo $quality_status = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][27])) {
					echo $receipt_number = $data -> sheets[0]["cells"][$x][27];
				} else {
					echo $receipt_number = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][28])) {
					echo $receipt_date = $data -> sheets[0]["cells"][$x][28];
				} else {
					echo $receipt_date = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][29])) {
					echo $evaluator_code = $data -> sheets[0]["cells"][$x][29];
				} else {
					echo $evaluator_code = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][30])) {
					echo $evaluator_name = $data -> sheets[0]["cells"][$x][30];
				} else {
					echo $evaluator_name = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][31])) {
					echo $evaluator_tl = $data -> sheets[0]["cells"][$x][31];
				} else {
					echo $evaluator_tl = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][32])) {
					echo $purchase_price = $data -> sheets[0]["cells"][$x][32];
				} else {
					echo $purchase_price = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][33])) {
					echo $est_refurbishment_cost = $data -> sheets[0]["cells"][$x][33];
				} else {
					echo $est_refurbishment_cost = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][34])) {
					echo $battery_replacement = $data -> sheets[0]["cells"][$x][34];
				} else {
					echo $battery_replacement = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][35])) {
					echo $body_repair = $data -> sheets[0]["cells"][$x][35];
				} else {
					echo $body_repair = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][36])) {
					echo $labour = $data -> sheets[0]["cells"][$x][36];
				} else {
					echo $labour = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][37])) {
					echo $mga_accessories = $data -> sheets[0]["cells"][$x][37];
				} else {
					echo $mga_accessories = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][38])) {
					echo $outside_labour = $data -> sheets[0]["cells"][$x][38];
				} else {
					echo $outside_labour = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][39])) {
					echo $spare_parts = $data -> sheets[0]["cells"][$x][39];
				} else {
					echo $spare_parts = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][40])) {
					echo $tyre_replacement = $data -> sheets[0]["cells"][$x][40];
				} else {
					echo $tyre_replacement = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][41])) {
					echo $workshop_repair = $data -> sheets[0]["cells"][$x][41];
				} else {
					echo $workshop_repair = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][42])) {
					echo $total_refurbishment_amount = $data -> sheets[0]["cells"][$x][42];
				} else {
					echo $total_refurbishment_amount = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][43])) {
					echo $other = $data -> sheets[0]["cells"][$x][43];
				} else {
					echo $other = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][44])) {
					echo $total_other_expense = $data -> sheets[0]["cells"][$x][44];
				} else {
					echo $total_other_expense = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][45])) {
					echo $expt_selling_price = $data -> sheets[0]["cells"][$x][45];
				} else {
					echo $expt_selling_price = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][46])) {
					echo $approved_disc = $data -> sheets[0]["cells"][$x][46];
				} else {
					echo $approved_disc = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][47])) {
					echo $exch_order_no = $data -> sheets[0]["cells"][$x][47];
				} else {
					echo $exch_order_no = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][48])) {
					echo $exchange_dealer_share = $data -> sheets[0]["cells"][$x][48];
				} else {
					echo $exchange_dealer_share = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][49])) {
					echo $exchange_mgf_share = $data -> sheets[0]["cells"][$x][49];
				} else {
					echo $exchange_mgf_share = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][50])) {
					echo $exchange_bonus = $data -> sheets[0]["cells"][$x][50];
				} else {
					echo $exchange_bonus = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][51])) {
					echo $order_number = $data -> sheets[0]["cells"][$x][51];
				} else {
					echo $order_number = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][52])) {
					echo $customer_name = $data -> sheets[0]["cells"][$x][52];
				} else {
					echo $customer_name = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][53])) {
					echo $allotted_date = $data -> sheets[0]["cells"][$x][53];
				} else {
					echo $allotted_date = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][54])) {
					echo $aloted_aging = $data -> sheets[0]["cells"][$x][54];
				} else {
					echo $aloted_aging = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][55])) {
					echo $dse = $data -> sheets[0]["cells"][$x][55];
				} else {
					echo $dse = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][56])) {
					echo $tl = $data -> sheets[0]["cells"][$x][56];
				} else {
					echo $tl = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][57])) {
					echo $total_landing_cost = $data -> sheets[0]["cells"][$x][57];
				} else {
					echo $total_landing_cost = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][58])) {
					echo $ageing = $data -> sheets[0]["cells"][$x][58];
				} else {
					echo $ageing = '';
				}
				echo "<br>";
				
				

				/*if (isset($data -> sheets[0]["cells"][$x][59])) {
					
					echo $stock_location = $data -> sheets[0]["cells"][$x][59];
				} else {
					echo $stock_location = '';
				}
				echo "<br>";*/
				
				
						
				echo $stock_location = $data -> sheets[0]["cells"][$x][59];

				echo "<br>";
					
				if ($stock_location != '') {

				$t = explode(" ", $stock_location);

				$stock_location = $t[0];

				}
				
				

				if (isset($data -> sheets[0]["cells"][$x][60])) {
					echo $stock_ageing = $data -> sheets[0]["cells"][$x][60];
				} else {
					echo $stock_ageing = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][61])) {
					echo $ready_for_sale = $data -> sheets[0]["cells"][$x][61];
				} else {
					echo $ready_for_sale = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][62])) {
					echo $ready_for_sale_date = $data -> sheets[0]["cells"][$x][62];
				} else {
					echo $ready_for_sale_date = '';
				}
				echo "<br>";

				if (isset($data -> sheets[0]["cells"][$x][63])) {
					echo $ready_for_sale_ageing = $data -> sheets[0]["cells"][$x][63];
				} else {
					echo $ready_for_sale_ageing = '';
				}
				echo "<br>";

				$query = $this -> upload_xls_model1 -> upload2($outlet_name, $make, $model, $submodel, $color, $source, $emission, $fuel_type, $rto_no, $reg_date, $chassis_number, $engine_number, $mfg_year, $mfg_month, $owner, $mileage, $odo_meter, $financier, $insurance_type, $insurance_expiry_date, $category, $ntv_reason, $rc_status, $vehicle_status, $quality_status, $receipt_number, $receipt_date, $evaluator_code, $evaluator_name, $evaluator_tl, $purchase_price, $est_refurbishment_cost, $battery_replacement, $body_repair, $labour, $mga_accessories, $outside_labour, $spare_parts, $tyre_replacement, $workshop_repair, $total_refurbishment_amount, $other, $total_other_expense, $expt_selling_price, $approved_disc, $exch_order_no, $exchange_dealer_share, $exchange_mgf_share, $exchange_bonus, $order_number, $customer_name, $allotted_date, $aloted_aging, $dse, $tl, $total_landing_cost, $ageing, $stock_location, $stock_ageing, $ready_for_sale, $ready_for_sale_date, $ready_for_sale_ageing);

			}

		}
	
redirect('upload_xls1');
}




}
?>
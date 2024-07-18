<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_web_quotation extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
	     $this->load->model('upload_web_quotation_model');
	   	date_default_timezone_set('Asia/Kolkata');     
		
	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();	
		$data['var']=site_url('upload_web_quotation/upload');
		$data['backup_date']=$this -> upload_web_quotation_model -> last_backup_date();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_web_quotation_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function backup_old_data()
{
	$sheet_name='Backup Quotation';
	$query = $this -> upload_web_quotation_model -> backup_old_data();
	$this->download_old_data($sheet_name);
}
public function restorebackup()
{
	$sheet_name='Backup Quotation';
	$query = $this -> upload_web_quotation_model -> restorebackup();
	//$this->download_old_data($sheet_name);
	redirect('upload_web_quotation');
}

	public function download_old_data($sheet_name=null)
{
	
	if(isset($sheet_name))
	{
		$sheet_name1=$sheet_name;
	}
	else {
		$sheet_name1='Quotation';
	}
		$query = $this -> upload_web_quotation_model -> download_old_data();
		//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Location','Model Code', 'Model name', 'variant', 'Type', 'Ex showroom','Auto Card', 'Number Plate With GST', 'Zero Dep Insurance with RTI & Engine Protect A Zone','Individual Registration with HP','Company Registration With HP', 'TCS @1%',  'Fastag Cost', 'Royal Platinum EW Price', 
		'Individual Onroad With A Zone Insurance', 'Company Onroad With A Zone Insurance', 'Consumer Offer', 'RIPS Support', 'Exchange bonus more than 7 year','Exchange bonus less than 7 year','Last Updated Date'
		);
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {
	
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $row -> location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row -> model_code);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> variant_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> ex_showroom);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> nexa_card);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> number_plate);
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> zero_dep_insurance_with_rti_and_engine_protect);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> individual_registration_with_hp);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> company_registration_with_hp);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> TCS);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> fastag_cost);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> royal_platinum_ew_price);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> individual_on_road_price);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> company_on_road_price);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> consumer_offer);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> rips_support);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row->exchange_bonus_more_than_7_year);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> exchnage_bonus_less_than_7_year);
			$lead_date=$row->date;
				if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(20, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, '00/00/00'); 
			}
		
		
			$excel_row++;

		}		
		$filename = $sheet_name1.' last updated on ' . $lead_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
	
}
	
	public function upload()
	{
		$date=date('Y-m-d:H:i:A');
		$location=$this->input->post('location');
		$query=$this->db->query("select max(upload_id) as upload_id from tbl_quotation")->result();
		if(isset($query[0]->upload_id)){
			
			$upload_id=$query[0]->upload_id + 1;
		}else{
	
			$upload_id=1;
		}


   			if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				"Type: " . $_FILES["file"]["type"] . "<br>";
				"Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				"Stored in: " . $_FILES["file"]["tmp_name"];"<br>";*/
			}
			
			
			move_uploaded_file($_FILES["file"]["tmp_name"],'upload/'.$date.'_'.$_FILES["file"]["name"]);
	
			$file='upload/'.$date.'_'.$_FILES["file"]["name"];
			//	echo $file;
			require_once 'Excel/reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($file);
			for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
				if(isset($data->sheets[0]["cells"][$x][2]))
				{
				echo $model_code=$data->sheets[0]["cells"][$x][2];
				}else{
					$model_code='';
				}
				echo     "<br>";
				/*if(isset($data->sheets[0]["cells"][$x][2]))
				{
					$model_id=$data->sheets[0]["cells"][$x][2];
				}
				else{
					$model_id='';
					}
					echo     "<br>";
					if(isset($data->sheets[0]["cells"][$x][3]))
				{
					$variant_id=$data->sheets[0]["cells"][$x][3];
				}else{
					$variant_id='';
				}
					echo     "<br>";*/
		
		
		if(isset($data->sheets[0]["cells"][$x][1]))
		{
			$location=$data->sheets[0]["cells"][$x][1];
		}
		else
		{
			$location='';
		}
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			$type=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$type='';
		}
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$ex_showroom =$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			 	$ex_showroom ='';
		}
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$nexa_card=$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$nexa_card='';
		}
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			$number_plate=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$number_plate='';
		}
		if(isset($data->sheets[0]["cells"][$x][9]))
		{
			$zero_dep_insurance_with_rti_and_engine_protect =$data->sheets[0]["cells"][$x][9];
		}
		else
		{
			$zero_dep_insurance_with_rti_and_engine_protect ='';
		}
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			$individual_registration_with_hp =$data->sheets[0]["cells"][$x][10];
		}
		else
		{
			$individual_registration_with_hp ='';
		}
		if(isset($data->sheets[0]["cells"][$x][11]))
		{
			$company_registration_with_hp  =$data->sheets[0]["cells"][$x][11];
		}
		else
		{
			$company_registration_with_hp ='';
		}
		if(isset($data->sheets[0]["cells"][$x][12]))
		{
			$TCS =$data->sheets[0]["cells"][$x][12];
		}
		else
		{
			$TCS ='';
		}
		if(isset($data->sheets[0]["cells"][$x][13]))
		{
			$fastag_cost =$data->sheets[0]["cells"][$x][13];
		}
		else
		{
			$fastag_cost ='';
		}
		if(isset($data->sheets[0]["cells"][$x][14]))
		{
			$royal_platinum_ew_price =$data->sheets[0]["cells"][$x][14];
		}
		else
		{
			$royal_platinum_ew_price ='';
		}
	if(isset($data->sheets[0]["cells"][$x][15]))
		{
			$individual_on_road_price =$data->sheets[0]["cells"][$x][15];
		}
		else
		{
			$individual_on_road_price ='';
		}
	if(isset($data->sheets[0]["cells"][$x][16]))
		{
			$company_on_road_price =$data->sheets[0]["cells"][$x][16];
		}
		else
		{
			$company_on_road_price ='';
		}
		if(isset($data->sheets[0]["cells"][$x][17]))
		{
			$consumer_offer  =$data->sheets[0]["cells"][$x][17];
		}
		else
		{
			 	$consumer_offer  ='';
		}
	if(isset($data->sheets[0]["cells"][$x][18]))
		{
			$rips_support   =$data->sheets[0]["cells"][$x][18];
		}
		else
		{
			 	$rips_support   ='';
		}
	if(isset($data->sheets[0]["cells"][$x][19]))
		{
			$exchange_bonus_more_than_7_year   =$data->sheets[0]["cells"][$x][19];
		}
		else
		{
			 	$exchange_bonus_more_than_7_year   ='';
		}
		if(isset($data->sheets[0]["cells"][$x][20]))
		{
			$exchnage_bonus_less_than_7_year   =$data->sheets[0]["cells"][$x][20];
		}
		else
		{
			 	$exchnage_bonus_less_than_7_year   ='';
		}
		
		$query=$this->upload_web_quotation_model->upload($upload_id,$location,$model_code,$type,$ex_showroom,$nexa_card,$number_plate,$zero_dep_insurance_with_rti_and_engine_protect,$individual_registration_with_hp,$company_registration_with_hp,$TCS,$fastag_cost,$royal_platinum_ew_price,$individual_on_road_price,$company_on_road_price,$consumer_offer,$rips_support,$exchange_bonus_more_than_7_year,$exchnage_bonus_less_than_7_year);
	
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_web_quotation');
		
		
		
	}
	public function upload_corporate() 
	{
		$this->session();	
		$data['var']=site_url('upload_web_quotation/upload_corporate1');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_corporate.php',$data);
		$this->load->view('include/footer.php');
	
	}
public function upload_corporate1()
	{
		$date=date('Y-m-d');
		if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				"Type: " . $_FILES["file"]["type"] . "<br>";
				"Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				"Stored in: " . $_FILES["file"]["tmp_name"];"<br>";*/
			}
			
			
			move_uploaded_file($_FILES["file"]["tmp_name"],'upload/'.$date.'_'.$_FILES["file"]["name"]);
	
			$file='upload/'.$date.'_'.$_FILES["file"]["name"];
			//	echo $file;
			require_once 'Excel/reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($file);
			for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
				if(isset($data->sheets[0]["cells"][$x][2]))
				{
				echo $corporate_name=$data->sheets[0]["cells"][$x][2];
				}else{
					$corporate_name='';
				}
				echo     "<br>";
			
			$query=$this->upload_web_quotation_model->upload_corporate($corporate_name,$date);
		
		
		
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
		redirect('upload_web_quotation/upload_corporate');
	}
	public function upload_onroad_perfoma() 
	{
		$this->session();	
		$data['var']=site_url('upload_web_quotation/upload_onroad_perfoma1');
		$data['backup_date']=$this -> upload_web_quotation_model -> last_updated_date_performa();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_onroad_perfoma_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function upload_onroad_perfoma1()
	{
		$date=date('Y-m-d:H:i:A');
		$location=$this->input->post('location');
		/*$query=$this->db->query("select max(upload_id) as upload_id from tbl_quotation")->result();
		if(isset($query[0]->upload_id)){
			
			$upload_id=$query[0]->upload_id + 1;
		}else{
	
			$upload_id=1;
		}*/


   			if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				"Type: " . $_FILES["file"]["type"] . "<br>";
				"Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				"Stored in: " . $_FILES["file"]["tmp_name"];"<br>";*/
			}
			
			
			move_uploaded_file($_FILES["file"]["tmp_name"],'upload/'.$date.'_'.$_FILES["file"]["name"]);
	
			$file='upload/'.$date.'_'.$_FILES["file"]["name"];
			//	echo $file;
			require_once 'Excel/reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($file);
			for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
				if(isset($data->sheets[0]["cells"][$x][2]))
				{
				echo $model_code=$data->sheets[0]["cells"][$x][2];
				}else{
					$model_code='';
				}
				echo     "<br>";
				/*if(isset($data->sheets[0]["cells"][$x][2]))
				{
					$model_id=$data->sheets[0]["cells"][$x][2];
				}
				else{
					$model_id='';
					}
					echo     "<br>";
					if(isset($data->sheets[0]["cells"][$x][3]))
				{
					$variant_id=$data->sheets[0]["cells"][$x][3];
				}else{
					$variant_id='';
				}
					echo     "<br>";*/
		
		
		if(isset($data->sheets[0]["cells"][$x][1]))
		{
			$location=$data->sheets[0]["cells"][$x][1];
		}
		else
		{
			$location='';
		}
		if (is_numeric($location)) { $location=''; } 
		if(isset($data->sheets[0]["cells"][$x][3]))
		{
			$type=$data->sheets[0]["cells"][$x][3];
		}
		else
		{
			$type='';
		}
		if (is_numeric($type)) { $type=''; } 
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			$basic_price=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$basic_price='';
		}
		if (is_numeric($basic_price)) {  } else { $basic_price=''; }
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$ex_showroom =$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			 	$ex_showroom ='';
		}if (is_numeric($ex_showroom)) { } else { $ex_showroom=''; }
		if(isset($data->sheets[0]["cells"][$x][14]))
		{
			$nexa_card=$data->sheets[0]["cells"][$x][14];
		}
		else
		{
			$nexa_card='';
		}if (is_numeric($nexa_card)) {  } else { $nexa_card=''; }
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			$ins_corp=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$ins_corp='';
		}if (is_numeric($ins_corp)) {  } else { $ins_corp=''; }
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$zero_dep_insurance_with_rti_and_engine_protect =$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$zero_dep_insurance_with_rti_and_engine_protect ='';
		}if (is_numeric($zero_dep_insurance_with_rti_and_engine_protect)) {  } else { $zero_dep_insurance_with_rti_and_engine_protect=''; }
		if(isset($data->sheets[0]["cells"][$x][9]))
		{
			$individual_registration_with_hp =$data->sheets[0]["cells"][$x][9];
		}
		else
		{
			$individual_registration_with_hp ='';
		}if (is_numeric($individual_registration_with_hp)) {  } else { $individual_registration_with_hp=''; }
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			$company_registration_with_hp  =$data->sheets[0]["cells"][$x][10];
		}
		else
		{
			$company_registration_with_hp ='';
		}
		if (is_numeric($company_registration_with_hp)) { } else { $company_registration_with_hp=''; }
		if(isset($data->sheets[0]["cells"][$x][11]))
		{
			$registration =$data->sheets[0]["cells"][$x][11];
		}
		else
		{
			$registration ='';
		}
		if (is_numeric($registration)) {  } else { $registration=''; }
		if(isset($data->sheets[0]["cells"][$x][12]))
		{
			$fastag_cost =$data->sheets[0]["cells"][$x][12];
		}
		else
		{
			$fastag_cost ='';
		}
		if (is_numeric($fastag_cost)) {  } else { $fastag_cost=''; }
		if(isset($data->sheets[0]["cells"][$x][13]))
		{
			$warranty =$data->sheets[0]["cells"][$x][13];
		}
		else
		{
			$warranty ='';
		}
		if (is_numeric($warranty)) { } else { $warranty=''; }
	if(isset($data->sheets[0]["cells"][$x][15]))
		{
			$individual_on_road_price =$data->sheets[0]["cells"][$x][15];
		}
		else
		{
			$individual_on_road_price ='';
		}	
		if (is_numeric($individual_on_road_price)) {  } else { $individual_on_road_price=''; }
if(isset($data->sheets[0]["cells"][$x][16]))
		{
			$company_on_road_price =$data->sheets[0]["cells"][$x][16];
		}
		else
		{
			$company_on_road_price ='';
		}	
		if (is_numeric($company_on_road_price)) {  } else { $company_on_road_price=''; }


		$query=$this->upload_web_quotation_model->upload_onroad_perfoma($location,$model_code,$type,$basic_price,$ex_showroom,$nexa_card,$ins_corp,$zero_dep_insurance_with_rti_and_engine_protect,$individual_registration_with_hp,$company_registration_with_hp,$registration,$fastag_cost,$warranty,$individual_on_road_price,$company_on_road_price);
	
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_web_quotation/upload_onroad_perfoma');
		
		/*if(isset($data->sheets[0]["cells"][$x][16]))
		{
			$company_on_road_price =$data->sheets[0]["cells"][$x][16];
		}
		else
		{
			$company_on_road_price ='';
		}
		if(isset($data->sheets[0]["cells"][$x][17]))
		{
			$consumer_offer  =$data->sheets[0]["cells"][$x][17];
		}
		else
		{
			 	$consumer_offer  ='';
		}
	if(isset($data->sheets[0]["cells"][$x][18]))
		{
			$rips_support   =$data->sheets[0]["cells"][$x][18];
		}
		else
		{
			 	$rips_support   ='';
		}
	if(isset($data->sheets[0]["cells"][$x][19]))
		{
			$exchange_bonus_more_than_7_year   =$data->sheets[0]["cells"][$x][19];
		}
		else
		{
			 	$exchange_bonus_more_than_7_year   ='';
		}
		if(isset($data->sheets[0]["cells"][$x][20]))
		{
			$exchnage_bonus_less_than_7_year   =$data->sheets[0]["cells"][$x][20];
		}
		else
		{
			 	$exchnage_bonus_less_than_7_year   ='';
		}*/
		
	}
	public function upload_onroad_perfoma_offer() 
	{
		$this->session();	
		$data['var']=site_url('upload_web_quotation/upload_onroad_perfoma_offer1');
		$data['backup_date']=$this -> upload_web_quotation_model -> last_updated_date_performa_offer();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_onroad_perfoma_offer_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function upload_onroad_perfoma_offer1()
	{
		$date=date('Y-m-d:H:i:A');
		$location=$this->input->post('location');
		/*$query=$this->db->query("select max(upload_id) as upload_id from tbl_quotation")->result();
		if(isset($query[0]->upload_id)){
			
			$upload_id=$query[0]->upload_id + 1;
		}else{
	
			$upload_id=1;
		}*/


   			if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				"Type: " . $_FILES["file"]["type"] . "<br>";
				"Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				"Stored in: " . $_FILES["file"]["tmp_name"];"<br>";*/
			}
			
			
			move_uploaded_file($_FILES["file"]["tmp_name"],'upload/'.$date.'_'.$_FILES["file"]["name"]);
	
			$file='upload/'.$date.'_'.$_FILES["file"]["name"];
			//	echo $file;
			require_once 'Excel/reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($file);
			for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
				if(isset($data->sheets[0]["cells"][$x][3]))
				{
				echo $model_code=$data->sheets[0]["cells"][$x][3];
				}else{
					$model_code='';
				}
				echo     "<br>";
				
		
		
		if(isset($data->sheets[0]["cells"][$x][1]))
		{
			$location=$data->sheets[0]["cells"][$x][1];
		}
		else
		{
			$location='';
		}
		 if (is_numeric($location)) { $location=''; } 
		 if(isset($data->sheets[0]["cells"][$x][2]))
		{
			$scheme_name=$data->sheets[0]["cells"][$x][2];
		}
		else
		{
			$scheme_name='';
		}
		if (is_numeric($scheme_name)) { $scheme_name=''; } 
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			$type=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$type='';
		}
		if (is_numeric($type)) { $type=''; } 
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
			$description=$data->sheets[0]["cells"][$x][4];
		}
		else
		{
			$description='';
		}
		if (is_numeric($description)) { $description=''; } 
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$cons_off =$data->sheets[0]["cells"][$x][6];
		}
		else
		{$cons_off ='';
		}
		if (is_numeric($cons_off)) { } else { $cons_off=''; }
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$cons_offdlr=$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$cons_offdlr='';
		}
		if (is_numeric($cons_offdlr)) { } else { $cons_offdlr=''; }
		if(isset($data->sheets[0]["cells"][$x][15]))
		{
			$rips =$data->sheets[0]["cells"][$x][15];
		}
		else
		{
			$rips ='';
		}
		if (is_numeric($rips)) { } else { $rips=''; }
		
		if(isset($data->sheets[0]["cells"][$x][8]))
		{			$dco=$data->sheets[0]["cells"][$x][8];		}
		else
		{			$dco='';		}
		if (is_numeric($dco)) { } else { $dco=''; }

		if(isset($data->sheets[0]["cells"][$x][9]))
		{			$dcodlr=$data->sheets[0]["cells"][$x][9];		}
		else
		{			$dcodlr='';		}
		if (is_numeric($dcodlr)) { } else { $dcodlr=''; }
		if(isset($data->sheets[0]["cells"][$x][10]))
		{			$fame=$data->sheets[0]["cells"][$x][10];		}
		else
		{			$fame='';		}
		if (is_numeric($fame)) { } else { $fame=''; }
		if(isset($data->sheets[0]["cells"][$x][11]))
		{			$finpay=$data->sheets[0]["cells"][$x][11];		}
		else
		{			$finpay='';		}
		if (is_numeric($finpay)) { } else { $finpay=''; }
		if(isset($data->sheets[0]["cells"][$x][12]))
		{			$focdisc=$data->sheets[0]["cells"][$x][12];		}
		else
		{			$focdisc='';		}
		if (is_numeric($focdisc)) { } else { $focdisc=''; }
		if(isset($data->sheets[0]["cells"][$x][13]))
		{			$jol=$data->sheets[0]["cells"][$x][13];		}
		else
		{			$jol='';		}
		if (is_numeric($jol)) { } else { $jol=''; }
		if(isset($data->sheets[0]["cells"][$x][14]))
		{			$joldlr=$data->sheets[0]["cells"][$x][14];		}
		else
		{			$joldlr='';		}
		if (is_numeric($joldlr)) { } else { $joldlr=''; }
		if(isset($data->sheets[0]["cells"][$x][16]))
		{			$rips1=$data->sheets[0]["cells"][$x][16];		}
		else
		{			$rips1='';		}
		if (is_numeric($rips1)) { } else { $rips1=''; }
		if(isset($data->sheets[0]["cells"][$x][17]))
		{			$ripsdlr=$data->sheets[0]["cells"][$x][17];		}
		else
		{			$ripsdlr='';		}
		if (is_numeric($ripsdlr)) { } else { $ripsdlr=''; }
		if(isset($data->sheets[0]["cells"][$x][18]))
		{			$rmk=$data->sheets[0]["cells"][$x][18];		}
		else
		{			$rmk='';		}
		if (is_numeric($rmk)) { } else { $rmk=''; }
		if(isset($data->sheets[0]["cells"][$x][19]))
		{			$rmkdlr=$data->sheets[0]["cells"][$x][19];		}
		else
		{			$rmkdlr='';		}
		if (is_numeric($rmkdlr)) { } else { $rmkdlr=''; }
		if(isset($data->sheets[0]["cells"][$x][20]))
		{			$tyt=$data->sheets[0]["cells"][$x][20];		}
		else
		{			$tyt='';		}
		if (is_numeric($tyt)) { } else { $tyt=''; }
		if(isset($data->sheets[0]["cells"][$x][21]))
		{			$tytdlr=$data->sheets[0]["cells"][$x][21];		}
		else
		{			$tytdlr='';		}
		if (is_numeric($tytdlr)) { } else { $tytdlr=''; }
		if(isset($data->sheets[0]["cells"][$x][22]))
		{			$woi=$data->sheets[0]["cells"][$x][22];		}
		else
		{			$woi='';		}
		if (is_numeric($woi)) { } else { $woi=''; }
		if(isset($data->sheets[0]["cells"][$x][23]))
		{			$woidlr=$data->sheets[0]["cells"][$x][23];		}
		else
		{			$woidlr='';		}
		if (is_numeric($woidlr)) { } else { $woidlr=''; }

		
	
		//echo $location;
		$query=$this->upload_web_quotation_model->upload_onroad_perfoma_offer($location,$model_code,$type,$description,$cons_off,$cons_offdlr,$scheme_name,$rips,$dco,$dcodlr,$fame,$finpay,$focdisc,$jol,$joldlr,$rips1,$ripsdlr,$rmk,$rmkdlr,$tyt,$tytdlr,$woi,$woidlr);
	
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_web_quotation/upload_onroad_perfoma_offer');
		
	
		
	}

public function download_old_data_performa_offer($sheet_name=null)
{
	
	if(isset($sheet_name))
	{
		$sheet_name1=$sheet_name;
	}
	else {
		$sheet_name1='Quotation Performa Offer';
	}
	$lead_date='';
		$query = $this -> upload_web_quotation_model -> download_old_data_performa_offer();
		//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);


		$table_columns = array('Location','Scheme Name','Model Code', 'Description', 'Type', 'CONSOFF', 'CONSOFFDLR', 'DCO', 'DCODLR','FAME','FINPAY', 'FOCDISC',  'JOL', 'JOLDLR', 'RIPS','RIPS1','RIPSDLR','RMK','RMKDLR','TYT','TYTDLR','WOI','WOIDLR');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}		
		$excel_row = 2;
		foreach ($query as $row) {
	
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $row -> location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row -> scheme_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> model_code);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> description);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> cons_off);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> cons_offdlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> dco);
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> dcodlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> fame);			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> finpay);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> focdisc);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> jol);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> joldlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> rips);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> rips1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> ripsdlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> rmk);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> rmkdlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> tyt);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> tytdlr);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> woi);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> woidlr);
			
			$lead_date=$row->date;
				/*if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(15, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, '00/00/00'); 
			}*/
		
		
			$excel_row++;

		}		
		$filename = $sheet_name1.' last updated on ' . $lead_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
	
}
	public function download_old_data_performa($sheet_name=null)
{
	
	if(isset($sheet_name))
	{
		$sheet_name1=$sheet_name;
	}
	else {
		$sheet_name1='Quotation performa';
	}
		$query = $this -> upload_web_quotation_model -> download_old_data_performa();
		//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);


		$table_columns = array('Location','Model Code', 'Type', 'Model name', 'Basic Price',  'Ex showroom', 'INS Ind', 'INS Corp','RTO Tax Ind','RTO TAX Corp', 'Registration Fees',  'Fastag Cost', '	3rd 4th and 5thYr EXT WARR', 'Auto Card',
		'Individual Onroad Price','Company Onroad Price'
		);

		/**/
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}		
		$excel_row = 2;
		foreach ($query as $row) {
			$model_variant=$row -> model_name.' '.$row->variant_name;
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $row -> location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row -> model_code);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $model_variant);			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> basic_price);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> ex_showroom);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> zero_dep_insurance_with_rti_and_engine_protect);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> ins_corp);
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> individual_registration_with_hp);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> company_registration_with_hp);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> registration);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> fastag_cost);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> warranty);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> nexa_card);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> individual_on_road_price);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> company_on_road_price);
			
			$lead_date=$row->date;
				/*if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(15, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, '00/00/00'); 
			}*/
		
		
			$excel_row++;
//break;
		}		
		$filename = $sheet_name1.' last updated on ' . $lead_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
	
}

}
?>
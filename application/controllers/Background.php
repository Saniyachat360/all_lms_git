<?php

class Background extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		//$this -> load -> model('add_user_model');
		}

    public function run($to = 'World')
    {
        echo "Hello I am a background process {$to}!" . PHP_EOL;
        return $query = $this -> add_user_model -> select_table();
		
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'User Name', 'Contact Number','Email ID', 'Password','Role','TL Name','Process','Location','Status');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {

	
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row->fname.' '.$row->lname);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> mobileno);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> email);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> password);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> role_name);
					$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> tl_fname.' '.$row->tl_lname);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> process_name);
	
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> location);
			if($row->status==1)
			{
				$status='Active';
			}
			else {
				$status='Deactive';
			}
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $status);
			$excel_row++;

		
		}

		$filename = 'LMS User Data' ;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
		
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class dynamic_upload_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function select_quotation_name() {
	$get_tbl_data=$this->db->query("select * from tbl_quotation_name ");
		return $get_tbl_data -> result();

	}
	public function insert_create_table()
	{
		
	$rows = $this->input->post('mytext');
	$dataty = $this->input->post('dataty');
	//print_r($_POST['mytext']);
	$location =$this->input->post('location_name');
	$quotation = $this->input->post('quotation_name');
	$today = date('Y-m-d');
	$j = count($rows) - 1;
	$get_table_name = $this -> db -> query("select table_name from tbl_quotation_name order by quotation_id desc limit 1") -> result();
	if (count($get_table_name) > 0) {
		$name = $get_table_name[0] -> table_name;
		$get_number = substr($name, 13);
		$get_number = $get_number + 1;
		$table = 'tbl_quotation' . $get_number;
	} else {
		$table = 'tbl_quotation1';
	}

	$query1 = $this -> db -> query("SHOW TABLES LIKE '" . $table . "'") -> result();

	if (count($query1) == 1) {

	} else {

		$query = $this -> db -> query("INSERT INTO `tbl_quotation_name`(`table_name`, `quotation_name`, `location`, `status`, `created_date`) VALUES ('$table','$quotation','$location','Inactive','$today')");
		$sql = "CREATE TABLE " . $table . "( quotation_name_id  int NOT NULL PRIMARY KEY AUTO_INCREMENT,";
		for ($i = 0; $i < count($rows); $i++) {
			$name=trim($rows[$i]);
			$name=str_replace(' ','_',$name);
			$name1=str_replace('-','_',$name);
			
			if ($i == $j) {
				
				$sql .= "`{$name1}` {$dataty[$i]}";
			} else {

				$sql .= "`{$name1}` {$dataty[$i]},";
			}

		}
		$sql .= ");";

		$this -> db -> query($sql);
	}

}
	
	public function upload_data()
	{
	
	$coloumn_data = array();
	 $table_name = $this->input->post('table_name');
	$date = date('Y-m-d');
	if ($_FILES["file"]["error"] > 0) {
		echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/' . $date . '_' . $_FILES["file"]["name"]);
	$file = 'upload/' . $date . '_' . $_FILES["file"]["name"];
	require_once 'Excel/reader.php';

	$data = new Spreadsheet_Excel_Reader();
	$data -> setOutputEncoding('CP1251');
	$data -> read($file);
	$coloumn_name = $this -> db -> query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'") -> result();

	for ($j = 1; $j < count($coloumn_name); $j++) {
		$coloumn_name1[] = $coloumn_name[$j] -> COLUMN_NAME;
		$column_list = join(',', $coloumn_name1);
		//array_push($coloumn_data,$coloumn_name1);
	}

	$count = $data -> sheets[0]["numCols"];
	for ($x = 2; $x <= count($data -> sheets[0]["cells"]); $x++) {

		//
		for ($i = 1; $i <= $count; $i++) {
			$value1[] = $data -> sheets[0]['cells'][$x][$i];
			$value_list = "'" . implode("', '", $value1) . "'";

		}

		$t = $data -> sheets[0]["cells"][$x];
		$t1 = "'" . implode("', '", $t) . "'";

		$insert_table = $this -> db -> query("INSERT INTO $table_name ($column_list) VALUES ($t1)");
		//echo $this->db->last_query();
		//	unset($value_list);

	}

		
	}	
public function select_qutation_table()
{
	$location=$this->input->post('location');
	$this->db->select('*');
	$this->db->from('tbl_quotation_name');
	$this->db->where('location',$location);
	$query=$this->db->get();
	//echo $this->db->last_query();
	return $query->result();
}
	
	
}
?>
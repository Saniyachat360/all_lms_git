<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dynamic_upload extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('dynamic_upload_model');

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
		}
public function index() {
	$this->session();
	$data['select_quotation_name']=$this->dynamic_upload_model->select_quotation_name();
$this->load->view('include/admin_header.php');
$this->load->view('dynamic_upload_view.php',$data);
$this->load->view('include/footer.php');
}
public function insert_create_table()

{
		
		$this->dynamic_upload_model->insert_create_table();
	redirect('dynamic_upload');
	
}
public function upload_data(){
	$this->dynamic_upload_model->upload_data();
	redirect('dynamic_upload');
}
public function active_table(){
	
	$this->load->view('include/admin_header.php');
$this->load->view('dynamic_upload_active_view.php');
$this->load->view('include/footer.php');
}
public function select_qutation_location()
{

	$select_data=$this->dynamic_upload_model->select_qutation_table();
	if(count($select_data)>0){
	?>
	<form action="<?php echo site_url();?>dynamic_upload/update_status" method="post">
		<input type="hidden" name="location" value="<?php echo $select_data[0]->location ;?>" />
	<table class='table  dataTable no-footer'>
				<thead>
				<tr>
					<th>Sr No</th>
					
					<th>Quotation name</th>
					<th>Created Date</th>
				</tr>
				</thead>
			<tbody>
				
				<?php $i=0; 
				foreach ($select_data as $row) { $i++;?>
					<tr>
					<td><?php echo $i; ?></td>
				
					<td> <input type="radio" name="makeactive" value="<?php echo $row->quotation_id;?>" <?php if($row->status == 'Active') {?> checked <?php } ?>>&nbsp;&nbsp;<?php echo $row->quotation_name;?></td>
					<td><?php echo $row->created_date;?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
			<hr>
			<br><br>
			
		<div class="col-md-offset-5 col-md-6">
					<div class="form-group">
	<input class="btn btn-info col-md-5 col-xs-5 col-sm-5" id="table_submit" type="submit" name="submit" value="Active" />
	</div>
	</div>
	</form>
<?php }}
public function update_status()
{

	$status=$this->input->post('makeactive');
	$location=$this->input->post('location');
	
	
	$this->db->query("update tbl_quotation_name set status='Inactive' where location='$location'");
	echo $this->db->last_query();
	$this->db->query("update tbl_quotation_name set status='Active' where quotation_id='$status'");
		echo $this->db->last_query();

	redirect('dynamic_upload/active_table');
	
}
public function download_data(){
	
	//header info for browser
header("Content-Type: application/csv");    
header("Content-Disposition: attachment; filename=quotation_table.csv");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/  
 
//print_r($result1);
//define separator (defines columns in excel & tabs in word)
$table_name=$this->input->get('table_name');
$select_coloumns=$this->db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'")->result();
//$select_data=$this->db->query("select * from '$table_name'")->result();
$this->db->select('*');
$this->db->from($table_name);
$select_data=$this->db->get()->result();

//print_r($result1);
//define separator (defines columns in excel & tabs in word)
if(isset($select_data))
{

	for ($j = 1; $j < count($select_coloumns); $j++) {
		$coloumn_name1[] = $select_coloumns[$j] -> COLUMN_NAME;
		$csv = join(',', $coloumn_name1);
		
		}
	
	foreach ($select_data as $row) {
		$csv.="\n";	

		for ($s = 1; $s < count($select_coloumns); $s++) {
				$coloum=$select_coloumns[$s] -> COLUMN_NAME;
		$value[] = $row->$coloum;
		if($s ==count($select_coloumns)-1){
		
			$csv.=$row->$coloum ;
		}else{
			$csv.=$row->$coloum .',';
		}
		//echo $s;
		//echo count($select_coloumns);
		}
	
	}


	
	 echo $csv;
	
}
/* $flag = false;
 foreach ($result1 as $key => $value) {
 	foreach ($value as $key1 => $value1) {
		 
	 
   
 
        if(!$flag) {
            // display column names as first row
           print_r($key1);
		  $key_data[]=$key1;
            echo implode("\t", $key_data) . "\n";
            $flag = true;
        }
        // filter data
      //  array_walk($value, 'filterData');
	  $value_data[]=$value1;
        echo implode("\t", $value_data) . "\n";

    }
 }*/
}
}
	?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Add_lms_user extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_user_model');
		}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$process_id=$data['select_process'] = $this -> add_user_model -> select_process();
		$test=$data['select_location'] = $this -> add_user_model -> select_location($process_id);
		//print_r($test);
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
		$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
		$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
public function searchuser() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$data['select_process'] = $this -> add_user_model -> select_process();
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
	//	print_r($data['maxEmpId']);
		//$data['select_location'] = $this -> add_user_model -> select_location();		
		$data['var'] = site_url('add_lms_user/add_user');
		
		$this -> load -> view('add_lms_user_filter_view.php', $data);
	}
public function searchuser1() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$this -> load -> view('download_lms_user_filter_view.php', $data);
	

	}

	public function paging_next() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$data['select_process'] = $this -> add_user_model -> select_process();
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
		
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
		$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
	//	print_r($data['maxEmpId']);
	//	$data['select_location'] = $this -> add_user_model -> select_location();		
		$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
public function paging_next1() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('download_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	public function add_user() {
		$process=$this->input->post('process');
		$finance_location=$this->input->post('finance_location');
		$insurance_location=$this->input->post('insurance_location');
		$service_location=$this->input->post('service_location');
		$accessories_location=$this->input->post('accessories_location');
		$new_car_location=$this->input->post('new_car_location');
		$used_car_location=$this->input->post('used_car_location');
		$evaluation_location=$this->input->post('evaluation_location');
		$complaint_location=$this->input->post('complaint_location');
		$location_array=array();
		if(is_array($finance_location)){
			$location_array=array_merge($location_array,$finance_location);
		}
		if(is_array($insurance_location)){
			$location_array=array_merge($location_array,$insurance_location);
		}
		if(is_array($service_location)){
			$location_array=array_merge($location_array,$service_location);
		}
		if(is_array($accessories_location)){
			$location_array=array_merge($location_array,$accessories_location);
		}
		if(is_array($new_car_location)){
			$location_array=array_merge($location_array,$new_car_location);
		}
		if(is_array($used_car_location)){
			$location_array=array_merge($location_array,$used_car_location);
		}
		if(is_array($evaluation_location)){
			$location_array=array_merge($location_array,$evaluation_location);
		}
			if(is_array($complaint_location)){
			$location_array=array_merge($location_array,$complaint_location);
		}
		//print_r($location_array);
		
	
		 $fname = $this -> input -> post('fname');
		$lname = $this -> input -> post('lname');
		$email = str_replace(' ', '', $this -> input -> post('email'));
	//	$email = $this -> input -> post('email');
		$pnum = $this -> input -> post('pnum');

		$location = $this -> input -> post('location');
		$role1 = $this -> input -> post('role');
		$role2=explode('#',$role1);
		$role=$role2[0];
		$role_name=$role2[1];
		//$process_id = $this -> input -> post('process_id');
		//if(count(process_id ==0))
		//{
			//$process_id=$this->input->post('process_id_single');
		//}
		
		$group_id = $this -> input -> post('group_id');
		$date = date('Y/m/d');
		//$password = rand(0, 10000);
		$password =$this -> input -> post('password');
		$status =$this -> input -> post('status');
	
		$query = $this -> add_user_model -> add_user($fname, $lname, $email, $pnum,$role, $date, $password, $group_id,$role_name,$status,$location_array);
		
		/*$data['email'] = $email;
		$data['password'] = $password;
		$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('LMS User Details');
		$body = $this -> load -> view('send_mail_view.php', $data, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();*/
	redirect('add_lms_user');

	}

	/*public function get_group_name(){
					
		$process_id=$this->input->post('process_id');		
		$select_group =$this->add_user_model->select_group($process_id);
		if(count($select_group)>0)
		{			
					
		?>	
			<label class="control-label col-md-2 col-sm-2 col-xs-12" >Group Name: </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<?php foreach ($select_group as $row) {?>
				<label class="checkbox-inline">
					<input type="checkbox"  name="group_id[]" value="<?php echo $row -> group_id; ?>" >
					&nbsp;&nbsp;<?php echo $row -> group_name; ?>
				</label>
				<?php } ?>
			</div>
	
		<?php 
		}
		else {
			?>
			<label class="control-label col-md-2 col-sm-2 col-xs-12" > </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type='hidden' required>
				<label class="control-label" >No Groups Found !! Please Add Group First.</label>
				
			</div>
			<?php
		}
	}*/
		public function edit_user() {
		$this -> session();
		$id = $this -> input -> get('id');
		$data['select_process'] = $this -> add_user_model -> select_process();

		//$data['select_location'] = $this -> add_user_model -> select_location();
		$query = $this -> add_user_model -> edit_user($id);
		$data['edit_dse'] = $this -> add_user_model -> edit_dse($query[0]->id);
		$data['edit_process'] = $this -> add_user_model -> edit_user_process($id);
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
		$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
		//print_r($query);
		$data['edit_user'] = $query;
		
		//$data['var1'] = site_url('add_lms_user/update_user');
		$data['var1'] = site_url('add_lms_user/update_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_user_view', $data);
		$this -> load -> view('include/footer');

	}

	function update_user() {

		$id = $this -> input -> post('id');
		
		$group_id = $this -> input -> post('group_id');
		//print_r($group_id);
		
		$fname = $this -> input -> post('fname');
		$lname = $this -> input -> post('lname');
		$email = $this -> input -> post('email');
		$pnum = $this -> input -> post('pnum');

		//$location = $this -> input -> post('location');
		$role1 = $this -> input -> post('role');
		$role2=explode('#',$role1);
		 $role=$role2[0];
		 $role_name=$role2[1];
		/* $process_id = $this -> input -> post('process_id');
		 if(count(process_id ==0))
		{
			$process_id=$this->input->post('process_id_single');
		}*/
		$process=$this->input->post('process');
		$finance_location=$this->input->post('finance_location');
		$insurance_location=$this->input->post('insurance_location');
		$service_location=$this->input->post('service_location');
		$accessories_location=$this->input->post('accessories_location');
		$new_car_location=$this->input->post('new_car_location');
		$used_car_location=$this->input->post('used_car_location');
		$evaluation_location=$this->input->post('evaluation_location');
		$complaint_location=$this->input->post('complaint_location');
		$location_array=array();
		if(is_array($finance_location)){
			$location_array=array_merge($location_array,$finance_location);
		}
		if(is_array($insurance_location)){
			$location_array=array_merge($location_array,$insurance_location);
		}
		if(is_array($service_location)){
			$location_array=array_merge($location_array,$service_location);
		}
		if(is_array($accessories_location)){
			$location_array=array_merge($location_array,$accessories_location);
		}
		if(is_array($new_car_location)){
			$location_array=array_merge($location_array,$new_car_location);
		}
		if(is_array($used_car_location)){
			$location_array=array_merge($location_array,$used_car_location);
		}
		if(is_array($evaluation_location)){
			$location_array=array_merge($location_array,$evaluation_location);
		}
			if(is_array($complaint_location)){
			$location_array=array_merge($location_array,$complaint_location);
		}
	
		$q = $this -> add_user_model -> update_user($fname, $lname, $email, $pnum,$role, $id,$role_name,$location_array,$process);
	
	redirect('add_lms_user');
	}

	function delete_user() {
		$q = $this -> add_user_model -> delete_user();
		redirect('add_lms_user');
	}
	public function get_tl_name()
	{
		$role=$this->input->post('role');
		 $select_tl=$this -> add_user_model -> select_tl($role);?>
		   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Team Leader:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <select name="tl_name" id="tl_name" required  class="form-control" >
                                                  	<option value=''>Please Select</option>
                                                  	<?php foreach ($select_tl as $row) {?>
                                                  	<option value='<?php echo $row -> id; ?>'><?php  echo $row -> fname . ' ' . $row -> lname; ?></option>	
                                                  	<?php } ?>
													</select>
													</div>	  
													  <?php
	}
	public function download_lms_user() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('download_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function download_data() {

	
		$query = $this -> add_user_model -> select_table();
		$csv="Sr No, User Name, Contact Number,Email ID, Password,Role,TL Name,Process,Location,Status\n";
		
		$i=0;
	foreach ($query as $row) {
		$i++;
		$cse_name = $row -> fname . ' ' . $row -> lname;
		$tl_name = $row -> tl_fname . ' ' . $row -> tl_lname;
		if($row->status==1)
			{
				$status='Active';
			}
			else {
				$status='Deactive';
			}	
		
			 $csv.= $i.',"'.$cse_name.'","'.$row->mobileno.'","'.$row->email.'","'.$row->password.'","'.$row->role_name.'","'.$tl_name.'","'.$row->process_name.'","'.$row->location.'",'.$status."\n";
		 }
	/*
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

		
		}/*
		$filename = 'LMS User Data' ;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');*/
		$csv_handler = fopen ('lmsuserdata.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'LMS User Data.csv';
    $data = file_get_contents('https://www.autovista.in/all_lms/lmsuserdata.csv'); // Read the file's contents
    
       // force_download($filename, $data);
	force_download($filename, $csv);
	}
public function download_data_api() {

	
		$query = $this -> add_user_model -> select_table1();
	
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'User Name', 'Contact Number','Email ID', 'Password','Role','Process','Location','Status');
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
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> process_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> location);
			if($row->status==1)
			{
				$status='Active';
			}
			else {
				$status='Deactive';
			}
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $status);
			$excel_row++;

		
		}

		$filename = 'LMS User Data' ;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	}
public function download_data_demo() {

	
	//$query = $this -> add_user_model -> select_table1();
	
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'User Name', 'Contact Number','Email ID');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		for($i=1;$i<=50;$i++) {

	
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row,'Excell Autovista');
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, '1234567890');
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row,'autovista@gmail.com');
		
			$excel_row++;

		
		}

		$filename = 'LMS User Data' ;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	}


}
?>
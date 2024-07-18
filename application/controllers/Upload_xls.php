<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Upload_xls extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
	   $this->load->model('upload_xls_model');
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
		$query1=$this->upload_xls_model->select_grp();
		$data['select_grp']=$query1;	
		
		$query=$this->upload_xls_model->select_lead_source();
		$data['select_lead_source']=$query;
			
	//	print_r($query1);
	
		$query2=$this->upload_xls_model->select_campaign();
		$data['select_campaign']=$query2;
		//print_r($query2);
				
		$data['var']=site_url('upload_xls/upload');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_xls_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	
	public function upload_new()
	{
		$data['var']=site_url('upload_xls/upload1');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_xls_demo_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function upload1()
	{




	$date=date('Y-m-d:H:i:A');


   if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				
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
				/*$first = $data->sheets[0]["cells"][$x][1];
				$last =$data->sheets[0]["cells"][$x][2];
				$this->addvlist_model->insert($villgeid,$first,$last);*/
			//	echo     "<br>";
			if(isset($data->sheets[0]["cells"][$x][1])){
		 	echo $name=$data->sheets[0]["cells"][$x][1];
			}else{
				$name='Unknown';
			}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][2]))
		{
		 	 $email_id=$data->sheets[0]["cells"][$x][2];
		}
		else{
			$email_id='';
		}
		echo     "<br>";
		 	 $contact=$data->sheets[0]["cells"][$x][3];
		 
		echo     "<br>";
		
		
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
			$new=$data->sheets[0]["cells"][$x][4];
		}
		else
		{
			$new='';
		}
		
	
	
			if(isset($data->sheets[0]["cells"][$x][5])){
		 $address=$data->sheets[0]["cells"][$x][5];
			}else{
				$address='';
			}
		
			$query=$this->upload_xls_model->upload4($name,$email_id,$contact,$new,$address);
	
	
	}
}
	public function upload()
	{
		$group_id=$this->input->post('group_name');
		$lead_source=$this->input->post('lead_source');
	if($this->input->post('campaign_name')=='')
	{
	if($this->input->post('lead_source')!='Carwale')
	{
	$query=$this->db->query("select group_name from tbl_group where group_id='$group_id'")->result();
	foreach ($query as $row) 
	{
		$campaign_name=$row->group_name;
	}
	}
	else
	{
		$campaign_name=$this->input->post('group_name');
	}
	}
	else
	{
	$campaign_name=$this->input->post('campaign_name');
	}



$date=date('Y-m-d:H:i:A');


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
				/*$first = $data->sheets[0]["cells"][$x][1];
				$last =$data->sheets[0]["cells"][$x][2];
				$this->addvlist_model->insert($villgeid,$first,$last);*/
			//	echo     "<br>";
			if(isset($data->sheets[0]["cells"][$x][1])){
		 	echo $name=$data->sheets[0]["cells"][$x][1];
			}else{
				$name='Unknown';
			}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][2]))
		{
		 	 $email_id=$data->sheets[0]["cells"][$x][2];
		}
		else{
			$email_id='';
		}
		echo     "<br>";
		 	 $contact=$data->sheets[0]["cells"][$x][3];
		 
		echo     "<br>";
		
		
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
			$new=$data->sheets[0]["cells"][$x][4];
		}
		else
		{
			$new='';
		}
		
	
	if ($new=='New')
	{
			if(isset($data->sheets[0]["cells"][$x][5])){
		 $address=$data->sheets[0]["cells"][$x][5];
			}else{
				$address='';
			}
			if(isset($data->sheets[0]["cells"][$x][6])){
		 $days=$data->sheets[0]["cells"][$x][6];
			}
			else{
				$days='';
			}
			
// 			$string1 = str_replace(' ', '', $contact);
//             echo $contact_no = str_replace('+', '', $string1);
//             $result = mb_substr($contact_no, 0, 2);
            
// if ($result == '91') {
// 	echo $str2 = substr($contact_no, 2);
// } else {
// 	$str2 = $contact_no;
// }

	$str2 = $contact;

			$query=$this->upload_xls_model->upload1($name,$email_id,$str2,$campaign_name,$address,$days);
	
	}
			
	else
		{
				
			
			/*echo $location=$data->sheets[0]["cells"][$x][4];
			echo     "<br>";
			 $lead_date1=$data->sheets[0]["cells"][$x][5];
			 //convert value in date format
			 $phpexcepDate = $lead_date1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		echo $lead_date = date('Y-m-d', $date);
			echo     "<br>";
			echo $assign_to_telecaller=$data->sheets[0]["cells"][$x][6];
			echo     "<br>";
			echo $status=$data->sheets[0]["cells"][$x][7];
			echo     "<br>";
			echo $disposition=$data->sheets[0]["cells"][$x][8];
			echo     "<br>";
			echo $new_model=$data->sheets[0]["cells"][$x][9];
			echo     "<br>";
			echo $new_variant=$data->sheets[0]["cells"][$x][10];
			echo     "<br>";
			echo $buyer_type=$data->sheets[0]["cells"][$x][11];
			echo     "<br>";
			echo $old_make=$data->sheets[0]["cells"][$x][12];
			echo     "<br>";
			echo $old_model=$data->sheets[0]["cells"][$x][13];
			echo     "<br>";
			echo $mfg_yr=$data->sheets[0]["cells"][$x][14];
			echo     "<br>";
			echo $kms=$data->sheets[0]["cells"][$x][15];
			echo     "<br>";
			echo $color=$data->sheets[0]["cells"][$x][16];
			echo     "<br>";
			echo $ownership=$data->sheets[0]["cells"][$x][17];
			echo     "<br>";
			echo $egerness=$data->sheets[0]["cells"][$x][18];
			echo     "<br>";
			 $created_date_followup1=$data->sheets[0]["cells"][$x][19];
			$phpexcepDate = $created_date_followup1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		echo $created_date_followup = date('Y-m-d', $date);
			echo     "<br>";
			 $nfd1=$data->sheets[0]["cells"][$x][20];
			$phpexcepDate = $nfd1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		echo $nfd = date('Y-m-d', $date);
			echo     "<br>";
			echo $remark=$data->sheets[0]["cells"][$x][21];
			
		$query=$this->upload_xls_model->upload2($name,$email_id,$contact,$location,$lead_date,$assign_to_telecaller,$status,$disposition,$new_model,$new_variant,$buyer_type,$old_make,$old_model,$mfg_yr,$kms,$color,$ownership,$egerness,$created_date_followup,$nfd,$remark,$group_id,$campaign_name);
		*/
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
		 $address=$data->sheets[0]["cells"][$x][4];
		}
		else
		{
			$address='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			 $lead_date1=$data->sheets[0]["cells"][$x][5];
			 //convert value in date format
			 $phpexcepDate = $lead_date1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		 $lead_date = date('Y-m-d', $date);
		}
		else
		{
				$lead_date='0000-00-00';
		}
			
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			 $cse_name=$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			$cse_name='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			 $cse_date1=$data->sheets[0]["cells"][$x][7];
			 //convert value in date format
			 $phpexcepDate = $cse_date1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		 $cse_date = date('Y-m-d', $date);
		}
		else
		{
			$cse_date='0000-00-00';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			 $disposition=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$disposition='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][9]))
		{
			 $cse_remark=$data->sheets[0]["cells"][$x][9];
		}
		else
		{
			$cse_remark='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			 $cse_nfd1=$data->sheets[0]["cells"][$x][10];
			//convert value in date format
			 $phpexcepDate = $cse_nfd1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		 $cse_nfd = date('Y-m-d', $date);
		}
		else
		{
			$cse_nfd='0000-00-00';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][11]))
		{
			 $tdhv_date1=$data->sheets[0]["cells"][$x][11];
			//convert value in date format
			 $phpexcepDate = $tdhv_date1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		 $tdhv_date = date('Y-m-d', $date);
		}
		else
		{
			$tdhv_date='0000-00-00';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][12]))
		{
			 $booking_within_days=$data->sheets[0]["cells"][$x][12];
		}
		else
		{
			$booking_within_days='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][13]))
		{
			 $dse_name=$data->sheets[0]["cells"][$x][13];
		}
		else
		{
			$dse_name='';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][14]))
		{
			$dse_call_date1=$data->sheets[0]["cells"][$x][14];
			$phpexcepDate = $dse_call_date1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		  $dse_call_date = date('Y-m-d', $date);
		}
		else
		{
		echo 	$dse_call_date='0000-00-00';
		}
			echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][15]))
		{
			 $dse_disposition = $data->sheets[0]["cells"][$x][15];
		}
		else
		{
			$dse_disposition='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][16]))
		{
			 $dse_remark= $data->sheets[0]["cells"][$x][16];
		}
		else
		{
			$dse_remark='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][17]))
		{
			$dse_nfd1=$data->sheets[0]["cells"][$x][17];
			$phpexcepDate = $dse_nfd1-25569; //to offset to Unix epoch
     		$date=strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	 		 $dse_nfd = date('Y-m-d', $date);
		}
		else
		{
			$dse_nfd='0000-00-00';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][18]))
		{
			 $buyer_type = $data->sheets[0]["cells"][$x][18];
		}
		else
		{
			$buyer_type='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][19]))
		{
			 $model=$data->sheets[0]["cells"][$x][19];
		}
		else
		{
			$model='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][20]))
		{
			  $variant= $data->sheets[0]["cells"][$x][20];
			
		}
		else
		{
					$variant='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][21]))
		{
			 $old_make= $data->sheets[0]["cells"][$x][21];
		}
		else
		{
			$old_make='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][22]))
		{
			 $old_model= $data->sheets[0]["cells"][$x][22];
		}
		else
		{
			$old_model='';
		}
		echo     "<br>";
		if(isset($data->sheets[0]["cells"][$x][23]))
		{
			 $mfg=$data->sheets[0]["cells"][$x][23];
		}
		else
		{
			$mfg='';
		}
	
		//$query=$this->upload_xls_model->upload3($name,$email_id,$contact,$address,$lead_date,$cse_name,$cse_date,$disposition,$cse_remark,$cse_nfd,$tdhv_date,$booking_within_days,$dse_call_date,$dse_name,$dse_disposition,$dse_remark,$dse_nfd,$buyer_type,$model,$variant,$old_make,$old_model,$mfg,$lead_source,$campaign_name);
		
		
		
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			}
			
			
	redirect('upload_xls');
		
		
		
	}
	
	
	public function select_campaign()
	
	{
			$group_id=$this->input->post('lead_source');
			//echo $group_id;
			
				$query3=$this->upload_xls_model->refresh_campaign($group_id);
					

			?>
			
			<select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name" name="campaign_name" >
			<option value=""> Please Select </option>
			
			<?php
			
			foreach($query3 as $fetch)
			{
			
			?>
			
			<option value="<?php echo $fetch -> sub_lead_source_name; ?>"><?php echo $fetch -> sub_lead_source_name; ?></option>
			
			<?php
			}
			?>
</select>

<?php
}
	public function upload_poc() 
	{
		$this->session();
		$query1=$this->upload_xls_model->select_grp();
		$data['select_grp']=$query1;	
		
		$query=$this->upload_xls_model->select_lead_source();
		$data['select_lead_source']=$query;
			
	//	print_r($query1);
	
		$query2=$this->upload_xls_model->select_campaign();
		$data['select_campaign']=$query2;
		//print_r($query2);
				
		$data['var']=site_url('upload_xls/upload_poc_data');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_xls_poc_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	
public function upload_poc_data()
	{
		$group_id=$this->input->post('group_name');
		$lead_source=$this->input->post('lead_source');
		$campaign_name= $this->input->post('campaign_name');
	if($this->input->post('campaign_name')=='')
	{
		
	if($this->input->post('lead_source')!='Carwale')
	{
		
	$query=$this->db->query("select group_name from tbl_group where group_id='$group_id'")->result();
	foreach ($query as $row) 
	{
		$campaign_name=$row->group_name;
	}
	}
	else
	{
	
		$campaign_name=$this->input->post('group_name');
	}
	}
	else
	{
		
	$campaign_name=$this->input->post('campaign_name');
	}



$date=date('Y-m-d:H:i:A');


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



			
			$error=array();
			$name=array();
			$contact=array();
			$email_id=array();
			$make=array();
			$model=array();
			$fuel_type=array();
			$year=array();
			$budget=array();
			$location=array();
			for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
				
		if(isset($data->sheets[0]["cells"][$x][2]))
		{
			
		
			if(ctype_alpha (str_replace(' ', '',$data->sheets[0]["cells"][$x][2])) ){
				
					array_push($name,$data->sheets[0]["cells"][$x][2]);
				
			}else{
				
			
					array_push($error,'B'.$x);
			 
			}
		
		}
		else{
			
			array_push($name,$data->sheets[0]["cells"][$x][2]);
		}
		if(isset($data->sheets[0]["cells"][$x][3]))
		{
			if(preg_match('/^\d{10}$/',$data->sheets[0]["cells"][$x][3])){
				array_push($contact,$data->sheets[0]["cells"][$x][3]);
			}else{
					array_push($error,'C'.$x);
				
				
			}
		 	  
		}
		else{
			 array_push($contact,$data->sheets[0]["cells"][$x][3]);
		}
		
		
		
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
			
			 array_push($email_id,$data->sheets[0]["cells"][$x][4]);
		}
		else
		{
			array_push($email_id,$data->sheets[0]["cells"][$x][4]);
		}
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
		
			if(ctype_alpha (str_replace(' ', '',$data->sheets[0]["cells"][$x][5])) ){
				array_push($make,$data->sheets[0]["cells"][$x][5]);
					
			}else{
				array_push($error,'E'.$x);
				
			
			}
		}
		else
		{
			array_push($make,$data->sheets[0]["cells"][$x][5]);
		}
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			
			array_push($model,$data->sheets[0]["cells"][$x][6]);
			
			
		}
		else
		{
		
			array_push($model,$data->sheets[0]["cells"][$x][6]);
		}
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			
			if(ctype_alpha (str_replace(' ', '',$data->sheets[0]["cells"][$x][7])) ){
					
				array_push($fuel_type,$data->sheets[0]["cells"][$x][7]);
			}else{
			
			
				array_push($error,'G'.$x);
			}
		}
		else
		{
				array_push($fuel_type,$data->sheets[0]["cells"][$x][7]);
		}
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			if(ctype_digit($data->sheets[0]["cells"][$x][8]) ){
				array_push($year,$data->sheets[0]["cells"][$x][8]);
				}else{
					array_push($error,'H'.$x);
				}
		
		}
		else
		{
			array_push($year,$data->sheets[0]["cells"][$x][8]);
		}
			if(isset($data->sheets[0]["cells"][$x][9]))
		{
			if(ctype_digit($data->sheets[0]["cells"][$x][9]) ){
				array_push($budget,$data->sheets[0]["cells"][$x][9]);
			}else{
			array_push($error,'I'.$x);
				
			}
			
	
			
		}
		else
		{
			array_push($budget,$data->sheets[0]["cells"][$x][9]);
		}
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			if(ctype_alpha (str_replace(' ', '',$data->sheets[0]["cells"][$x][10])) ){
				array_push($location,$data->sheets[0]["cells"][$x][10]);
			}else{
			$error[]='J'.$x;
			
			}
		}
		else
		{
			array_push($location,$data->sheets[0]["cells"][$x][10]);
		}
	}
	
	if(count($error)>0){
		//for($r=0;$r<count($error);$r++){
			 $this -> session -> set_flashdata('msg_error', $error);
			// echo "<br>";
		 redirect('upload_xls/upload_poc');
	//	}
	}
	$query=$this->upload_xls_model->upload_poc($name,$contact,$email_id,$make,$model,$fuel_type,$year,$budget,$location,$campaign_name,$lead_source);
	
	
	
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_xls/upload_poc');
		
		
		
	}
		public function upload_poc1() 
	{
		$this->session();
		$query1=$this->upload_xls_model->select_grp();
		$data['select_grp']=$query1;	
		
		$query=$this->upload_xls_model->select_lead_source();
		$data['select_lead_source']=$query;
			
	//	print_r($query1);
	
		$query2=$this->upload_xls_model->select_campaign();
		$data['select_campaign']=$query2;
		//print_r($query2);
				
		$data['var']=site_url('upload_xls/upload_poc_data1');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_xls_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	
public function upload_poc_data1()
	{
		$group_id=$this->input->post('group_name');
		$lead_source=$this->input->post('lead_source');
	if($this->input->post('campaign_name')=='')
	{
	if($this->input->post('lead_source')!='Carwale')
	{
	$query=$this->db->query("select group_name from tbl_group where group_id='$group_id'")->result();
	foreach ($query as $row) 
	{
		$campaign_name=$row->group_name;
	}
	}
	else
	{
		$campaign_name=$this->input->post('group_name');
	}
	}
	else
	{
	$campaign_name=$this->input->post('campaign_name');
	}



$date=date('Y-m-d:H:i:A');


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
		 	  $name=$data->sheets[0]["cells"][$x][2];
		}
		else{
			$name='';
		}
		if(isset($data->sheets[0]["cells"][$x][3]))
		{
		 	  $contact=$data->sheets[0]["cells"][$x][3];
		}
		else{
			$contact='';
		}
		
		echo     "<br>";
		
		
		if(isset($data->sheets[0]["cells"][$x][4]))
		{
			$email_id=$data->sheets[0]["cells"][$x][4];
		}
		else
		{
			$email_id='';
		}
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			$make=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$make='';
		}
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$model=$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			$model='';
		}
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$fuel_type=$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$fuel_type='';
		}
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			$year=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$year='';
		}
			if(isset($data->sheets[0]["cells"][$x][9]))
		{
			$budget=$data->sheets[0]["cells"][$x][9];
		}
		else
		{
			$budget='';
		}
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			$location=$data->sheets[0]["cells"][$x][10];
		}
		else
		{
			$location='';
		}
	}
	//	$query=$this->upload_xls_model->upload_poc($name,$contact,$email_id,$make,$model,$fuel_type,$year,$budget,$location,$campaign_name,$lead_source);
	
			
	
		
	/*if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_xls/upload_poc1');*/
		
		
		
	}
	
	
	
	public function upload_loankaro()
	{
		$this->session();
		$query1 = $this->upload_xls_model->select_grp();
		$data['select_grp'] = $query1;

		$query = $this->upload_xls_model->select_lead_source();
		$data['select_lead_source'] = $query;

		//	print_r($query1);

		$query2 = $this->upload_xls_model->select_campaign();
		$data['select_campaign'] = $query2;
		//print_r($query2);

		$data['var'] = site_url('upload_xls/upload_loankaro_data');
		$this->load->view('include/admin_header.php');
		$this->load->view('upload_xls_loankaro_view.php', $data);
		$this->load->view('include/footer.php');
	}


	public function upload_loankaro_data() {
        $group_id = $this->input->post('group_name');
        $lead_source = $this->input->post('lead_source');

        if ($this->input->post('campaign_name') == '') {
            if ($this->input->post('lead_source') != 'Carwale') {
                $query = $this->db->query("SELECT group_name FROM tbl_group WHERE group_id='$group_id'")->result();
                foreach ($query as $row) {
                    $campaign_name = $row->group_name;
                }
            } else {
                $campaign_name = $this->input->post('group_name');
            }
        } else {
            $campaign_name = $this->input->post('campaign_name');
        }

        $date = date('Y-m-d:H:i:A');

        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
            return;
        }

        $upload_path = 'upload/' . $date . '_' . $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path);
        
			require_once 'Excel/reader.php';

        // Load the Excel file
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($upload_path);

        // Start processing the data from the second row
        for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
            $name = isset($data->sheets[0]["cells"][$x][1]) ? $data->sheets[0]["cells"][$x][1] : 'Unknown';
            $email_id = isset($data->sheets[0]["cells"][$x][2]) ? $data->sheets[0]["cells"][$x][2] : '';
            $mobile_number = isset($data->sheets[0]["cells"][$x][3]) ? $data->sheets[0]["cells"][$x][3] : '';

            $lead_data = [
                'name' => $name,
                'email' => $email_id,
                'contact_no' => $mobile_number
            ];
            
            var_dump($lead_data);die;

            // Insert into database
            $this->upload_xls_model->insert_loanakaro($lead_data);
        }

        echo "Data successfully inserted.";
    }
	
	
	public function upload_excell()
	{
		$this->load->view('include/admin_header.php');
		$this->load->view('loankaro_excell');
		$this->load->view('include/footer.php');
	}


	public function excell_leads()
	{
		if (!isset($_FILES["file"])) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">No file was uploaded.</div>');
			redirect('upload_xls/upload_excell');
			return;
		}
	
		if ($_FILES["file"]["error"] > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Error uploading file: ' . $_FILES["file"]["error"] . '</div>');
			redirect('upload_xls/upload_excell');
			return;
		}
	
		$date = date('Y-m-d_H-i-s');
		$uploadPath = './finance_uploads/';
		$targetFile = $uploadPath . $date . '_' . $_FILES["file"]["name"];
	
		if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Failed to move uploaded file.</div>');
			redirect('upload_xls/upload_excell');
			return;
		}
		require_once 'Excel/reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($targetFile);
		$uniqueNumbers = [];
		for ($x = 2; $x <= $data->sheets[0]["numRows"]; $x++) {
			$row = array(
				'lead_source' => $data->sheets[0]["cells"][$x][1],
				'name' => $data->sheets[0]["cells"][$x][2], 
				'contact_no' => $data->sheets[0]["cells"][$x][3], 
			);
			$mobileNumber = trim($row['contact_no']);
			if (strlen($mobileNumber) > 10) {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Contact number cannot be more than 10 digits: ' . $mobileNumber . '</div>');
					redirect('upload_xls/upload_excell');
					return;
			}
			if (strlen($mobileNumber) < 10) {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Contact number must be at least 10 digits long: ' . $mobileNumber . '</div>');
					redirect('upload_xls/upload_excell');
					return;
				}
			if (in_array($mobileNumber, $uniqueNumbers)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Duplicate phone number detected: ' . $mobileNumber . '</div>');
				redirect('upload_xls/upload_excell');
				return;
			}
			$uniqueNumbers[] = $mobileNumber;
			$lead_source = $row['lead_source'];
			$los_number = ''; 
			$loan_amount = ''; 
			$result = $this->upload_xls_model->upload_leads($row['name'], $lead_source, $row['contact_no'], $los_number, $loan_amount);
	
			if ($result == 'inserted') {
				$successCount++;
			} elseif ($result == 'exists') {
				$existsCount++;
			}
		}
	
		if ($successCount > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">File uploaded successfully. Inserted ' . $successCount . ' new leads.</div>');
		}
	
		if ($existsCount > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-warning text-center">' . $existsCount . ' leads already exist and were not inserted.</div>');
		}
	
		redirect('upload_xls/upload_excell');
	}
	
	
	
	
	
	
	
	
	
	
}
?>
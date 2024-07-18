<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_exshowroom extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
	     $this->load->model('upload_exshowroom_model');
	   	date_default_timezone_set('Asia/Kolkata');     
		
	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		error_reporting(0);
		$this->session();	
		$data['var']=site_url('upload_exshowroom/upload');
		$data['backup_date']=$this -> upload_exshowroom_model -> last_backup_date();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_exshowroom_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function upload()
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
			$exshowroom_mumbai=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$exshowroom_mumbai='';
		}
		if (is_numeric($exshowroom_mumbai)) {  } else { $exshowroom_mumbai=''; }
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$exshowroom_pune =$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			 	$exshowroom_pune ='';
		}if (is_numeric($exshowroom_pune)) { } else { $exshowroom_pune=''; }
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$exshowroom_new_mumbai=$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$exshowroom_new_mumbai='';
		}if (is_numeric($exshowroom_new_mumbai)) {  } else { $exshowroom_new_mumbai=''; }
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			$exshowroom_thane=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$exshowroom_thane='';
		}if (is_numeric($exshowroom_thane)) {  } else { $exshowroom_thane=''; }
		$query=$this->upload_exshowroom_model->upload_exshowroom($location,$model_code,$type,$exshowroom_mumbai,$exshowroom_pune,$exshowroom_new_mumbai,$exshowroom_thane);
	
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}		
			
			
//	redirect('upload_exshowroom');
		
		
	}
}
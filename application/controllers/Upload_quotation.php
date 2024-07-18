<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_quotation extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
	   $this->load->model('upload_quotation_model');
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
		$data['var']=site_url('upload_quotation/upload');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('upload_quotation_view.php',$data);
		$this->load->view('include/footer.php');
	
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
				echo $model_id=$data->sheets[0]["cells"][$x][2];
				}else{
					$model_id='';
				}
				echo     "<br>";
				if(isset($data->sheets[0]["cells"][$x][3]))
				{
					$model=$data->sheets[0]["cells"][$x][3];
				}
				else{
					$model='';
					}
					echo     "<br>";
					if(isset($data->sheets[0]["cells"][$x][4]))
				{
					$variant=$data->sheets[0]["cells"][$x][4];
				}else{
					$variant='';
				}
					echo     "<br>";
		
		
		if(isset($data->sheets[0]["cells"][$x][5]))
		{
			$ex_showroom=$data->sheets[0]["cells"][$x][5];
		}
		else
		{
			$ex_showroom='';
		}
		if(isset($data->sheets[0]["cells"][$x][6]))
		{
			$registration=$data->sheets[0]["cells"][$x][6];
		}
		else
		{
			$registration='';
		}
		if(isset($data->sheets[0]["cells"][$x][7]))
		{
			$insurance=$data->sheets[0]["cells"][$x][7];
		}
		else
		{
			$insurance='';
		}
		if(isset($data->sheets[0]["cells"][$x][8]))
		{
			$nexa_card=$data->sheets[0]["cells"][$x][8];
		}
		else
		{
			$nexa_card='';
		}
		if(isset($data->sheets[0]["cells"][$x][9]))
		{
			$warranty=$data->sheets[0]["cells"][$x][9];
		}
		else
		{
			$warranty='';
		}
		if(isset($data->sheets[0]["cells"][$x][10]))
		{
			$on_road_price=$data->sheets[0]["cells"][$x][10];
		}
		else
		{
			$on_road_price='';
		}
	
	
		$query=$this->upload_quotation_model->upload($upload_id,$location,$model_id,$model,$variant,$ex_showroom,$registration,$insurance,$nexa_card,$warranty,$on_road_price,$date);
		
		
		
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
			
			
			
			
			
	redirect('upload_quotation');
		
		
		
	}
	public function upload_corporate() 
	{
		$this->session();	
		$data['var']=site_url('upload_quotation/upload_corporate1');
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
			
			$query=$this->upload_quotation_model->upload_corporate($corporate_name,$date);
		
		
		
}
		
	if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');

		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
			
		}
		redirect('upload_quotation/upload_corporate');
	}

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_brochure extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('upload_brochure_model');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {

		$this -> session();
		$query1 = $this -> upload_brochure_model -> select_model();
		$data['model'] = $query1;
		$data['var'] = site_url('add_campaign/add');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('upload_brochure_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function edit($model_id) {

		$this -> session();
		$query1 = $this -> upload_brochure_model -> edit($model_id);
		$data['model'] = $query1;
		$data['var'] = site_url('upload_brochure/update');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('upload_brochure_edit_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
public function update()
{
	$model_id=$this->input->post('model');
	$date=date('Y-m-d');
   if($_FILES["file"]["error"] > 0) 
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				
			}
	move_uploaded_file($_FILES["file"]["tmp_name"],'upload/'.$date.'_'.$_FILES["file"]["name"]);
	$file=$date.'_'.$_FILES["file"]["name"];
	echo $file;
	$this -> upload_brochure_model -> update($model_id,$file);
	redirect('upload_brochure');
}

	

}
?>
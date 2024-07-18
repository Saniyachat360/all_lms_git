<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accessories_package extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table','form_validation','session'));
		$this->load->helper(array('form','url'));
				
		$this->load->model('add_accessories_model');
		
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "")
		{
			redirect('login/logout');
		}
	}
	public function index()
	{
	
		$this->session();
	
		$data['select_package']=$this->add_accessories_model->select_package();
		$data['select_model']=$this->add_accessories_model->select_model();

		$data['var']=site_url('accessories_package/add');
	
		$this->load->view('include/admin_header.php');
		$this->load->view('add_accessories_package_view.php',$data);
		$this->load->view('include/footer.php');
	} 	
	public function items()
	{
		$this->session();
			
		$data['select_package_item']=$this->add_accessories_model->select_package_item();
		$data['select_package']=$this->add_accessories_model->select_package();
	
		$data['var']=site_url('accessories_package/upload_items');
	
		$this->load->view('include/admin_header.php');
		$this->load->view('add_accessories_package_item_view.php',$data);
		$this->load->view('include/footer.php');
	
	} 	
	public function add()
	{
		$query=$this->add_accessories_model->insert_package();
		if (!$query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Package Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Package Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		}
		redirect('accessories_package');
	}
	public function delete_package($id)
	{
		$q=$this->add_accessories_model->delete_package($id);
		redirect('accessories_package');
	}
	public function delete_package_item($id)
	{
		$q=$this->add_accessories_model->delete_package_item($id);
		redirect('accessories_package/items');
	}
	public function upload_items()
	{
		$date=date('Y-m-d');
		$accessories_package_id=$this->input->post('package_id');
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
				echo $accessories_name=$data->sheets[0]["cells"][$x][2];
			}else{
					$accessories_name='';
			}
			echo     "<br>";
			if(isset($data->sheets[0]["cells"][$x][3]))
			{
				$price=$data->sheets[0]["cells"][$x][3];
			}else{
				$price='';
			}
			echo     "<br>";
			$query=$this->add_accessories_model->upload($accessories_package_id,$accessories_name,$price,$date);
		}
		if(!$query)
		{
			 $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Upload successfully ...!</strong>');
		}else{
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> File Can not Upload successfully ...!</strong>');
		}
		redirect('accessories_package/items');
	}
	public function get_accessories_item(){
	$select_package_item=$this->add_accessories_model->select_package_item();?>
	
	<div class="col-md-12" >
		<div class="table-responsive">
			<table id="example"  class="table " style="width:100%;" cellspacing="0"> 
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>Model Name</th>
						<th>Variant Name</th>
						<th>Accessories Name</th>
						<th>Price</th>
						<th>Action</th>
					</tr>	
				</thead>
				<tbody>
				<?php 
					 $i=0;
					foreach($select_package_item as $fetch) 
					{
						$i++;
				?>
				<tr>
					<td>	<?php echo $i; ?> 		</td>
					<td>	<?php echo $fetch -> model_name; ?></td>
					<td>	<?php echo $fetch -> variant_name; ?></td>
					<td>	<?php echo $fetch -> accessories_name; ?></td>
					<td>	<?php echo $fetch -> price; ?></td>
					<td><a href="<?php echo site_url(); ?>accessories_package/delete_package_item/<?php echo $fetch -> package_item_id; ?>" onclick="return getConfirmation();"> Delete </a></a></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php 
	}
	
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_accessories_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function select_package() {
		$this -> db -> select('a.*,m.model_name');
		$this -> db -> from('tbl_accessories_package_lms a');
		$this -> db -> join('make_models m', 'm.model_id=a.model_id');
		$this -> db -> where('a.status!=','-1');
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
	public function select_package_item(){
		$accessories_package_id=$this->input->post('accessories_package_id');
		$this -> db -> select('a.*,m.model_name,v.variant_name');
		$this -> db -> from('tbl_accessories_package_item_lms a');
		$this -> db -> join('make_models m', 'm.model_id=a.model_id');
		$this -> db -> join('model_variant v', 'v.variant_id=a.variant_id');
		$this -> db -> where('a.status!=','-1');
		if($accessories_package_id!=''){
		$this -> db -> where('a.accessories_package_id',$accessories_package_id);
		}
		$query1 = $this -> db -> get();
		return $query1 -> result();
	}
	public function select_model(){
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', 1);
		$this -> db -> where('status!=','-1');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function insert_package() {
		$date=date('Y-m-d');
		$query=$this->db->query("select max(upload_id) as upload_id from tbl_accessories_package_lms")->result();
		if(isset($query[0]->upload_id)){
		
			$upload_id=$query[0]->upload_id+1;
		}else{
			$upload_id=1;
		}
		$model_id=$this->input->post('model_id');
		$package_name=$this->input->post('package_name');
		$package_price=$this->input->post('package_price');
		$benefit=$this->input->post('benefit');
		$package_total_price=$this->input->post('package_total_price');
		$this->db->query("INSERT INTO `tbl_accessories_package_lms`( `model_id`, `package_name`, `package_price`, `benefit`, `package_total_price`, `created_date`, `upload_id`) 
		VALUES ('$model_id','$package_name','$package_price','$benefit','$package_total_price','$date','$upload_id')");

	}
	public function delete_package($id) {
		$this -> db -> query("update tbl_accessories_package_lms set status='-1' where accessories_package_id='$id'");
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Accesseries Package Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Accesseries Package Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}
public function delete_package_item($id) {
		$this -> db -> query("update tbl_accessories_package_item_lms set status='-1' where package_item_id='$id'");
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Accesseries Package Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Accesseries Package Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	
	public function upload($accessories_package_id,$accessories_name,$price,$date){
		$get_model_id=$this->db->query("select model_id from  tbl_accessories_package_lms where accessories_package_id='$accessories_package_id' ")->result();
		if(isset($get_model_id[0]->model_id)){
		$model_id=$get_model_id[0]->model_id;
		}else{
			$model_id='';
		}
		$query=$this->db->query("INSERT INTO `tbl_accessories_package_item_lms`( `model_id`,`accessories_name`, `price`, `accessories_package_id`, `date`) 
		VALUES ('$model_id','$accessories_name','$price','$accessories_package_id','$date')");
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Accesseries Package Items Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Accesseries Package Not Items Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}
	
}

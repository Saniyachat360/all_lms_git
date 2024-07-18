<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class upload_brochure_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function select_model() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id',1);
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
	public function edit($model_id) {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('model_id',$model_id);
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
	public function update($model_id,$file)
	{
		$this->db->query("update make_models set brochure='$file' where model_id='$model_id'");
		if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
		}
	
}
?>
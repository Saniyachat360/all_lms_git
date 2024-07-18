<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_process_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_process($process_name) {

		$q = $this -> db -> query('select * from tbl_process where process_name="' . $process_name . '"') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Process Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$query = $this -> db -> query("insert into tbl_process (`process_name`,process_status)values('$process_name','1')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Process Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_process() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_process');
		//$this -> db -> where('location_status !=','Deactive');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_process($id) {
		$this -> db -> select('process_id,process_name');
		$this -> db -> from('tbl_process');
		$this -> db -> where('process_id', $id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_new_process($id, $process_name) {

		$q = $this -> db -> query('select * from tbl_process where process_name="' . $process_name . '"') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Process Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_process set process_id="' . $id . '", process_name="' . $process_name . '"  where process_id="' . $id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Process Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Process Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	/*public function delete_process($id) {

		$this -> db -> query('update tbl_process set process_status="-1" where process_id="'.$id.'"');
		
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Process Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Process Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}*/

}

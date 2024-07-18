<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Holiday_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			$this->date = date("Y-m-d");
	}

	public function insert_data() {
       $occassion_name=$this->input->post('occassion_name');
        $occassion_date=$this->input->post('occassion_date');
         $description=$this->input->post('description');
		$q = $this -> db -> query('select * from tbl_holiday where  date="'. $occassion_date .'" ') -> result();
		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_holiday where date='$occassion_date'  AND  status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_holiday set status='1' ,name='$occassion_name',description='$description' where date='$occassion_date' AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into tbl_holiday (`name`,`status`,date,description,created_date)values('$occassion_name','1','$occassion_date','$description','$this->date')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_data() {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_holiday l');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_data($id) {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_holiday l');
	//	$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.holiday_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function update_data($login_status_id) {
   $occassion_name=$this->input->post('occassion_name');
        $occassion_date=$this->input->post('occassion_date');
         $description=$this->input->post('description');
		$q = $this -> db -> query('select * from tbl_holiday where date="' . $occassion_date . '" and  holiday_id !="'.$login_status_id.'" ') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_holiday set name="' . $occassion_name . '",date="'.$occassion_date.'",description="'.$description.'"  where holiday_id="' . $login_status_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_data($id) {

		$this -> db -> query('update tbl_holiday set status="-1" where holiday_id="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
}

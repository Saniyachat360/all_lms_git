<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Feedback_status_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_feedback_status($fStatusName,$process_id) {

		$q = $this -> db -> query('select * from tbl_feedback_status where feedbackStatusName="' . $fStatusName . '" and process_id="'.$process_id.'" and fstatus="Active"') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Feedback Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$q1 = $this -> db -> query('select * from tbl_feedback_status where feedbackStatusName="' . $fStatusName . '" and process_id="'.$process_id.'" and fstatus="Deactive"') -> result();
		if (count($q1) > 0) {
					$query = $this -> db -> query('update tbl_feedback_status set fstatus="Active" where feedbackStatusName="' . $fStatusName . '" and process_id="'.$process_id.'" and fstatus="Deactive"');
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Feedback Status Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
		}else{
				$query = $this -> db -> query("insert into tbl_feedback_status (`feedbackStatusName`,`process_id`,`fstatus`)values('$fStatusName',$process_id,'Active')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Feedback Status Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			
		}
				}
	}

	public function select_feedback_status() {
		$this -> db -> select('f.feedbackStatusId,f.feedbackStatusName,p.process_name,fstatus');
		$this -> db -> from('tbl_feedback_status f');
		$this->db->join('tbl_process p','p.process_id=f.process_id','left');
	//	$this -> db -> where('fstatus!=','Deactive');
		$this -> db -> where('p.process_name',$_SESSION['process_name']);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_feedback_status($id) {
		$this -> db -> select('feedbackStatusId,feedbackStatusName,p.process_name,p.process_id');
		$this -> db -> from('tbl_feedback_status f');
		$this->db->join('tbl_process p','p.process_id=f.process_id','left');
		
		$this -> db -> where('feedbackStatusId',$id);
		$query = $this -> db -> get();
		return $query -> result();
		

	}

	public function edit_new_feedback_status($fstatus_id,$fstatus_name,$process_id) {

		$q = $this -> db -> query('select * from tbl_feedback_status where feedbackStatusName="' . $fstatus_name . '" and process_id="'.$process_id.'"and fstatus=" "') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Feedback Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_feedback_status set feedbackStatusName="' . $fstatus_name . '",process_id="'.$process_id.'"  where feedbackStatusId="' . $fstatus_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Feedback Status Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Feedback Status Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_feedback_status($id) {

		//$this -> db -> query("delete from tbl_feedback_status where feedbackStatusId='$id'");
		
		$this -> db -> query('update tbl_feedback_status set fstatus="Deactive"  where feedbackStatusId="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Feedback Status Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Feedback Status Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
public function select_process()
{
		$this -> db -> select('process_id,process_name');
		$this -> db -> from('tbl_process');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
	

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scripts_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_script($script,$loan_id) {

		$q = $this -> db -> query('select * from tbl_script where loan_id="' . $loan_id . '" and script_desc="'. $script .'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_script where script_desc='$script'  AND loan_id ='$loan_id' AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_script set status='1' where script_desc='$script'  AND loan_id ='$loan_id'  AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into tbl_script (`script_desc`,`loan_id`,`status`)values('$script','$loan_id','1')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_script() {
		$this -> db -> select('l.script_desc,l.script_id,p.loan_name,l.status');
		$this -> db -> from('tbl_script l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_script($id) {
		$this -> db -> select('l.script_desc,l.script_id,p.loan_name,l.status,p.loan_id');
		$this -> db -> from('tbl_script l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.script_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function show_script($loan_id) {
		$this -> db -> select('l.script_desc,l.script_id,p.loan_name,l.status,p.loan_id');
		$this -> db -> from('tbl_script l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.loan_id', $loan_id);
			$this -> db -> where('l.status', '1');
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function update_scripts($script_desc,$loan_id,$script_id) {

		$q = $this -> db -> query('select * from tbl_script where script_desc="' . $script_desc . '" and loan_id="'.$loan_id.'" 
		and  status="1"') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_script set script_desc="' . $script_desc . '",loan_id="'.$loan_id.'"  where script_id="' . $script_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_script($id) {

		$this -> db -> query('update tbl_script set status="-1" where script_id="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}


public function select_loan_type()
{
		$this -> db -> select('*');
		$this -> db -> from('tbl_loan');
		$this -> db -> where('loan_status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}

}

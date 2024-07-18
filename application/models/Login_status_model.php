<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_status_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			$this->date = date("Y-m-d");
	}

	public function insert_l_status($login_status) {
     //   $scheme_name=$this->input->post('l_status_name');
		$q = $this -> db -> query('select * from tbl_loginstatus where  login_status_name="'. $login_status .'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_loginstatus where login_status_name='$login_status'  AND  status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_loginstatus set status='1' where login_status_name='$login_status'    AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into tbl_loginstatus (`login_status_name`,`status`)values('$login_status','1')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_l_status() {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_loginstatus l');
		//$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_l_status($id) {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_loginstatus l');
	//	$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.login_status_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function show_scheme($loan_id) {
		$this -> db -> select('l.scheme_desc,l.scheme_id,p.loan_name,l.status,p.loan_id,l.scheme_name');
		$this -> db -> from('tbl_loginstatus l');
	//	$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.loan_id', $loan_id);
			$this -> db -> where('l.status', '1');
		$this->db->order_by('l.scheme_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function update_l_status($reason_name,$login_status_id) {
  $scheme_name=$this->input->post('scheme_name');
		$q = $this -> db -> query('select * from tbl_loginstatus where login_status_name="' . $reason_name . '" and  login_status_id !="'.$login_status_id.'" ') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_loginstatus set login_status_name="' . $reason_name . '"  where login_status_id="' . $login_status_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_l_status($id) {

		$this -> db -> query('update tbl_loginstatus set status="-1" where login_status_id="' . $id . '"');
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

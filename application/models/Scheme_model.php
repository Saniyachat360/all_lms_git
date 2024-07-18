<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scheme_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			$this->date = date("Y-m-d");
	}

	public function insert_scheme($scheme,$loan_id) {
        $scheme_name=$this->input->post('scheme_name');
		$q = $this -> db -> query('select * from tbl_scheme where loan_id="' . $loan_id . '" and scheme_name="'. $scheme_name .'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_scheme where scheme_name='$scheme_name'  AND loan_id ='$loan_id' AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_scheme set status='1' where scheme_name='$scheme_name'  AND loan_id ='$loan_id'  AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into tbl_scheme (`scheme_desc`,`loan_id`,`status`,scheme_name,updated_date)values('$scheme','$loan_id','1','$scheme_name','$this->date')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_scheme() {
		$this -> db -> select('l.scheme_desc,l.scheme_id,p.loan_name,l.status,l.*');
		$this -> db -> from('tbl_scheme l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_scheme($id) {
		$this -> db -> select('l.scheme_desc,l.scheme_id,p.loan_name,l.status,p.loan_id,l.*');
		$this -> db -> from('tbl_scheme l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.scheme_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function show_scheme($loan_id) {
		$this -> db -> select('l.scheme_desc,l.scheme_id,p.loan_name,l.status,p.loan_id,l.scheme_name');
		$this -> db -> from('tbl_scheme l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this -> db -> where('l.loan_id', $loan_id);
			$this -> db -> where('l.status', '1');
		$this->db->order_by('l.scheme_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function update_scheme($scheme_desc,$loan_id,$scheme_id) {
  $scheme_name=$this->input->post('scheme_name');
		$q = $this -> db -> query('select * from tbl_scheme where scheme_name="' . $scheme_name . '" and loan_id="'.$loan_id.'" 
		and  scheme_id !="'.$scheme_id.'" ') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_scheme set scheme_desc="' . $scheme_desc . '",
			scheme_name="' . $scheme_name . '",updated_date="' . $this->date . '",
			loan_id="'.$loan_id.'"  where scheme_id="' . $scheme_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_scheme($id) {

		$this -> db -> query('update tbl_scheme set status="-1" where scheme_id="' . $id . '"');
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

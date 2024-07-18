<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Document_model extends CI_Model {
	public function __construct() {
		parent::__construct();
			$this->date = date("Y-m-d");
	}

	public function insert_document($scheme) {
        $scheme_name=$this->input->post('document');
        $loan_id=$this->input->post('loan_id');
       echo   $mandatory=$this->input->post('mandatory');
       if($mandatory=='on')
       {
           $mandatory='Yes';
       }else{$mandatory='No';}
		$q = $this -> db -> query('select * from tbl_document where document_name="'. $scheme_name .'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_document where document_name='$scheme_name'  AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_document set status='1' where document_name='$scheme_name'   AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {
           
			$query = $this -> db -> query("insert into tbl_document (`document_name`,`status`,updated_date,mandatory)values('$scheme_name','1','$this->date','$mandatory')");
            $document_id=$this->db->insert_id();
            for($i=0;$i<count($loan_id);$i++)
           {
               $this->insert_map_document($document_id, $loan_id[$i]);
           }
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}
	public function insert_map_document($document_id, $loan_id) {
        
		$q = $this -> db -> query('select * from tbl_document_map where document_id="'. $document_id .'" and loan_id="'.$loan_id.'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select * from  tbl_document_map where document_id='$document_id'  and loan_id='$loan_id'  AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update tbl_document_map set status='1' where document_id='$document_id' and loan_id='$loan_id'  AND status='-1' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into tbl_document_map (`document_id`,`status`,updated_date,loan_id)values('$document_id','1','$this->date','$loan_id')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_document() {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_document l');
		//$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
		public function select_table_data() {
		    
		    $this -> db -> select('*');
		$this -> db -> from('tbl_document a');
		$query = $this -> db -> get()->result();
		if(count($query)>0)
		{
		    foreach($query as $row){
		    $document_id=$row->document_id;
		    	$this -> db -> select('a.*,p.loan_name');
		$this -> db -> from('tbl_document_map a');
			$this->db->join('tbl_loan p','p.loan_id=a.loan_id','left');
		$this -> db -> where('a.document_id',$document_id);
	//	$this->db->group_by('a.user_id');
		$query = $this -> db -> get()->result();
		//echo $this->db->last_query();
		//return $query -> result();
		$data[] = array('document_id'=>$document_id,'document_name'=>$row->document_name,'status'=>$row->status,'updated_date'=>$row->updated_date,'mandatory'=>$row->mandatory,'loans'=>$query);
		    }
		}
		else
		{
		    $data = array();
		}
	return	$data;

	}

	public function edit_document($id) {
		$this -> db -> select('l.*, a.loan_id');
		$this -> db -> from('tbl_document l');
			$this -> db -> join('tbl_document_map a','a.document_id=l.document_id','left');
			//$this->db->join('tbl_loan p','p.loan_id=a.loan_id','left');
		$this -> db -> where('l.document_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}


	public function update_document($document,$document_id,$loan_id) {
   echo   $mandatory=$this->input->post('mandatory');
       if($mandatory=='on')
       {
           $mandatory='Yes';
       }else{$mandatory='No';}
		$q = $this -> db -> query('select * from tbl_document where document_name="' . $document . '" and  document_id !="'.$document_id.'" ') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Already Exists ...!</strong>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_document set document_name="' . $document . '",
			mandatory="' . $mandatory . '",updated_date="' . $this->date . '" where document_id="' . $document_id . '"');
			$q=$this->db->query("DELETE FROM `tbl_document_map` WHERE document_id='$document_id'");
            for($i=0;$i<count($loan_id);$i++)
           {
               $this->insert_map_document($document_id, $loan_id[$i]);
           }
           
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_document($id) {

		$this -> db -> query('update tbl_document set status="-1" where document_id="' . $id . '"');
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
	public function document_list() {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_document l');
		//$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$this -> db -> where('status', '1');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
		public function map_list() {
		$this -> db -> select('l.*,p.loan_name,p1.document_name');
		$this -> db -> from('tbl_document_map l');
		$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		$this->db->join('tbl_document p1','p1.document_id=l.document_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
	//	$this -> db -> where('p.process_id',$_SESSION['process_id']);
	//	$this -> db -> where('status', '1');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}


}

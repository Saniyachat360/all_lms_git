<?php
class edit_customer_model extends CI_Model{
function __construct() {
parent::__construct();
$this->process_name=$this->session->userdata('process_name');
$this -> process_id = $_SESSION['process_id'];
$this -> user_id = $this -> session -> userdata('user_id');
if ($this -> process_id == 6 || $this -> process_id == 7 || $this -> process_id == 8) {
			$this -> table_name = 'lead_master';
		
		} else {
			$this -> table_name = 'lead_master_all';
			
		}
}



function fetch_data()
{
ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
	$this->db->select('l.enq_id,l.name,l.contact_no,l.email,l.address,');
	$this->db->from($this->table_name.' l');
	$w="(name='' or contact_no='' or email='')";
	$this->db->where('process',$this->process_name);
	$this->db->where($w);
	/*$this->db->or_where('name', '');
	$this->db->or_where('contact_no', '');
	$this->db->or_where('email', '');*/
	
	$this -> db -> limit($rec_limit, $offset);
	
	$query=$this->db->get();
	//echo $this -> db->last_query();
	return $query->result();
}


function count_data()
{

	$this->db->select('count(l.enq_id) as total_count');
	$this->db->from($this->table_name.' l');
	$w="(name='' or contact_no='' or email='')";
	$this->db->where('process',$this->process_name);
	$this->db->where($w);
	
	/*$this->db->or_where('name', '');
	$this->db->or_where('contact_no', '');
	$this->db->or_where('email', '');*/
	
	$query=$this->db->get();
	return $query->result();
}


public function edit_user($id) {
		$this -> db -> select('*');
		$this -> db -> from($this->table_name.' l');
		
		$this -> db -> where('enq_id', $id);
		$query = $this -> db -> get();
		// $this->db->last_query();
		return $query -> result();

	}
	
	
function update_user($id, $name, $contact, $email, $address) 
	{
		$today=date('Y-m-d');
		$query=$this -> db -> query('update '.$this->table_name.'  set name="' . $name . '",contact_no="' . $contact . '",email="' . $email . '",address="' . $address . '" ,last_edited_by="' . $this->user_id . '" ,last_edited_date="' . $today . '"  where enq_id="' . $id . '"');
		
		//redirect("edit_customer");
	}

function duplicate_user($id, $contact)
{
	$this -> db -> select('*');
		$this -> db -> from('lead_master');
		
		$this -> db -> where('contact_no', $contact);
		$query = $this -> db -> get() -> result();
		
			if(count($query) > 1)
			{
				//$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Repeated Record Not Exist ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				$query=$this -> db -> query('INSERT INTO lead_master_repeat SELECT * FROM lead_master where enq_id="' . $id . '"');
				$query=$this -> db -> query('DELETE FROM lead_master where enq_id="' . $id . '"');
			
			}
			else{
		$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>This is unique enquiry ,you cant remove this enquiry</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		//$query=$this -> db -> query('INSERT INTO lead_master_repeat SELECT * FROM lead_master where enq_id="' . $id . '"');
			}
	
}

public function select_lead_dse() {

		$customer_name = $this -> input -> post('customer_name');
		$this->db->select('l.enq_id,l.name,l.contact_no,l.email,l.address');
		$this -> db -> from($this->table_name.' l');
		

		if (is_numeric($customer_name)) {
			$this -> db -> where("contact_no LIKE '%$customer_name%'");
		} else {
			$this -> db -> where("name LIKE '%$customer_name%'");

		}
		if($_SESSION['process_id']==8){
			$this->db->where('evaluation','Yes');
		}
		else{
			$this->db->where('process',$this->process_name);
		}
	
	
		$this -> db -> limit(50);

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

}
?>
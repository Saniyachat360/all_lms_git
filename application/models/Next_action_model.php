<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Next_action_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_next_action_status($naction_name,$process_id) {

		$q = $this -> db -> query('select * from tbl_nextaction where nextActionName="' . $naction_name . '" and process_id="'.$process_id.'" and nextActionstatus="Active"') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
	$q1 = $this -> db -> query('select * from tbl_nextaction where nextActionName="' . $naction_name . '" and process_id="'.$process_id.'" and nextActionstatus="Deactive"') -> result();
if (count($q1) > 0) {
		$query = $this -> db -> query("update tbl_nextaction set nextActionstatus = 'Active' where nextActionName='$naction_name' and process_id='$process_id' and nextActionstatus='Deactive'");
	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
}else{
	$query = $this -> db -> query("insert into tbl_nextaction (`nextActionName`,`process_id`,`nextActionstatus`)values('$naction_name','$process_id','Active')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
}
		
		}
	}

	public function select_next_action_status() {
		$this -> db -> select('n.nextActionId,n.nextActionName,p.process_id,p.process_name,nextActionstatus');
		$this -> db -> from('tbl_nextaction n');
		$this -> db -> join('tbl_process p','p.process_id=n.process_id','left');
		//$this -> db -> where('nextActionstatus!=','Deactive');
		$this -> db -> where('p.process_name',$_SESSION['process_name']);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_next_action_status($id) {
		$this -> db -> select('n.nextActionId,n.nextActionName,p.process_id,p.process_name');
		$this -> db -> from('tbl_nextaction n');
			$this -> db -> join('tbl_process p','p.process_id=n.process_id','left');
		$this -> db -> where('nextActionId',$id);
		
		$query = $this -> db -> get();
		return $query -> result();
		

	}

	public function edit_new_next_action_status($naction_id,$naction_name,$process_id) {

		$q = $this -> db -> query('select * from tbl_nextaction where nextActionName="' . $naction_name . '" and process_id="'.$process_id.'" and nextActionstatus=" "') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_nextaction set nextActionName="' . $naction_name . '",process_id="'.$process_id.'"  where nextActionId="' . $naction_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Next Action Status Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_next_action_status($id) {

		//$this -> db -> query("delete from tbl_nextaction where nextActionId='$id'");
		$this -> db -> query('update tbl_nextaction set nextActionstatus="Deactive"  where nextActionId="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

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

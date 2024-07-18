<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Map_next_action_to_feedback_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_map_next_action_to_feedback_status() {
		
		$feedback=$this->input->post('feedback');
		$nextaction=$this->input->post('nextaction');
		$process_id=$this->input->post('process_id');

		$q = $this -> db -> query('select * from tbl_mapNextAction where nextActionName="' . $nextaction . '" and feedbackStatusName="' . $feedback . '" and process_id="'.$process_id.'" and map_next_to_feed_status="Active"') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Next Action Status Already Mapped ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
				$q1 = $this -> db -> query('select * from tbl_mapNextAction where nextActionName="' . $nextaction . '" and feedbackStatusName="' . $feedback . '" and process_id="'.$process_id.'" and map_next_to_feed_status="Deactive"') -> result();
	if (count($q1) > 0) {
				$query = $this -> db -> query("update tbl_mapNextAction set map_next_to_feed_status='Active' where nextActionName='$nextaction' and feedbackStatusName='$feedback' and process_id='$process_id' and map_next_to_feed_status='Deactive'");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Next Action Status Mapped Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
	}else{
				$query = $this -> db -> query("insert into tbl_mapNextAction (`feedbackStatusName`,`nextActionName`,`process_id`)values('$feedback','$nextaction','$process_id')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Next Action Status Mapped Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
	}
	
		}
	}

	public function select_next_action_status($process_id) {
		$this -> db -> select('nextActionId,nextActionName');
		$this -> db -> from('tbl_nextaction');
		$this -> db -> where('process_id',$process_id);
		$this -> db -> where('nextActionstatus!=','Deactive');
		//echo $this->db->last_query();
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_next_action_status($id) {
		$this -> db -> select('nextActionId,nextActionName');
		$this -> db -> from('tbl_nextaction');
		$this -> db -> where('nextActionId',$id);
		
		$query = $this -> db -> get();
		return $query -> result();
		

	}

	public function edit_new_next_action_status($naction_id,$naction_name) {

		$q = $this -> db -> query('select * from tbl_nextaction where (nextActionName="' . $naction_name . '" and nextActionstatus=" "') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_nextaction set nextActionName="' . $naction_name . '"  where nextActionId="' . $naction_id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Next Action Status Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_next_action_to_feedback_status($id) {

		//$this -> db -> query("delete from tbl_nextaction where nextActionId='$id'");
		$this -> db -> query('update tbl_mapNextAction set map_next_to_feed_status="Deactive"  where mapId="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Mapped Next Action Status Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Mapped Next Action Status Not Deleted ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
	
	public function select_feedback_status($process_id) {
		$this -> db -> select('feedbackStatusId,feedbackStatusName');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('process_id',$process_id);
		$this -> db -> where('fstatus!=','Deactive');
		$query = $this -> db -> get();
		return $query -> result();

	}
	
	public function map_nxta_to_feed($process_id) {
		$this -> db -> select('m.feedbackStatusName,m.nextActionName,m.process_id,m.mapId,p.process_name,map_next_to_feed_status');
		$this -> db -> from('tbl_mapNextAction m');
		$this -> db -> join('tbl_process p','p.process_id=m.process_id');
		//$this -> db -> where('map_next_to_feed_status!=','Deactive');
		$this -> db -> where('m.process_id',$process_id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	function searchlocation() {
		//we are join the table lmsuser and mapdse
		$locationName = $this -> input -> post('locationName');
		
		
		$this -> db -> select('*');
		$this -> db -> from('tbl_mapNextAction');
		
		
		if($locationName !='')
		{
			//$this -> db   ->where("CONCAT_WS(l.fname,l.lname) LIKE '%$locationName%'");
			$this -> db   ->where("feedbackStatusName LIKE '%$locationName%'");
			$this -> db   ->or_where("nextActionName LIKE '%$locationName%'");
			
		}
		//$this -> db -> limit($rec_limit, $offset);
		$this -> db -> where('map_next_to_feed_status!=','Deactive');
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}
	
public function select_process()
{
		$this -> db -> select('process_id,process_name');
		$this -> db -> from('tbl_process');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_campaign_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function select_campaign() {
		$this -> db -> select('c.campaign_id,c.campaign_name,c.group_id,g.group_name');
		$this -> db -> from('tbl_campaign c');
		$this -> db -> join('tbl_group g', 'g.group_id=c.group_id');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where('g.process_id', $_SESSION['process_id']);
		}
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}

	public function select_grp() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_group');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where('process_id', $_SESSION['process_id']);
		}
		$query2 = $this -> db -> get();
		return $query2 -> result();

	}

	public function add_campaign($campaign_name, $group_id) {
		$this -> db -> select("*");
		$this -> db -> from("tbl_campaign");
		$this -> db -> where("campaign_name", $campaign_name);
		$query1 = $this -> db -> get() -> result();

		if (count($query1) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Campaign Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$query = $this -> db -> query("insert into tbl_campaign (`campaign_name`,`group_id`)values('$campaign_name','$group_id')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Campaign Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}

	public function select_campaign_id($id) {
		$this -> db -> select('c.campaign_id,c.campaign_name,c.group_id,g.group_name');
		$this -> db -> from('tbl_campaign c');
		$this -> db -> join('tbl_group g', 'g.group_id=c.group_id');
		$this -> db -> where('campaign_id', $id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	function update_campaign($id, $campaign_name, $group_id) {

		//		$data = array('campaign_name' => $campaign_name, 'group_id' => $group_id);
		//	$this -> db -> where('campaign_id', $id);
		//$this -> db -> update('tbl_campaign', $data);

		$this -> db -> select("*");
		$this -> db -> from("tbl_campaign");
		$this -> db -> where("campaign_name", $campaign_name);
		$this -> db -> where("group_id", $group_id);
		$q = $this -> db -> get() -> result();

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Campaign Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update tbl_campaign set campaign_name="' . $campaign_name . '", group_id="' . $group_id . '"  where campaign_id="' . $id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Campaign Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Campaign Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}

	}

	function delete_campaign($id) {
	
		
		$this -> db -> query("delete from tbl_campaign where campaign_id='$id'");
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Campaign Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Campaign Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}

}

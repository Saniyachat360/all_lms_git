<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accessories_followup_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	public function select_lead($process_name) {
		$this -> db -> select('*');
		$this -> db -> from('lead_master');
		$this -> db -> where('process', $process_name);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reporting_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	public function leadmaster($from_date, $to_date, $user_id, $user_name) {
		$query = $this -> db -> query("call lead_date_tracker('$from_date','$to_date','$user_id','$user_name')");
		$res = $query -> result();
		//add this two line
		$query -> next_result();
		$query -> free_result();
		//end of new code

		return $res;

	}

	public function leadmasterlc($from_date, $to_date, $user_id, $user_name) {
		$query1 = $this -> db -> query("call lead_date_tracker_lc('$from_date','$to_date','$user_id','$user_name')");
		$res1 = $query1 -> result();
		return $res1;
	}

}
?>
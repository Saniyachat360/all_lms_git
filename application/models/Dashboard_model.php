<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_model extends CI_model
{
	function __construct()
	{
		parent::__construct();
	}

	public function select_campaign()
	{
		$this->db->select('DISTINCT (enquiry_for) as enquiry_for ');
		$this->db->from('lead_master');
		$this->db->where('lead_source', 'Facebook');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function select_campaign_cse()
	{
		$this->db->select('c.*,g.group_id ');
		$this->db->from('tbl_user_group g');
		$this->db->join('tbl_campaign c', 'c.group_id=g.group_id');
		$this->db->join('lead_master l', 'l.enquiry_for=c.campaign_name');
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->group_by('l.enquiry_for');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function checkUserCountRightsForEnq()
	{
		/*---check count as per group & user--*/
		if ($_SESSION['role'] != 1) {
			$user_id = $_SESSION['user_id'];

			$this->db->select('c.campaign_name');
			$this->db->from('tbl_user_group u');
			$this->db->join('tbl_campaign c', 'c.group_id=u.group_id');
			$this->db->where('u.user_id', $user_id);
			$query1 = $this->db->get()->result();

			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						if ($query1[$i]->campaign_name == 'New Car') {
							$t = $t . "enquiry_for != 'Used Car'";
						} else {
							$t = $t . "enquiry_for = '" . $query1[$i]->campaign_name . "'";
						}
					} else {
						$t = $t . " or enquiry_for ='" . $query1[$i]->campaign_name . "'";
					}
				}
				$t = $t . " or lead_source=''";
				$st = $t . ')';
			}
			return $st;
		}
	}

	function checkUserCountRights()
	{
		if ($_SESSION['role'] != 1) {
			$process_id = $_SESSION['process_id'];
			$user_id = $_SESSION['user_id'];

			$this->db->select('g.group_id');
			$this->db->from('tbl_group g');
			$this->db->join('tbl_user_group u', 'u.group_id=g.group_id');
			$this->db->where('u.user_id', $user_id);
			$query1 = $this->db->get()->result();
			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {

						$t = $t . "group_id = '" . $query1[$i]->group_id . "'";
					} else {
						$t = $t . " or group_id ='" . $query1[$i]->group_id . "'";
					}
				}
				$st = $t . ')';
			}
			return $st;
		}
	}

	public function select_cse($st)
	{
		$this->db->select('id,fname,lname');
		$this->db->from('lmsuser l');
		$this->db->join('tbl_user_group u', 'u.user_id=l.id');
		$this->db->join('tbl_rights r', 'r.user_id=l.id');
		$this->db->join('tbl_location lo', 'lo.location_id=l.location');
		$this->db->where('r.form_name', 'Calling Notification');
		$this->db->where('r.view', '1');
		$this->db->where('lo.location_id', 38);

		$this->db->where('status', '1');
		if ($_SESSION['role'] != 1) {
			$this->db->where($st);
		}

		$this->db->group_by('l.id');
		$this->db->order_by('l.fname', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function select_grp($st)
	{
		$this->db->select('group_id,group_name');
		$this->db->from('tbl_group ');
		if ($_SESSION['role'] != 1) {
			$this->db->where($st);
		}

		$query = $this->db->get();
		return $query->result();
	}

	function lmsuser()
	{
		$this->db->select('id,fname,lname');
		$this->db->from('lmsuser l');

		$this->db->where('status', '1');
		$this->db->where('role', '3');

		$query = $this->db->get();
		return $query->result();
	}


	function all_y($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('count(enq_id)as lcount,enq_id,status,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_live($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Live');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function all_y_postponed($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Postponed');
		//$this -> db -> group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_convert($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Convert');
		//$this -> db -> group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_lost($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Lost');
		//$this -> db -> group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_lc($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('count(enq_id)as lcount,status,status_name');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_lost_lc($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Lost');
		//$this -> db -> group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_y_convert_lc($first, $last)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,status,status_name');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.status_name', 'Convert');
		//	$this -> db -> group_by('s.status_name');
		$this->db->where('s.process_id', $process_id);
		//$this -> db -> order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_new($from, $to, $source)
	{
		$st = $this->checkUserCountRightsForEnq();
		//Select Lead Campaign wise new lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		if ($source != 'All') {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		if ($_SESSION['role'] != 1) {
			$this->db->where($st);
		}
		$this->db->where('l.assign_date>=', $yesterday);
		$this->db->where('s.status_name', 'Not Yet');
		$this->db->where('s.process_id', $process_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_pending_attened($from, $to, $source)
	{
		//Select Lead Campaign wise pending attened lead
		$date = date('Y-m-d');
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id");
		if ($source != 'All') {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where("lf.nextfollowupdate!=", '0000-00-00');
		$this->db->where("lf.nextfollowupdate <", $date);
		$this->db->where("lf.nextfollowupdate >=", $from);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_pending_not_attened($from, $to, $source)
	{
		//Select Lead Campaign wise pending not attened lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id", 'left');
		if ($source != 'All') {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.assign_date < ', $yesterday);
		$this->db->where('l.assign_date >= ', $from);
		$this->db->where('s.status_name', 'Not Yet');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function web_m($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('count(enq_id)as lcount,lead_source,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->group_by('status_name');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function web_m_lost_lc($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Lost');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function web_m_convert_lc($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Convert');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}


	function campaign_m($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('count(l.enq_id) as lcount,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->group_by('s.status_name');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_m_live($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Live');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_m_lost($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Lost');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_m_postponed($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Postponed');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_m_convert($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Convert');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function campaign_m_lost_lc($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('l.enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Lost');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function campaign_m_convert_lc($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise
		$process_id = $_SESSION['process_id'];
		$this->db->select('l.enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Convert');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_new($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise new lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.assign_date>=', $yesterday);
		$this->db->where('s.status_name', 'Not Yet');
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_pending_attened($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise pending attened lead
		$date = date('Y-m-d');
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id");
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where("lf.nextfollowupdate!=", '0000-00-00');
		$this->db->where("lf.nextfollowupdate <", $date);
		$this->db->where("lf.nextfollowupdate >=", $from);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function campaign_pending_not_attened($from, $to, $campaign_name)
	{
		//Select Lead Campaign wise pending not attened lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id", 'left');
		if ($campaign_name != 'Web') {
			$this->db->where('l.enquiry_for', $campaign_name);
			$this->db->where('l.lead_source!=', '');
		} else {
			$this->db->where('l.lead_source', '');
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.assign_date < ', $yesterday);
		$this->db->where('l.assign_date >= ', $from);
		$this->db->where('s.status_name', 'Not Yet');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('l.assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function cse_m_live($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Live');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function cse_m_postponed($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Postponed');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function cse_m_lost($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Lost');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function cse_m_convert($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Convert');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function cse_m_lost_lc($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);

		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'Lost');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function cse_m_convert_lc($from, $to, $cse_id)
	{
		// All Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from);
		$this->db->where('l.created_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);

		$this->db->where('s.process_id', $process_id);
		$this->db->where('s.status_name', 'convert');
		$this->db->order_by('l.status', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function cse_new($from, $to, $cse_id)
	{
		//Select Lead Campaign wise new lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.assign_date>=', $yesterday);
		$this->db->where('s.status_name', 'Not Yet');
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function cse_pending_attened($from, $to, $cse_id)
	{
		//Select Lead Campaign wise pending attened lead
		$date = date('Y-m-d');
		$process_id = $_SESSION['process_id'];
		$this->db->select('l.enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id");
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where("lf.nextfollowupdate!=", '0000-00-00');
		$this->db->where("lf.nextfollowupdate <", $date);
		$this->db->where("lf.nextfollowupdate >=", $from);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function cse_pending_not_attened($from, $to, $cse_id)
	{
		//Select Lead Campaign wise pending not attened lead
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$process_id = $_SESSION['process_id'];
		$this->db->select('l.enq_id,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join("lead_followup lf", "l.followup_id=lf.id", 'left');
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.assign_date < ', $yesterday);
		$this->db->where('l.assign_date >= ', $from);
		$this->db->where('s.status_name', 'Not Yet');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function all_m_live($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '2');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_m_postponed($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '3');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_m_lost($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '4');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_m_converted($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '5');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_m_nf($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '1');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_m($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}



	function web_m_postponed($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Postponed');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function web_m_lost($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Lost');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function web_m_converted($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Convert');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}



	function web_m_Live($first, $last)
	{
		// website Leads Count 
		$process_id = $_SESSION['process_id'];
		$this->db->select('enq_id,lead_source,status_name');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $first);
		$this->db->where('l.created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->where('s.process_id', $process_id);
		$this->db->where('l.lead_source', '');
		$this->db->where('s.status_name', 'Live');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function all_y_live1($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '2');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_y_postponed1($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '3');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_y_lost1($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '4');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_y_converted1($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '5');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_y_nf($first, $last)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '1');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function web_y_live($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source,status');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '2');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}

	function web_y_postponed($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '3');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}

	function web_y_lost($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '4');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}

	function web_y_converted($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '5');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}

	function web_y_nf($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		$this->db->where('status', '1');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}

	function web_y($first, $last)
	{
		$this->db->select('count(enq_id)as lcount,lead_source,status');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $first);
		$this->db->where('created_date <=', $last);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();
		return $query->result();
	}



	function today_followup($assign_to_telecaller)
	{
		$today = date('Y-m-d');
		$day = date('d-m-Y');
		$query = $this->db->query("select count(enq_id)as todaycount 
		from lead_master lm 
		left join lmsuser u on u.id=lm.assignby
		inner join lead_followup lf on lf.leadid=lm.enq_id
		 AND lf.id = 
		        (
		           SELECT MAX(id) 
		           FROM lead_followup z 
		           WHERE z.leadid = lf.leadid
		        )
		where  lm.assign_to_telecaller='$assign_to_telecaller' 
			and (lf.nextfollowupdae = '$today' or lf.nextfollowupdae = '$day')
			group by lf.leadid
		");
		return $query->result();
	}

	public function new_lead($assign_to_telecaller)
	{

		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this->db->select('count(enq_id) as newleadcount');
		$this->db->from('lead_master l');
		$this->db->join('lmsuser u', 'l.assign_to_telecaller=u.id');
		$this->db->where('l.assign_to_telecaller', $assign_to_telecaller);
		$this->db->where('l.status', '1');
		$this->db->where('l.assign_date>=', $yesterday);
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->result();
	}

	public function pending_attended($assign_to_telecaller)
	{

		$today = date('Y-m-d');
		$query = $this->db->query("select count(enq_id)as p_attendedcount ,enq_id
		from lead_master lm 
		inner join lead_followup lf ON lm.enq_id = lf.leadid
		 AND lf.id = 
		        (
		           SELECT MAX(id) 
		           FROM lead_followup z 
		           WHERE z.leadid = lf.leadid
		        )
		inner join lmsuser lu on lu.id=lm.assignby
		where lm.assign_to_telecaller='$assign_to_telecaller' 
			and lf.nextfollowupdae <'$today' 
			and lf.nextfollowupdae !='0000-00-00' 
			and (lm.status = 2 or lm.status = 3 ) 
			
			
			 ");

		return $query->result();
	}

	public function pending_not_attended($assign_to_telecaller)
	{

		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this->db->select('count(enq_id)as p_not_attendedcount ');
		$this->db->from('lead_master lm');
		$this->db->join('lmsuser lu', 'lu.id=lm.assignby');
		$this->db->where('assign_to_telecaller', $assign_to_telecaller);
		$this->db->where('lm.assign_date < ', $yesterday);
		$this->db->where('lm.status', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function all_m_filter($from_month, $to_month, $cname)
	{
		$this->db->select('count(enq_id)as lcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $from_month);
		$this->db->where('created_date <=', $to_month);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		if ($cname == 'Web') {
			$this->db->where('lead_source', '');
		} else {
			$this->db->where('lead_source', 'Facebook');
			$this->db->where('enquiry_for', $cname);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function all_y_filter($from_month, $to_month, $cname)
	{
		$this->db->select('count(enq_id)as lcount,lead_source');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $from_month);
		$this->db->where('created_date <=', $to_month);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		if ($cname == 'Web') {
			$this->db->where('lead_source', '');
		} else {
			$this->db->where('lead_source', 'Facebook');
			$this->db->where('enquiry_for', $cname);
		}
		$this->db->group_by('lead_source');
		$query = $this->db->get();

		return $query->result();
	}

	public function all_m_filter1($from_month, $to_month, $cname)
	{
		$this->db->select('count(enq_id)as lcount,status');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $from_month);
		$this->db->where('created_date <=', $to_month);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		if ($cname == 'Web') {
			$this->db->where('lead_source', '');
		} else {
			$this->db->where('lead_source', 'Facebook');
			$this->db->where('enquiry_for', $cname);
		}
		$this->db->group_by('status');
		$this->db->order_by('status', 'asc');

		$query = $this->db->get();
		return $query->result();
	}

	public function all_y_filter1($from_month, $to_month, $cname)
	{
		$this->db->select('count(enq_id)as lcount,status');
		$this->db->from('lead_master');
		$this->db->where('created_date >=', $from_month);
		$this->db->where('created_date <=', $to_month);
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '4') {
			$this->db->where('assign_to_telecaller', $_SESSION['user_id']);
		}
		if ($cname == 'Web') {
			$this->db->where('lead_source', '');
		} else {
			$this->db->where('lead_source', 'Facebook');
			$this->db->where('enquiry_for', $cname);
		}
		$this->db->group_by('status');
		$this->db->order_by('status', 'asc');

		$query = $this->db->get();
		return $query->result();
	}


	public function select_campaign1()
	{
		$this->db->select('*');
		$this->db->from('tbl_campaign');
		$query = $this->db->get();
		return $query->result();
	}

	public function refresh_campaign($group_id)
	{

		$this->db->select('*');
		$this->db->from('tbl_campaign');
		$this->db->where('group_id', $group_id);
		$query3 = $this->db->get();
		return $query3->result();
	}

	public function select_table($campaign_name)
	{

		$this->db->select('*');
		$this->db->from('tbl_campaign');

		$this->db->where('campaign_name', $campaign_name);
		$query4 = $this->db->get();

		//echo $this->db->last_query();
		return $query4->result();
	}



	function campaign_y_live($from_year, $to_year, $campaign_name)
	{

		$this->db->select('count(l.enq_id) as lcount,l.enquiry_for,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from_year);
		$this->db->where('l.created_date <=', $to_year);
		$this->db->where('l.enquiry_for', $campaign_name);
		$this->db->group_by('l.status');
		$query = $this->db->get();
		return $query->result();
	}



	public function cse_y_live($from_year, $to_year, $cse_id)
	{
		$this->db->select('count(l.enq_id) as lcount,l.assign_to_telecaller,l.lead_source,s.status_name,l.status');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.created_date >=', $from_year);
		$this->db->where('l.created_date <=', $to_year);
		$this->db->where('l.assign_to_telecaller', $cse_id);

		$this->db->group_by('l.status');
		$query = $this->db->get();
		return $query->result();
	}

	public function cse_m_new($from, $to, $cse_id)
	{

		$yesterday = date("Y-m-d", strtotime('-1 days'));

		$this->db->select('count(l.enq_id) as lcount');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.assign_date >=', $yesterday);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function cse_y_new($from, $to, $cse_id)
	{

		$yesterday = date("Y-m-d", strtotime('-1 days'));

		$this->db->select('count(l.enq_id) as lcount,l.assign_to_telecaller,l.lead_source,s.status_name,l.status,l.assign_date');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->where('l.assign_date>=', $yesterday);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function cse_m_pending($from, $to, $cse_id)
	{

		$today = date('Y-m-d');
		$this->db->select('count(l.enq_id) as lcount,l.assign_to_telecaller,l.lead_source,s.status_name,l.status,l.assign_date');
		$this->db->from('lead_master l');
		$this->db->join('tbl_status s', 's.status_id=l.status');
		$this->db->join('lead_followup lf', 'l.followup_id=lf.id');
		$this->db->where("lf.nextfollowupdate!=", '0000-00-00');
		$this->db->where("lf.nextfollowupdate <", $today);
		$this->db->where('l.assign_date >=', $from);
		$this->db->where('l.assign_date <=', $to);
		$this->db->where('l.assign_to_telecaller', $cse_id);
		$query = $this->db->get();
		return $query->result();
	}
	function campaign_today_followup($from, $to, $cse_id)
	{

		//Today followup Leads
		$today = date('Y-m-d');


		$this->db->select("enq_id");
		$this->db->from("lead_master lm");
		$this->db->join("lead_followup lf", "lm.followup_id=lf.id", 'left');

		if ($cse_id != 0) {
			$this->db->where("lm.assign_to_telecaller=", $cse_id);
		}

		$this->db->where('lf.nextfollowupdate', $today);
		$this->db->group_by('lf.leadid');
		$this->db->order_by('lf.id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function tracker_new()
	{
		$enq_id = $this->input->post('st');
		$this->db->select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this->db->from('lead_master l');
		$this->db->join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this->db->join('lead_followup f', 'f.id=l.followup_id', 'left');
		$this->db->join('tbl_status s', 's.status_id=l.status', 'left');
		$this->db->join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this->db->join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this->db->join('make_models m', 'm.model_id=l.model_id', 'left');
		$this->db->join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this->db->join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this->db->where($enq_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function tracker_new1()
	{
		$enq_id = $this->input->post('st');
		$this->db->select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this->db->from('lead_master_lc l');
		$this->db->join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this->db->join('lead_followup_lc f', 'f.id=l.followup_id', 'left');
		$this->db->join('tbl_status s', 's.status_id=l.status', 'left');
		$this->db->join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this->db->join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this->db->join('make_models m', 'm.model_id=l.model_id', 'left');
		$this->db->join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this->db->join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this->db->where($enq_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Notification_evaluation_model extends CI_Model
{
    public $process_name;
    public $role;
    public $user_id;
    public     $location;
    public function __construct()
    {
        parent::__construct();
        //Session Values
        $this->today = date('Y-m-d');
        $this->process_name = $this->session->userdata('process_name');
        $this->role = $this->session->userdata('role');
        $this->user_id = $this->session->userdata('user_id');
        $this->process_id = $this->session->userdata('process_id');
        $this->location = $this->session->userdata('location');
        $this->location_id = $this->session->userdata('location_id');
        //Select Table
        if ($this->process_id == 6 || $this->process_id == 7) {
            $this->table_name = 'lead_master';
            $this->table_name1 = 'lead_followup';
            $this->table_name2 = 'tbl_escalation';
            $this->selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
        } elseif ($this->process_id == 8) {
            $this->table_name = 'lead_master_evaluation';
            $this->table_name1 = 'lead_followup_evaluation';
            $this->table_name2 = 'tbl_escalation';
            $this->selectElement = 'l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
        } else {
            $this->table_name = 'lead_master_all';
            $this->table_name1 = 'lead_followup_all';
            $this->table_name2 = 'tbl_escalation_all';
            $this->selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
        }
        //Select Table 
        /*	if($this->process_id==6 || $this->process_id==7)
		{
			$this->table_name='lead_master';
			$this->table_name1='lead_followup';		
			
							
		}
		else
		{
			$this->table_name='lead_master_all';		
			$this->table_name1='lead_followup_all';	
			$this->table_name2='tbl_escalation_all';		
				
		}*/
        //Excecutive array

        $this->tl_role = array("CSE Team Leader", "DSE Team Leader", "Service TL", "Insurance TL", "Accessories TL", "Finance TL", "Evaluation Team Leader");
        $this->executive_role = array("CSE", "DSE", "Service Excecutive", "Insurance Executive", "Accessories Executive", "Finance Executive", "Evaluation Executive");
    }
    public function select_default_close_lead_status()
    {
        $status_query = $this->db->query("select nextActionName from tbl_add_default_close_lead_status where process_id='$this->process_id'")->result();
        if (count($status_query) > 0) {
            $default_close_lead_status = $status_query[0]->nextActionName;
            //echo $default_close_lead_status;
            $default_close_lead_status = json_decode($default_close_lead_status);
            return $default_close_lead_status;
        }
    }
    //Get Location Of User
    public function select_location()
    {


        $this->db->select('l.location_id,l.location');
        $this->db->from('tbl_location l');
        $this->db->join('tbl_manager_process p', 'p.location_id=l.location_id');
        $this->db->where('p.process_id', $this->process_id);
        $this->db->where('p.user_id', $this->user_id);
        $this->db->where('p.status !=', '-1');
        /*if($this->role !='1' && $this->role !='2')
			{*/

        //$this -> db -> where('l.location_id', $this->location_id);
        //	}
        //$this->db->group_by('l.location_id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }


    public function location_data($location_name)
    {
        $user = $this->input->post('user');
        $select_role = array("3", "4", "8", "10", "12", "14", "16");
        $this->db->select('u.id,u.fname,u.lname,u.location,u.role,l.location as location_name');
        $this->db->from('lmsuser u');
        $this->db->join('tbl_manager_process p', 'p.user_id=u.id');
        $this->db->join('tbl_location l', 'l.location_id=p.location_id');
        $this->db->join('tbl_mapdse m', 'm.dse_id=u.id', 'left');
        $this->db->where('p.location_id', $location_name);
        $this->db->where('p.process_id', $this->process_id);
        $this->db->where('u.status', 1);

        if (in_array($this->role, $select_role)) {
            $this->db->where('id', $this->user_id);
        } else {
            if ($user == 'DSE') {

                if (in_array($_SESSION['role_name'], $this->tl_role)) {
                    $this->db->where('m.tl_id', $this->user_id);
                } else {
                    $this->db->where_in('role_name', $this->executive_role);
                }
            } else {

                if (in_array($_SESSION['role_name'], $this->tl_role)) {
                    $this->db->where('id', $this->user_id);
                } else {
                    $this->db->where_in('role_name', $this->tl_role);
                }
            }
        }
        $this->db->group_by('u.id');
        $this->db->order_by('u.fname', 'asc');
        $query = $this->db->get();
        if ($this->user_id == '538') {
            //echo $this->db->last_query();
        }

        //
        $query = $query->result();
        //print_r($query);
        if (count($query) > 0) {
            foreach ($query as $row) {
                // echo  'id '.$row->id. ' role '.$row->role;
                // exit;

                if ($_SESSION['process_id'] == 6 || $_SESSION['process_id'] == 7 || $_SESSION['process_id'] == 8) {
                    // echo "inside the if condition";
                    // exit;

                    $con = 'f.appointment_type="Evaluation Allotted"';
                    $con1 = 'Evaluation Allotted';
                    $evaluation_count = $this->check_count($con1, $con, $row->id, $row->role);
                } else {
                    $evaluation_count = 0;
                }

                // New query optimised without escalation 			
                $select_leads[] = array(
                    'id' => $row->id, 'role' => $row->role, 'location_name' => $row->location_name,
                    'fname' => $row->fname, 'lname' => $row->lname, 'evaluation_count' => $evaluation_count
                );
            }
        } else {
            //$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');
            $select_leads = array();
        }
        return    $select_leads;
    }




    public function check_count($con1, $con, $id, $role)
    {
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as call_today');
        $this->db->from($this->table_name . ' ln');
        if ($_SESSION['process_id'] == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }
            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        //$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
        if ($role == '5') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('ln.assign_to_cse', $id);
            //$this -> db -> where('ln.assign_to_dse_tl',0);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('assign_by_cse_tl', $id);
        }
        $this->db->where($con);
        //	$this -> db -> where('ln.process', $this->process_name);
        /*if($con1=='Home Visit')
		{
			$this -> db -> where('f.td_hv_date', $this->today);
		}
		else {*/
        $this->db->where('f.appointment_date', $this->today);
        //}
        //$this -> db -> where('f.td_hv_date', $this->today);
        //$this -> db -> where('ln.nextAction!=', "Close");	
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_call_today = $query1[0]->call_today;
        return $total_call_today;
    }

    public function escalation_level_1($id, $role)
    {

        //$today=date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(distinct(enq_id)) as new_leads');
        $this->db->from($this->table_name . ' ln');
        //$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id','left');
        if ($_SESSION['process_id'] == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }

            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        $this->db->where('esc_level1', "Yes");
        if ($role == '5') {
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->where('ln.assign_to_cse', $id);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('assign_by_cse_tl', $id);
        }

        $this->db->where('ln.esc_level1_resolved', " ");
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        /*$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();

        $total_new_lead = $query1[0]->new_leads;
        return $total_new_lead;
    }

    public function escalation_level_2($id, $role)
    {

        //$today=date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(distinct(enq_id)) as new_leads');
        $this->db->from($this->table_name . ' ln');
        //$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
        if ($_SESSION['process_id'] == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }

            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        $this->db->where('esc_level2', "Yes");
        if ($role == '5') {
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->where('ln.assign_to_cse', $id);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('assign_by_cse_tl', $id);
        }

        $this->db->where('ln.esc_level2_resolved', " ");
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        /*	$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_new_lead = $query1[0]->new_leads;
        return $total_new_lead;
    }


    public function escalation_level_3($id, $role)
    {

        //$today=date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(distinct(enq_id)) as new_leads');
        $this->db->from($this->table_name . ' ln');
        //$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }

            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        $this->db->where('esc_level3', "Yes");
        if ($role == '5') {
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->where('ln.assign_to_cse', $id);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('assign_by_cse_tl', $id);
        }

        $this->db->where('ln.esc_level3_resolved', " ");
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        /*	$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_new_lead = $query1[0]->new_leads;
        return $total_new_lead;
    }

    public function unassigned_leads($id, $role)
    {

        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as unassign');
        $this->db->from($this->table_name . ' ln');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }
            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        //$this -> db -> where('ln.nextAction!=', "Close");
        if ($role == '5') {
            $this->db->where('ln.assign_to_dse_tl', $id);
            $this->db->where('ln.assign_to_dse', 0);
        } elseif ($role == '4') {
            $this->db->where('ln.assign_to_dse_tl', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            $this->db->where('ln.assign_to_e_tl', $id);
            $this->db->where('ln.assign_to_e_exe', 0);
        } elseif ($role == '16') {
            $this->db->where('ln.assign_to_e_tl', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->where('assign_by_cse_tl', 0);
            $this->db->where('ln.assign_to_cse', $id);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('assign_by_cse_tl', 0);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_unassigned = $query1[0]->unassign;
        return $total_unassigned;
    }

    public function new_leads($id, $role)
    {

        $today = date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as new_leads');
        $this->db->from($this->table_name . ' ln');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }
            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        //$this -> db -> where('ln.nextAction!=', "Close");

        if ($role == '5') {
            $this->db->where('dse_followup_id', 0);
            $this->db->where('ln.assign_to_dse_tl', $id);
            $this->db->where('ln.assign_to_dse_date', $today);
        } elseif ($role == '4') {
            $this->db->where('dse_followup_id', 0);
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
            $this->db->where('ln.assign_to_dse_date', $today);
        } elseif ($role == '15') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('tracking_followup_id', 0);
                $this->db->where('ln.evaluation_tracking_date ', $today);
            } else {
                $this->db->where('exe_followup_id', 0);
                $this->db->where('ln.assign_to_e_exe_date', $today);
            }

            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            if ($_SESSION['sub_poc_purchase'] == 2) {

                $this->db->where('tracking_followup_id', 0);
                $this->db->where('evaluation_tracking_date ', $today);
            } else {
                $this->db->where('exe_followup_id', 0);
                $this->db->where('assign_to_e_exe_date ', $today);
            }
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
            //	$this -> db -> where('ln.assign_to_e_exe_date', $today);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->where('cse_followup_id', 0);
            $this->db->where('ln.assign_to_cse', $id);
            $this->db->where('ln.assign_to_cse_date', $today);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('assign_by_cse_tl', $id);
            $this->db->where('ln.assign_to_dse_tl', 0);
            $this->db->where('ln.assign_to_cse_date', $today);
            $this->db->where('cse_followup_id', 0);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_new_lead = $query1[0]->new_leads;
        return $total_new_lead;
    }

    public function call_today($id, $role)
    {
        //echo $id;
        $today = date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as call_today');
        $this->db->from($this->table_name . ' ln');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }
            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        if ($role == '5') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.tracking_followup_id');
            } else {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            }
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.tracking_followup_id');
            } else {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            }
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('ln.assign_to_cse', $id);
            //$this -> db -> where('ln.assign_to_dse_tl',0);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('assign_by_cse_tl', $id);
        }
        //$this -> db -> where('ln.process', $this->process_name);
        $this->db->where('f.nextfollowupdate', $today);
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        //$this -> db -> where('ln.nextAction!=', "Close");	
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_call_today = $query1[0]->call_today;
        return $total_call_today;
    }

    public function pending_new($id, $role)
    {

        $today = date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as pending_new');
        $this->db->from($this->table_name . ' ln');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }


            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        //$this -> db -> where('ln.nextAction!=', "Close");

        if ($role == '5') {

            $this->db->where('dse_followup_id', 0);
            $this->db->where('ln.assign_to_dse_tl', $id);
            $this->db->where('ln.assign_to_dse_date <', $today);
            $this->db->where('ln.assign_to_dse_date!=', '0000-00-00');
        } elseif ($role == '4') {
            $this->db->where('ln.dse_followup_id', 0);
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
            $this->db->where('ln.assign_to_dse_date <', $today);
            $this->db->where('ln.assign_to_dse_date!=', '0000-00-00');
        } elseif ($role == '15') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('tracking_followup_id', 0);
                $this->db->where('ln.evaluation_tracking_date  <', $today);
                $this->db->where('ln.evaluation_tracking_date !=', '0000-00-00');
            } else {
                $this->db->where('exe_followup_id', 0);
                $this->db->where('ln.assign_to_e_exe_date <', $today);
                $this->db->where('ln.assign_to_e_exe_date!=', '0000-00-00');
            }
            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('tracking_followup_id', 0);
                $this->db->where('ln.evaluation_tracking_date  <', $today);
                $this->db->where('ln.evaluation_tracking_date !=', '0000-00-00');
            } else {
                $this->db->where('exe_followup_id', 0);
                $this->db->where('ln.assign_to_e_exe_date <', $today);
                $this->db->where('ln.assign_to_e_exe_date!=', '0000-00-00');
            }
            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {

            $this->db->where('cse_followup_id', 0);
            $this->db->where('ln.assign_to_dse_tl', 0);
            $this->db->where('ln.assign_to_cse', $id);
            $this->db->where('ln.assign_to_cse_date < ', $today);
            $this->db->where('ln.assign_to_cse_date!=', '0000-00-00');
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->where('ln.assign_to_dse_tl', 0);

            $this->db->where('assign_by_cse_tl', $id);
            $this->db->where('ln.assign_to_cse_date < ', $today);
            $this->db->where('ln.assign_to_cse_date!=', '0000-00-00');
            $this->db->where('cse_followup_id', 0);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $query1 = $query->result();
        $total_pending_new = $query1[0]->pending_new;
        return $total_pending_new;
    }

    public function pending_followup($id, $role)
    {
        //echo $id;
        //echo $role;
        $today = date('Y-m-d');
        $this->executive_array = array("3", "8", "10", "12", "14");
        $this->tl_array = array("2", "7", "9", "11", "13");
        $this->db->select('count(enq_id) as call_today');
        $this->db->from($this->table_name . ' ln');
        if ($this->process_id == 8) {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->where('ln.nextAction_for_tracking', 'Evaluation Done');
            }

            $this->db->where('ln.evaluation', 'Yes');
        } else {
            $this->db->where('ln.process', $this->process_name);
        }
        if ($role == '5') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl', $id);
        } elseif ($role == '4') {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.dse_followup_id');
            $this->db->where('ln.assign_to_dse_tl!=', 0);
            $this->db->where('ln.assign_to_dse', $id);
        } elseif ($role == '15') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.tracking_followup_id');
            } else {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            }

            $this->db->where('ln.assign_to_e_tl', $id);
        } elseif ($role == '16') {
            if ($_SESSION['sub_poc_purchase'] == 2) {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.tracking_followup_id');
            } else {
                $this->db->join($this->table_name1 . ' f', 'f.id=ln.exe_followup_id');
            }

            $this->db->where('ln.assign_to_e_tl!=', 0);
            $this->db->where('ln.assign_to_e_exe', $id);
        } elseif (in_array($role, $this->executive_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('ln.assign_to_cse', $id);
            //$this -> db -> where('ln.assign_to_dse_tl',0);
        } elseif (in_array($role, $this->tl_array)) {
            $this->db->join($this->table_name1 . ' f', 'f.id=ln.cse_followup_id');
            $this->db->where('assign_by_cse_tl', $id);
            //$this -> db -> where('ln.assign_to_dse_tl',0);
        }
        //$this -> db -> where('ln.process', $this->process_name);
        $this->db->where('f.nextfollowupdate <', $today);
        $this->db->where('f.nextfollowupdate!=', '0000-00-00');
        $default_close_lead_status = $this->select_default_close_lead_status();
        if (isset($default_close_lead_status)) {
            $this->db->where_not_in('ln.nextAction', array_values($default_close_lead_status));
        }
        //$this -> db -> where('ln.nextAction!=', "Close");	
        $query = $this->db->get();
        if ($_SESSION['user_id'] == 1) {
            //	echo $this->db->last_query();
        }

        $query1 = $query->result();
        $total_call_today = $query1[0]->call_today;
        return $total_call_today;
    }
}

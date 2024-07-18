<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CseModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_cse($process_id)
    {
        $this->db->select('concat(u.fname," ",u.lname) as cse_name,u.id');
        $this->db->from('lmsuser u');
        $this->db->join('tbl_manager_process m', 'm.user_id=u.id');
        $this->db->where('m.process_id', $process_id);
        $this->db->where('m.location_id', 38);
        $this->db->where('u.role', 3);
        $this->db->where('u.status', 1);
        $this->db->group_by('u.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProcessName($process_id)
    {
        $this->db->select('process_id,process_name');
        $this->db->from('tbl_process');
        $this->db->where('process_id', $process_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeadCount($process, $cse_user, $start_date, $end_date)
    {
        $this->db->select("DATE(lead_master.created_date) AS date, tbl_role.role AS cse_user_id, lmsuser.role_name AS cse_username, COUNT(DISTINCT lead_master.enq_id) AS lead_count");
        $this->db->from("lead_master");
        $this->db->join("lmsuser", "lead_master.assign_to_cse = lmsuser.id");
        $this->db->join("tbl_role", "lmsuser.role = tbl_role.role");
        $this->db->where("lead_master.process", "New Car");
        $this->db->where("lead_master.created_date >=", $start_date);
        $this->db->where("lead_master.created_date <=", $end_date);
        $this->db->where("tbl_role.role", 3);
        $this->db->where("lead_master.process", $process[0]->process_name);
        $this->db->where("lead_master.assign_to_cse", $cse_user);
        $this->db->group_by("DATE(lead_master.created_date), tbl_role.role, lmsuser.role_name");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getConnectedCount($process, $cse_user, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(lf.id) AS connected_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("lmsuser", "lm.assign_to_cse = lmsuser.id");
        $this->db->join("tbl_role", "lmsuser.role = tbl_role.role");
        if ($process[0]->process_id == 8) {
            $this->db->where('lm.evaluation', 'Yes');
        } else {
            $this->db->where('lm.process', $process[0]->process_name);
        }
        $this->db->where("lf.contactibility", "Connected");
        $this->db->where("lm.assign_to_cse_date >=", $start_date);
        $this->db->where("lm.assign_to_cse_date <=", $end_date);
        $this->db->where("tbl_role.role", 3);
        $this->db->where("lm.assign_to_cse", $cse_user);
        $this->db->group_by("DATE(lf.date)");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getInterestedCount($process, $cse_user, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(lf.id) AS interested_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("lmsuser", "lm.assign_to_cse = lmsuser.id");
        $this->db->join("tbl_role", "lmsuser.role = tbl_role.role");
        if ($process[0]->process_id == 8) {
            $this->db->where('lm.evaluation', 'Yes');
        } else {
            $this->db->where('lm.process', $process[0]->process_name);
        }
        $this->db->where("lf.feedbackStatus", "Interested");
        $this->db->where("lm.assign_to_cse_date >=", $start_date);
        $this->db->where("lm.assign_to_cse_date <=", $end_date);
        $this->db->where("tbl_role.role", 3);
        $this->db->where("lm.assign_to_cse", $cse_user);
        $this->db->group_by("DATE(lf.date)");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTestDriveCount($process, $cse_user, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(lf.id) AS testdrive_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("lmsuser", "lm.assign_to_cse = lmsuser.id");
        $this->db->join("tbl_role", "lmsuser.role = tbl_role.role");
        if ($process[0]->process_id == 8) {
            $this->db->where('lm.evaluation', 'Yes');
        } else {
            $this->db->where('lm.process', $process[0]->process_name);
        }
        $this->db->where("lf.nextAction", "Test Drive");
        $this->db->where("lm.assign_to_cse_date >=", $start_date);
        $this->db->where("lm.assign_to_cse_date <=", $end_date);
        $this->db->where("tbl_role.role", 3);
        $this->db->where("lm.assign_to_cse", $cse_user);
        $this->db->group_by("DATE(lf.date)");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBookedCount($process, $cse_user, $start_date, $end_date)
    {
        $this->db->select("DATE(lm.created_date) AS date, COUNT(DISTINCT lm.contact_no) AS booked_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("lmsuser", "lm.assign_to_cse = lmsuser.id");
        $this->db->join("tbl_role", "lmsuser.role = tbl_role.role");
        if ($process[0]->process_id == 8) {
            $this->db->where('lm.evaluation', 'Yes');
        } else {
            $this->db->where('lm.process', $process[0]->process_name);
        }
        $this->db->where('lm.edms_status IS NOT NULL');
        $this->db->where("lm.assign_to_cse_date >=", $start_date);
        $this->db->where("lm.assign_to_cse_date <=", $end_date);
        $this->db->where("tbl_role.role", 3);
        $this->db->where("lm.assign_to_cse", $cse_user); 
        $this->db->group_by("DATE(lm.created_date)");
        $query = $this->db->get();
        return $query->result_array();
    }
}

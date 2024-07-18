<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Leads_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function submit_action()
    {
        $this->load->model('Leads_model');
        $data['lead'] = $this->Leads_model->select_lead();
        $this->load->view('Leads_view', $data);
    }
    public function select_lead()
{
    $this->db->select('id, CONCAT(fname,"",lname) AS full_name, COUNT(*) as lead_count');               
    $this->db->from('lmsuser');
    $this->db->where('status', 1);
    $this->db->where('role_name', 'DSE');
    $this->db->group_by('full_name','date');
    $query = $this->db->get();
    return $query->result_array();
}
    public function getDate($table, $where = array(), $order_by = '', $result = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($order_by != '') {
            $this->db->order_by($order_by);
        }
        if ($result != '') {
            $this->db->result($result);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function displayfiltersubmission($dse_user,$start_date,$end_date,$process)
    {
    if ($dse_user == 'all') {
        $this->db->select('CONCAT(u.fname, " ",u.lname) AS full_name, DATE(lm.assign_to_dse_tl_date) AS date , COUNT(lf.id) AS attempt, 
        COUNT(lm.enq_id) AS total_leads,
        SUM(CASE WHEN lf.contactibility = "Connected" THEN 1 ELSE 0 END) AS connected, 
        SUM(CASE WHEN lf.feedbackstatus = "Interested" THEN 1 ELSE 0 END) AS interested,
        SUM(CASE WHEN lf.nextAction = "Test Drive" THEN 1 ELSE 0 END) AS Test_Drive,
        SUM(CASE WHEN lf.feedbackstatus = "Booked" THEN 1 ELSE 0 END) AS Booked');
        $this->db->from('lmsuser u');
        $this->db->join('lead_master lm', "u.id = lm.assign_to_dse  AND lm.assign_to_dse_tl_date >= '$start_date'  AND lm.assign_to_dse_tl_date <= '$end_date' AND lm.process = '$process'", 'left');
        $this->db->join('lead_followup lf', 'lm.enq_id = lf.leadid', 'left');
        $this->db->where('u.role', 4);
        // $this->db->group_by('u.fname','lm.assign_to_dse_tl_date');
        $this->db->group_by(array('full_name', 'date'));
        $query = $this->db->get();
        return $query->result_array();
    }
    else{
        $this->db->select('CONCAT(u.fname, " ",u.lname) AS full_name, DATE(lm.assign_to_dse_tl_date) AS date ,COUNT(lf.id) AS attempt, 
        COUNT(lm.enq_id) AS total_leads,
        SUM(CASE WHEN lf.contactibility = "Connected" THEN 1 ELSE 0 END) AS connected, 
        SUM(CASE WHEN lf.feedbackstatus = "Interested" THEN 1 ELSE 0 END) AS interested,
        SUM(CASE WHEN lf.nextAction = "Test Drive" THEN 1 ELSE 0 END) AS Test_Drive,
        SUM(CASE WHEN lf.feedbackstatus = "Booked" THEN 1 ELSE 0 END) AS Booked');
        $this->db->from('lmsuser u');
        $this->db->join('lead_master lm', "u.id = lm.assign_to_dse  AND lm.assign_to_dse_tl_date >= '$start_date'  AND lm.assign_to_dse_tl_date <= '$end_date' AND lm.process = '$process'", 'left');
        $this->db->join('lead_followup lf', 'lm.enq_id = lf.leadid', 'left');
        $this->db->where('u.id', $dse_user);
        // $this->db->group_by('lm.assign_to_dse_tl_date');
        $this->db->group_by(array('u.fname', 'u.lname', 'date'));
        $query = $this->db->get();
        return $query->result_array();
    }
    }


public function count_leads_by_dse()
{
    $this->db->select('CONCAT(fname, " ", lname) AS full_name, COUNT(*) as lead_count');               
    $this->db->from('lmsuser');
    $this->db->where('status', 1);
    $this->db->where('role_name', 'DSE');
    $this->db->group_by(array('fname', 'lname')); // Group by individual columns
    $query = $this->db->get();
    return $query->result_array();  
}
}

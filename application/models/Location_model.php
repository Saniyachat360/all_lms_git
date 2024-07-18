<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Location_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function submit_action()
    {
        $this->load->model('Location_model');
        $data['lead'] = $this->Leads_model->select_lead();
        $this->load->view('Location_view', $data);
    }

public function select_lead()
{
    $this->db->select('enq_id, location, COUNT(*) as lead_count');
    $this->db->from('lead_master');
    $this->db->group_by('location');
    $this->load->model('Location_model');
    $query = $this->db->get();
    return $query->result_array();
}


    public function getDate($table, $where = array(), $order_by = '', $result = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }
        if (!empty($result)) {
            $this->db->result($result);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    public function displayfiltersubmission($location, $start_date, $end_date, $process)
    {   
        $this->db->select("DATE(lm.created_date) AS date, lm.location,
            COUNT(lf.id) AS attempt,
            COUNT(lm.enq_id) AS total_leads,
            SUM(CASE WHEN lf.contactibility = 'Connected' THEN 1 ELSE 0 END) AS connected,
            SUM(CASE WHEN lf.feedbackstatus = 'Interested' THEN 1 ELSE 0 END) AS interested,
            SUM(CASE WHEN lf.nextAction = 'Test Drive' THEN 1 ELSE 0 END) AS Test_Drive,
            SUM(CASE WHEN lf.feedbackstatus = 'Booked' THEN 1 ELSE 0 END) AS Booked");
        $this->db->from('lead_master lm');
        $this->db->join('lead_followup lf', 'lm.enq_id = lf.leadid', 'left');
        $this->db->where('lm.created_date >=', $start_date);
        $this->db->where('lm.created_date <=', $end_date);
        $this->db->where('lm.process', $process);
    
        if ($location != 'all') {
            $this->db->where('lm.location', $location);
            $this->db->group_by(array('lm.location', 'DATE(lm.created_date)'));
        } else {
            $this->db->group_by(array('lm.location', 'DATE(lm.created_date)'));
        }
        
        $this->db->order_by('date', 'ASC');
    
        $query = $this->db->get();
        return $query->result_array();
    }
    
}




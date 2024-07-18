<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LeadsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_source()
    {
        $this->db->select('id,lead_source_name');
        $this->db->from('lead_source');
        $this->db->where('leadsourceStatus', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function displayfiltersubmission($source, $start_date, $end_date, $process)
    {
        $this->db->select('lm.lead_source, DATE(lm.assign_to_dse_tl_date) as date');
        $this->db->select('COUNT(DISTINCT lm.enq_id) AS total_leads');
        $this->db->select('COUNT(lf.id) AS attempt');
        $this->db->select('SUM(CASE WHEN lf.contactibility = "Connected" THEN 1 ELSE 0 END) AS connected');
        $this->db->select('SUM(CASE WHEN lf.feedbackstatus = "Interested" THEN 1 ELSE 0 END) AS interested');
        $this->db->select('SUM(CASE WHEN lf.nextAction = "Test Drive" THEN 1 ELSE 0 END) AS Test_Drive');
        $this->db->select('SUM(CASE WHEN lf.feedbackstatus = "Booked" THEN 1 ELSE 0 END) AS Booked');
        $this->db->from('lead_master lm');
        $this->db->join('lead_followup lf', 'lm.enq_id = lf.leadid', 'left');
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(lm.assign_to_dse_tl_date) >=', $start_date);
            $this->db->where('DATE(lm.assign_to_dse_tl_date) <=', $end_date);
        }
        if (!empty($process)) {
            $this->db->where('lm.process', $process);
        }
        $this->db->group_by('lm.lead_source, DATE(lm.assign_to_dse_tl_date)');
        $query = $this->db->get();
        return $query->result_array();
    }
}

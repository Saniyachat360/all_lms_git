
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SourceModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_source()
    {
        $this->db->select('id, lead_source_name');
        $this->db->from('lead_source');
        $this->db->where('leadsourceStatus', 'Active');
        $this->db->group_by('lead_source_name');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProcessName($process_id)
    {
        $this->db->select('process_name');
        $this->db->from('tbl_process');
        $this->db->where('process_id', $process_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeadCount($process, $lead_source, $start_date, $end_date)
    {
        $this->db->select('DATE(created_date) as date, COUNT(DISTINCT enq_id) as lead_count');
        $this->db->from('lead_master');
        $this->db->where('process', $process[0]->process_name);
        $this->db->where('lead_source', $lead_source);
        $this->db->where('created_date >=', $start_date);
        $this->db->where('created_date <=', $end_date);
        $this->db->group_by('DATE(created_date)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getConnectedCount($process, $source, $start_date, $end_date)
    {
        $this->db->select('DATE(lf.date) as date, COUNT(lf.id) as connected_count');
        $this->db->from('lead_followup lf');
        $this->db->join('lead_master lm', 'lf.leadid = lm.enq_id');
        $this->db->where('lf.contactibility', 'Connected');
        $this->db->where('lm.lead_source', $source);
        $this->db->where('lm.process', $process[0]->process_name);
        $this->db->where('lf.date >=', $start_date);
        $this->db->where('lf.date <=', $end_date);
        $this->db->group_by('DATE(lf.date)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getInterestedCount($process, $source, $start_date, $end_date)
    {
        $this->db->select('DATE(lf.date) as date, COUNT(lf.id) as interested_count');
        $this->db->from('lead_followup lf');
        $this->db->join('lead_master lm', 'lf.leadid = lm.enq_id');
        $this->db->where('lf.feedbackStatus', 'Interested');
        $this->db->where('lm.lead_source', $source);
        $this->db->where('lm.process', $process[0]->process_name);
        $this->db->where('lf.date >=', $start_date);
        $this->db->where('lf.date <=', $end_date);
        $this->db->group_by('DATE(lf.date)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTestDriveCount($process, $source, $start_date, $end_date)
    {
        $this->db->select('DATE(lf.date) as date, COUNT(lf.id) as testdrive_count');
        $this->db->from('lead_followup lf');
        $this->db->join('lead_master lm', 'lf.leadid = lm.enq_id');
        $this->db->where('lf.nextAction', 'Test Drive');
        $this->db->where('lm.lead_source', $source);
        $this->db->where('lm.process', $process[0]->process_name);
        $this->db->where('lf.date >=', $start_date);
        $this->db->where('lf.date <=', $end_date);
        $this->db->group_by('DATE(lf.date)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBookedCount($process, $source, $start_date, $end_date)
    {
        $this->db->select('DATE(lm.created_date) as date, 
        COUNT(DISTINCT lm.contact_no) as booked_count');
        $this->db->from('lead_followup lf');
        $this->db->join('lead_master lm', 'lf.leadid = lm.enq_id');
        $this->db->where('lm.lead_source', $source);
        $this->db->where('lm.process', $process[0]->process_name);
        $this->db->where('lm.created_date >=', $start_date);
        $this->db->where('lm.created_date <=', $end_date);
        $this->db->where('lm.edms_status IS NOT NULL');
        $this->db->group_by('DATE(lm.created_date)');
        $query = $this->db->get();
        return $query->result_array();
    }
}


<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Call_StatusModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProcessName($process_id)
    {
        $this->db->select('process_name');
        $this->db->from('tbl_process');
        $this->db->where('process_id', $process_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAllUniqueFeedbackStatus($process_id)
    {
        $this->db->distinct();
        $this->db->select('lf.feedbackStatusName');
        $this->db->from('tbl_feedback_status lf');
        $this->db->where('process_id',$process_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCallStatus($start_date, $end_date, $process, $call_status, $unique_feedback_statuses, $location)
    {
        $results = [];
        foreach ($unique_feedback_statuses as $status) {
            $this->db->select('DATE(lf.date) as date,lf.feedbackStatus, COUNT(*) as status_count');
            $this->db->from('lead_followup_all lf');
            $this->db->join('lead_master_all lm', 'lf.leadid = lm.enq_id');
            $this->db->join('request_to_lead_transfer_all r', 'r.lead_id = lm.enq_id');
            $this->db->where('lf.contactibility', $call_status);
            $this->db->where('lm.process', $process->process_name);
            $this->db->where('lf.feedbackStatus', $status['feedbackStatusName']);
            $this->db->where('r.location', $location);
            $this->db->where('lf.date >=', $start_date);
            $this->db->where('lf.date <=', $end_date);
            $this->db->group_by('DATE(lf.date), lf.feedbackStatus');
            $query = $this->db->get();
            if (!$query) {
                echo 'Query Error: ' . $this->db->error()['message'];
                return false;
            }
            $result_item = [
                'feedbackStatus' => $status['feedbackStatusName'],
                'counts' => $query->result_array()
            ];
            $results[] = $result_item;
        }
        return $results;
    }
}

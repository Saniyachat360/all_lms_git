
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Bank_model extends CI_Model
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

    public function getAllBank()
    {
        $this->db->distinct();
        $this->db->select('b.bank_name');
        $this->db->from('tbl_bank b');
        $this->db->where('status','1');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCallStatusConnected($start_date, $end_date)
    {
        $this->db->select('b.bank_name, DATE(l.created_date) as date, COUNT(*) as status_count');
        $this->db->from('lead_master_all l');
        $this->db->join('tbl_bank b', 'l.bank_name = b.bank_name'); 
        $this->db->where('l.created_date >=', $start_date);
        $this->db->where('l.created_date <=', $end_date);
        $this->db->group_by(['b.bank_name', 'DATE(l.created_date)']);
        $query = $this->db->get();
        $result = [];
        foreach ($query->result_array() as $row) {
            $result[$row['bank_name']]['bank_name'] = $row['bank_name'];
            $result[$row['bank_name']]['counts'][] = [
                'date' => $row['date'],
                'status_count' => $row['status_count']
            ];
        }
    
        return $result;

    } 

    public function getCallStatus($start_date, $end_date, $process,$location,$unique_feedback_statuses)
    {
        $results = [];
        
        if (!empty($unique_feedback_statuses)) {
            foreach ($unique_feedback_statuses as $status) {
                $this->db->select('DATE(lf.created_date) as date, b.bank_name, COUNT(*) as status_count');
                $this->db->from('lead_master_all lf');
                $this->db->join('tbl_bank b', 'lf.bank_name = b.bank_name');
                $this->db->join('request_to_lead_transfer_all r', 'r.lead_id = lf.enq_id');
                $this->db->where('lf.process', $process->process_name);
                $this->db->where('r.location', $location);
                $this->db->where('b.bank_name', $status['bank_name']);
                $this->db->where('lf.created_date >=', $start_date);
                $this->db->where('lf.created_date <=', $end_date);
                $this->db->group_by('DATE(lf.created_date), b.bank_name');
    
                $query = $this->db->get();
    
                if (!$query) {
                    echo 'Query Error: ' . $this->db->error()['message'];
                    return false;
                }
    
                $result_item = [
                    'bank_name' => $status['bank_name'],
                    'counts' => $query->result_array()
                ];
    
                $results[] = $result_item;
            }
        }
    
        return $results;
    }
    
    

}

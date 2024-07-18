<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loan_product_model extends CI_Model
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

    public function getAllUniqueLoanTypes()
    {
        $this->db->distinct();
        $this->db->select('lm.loan_name');
        $this->db->from('tbl_loan lm');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getLoanStatus($start_date, $end_date, $process, $loan_type, $location)
    {
        $results = [];
        foreach ($loan_type as $status) {
            $this->db->select('DATE(lm.created_date) as date, lm.loan_type, COUNT(*) as status_count');
            $this->db->from('lead_master_all lm');
            $this->db->join('request_to_lead_transfer_all r', 'r.lead_id = lm.enq_id');
            $this->db->where('r.location', $location);
            $this->db->where('lm.loan_type', $status['loan_name']);
            $this->db->where('lm.created_date >=', $start_date);
            $this->db->where('lm.created_date <=', $end_date);
            $this->db->where('lm.process', $process->process_name);
            $this->db->group_by('DATE(lm.created_date), lm.loan_type');
            $query = $this->db->get();
            if (!$query) {
                echo 'Query Error: ' . $this->db->error()['message'];
                return false;
            }
            $result = $query->result_array();    
            $result_item = [
                'loan_type' => $status['loan_name'],
                'counts' => $result
            ];
            $results[] = $result_item;
        }
    
        return $results;
    }
}

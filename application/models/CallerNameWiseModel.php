
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CallerNameWiseModel extends CI_Model
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

    public function getAllUniqueCaller($process_id)
    {
        $this->db->distinct();
        $this->db->select("CONCAT(fname, ' ', lname) as name", false);
        $this->db->from('lmsuser');
        $this->db->join('tbl_manager_process tp','tp.user_id = lmsuser.id');
        $this->db->where('tp.process_id',$process_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCallerStatus($start_date, $end_date, $process, $all_caller_name, $location)
    {
        $results = [];
        foreach ($all_caller_name as $status) {
            $this->db->select('DATE(lm.created_date) AS date, CONCAT(u.fname, " ", u.lname) AS name, COUNT(*) AS status_count');
            $this->db->from('lmsuser u');
            $this->db->join('lead_master lm', 'CONCAT(u.fname, " ", u.lname) = lm.name');
            $this->db->join('request_to_lead_transfer_all r', 'r.lead_id = lm.enq_id');
            $this->db->where('lm.process', $process->process_name);
            $this->db->where('CONCAT(u.fname, " ", u.lname) LIKE', '%' . $status['name'] . '%');
            $this->db->where('r.location', $location);
            $this->db->where('lm.created_date >=', $start_date);
            $this->db->where('lm.created_date <=', $end_date);
            $this->db->group_by('DATE(lm.created_date), CONCAT(u.fname, " ", u.lname)');
            $query = $this->db->get();
            if (!$query) {
                echo 'Query Error: ' . $this->db->error()['message'];
                return false;
            }
            $result = $query->result_array();    
            $result_item = [
                'callername' => $status['name'],
                'counts' => $result
            ];
            $results[] = $result_item;
        }
    
        return $results;
    }
    
}

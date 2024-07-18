<?php
defined('BASEPATH') or exit('No direct script access allowed');
class EDMSModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLeadsByMobileNoAndDateRange($mobile_no, $from_date, $to_date)
    {
        $this->db->select('contact_no, created_date');
        $this->db->from('lead_master');
        $this->db->where('contact_no', $mobile_no);
        $this->db->where('created_date >=', date('Y-m-d', strtotime($from_date)));
        $this->db->where('created_date <=', date('Y-m-d', strtotime($to_date)));
        $this->db->order_by('created_date', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }    

    public function updateEdmsStatus($contact_no, $new_status)
    {
        $this->db->where('contact_no', $contact_no);
        $this->db->where('edms_status', '');
        $this->db->update('lead_master', array('edms_status' => $new_status));
    }
}

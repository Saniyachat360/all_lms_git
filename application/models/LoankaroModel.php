<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LoankaroModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function countAllLoanDetails()
    {
        return $this->db->count_all('lead_master_all');
    }

    public function getLoanDetails($limit, $offset)
    {
        $this->db->select("l.enq_id as sr_no, l.lead_source, CONCAT_WS(' ', ucse.fname, ucse.lname) AS customer_name, l.contact_no AS phone_number, CONCAT_WS(' ', ucsetl.fname, ucsetl.lname) AS caller_name, l.feedbackStatus AS disposition, l.enquiry_for AS product, l.assign_to_dse AS bank_nbfc, l.nextAction AS status, l.loanamount, f1.date AS call_date, f1.comment AS customer_remark, f1.nextfollowupdate AS followup_1_date, f1.nextfollowuptime AS followup_1_remark, f2.date AS followup_2_date, f2.comment AS followup_2_remark, l.old_make AS manufacture, l.old_model AS model, l.chasis_no, l.model_id AS new_car_model, l.variant_id AS new_car_variant, l.reg_no, f2.comment AS remark");
        $this->db->from('lead_master_all l');
        $this->db->join('lead_followup_all f1', 'f1.id = l.cse_followup_id', 'left');
        $this->db->join('lmsuser ucsetl', 'ucsetl.id = l.assign_by_cse_tl', 'left');
        $this->db->join('lmsuser ucse', 'ucse.id = l.assign_to_cse', 'left');
        $this->db->join('lead_followup_all f2', 'f2.id = l.dse_followup_id', 'left');
        $this->db->join('lmsuser udsetl', 'udsetl.id = l.assign_to_dse_tl', 'left');
        $this->db->join('lmsuser udse', 'udse.id = l.assign_to_dse', 'left');
        $this->db->where('l.process', 'Finance');
        $this->db->order_by('l.enq_id', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
}

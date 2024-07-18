<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_dse_model extends CI_Model
{
    public $process_name;
    public $role;
    public $user_id;
    public $location;

    public function __construct()
    {
        parent::__construct();
        //Session Values
        $this->today = date('Y-m-d');
        $this->process_name = $this->session->userdata('process_name');
        $this->role = $this->session->userdata('role');
        $this->user_id = $this->session->userdata('user_id');
        $this->process_id = $this->session->userdata('process_id');
        $this->location = $this->session->userdata('location');
        $this->location_id = $this->session->userdata('location_id');
        //Select Table		
        $this->table_name = 'lead_master l';
        $this->table_name1 = 'lead_followup f';

        $this->tl_role = array("CSE Team Leader", "DSE Team Leader", "Service TL", "Insurance TL", "Accessories TL", "Finance TL", "Evaluation Team Leader");
        $this->executive_role = array("CSE", "DSE", "Service Excecutive", "Insurance Executive", "Accessories Executive", "Finance Executive", "Evaluation Executive");
    }

    public function select_location()
    {
        $this->db->select('l.location_id,l.location');
        $this->db->from('tbl_location l');
        $this->db->join('tbl_manager_process p', 'p.location_id=l.location_id');
        $this->db->where('p.process_id', $this->process_id);
        $this->db->where('p.user_id', $this->user_id);
        $this->db->where('p.status !=', '-1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function fetch_tl()
    {
        $this->db->select('DISTINCT(u.fname),concat(u.fname," ",u.lname) as tl_name,u.id ');
        $this->db->from('lmsuser u');
        $this->db->join('tbl_manager_process m', 'm.user_id=u.id');
        $this->db->join('tbl_mapdse d', 'd.tl_id=u.id');

        if ($this->role == 5) {
            $this->db->where('d.tl_id', $_SESSION['user_id']);
        }
        if ($this->role == 4) {
            $this->db->where('u.id', $_SESSION['user_id']);
        }
        $this->db->where('u.id!=', 1);
        $this->db->where('u.status', 1);
        $this->db->order_by('u.fname', 'asc');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    function select_tl()
    {
        $location = $this->input->post('location');
        $this->db->select(' DISTINCT(u.fname),concat(u.fname," ",u.lname) as tl_name,u.id,d.tl_id');
        $this->db->from('lmsuser u');
        $this->db->join('tbl_manager_process m', 'm.user_id=u.id');
        $this->db->join('tbl_mapdse d', 'd.tl_id=u.id');
        $this->db->where('m.location_id', $location);
        if ($this->role == 5) {
            $this->db->where('d.tl_id', $_SESSION['user_id']);
        }
        if ($this->role == 4) {
            $this->db->where('u.id', $_SESSION['user_id']);
        }
        $this->db->where('u.id!=', 1);
        $this->db->where('u.status', 1);
        $this->db->order_by('u.fname', 'asc');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    function select_dse()
    {
        $location = $this->input->post('location');
        $tl_id = $this->input->post('tl_id');
        $this->db->select('concat(u.fname," ",u.lname) as dse_name,u.id');
        $this->db->from('lmsuser u');
        $this->db->join('tbl_manager_process m', 'm.user_id=u.id');
        $this->db->join('tbl_mapdse d', 'd.dse_id=u.id');
        $this->db->where('m.location_id', $location);
        $this->db->where('d.tl_id', $tl_id);
        if ($this->role == 5) {
            $this->db->where('d.tl_id', $_SESSION['user_id']);
        }
        if ($this->role == 4) {
            $this->db->where('u.id', $_SESSION['user_id']);
        }
        $this->db->where('u.id!=', 1);
        if ($this->process_id == 8) {
            $this->db->where('u.role', 16);
        } else {
            $this->db->where('u.role', 4);
        }

        $this->db->where('u.status', 1);
        $this->db->order_by('u.fname', 'asc');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    public function total_leads($from_date, $to_date, $date_type)
    {
        $date_type = $date_type;
        $from_date = $from_date;
        $to_date = $to_date;
        $tl_id = $this->input->post('tl_id');
        $dse_id = $this->input->post('dse_id');
        $location_name = $this->input->post('location_name');

        $this->db->select('count(enq_id) as total_leads');
        $this->db->from('lead_master');

        $this->db->where('location', $location_name);

        if ($tl_id != '') {
            $this->db->where('assign_to_dse_tl', $tl_id);
        }

        if ($dse_id != '') {
            $this->db->where('assign_to_dse', $dse_id);
        }

        if ($from_date != '') {
            $this->db->where('created_date>=', $from_date);
            $this->db->where('created_date<=', $to_date);
        }

        if ($date_type == 'As on date') {
            $this->db->where('created_date>=', $from_date);
            $this->db->where('created_date<=', $to_date);
        }

        $query = $this->db->get();
        $query1 = $query->result();
        $total_leads = $query1[0]->total_leads;
        // echo $this->db->last_query();
        return $total_leads;
    }

    public function assign_leads($from_date, $to_date, $date_type)
    {
        $date_type = $this->input->post('date_type');
        $from_date = $from_date;
        $to_date = $to_date;
        $tl_id = $this->input->post('tl_id');
        $dse_id = $this->input->post('dse_id');
        $location_name = $this->input->post('location_name');

        $this->db->select('count(enq_id) as assign_lead');
        $this->db->from('lead_master');

        $this->db->where('location', $location_name);

        if ($tl_id != '') {
            $this->db->where('assign_to_dse_tl', $tl_id);
        }

        if ($dse_id != '') {
            $this->db->where('assign_to_dse', $dse_id);
        }

        if ($from_date != '') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }

        if ($date_type == 'As on date') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }
        $query = $this->db->get();
        $query2 = $query->result();
        $assign_lead = $query2[0]->assign_lead;
        // echo $this->db->last_query();
        return $assign_lead;
    }


    public function pending_new_leads($from_date, $to_date, $date_type)
    {
        $date_type = $this->input->post('date_type');
        $from_date = $from_date;
        $to_date = $to_date;
        $tl_id = $this->input->post('tl_id');
        $dse_id = $this->input->post('dse_id');
        $location_name = $this->input->post('location_name');

        $today = date('Y-m-d');
        $this->db->select('count(distinct l.enq_id) as pending_new_leads');
        $this->db->from('lead_master as l');
        $this->db->where('l.nextAction!=', "Close");

        $this->db->where('location', $location_name);
        $this->db->where('dse_followup_id', 0);
        if ($tl_id != '') {
            $this->db->where('assign_to_dse_tl', $tl_id);
        }

        if ($dse_id != '') {
            $this->db->where('assign_to_dse', $dse_id);
        }

        if ($from_date != '') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }

        if ($date_type == 'As on date') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }


        $query = $this->db->get();
        $query3 = $query->result();
        $pending_new_leads = $query3[0]->pending_new_leads;
        //echo $this->db->last_query();
        return $pending_new_leads;
    }


    public function pending_followup_leads($from_date, $to_date, $date_type)
    {
        $date_type = $this->input->post('date_type');
        $from_date = $from_date;
        $to_date = $to_date;
        $tl_id = $this->input->post('tl_id');
        $dse_id = $this->input->post('dse_id');
        $location_name = $this->input->post('location_name');
        $today = date('Y-m-d');

        $this->db->select('count(distinct l.enq_id) as pending_followup_leads');

        $this->db->from('lead_master as l');
        $this->db->join('lead_followup as f', 'l.dse_followup_id=f.id');
        if ($tl_id != '') {
            $this->db->where('assign_to_dse_tl', $tl_id);
        }

        if ($dse_id != '') {
            $this->db->where('assign_to_dse', $dse_id);
        }

        if ($from_date != '') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }
        $this->db->where('l.process', $this->process_name);
        $this->db->where('l.assign_to_dse_date>=', $from_date);
        $this->db->where('l.assign_to_dse_date<=', $to_date);
        $this->db->where('f.nextfollowupdate <', $today);
        $this->db->where('f.nextfollowupdate!=', '0000-00-00');
        $this->db->where('l.nextAction!=', "Close");

        $query = $this->db->get();
        $query = $query->result();
        $pending_followup_leads = $query[0]->pending_followup_leads;
       // echo $this->db->last_query();
        return $pending_followup_leads;
    }

    public function gap_beetween_first_call($from_date, $to_date, $date_type)
    {
        $date_type = $this->input->post('date_type');
        $from_date = $from_date;
        $to_date = $to_date;
        $tl_id = $this->input->post('tl_id');
        $dse_id = $this->input->post('dse_id');
        $location_name = $this->input->post('location_name');
        $today = date('Y-m-d');

        $this->db->select('count(distinct l.enq_id) as gap_beetween_first_call');

        $this->db->from('lead_master as l');
        $this->db->join('lead_followup as f', 'l.dse_followup_id=f.id');
        if ($tl_id != '') {
            $this->db->where('assign_to_dse_tl', $tl_id);
        }

        if ($dse_id != '') {
            $this->db->where('assign_to_dse', $dse_id);
        }

        if ($from_date != '') {
            $this->db->where('assign_to_dse_date>=', $from_date);
            $this->db->where('assign_to_dse_date<=', $to_date);
        }
        $this->db->where('l.process', $this->process_name);
        $this->db->where('l.assign_to_dse_date>=', $from_date);
        $this->db->where('l.assign_to_dse_date<=', $to_date);
        $this->db->where('l.nextAction!=', "Close"); 

        $query = $this->db->get();
        $query = $query->result();
        $gap_beetween_first_call = $query[0]->gap_beetween_first_call;
        //echo $this->db->last_query();
        return $gap_beetween_first_call;
    }

}

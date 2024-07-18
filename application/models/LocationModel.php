<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LocationModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_locations_by_city($city)
    {
        $this->db->select('location_id, location');
        $this->db->from('tbl_location');
        $this->db->where('city', $city);
        $this->db->where('location NOT LIKE', '%Workshop%');
        $this->db->order_by('location', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProcessName($process_id)
    {
        $this->db->select('process_id,process_name');
        $this->db->from('tbl_process');
        $this->db->where('process_id', $process_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLocation($location_id)
    {
        $this->db->select('location');
        $this->db->from('tbl_location');
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeadCount($process, $location, $start_date, $end_date)
    {
        $this->db->select("DATE(lead_master.created_date) as date, COUNT(DISTINCT lead_master.enq_id) as lead_count");
        $this->db->from("lead_master");
        $this->db->join("request_to_lead_transfer", "lead_master.enq_id = request_to_lead_transfer.lead_id", "left");
        $this->db->where("request_to_lead_transfer.location", $location[0]->location);
        $this->db->where("request_to_lead_transfer.created_date >=", $start_date);
        $this->db->where("request_to_lead_transfer.created_date <=", $end_date);
        $this->db->where("lead_master.process", $process[0]->process_name);
        $this->db->group_by("DATE(lead_master.created_date)");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getConnectedCount($process, $location, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(DISTINCT lf.id) AS connected_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("request_to_lead_transfer rtlt", "rtlt.lead_id = lf.leadid");
        $this->db->where("lf.contactibility", "Connected");
        $this->db->where("rtlt.location", $location[0]->location);
        $this->db->where("lm.process", $process[0]->process_name);
        $this->db->where("lf.date >=", $start_date);
        $this->db->where("lf.date <=", $end_date);
        $this->db->group_by("DATE(lf.date), rtlt.lead_id");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getInterestedCount($process, $location, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(DISTINCT lf.id) AS interested_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("request_to_lead_transfer rtlt", "rtlt.lead_id = lf.leadid");
        $this->db->where("lf.feedbackStatus", "Interested");
        $this->db->where("rtlt.location", $location[0]->location);
        $this->db->where("lm.process", $process[0]->process_name);
        $this->db->where("lf.date >=", $start_date);
        $this->db->where("lf.date <=", $end_date);
        $this->db->group_by("DATE(lf.date), rtlt.lead_id");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTestDriveCount($process, $location, $start_date, $end_date)
    {
        $this->db->select("DATE(lf.date) AS date, COUNT(DISTINCT lf.id) AS testdrive_count");
        $this->db->from("lead_followup lf");
        $this->db->join("lead_master lm", "lf.leadid = lm.enq_id");
        $this->db->join("request_to_lead_transfer rtlt", "rtlt.lead_id = lf.leadid");
        $this->db->where("lf.nextAction", "Test Drive");
        $this->db->where("rtlt.location", $location[0]->location);
        $this->db->where("lm.process", $process[0]->process_name);
        $this->db->where("lf.date >=", $start_date);
        $this->db->where("lf.date <=", $end_date);
        $this->db->group_by("DATE(lf.date), rtlt.lead_id");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getBookedCount($process, $location, $start_date, $end_date)
    {
        $this->db->select('DATE(lm.created_date) as date, 
        COUNT(DISTINCT lm.contact_no) as booked_count');
        $this->db->from('lead_followup lf');
        $this->db->join('lead_master lm', 'lf.leadid = lm.enq_id');
        $this->db->join('request_to_lead_transfer rtlt', 'rtlt.lead_id = lf.leadid');
        $this->db->where('lm.process', $process[0]->process_name);
        $this->db->where('lm.created_date >=', $start_date);
        $this->db->where('lm.created_date <=', $end_date);
        $this->db->where('lm.edms_status IS NOT NULL');
        $this->db->where('rtlt.location', $location[0]->location);
        $this->db->group_by('DATE(lm.created_date), rtlt.lead_id');
        $query = $this->db->get();
        return $query->result_array();
    }
}

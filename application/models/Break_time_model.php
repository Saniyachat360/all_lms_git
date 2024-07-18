<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Break_time_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->process_id = $_SESSION['process_id'];
        $this->location_id = $_SESSION['location_id'];
        $this->role = $this->session->userdata('role');
        $this->user_id = $this->session->userdata('user_id');
        date_default_timezone_set('Asia/Calcutta'); 
    }
  
    function insert()
    {
        $lunchStart = $this->input->post('lunchStart');
        $lunchEnd = $this->input->post('lunchEnd');
        $teaStart = $this->input->post('teaStart');
        $teaEnd = $this->input->post('teaEnd');
        $emergencyStart = $this->input->post('emergencyStart');
        $emergencyEnd = $this->input->post('emergencyEnd');
        $user_id = $this->session->userdata('user_id');
        $created_date = date("Y-m-d");

        // Lunch Break Start
        if ($lunchStart != '') {

            $this->db->select('user_id, start_lunchbreak, end_lunchbreak, start_teabreak, end_teabreak, created_date');
            $this->db->from('tbl_break_time');
            $this->db->where('user_id', $user_id);
            $this->db->where('created_date', $created_date);
            $query = $this->db->get();
            $lunchStartSelectQuery = $query->num_rows();

            if ($lunchStartSelectQuery > 0) {
                $teaStartUpdateQuery = $this->db->query("UPDATE tbl_break_time SET start_lunchbreak = '$lunchStart' where user_id='$user_id' AND created_date='$created_date'");
                if ($teaStartUpdateQuery > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lunch Break Start Time Updated Successfully...!</strong>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lunch Break Start Time Not Updated...!</strong>');
                }
            } else {
                $lunchStartInsertQuery = $this->db->query('INSERT INTO tbl_break_time( `user_id` , `start_lunchbreak` ,`end_lunchbreak`, `start_teabreak` , `end_teabreak` , 
                `em_break_start_1`, `em_break_end_1`, `em_break_start_2`, `em_break_end_2`, `em_break_start_3`, `em_break_end_3`, 
                `em_break_start_4`, `em_break_end_4`, `em_break_start_5`, `em_break_end_5`, `em_break_start_6`, `em_break_end_6`,
                `em_break_start_7`, `em_break_end_7`, `em_break_start_8`, `em_break_end_8`, `em_break_start_9`,`em_break_end_9`,
                `em_break_start_10`,`em_break_end_10`,  `created_date`)  VALUES("' . $user_id . '","' . $lunchStart . '","00:00:00", "00:00:00", "00:00:00",
                "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00",
                "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "' . $created_date . '")');
                if (count($lunchStartInsertQuery) > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lunch Break Start Time Inserted Successfully...!</strong>');
                }
            }
            $b_id = $this->db->insert_id();
        }


        // Lunch Break End
        if ($lunchStart == '' && $lunchEnd != '') {

            $lunchEndUpdateQuery = $this->db->query("UPDATE tbl_break_time SET end_lunchbreak = '$lunchEnd' where user_id='$user_id' AND created_date='$created_date'");

            if ($lunchEndUpdateQuery == 1) {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lunch Break End Time Updated Successfully...!</strong>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lunch Break End Time Not Updated...!</strong>');
            }
        }



        // Tea Break Start
        if ($lunchStart == '' && $lunchEnd == '' && $teaStart != '') {

            $this->db->select('user_id, start_lunchbreak, end_lunchbreak, start_teabreak, created_date');
            $this->db->from('tbl_break_time');
            $this->db->where('user_id', $user_id);
            $this->db->where('created_date', $created_date);
            $query = $this->db->get();
            $teaStartSelectQuery = $query->num_rows();

            if ($teaStartSelectQuery > 0) {

                $teaStartUpdateQuery = $this->db->query("UPDATE tbl_break_time SET start_teabreak = '$teaStart' where user_id='$user_id' AND created_date='$created_date'");

                if ($teaStartUpdateQuery > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Tea Break Start Time Updated Successfully...!</strong>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Tea Break Start Time Not Updated...!</strong>');
                }
            } else {
                $teaStartInsertQuery = $this->db->query('INSERT INTO tbl_break_time( `user_id` , `start_lunchbreak` ,`end_lunchbreak`, `start_teabreak` , `end_teabreak` , `created_date`)  VALUES("' . $user_id . '","00:00:00", "00:00:00","' . $teaStart . '","00:00:00","' . $created_date . '")');

                if ($teaStartInsertQuery > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Tea Break Start Time Inserted Successfully...!</strong>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Tea Break Start Time Not Inserted...!</strong>');
                }
            }
        }


        // Tea Break End
        if ($lunchStart == '' && $lunchEnd == '' && $teaStart == '' && $teaEnd != '') {

            $teaEndUpdateQuery = $this->db->query("UPDATE tbl_break_time SET end_teabreak = '$teaEnd' where user_id='$user_id' AND created_date='$created_date'");

            if ($teaEndUpdateQuery > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Tea Break End Time Updated Successfully...!</strong>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Tea Break End Time Not Updated...!</strong>');
            }
        }



        // Emergency Break Start
        if ($lunchStart == '' && $lunchEnd == '' && $teaStart == '' && $teaEnd == '' && $emergencyStart != '') {
            $user_id = $this->session->userdata('user_id');
            $created_date = date("Y-m-d");
            $this->db->select('user_id,start_lunchbreak, end_lunchbreak, start_teabreak, end_teabreak, created_date,
            em_break_start_1, em_break_end_1, em_break_start_2, em_break_end_2, em_break_start_3, em_break_end_3, 
            em_break_start_4, em_break_end_4, em_break_start_5, em_break_end_5, em_break_start_6, em_break_end_6, 
            em_break_start_7, em_break_end_7, em_break_start_8, em_break_end_8, em_break_start_9, em_break_end_9, 
            em_break_start_10, em_break_end_10');
            $this->db->from('tbl_break_time');
            $this->db->where('user_id', $user_id);
            $this->db->where('created_date', $created_date);
            $query = $this->db->get();
            $query->result();
            $row = $query->row();

            if (isset($query)) {
                foreach ($query->result_array() as $row) {
                    $lunch_start = $row['start_lunchbreak'];
                    $lunch_end = $row['end_lunchbreak'];
                    $tea_start = $row['start_teabreak'];
                    $tea_end = $row['end_teabreak'];
                    $em_break_start_1 = $row['em_break_start_1'];
                    $em_break_end_1 = $row['em_break_end_1'];
                    $em_break_start_2 = $row['em_break_start_2'];
                    $em_break_end_2 = $row['em_break_end_2'];
                    $em_break_start_3 = $row['em_break_start_3'];
                    $em_break_end_3 = $row['em_break_end_3'];
                    $em_break_start_4 = $row['em_break_start_4'];
                    $em_break_end_4 = $row['em_break_end_4'];
                    $em_break_start_5 = $row['em_break_start_5'];
                    $em_break_end_5 = $row['em_break_end_5'];
                    $em_break_start_6 = $row['em_break_start_6'];
                    $em_break_end_6 = $row['em_break_end_6'];
                    $em_break_start_7 = $row['em_break_start_7'];
                    $em_break_end_7 = $row['em_break_end_7'];
                    $em_break_start_8 = $row['em_break_start_8'];
                    $em_break_end_8 = $row['em_break_end_8'];
                    $em_break_start_9 = $row['em_break_start_9'];
                    $em_break_end_9 = $row['em_break_end_9'];
                    $em_break_start_10 = $row['em_break_start_10'];
                    $em_break_end_10 = $row['em_break_end_10'];
                }
                if (!isset($lunch_start) || empty($lunch_start) || $lunch_start == "") {
                    $emStartinsrtQuery = $this->db->query('INSERT INTO tbl_break_time( 
                    `user_id` , `start_lunchbreak` ,`end_lunchbreak`, `start_teabreak` , `end_teabreak` , 
                    `em_break_start_1`, `em_break_end_1`, `em_break_start_2`, `em_break_end_2`, `em_break_start_3`, `em_break_end_3`, 
                    `em_break_start_4`, `em_break_end_4`, `em_break_start_5`, `em_break_end_5`, `em_break_start_6`, `em_break_end_6`,
                    `em_break_start_7`, `em_break_end_7`, `em_break_start_8`, `em_break_end_8`, `em_break_start_9`,`em_break_end_9`,
                    `em_break_start_10`,`em_break_end_10`,  `created_date`)  VALUES("' . $user_id . '", "00:00:00", "00:00:00", "00:00:00", "00:00:00",
                    "' . $emergencyStart . '", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00",
                    "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "' . $created_date . '")');
                } elseif ($em_break_start_1 == "00:00:00") {
                    $emStartUpdateQuery_1 = $this->db->query("UPDATE tbl_break_time SET em_break_start_1 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_2 == "00:00:00") {
                    $emStartUpdateQuery_2 = $this->db->query("UPDATE tbl_break_time SET em_break_start_2 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_3 == "00:00:00") {
                    $emStartUpdateQuery_3 = $this->db->query("UPDATE tbl_break_time SET em_break_start_3 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_4 == "00:00:00") {
                    $emStartUpdateQuery_4 = $this->db->query("UPDATE tbl_break_time SET em_break_start_4 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_5 == "00:00:00") {
                    $emStartUpdateQuery_5 = $this->db->query("UPDATE tbl_break_time SET em_break_start_5 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_6 == "00:00:00") {
                    $emStartUpdateQuery_6 = $this->db->query("UPDATE tbl_break_time SET em_break_start_6 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_7 == "00:00:00") {
                    $emStartUpdateQuery_7 = $this->db->query("UPDATE tbl_break_time SET em_break_start_7 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_8 == "00:00:00") {
                    $emStartUpdateQuery_8 = $this->db->query("UPDATE tbl_break_time SET em_break_start_8 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_9 == "00:00:00") {
                    $emStartUpdateQuery_9 = $this->db->query("UPDATE tbl_break_time SET em_break_start_9 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_start_10 == "00:00:00") {
                    $emStartUpdateQuery_10 = $this->db->query("UPDATE tbl_break_time SET em_break_start_10 = '$emergencyStart' WHERE user_id='$user_id' AND created_date = '$created_date'");
                }

                if ($emStartinsrtQuery > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Emergency Break Start Time Inserted Successfully...!</strong>');
                } elseif (
                    isset($emStartUpdateQuery_1) > 0 || isset($emStartUpdateQuery_2) > 0 || isset($emStartUpdateQuery_3) > 0 || isset($emStartUpdateQuery_4) > 0 ||
                    isset($emStartUpdateQuery_5) > 0 || isset($emStartUpdateQuery_6) > 0 || isset($emStartUpdateQuery_7) > 0 || isset($emStartUpdateQuery_8) > 0 ||
                    isset($emStartUpdateQuery_9) > 0 || isset($emStartUpdateQuery_10) > 0
                ) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Emergency Break Start Time Updated Successfully...!</strong>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Emergency Break Start Time Not Updated...!</strong>');
                }
            }
        }


        // Emergency Break End
        if ($lunchStart == '' && $lunchEnd == '' && $teaStart == '' && $teaEnd == '' && $emergencyStart == '' && $emergencyEnd != '') {

            $user_id = $this->session->userdata('user_id');
            $created_date = date("Y-m-d");
            $this->db->select('user_id,start_lunchbreak, end_lunchbreak, start_teabreak, end_teabreak, created_date,
            em_break_start_1, em_break_end_1, em_break_start_2, em_break_end_2, em_break_start_3, em_break_end_3, 
            em_break_start_4, em_break_end_4, em_break_start_5, em_break_end_5, em_break_start_6, em_break_end_6, 
            em_break_start_7, em_break_end_7, em_break_start_8, em_break_end_8, em_break_start_9, em_break_end_9, 
            em_break_start_10, em_break_end_10');
            $this->db->from('tbl_break_time');
            $this->db->where('user_id', $user_id);
            $this->db->where('created_date', $created_date);
            $query = $this->db->get();
            $query->result();
            $row = $query->row();

            if (isset($query)) {
                foreach ($query->result_array() as $row) {
                    $lunch_start = $row['start_lunchbreak'];
                    $lunch_end = $row['end_lunchbreak'];
                    $tea_start = $row['start_teabreak'];
                    $tea_end = $row['end_teabreak'];
                    $em_break_start_1 = $row['em_break_start_1'];
                    $em_break_end_1 = $row['em_break_end_1'];
                    $em_break_start_2 = $row['em_break_start_2'];
                    $em_break_end_2 = $row['em_break_end_2'];
                    $em_break_start_3 = $row['em_break_start_3'];
                    $em_break_end_3 = $row['em_break_end_3'];
                    $em_break_start_4 = $row['em_break_start_4'];
                    $em_break_end_4 = $row['em_break_end_4'];
                    $em_break_start_5 = $row['em_break_start_5'];
                    $em_break_end_5 = $row['em_break_end_5'];
                    $em_break_start_6 = $row['em_break_start_6'];
                    $em_break_end_6 = $row['em_break_end_6'];
                    $em_break_start_7 = $row['em_break_start_7'];
                    $em_break_end_7 = $row['em_break_end_7'];
                    $em_break_start_8 = $row['em_break_start_8'];
                    $em_break_end_8 = $row['em_break_end_8'];
                    $em_break_start_9 = $row['em_break_start_9'];
                    $em_break_end_9 = $row['em_break_end_9'];
                    $em_break_start_10 = $row['em_break_start_10'];
                    $em_break_end_10 = $row['em_break_end_10'];
                }

                if ($em_break_end_1 == "00:00:00") {
                    $emendUpdateQuery_1 = $this->db->query("UPDATE tbl_break_time SET em_break_end_1 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_2 == "00:00:00") {
                    $emendUpdateQuery_2 = $this->db->query("UPDATE tbl_break_time SET em_break_end_2 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_3 == "00:00:00") {
                    $emendUpdateQuery_3 = $this->db->query("UPDATE tbl_break_time SET em_break_end_3 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_4 == "00:00:00") {
                    $emendUpdateQuery_4 = $this->db->query("UPDATE tbl_break_time SET em_break_end_4 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_5 == "00:00:00") {
                    $emendUpdateQuery_5 = $this->db->query("UPDATE tbl_break_time SET em_break_end_5 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_6 == "00:00:00") {
                    $emendUpdateQuery_6 = $this->db->query("UPDATE tbl_break_time SET em_break_end_6 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_7 == "00:00:00") {
                    $emendUpdateQuery_7 = $this->db->query("UPDATE tbl_break_time SET em_break_end_7 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_8 == "00:00:00") {
                    $emendUpdateQuery_8 = $this->db->query("UPDATE tbl_break_time SET em_break_end_8 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_9 == "00:00:00") {
                    $emendUpdateQuery_9 = $this->db->query("UPDATE tbl_break_time SET em_break_end_9 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                } elseif ($em_break_end_10 == "00:00:00") {
                    $emendUpdateQuery_10 = $this->db->query("UPDATE tbl_break_time SET em_break_end_10 = '$emergencyEnd' WHERE user_id='$user_id' AND created_date = '$created_date'");
                }

                if (
                    isset($emendUpdateQuery_1) > 0 || isset($emendUpdateQuery_2) > 0 || isset($emendUpdateQuery_3) > 0 || isset($emendUpdateQuery_4) > 0 ||
                    isset($emendUpdateQuery_5) > 0 || isset($emendUpdateQuery_6) > 0 || isset($emendUpdateQuery_7) > 0 || isset($emendUpdateQuery_8) > 0 ||
                    isset($emendUpdateQuery_9) > 0 || isset($emendUpdateQuery_10) > 0
                ) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Emergency Break End Time Updated Successfully...!</strong>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Emergency Break End Time Not Updated...!</strong>');
                }
            }
        }
    }




    function get_break_time()
    {
        $user_id = $this->session->userdata('user_id');
        $created_date = date("Y-m-d");
        $this->db->select('user_id,start_lunchbreak, end_lunchbreak, start_teabreak, end_teabreak, created_date,
        em_break_start_1, em_break_end_1, em_break_start_2, em_break_end_2, em_break_start_3, em_break_end_3, 
        em_break_start_4, em_break_end_4, em_break_start_5, em_break_end_5, em_break_start_6, em_break_end_6, 
        em_break_start_7, em_break_end_7, em_break_start_8, em_break_end_8, em_break_start_9, em_break_end_9, 
        em_break_start_10, em_break_end_10');
        $this->db->from('tbl_break_time');
        $this->db->where('user_id', $user_id);
        $this->db->where('created_date', $created_date);
        $query = $this->db->get();
        return $query->result();
    }

    function get_emg_break_time()
    {
        $user_id = $this->session->userdata('user_id');
        $created_date = date("Y-m-d");
        $this->db->select('user_id, start_embreak, end_embreak, em_date');
        $this->db->from('tbl_emergencybreak');
        $this->db->where('user_id', $user_id);
        $this->db->where('em_date', $created_date);
        $query = $this->db->get();
        return $query->result();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Bank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('Bank_model');
    }

    public function session()
    {
        if ($this->session->userdata('username') == "") {
            redirect('login/logout');
        }
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $city = $this->input->post('city');
            $process_id = $this->session->userdata('process_id');
            $process = $this->Bank_model->getProcessName($process_id);
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            if ($city === 'mumbai' || $city === 'pune') {
                $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
            } else {
                $location = 'Mumbai Call Center';
            }
            $all_bank = $this->Bank_model->getAllBank();
            $bank_report = $this->Bank_model->getCallStatus($start_date,$end_date,$process,$location,$all_bank,$city);
            $dates = $this->datesBetween($start_date, $end_date);
            $response = [
                'success' => true,
                'getalluniquebank' => $all_bank,
                'bank_report' => $bank_report,
                'dates' => $dates,
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $this->session();
            $this->load->view('include/admin_header.php');
            $process_id = $this->session->userdata('process_id');
            $process = $this->Bank_model->getProcessName($process_id);
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            $dates = $this->datesBetween($start_date, $end_date);
            $all_bank = $this->Bank_model->getAllBank();
            $bank_report = $this->Bank_model->getCallStatus($start_date,$end_date,$process,"Mumbai Call Center",$all_bank);
            $this->load->view('bank_view.php', [
                'getalluniquebank' => $all_bank,
                'bank_report' => $bank_report,
                'dates' => $dates,
            ]);
            $this->load->view('include/footer.php');
        }
    }

    public function filterSubmissionProcesses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('fromdate', 'Start Date', 'required');
            $this->form_validation->set_rules('todate', 'End Date', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                $response = ['success' => false, 'errors' => $errors];
            } else {
                $start_date = $this->input->post('fromdate');
                $end_date = $this->input->post('todate');
                $process_id = $this->session->userdata('process_id');
                $process = $this->Bank_model->getProcessName($process_id);
                $start_date_timestamp = strtotime($start_date);
                $end_date_timestamp = strtotime($end_date);
                $city = $this->input->post('mumbai') ? 'mumbai' : ($this->input->post('pune') ? 'pune' : 'mumbai');
                if ($city === 'mumbai' || $city === 'pune') {
                    $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
                } else {
                    $location = 'Mumbai Call Center';
                }
                if ($start_date_timestamp >= $end_date_timestamp) {
                    $errors = ['Invalid date range. Start date must be before end date.'];
                    $response = ['success' => false, 'errors' => $errors];
                } else {
                    $getallfeedbackstatus = $this->Bank_model->getAllBank();
                    $valid_feedbackstatus = array_filter($getallfeedbackstatus, function ($status) {
                        return isset($status['bank_name']);
                    });
                    $dates = $this->datesBetween($start_date, $end_date);
                    $results = [];
                    $call_status_count_connected = $this->Bank_model->getCallStatus($start_date, $end_date,$process,$location,$valid_feedbackstatus);
                    foreach ($valid_feedbackstatus as $status) {
                        $bank_data = ['bank_name' => $status['bank_name']];
                        foreach ($dates as $date) {
                            $bank_data[$date] = 0;
                        }
                        if (isset($call_status_count_connected[$status['bank_name']])) {
                            foreach ($call_status_count_connected[$status['bank_name']]['counts'] as $data) {
                                if (in_array($data['date'], $dates)) {
                                    $bank_data[$data['date']] = $data['status_count'];
                                }
                            }
                        }
                        $results[] = $bank_data;
                    }
                    $response = [
                        'success' => true,
                        'results' => $results,
                        'dates' => $dates,
                    ];
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }


    private function datesBetween($start_date, $end_date)
    {
        $dates = [];
        $current_date = strtotime($start_date);
        $end_date = strtotime($end_date);
        while ($current_date <= $end_date) {
            $dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }
        return $dates;
    }
}

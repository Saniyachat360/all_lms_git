<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Call_Status extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('Call_StatusModel');
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
            $process = $this->Call_StatusModel->getProcessName($process_id);
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            if ($city === 'mumbai' || $city === 'pune') {
                $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
            } else {
                $location = 'Mumbai Call Center';
            }
            $unique_feedback_statuses = $this->Call_StatusModel->getAllUniqueFeedbackStatus($process_id);
            $call_status_count_connected = $this->getInitialConnectedCallStatusData($process, $location);
            $call_status_count_not_connected = $this->getInitialNotConnectedCallStatusData($process, $location);
            $dates = $this->datesBetween($start_date, $end_date);
            $response = [
                'success' => true,
                'unique_feedback_statuses'=>$unique_feedback_statuses,
                'connectedData' => $call_status_count_connected,
                'notConnectedData' => $call_status_count_not_connected,
                'dates'=>$dates
            ];
    
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $this->session();
            $this->load->view('include/admin_header.php');
            $process_id = $this->session->userdata('process_id');
            $process = $this->Call_StatusModel->getProcessName($process_id);
            $unique_feedback_statuses = $this->Call_StatusModel->getAllUniqueFeedbackStatus($process_id);
            $call_status_count_connected = $this->getInitialConnectedCallStatusData($process, "Mumbai Call Center");
            $call_status_count_not_connected = $this->getInitialNotConnectedCallStatusData($process, "Mumbai Call Center");
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            $dates = $this->datesBetween($start_date, $end_date);
            $this->load->view('call_status_view.php', [
                'getalluniqueuser' => $unique_feedback_statuses,
                'call_status_count_connected' => $call_status_count_connected,
                'call_status_count_not_connected' => $call_status_count_not_connected,
                'dates' => $dates,
            ]);
            $this->load->view('include/footer.php');
        }
    }

    private function getInitialConnectedCallStatusData($process, $location)
    {
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        $call_status = 'Connected';
        $process_id = $this->session->userdata('process_id');
        $unique_feedback_statuses = $this->Call_StatusModel->getAllUniqueFeedbackStatus($process_id);
        $call_status_count = $this->Call_StatusModel->getCallStatus($start_date, $end_date, $process, $call_status, $unique_feedback_statuses, $location);
        return $call_status_count;
    }

    private function getInitialNotConnectedCallStatusData($process, $location)
    {
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        $call_status = 'Not Connected';
        $process_id = $this->session->userdata('process_id');
        $unique_feedback_statuses = $this->Call_StatusModel->getAllUniqueFeedbackStatus($process_id);
        $call_status_count = $this->Call_StatusModel->getCallStatus($start_date, $end_date, $process, $call_status, $unique_feedback_statuses, $location);
        return $call_status_count;
    }

    public function filterSubmissionProcesses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('call_status', 'Call Status', 'required');
            $this->form_validation->set_rules('fromdate', 'Start Date', 'required');
            $this->form_validation->set_rules('todate', 'End Date', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                $response = ['success' => false, 'errors' => $errors];
            } else {
                $start_date = $this->input->post('fromdate');
                $end_date = $this->input->post('todate');
                $start_date_timestamp = strtotime($start_date);
                $end_date_timestamp = strtotime($end_date);
                if ($start_date_timestamp >= $end_date_timestamp) {
                    $errors = ['Invalid date range. Start date must be before end date.'];
                    $response = ['success' => false, 'errors' => $errors];
                } else {
                    $process_id = $this->session->userdata('process_id');
                    $process = $this->Call_StatusModel->getProcessName($process_id);
                    $call_status = $this->input->post('call_status');
                    $city = $this->input->post('mumbai') ? 'mumbai' : ($this->input->post('pune') ? 'pune' : 'mumbai');
                    if ($city === 'mumbai' || $city === 'pune') {
                        $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
                    } else {
                        $location = 'Mumbai Call Center';
                    }
                    $getallfeedbackstatus = $this->Call_StatusModel->getAllUniqueFeedbackStatus($process_id);
                    $call_status_count = $this->Call_StatusModel->getCallStatus($start_date, $end_date, $process, $call_status, $getallfeedbackstatus,$location);
                    $dates = $this->datesBetween($start_date, $end_date);
                    $results = [];
                    foreach ($dates as $date) {
                        $result = ['date' => $date];
                        foreach ($getallfeedbackstatus as $status) {
                            $result[$status['feedbackStatusName']] = 0;
                        }
                        $results[] = $result;
                    }
                    foreach ($call_status_count as $feedback) {
                        foreach ($results as &$result) {
                            if (isset($feedback['counts'])) {
                                foreach ($feedback['counts'] as $count) {
                                    if ($result['date'] == $count['date']) {
                                        $result[$count['feedbackStatus']] = $count['status_count'];
                                    }
                                }
                            }
                        }
                    }
                    $response = [
                        'success' => true,
                        'results' => $results,
                        'dates' => $dates
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

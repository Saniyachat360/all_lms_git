<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class CallerNameWise extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('CallerNameWiseModel');
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
            $process = $this->CallerNameWiseModel->getProcessName($process_id);
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            if ($city === 'mumbai' || $city === 'pune') {
                $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
            } else {
                $location = 'Mumbai Call Center'; 
            }
            $all_user = $this->CallerNameWiseModel->getAllUniqueCaller($process_id);
            $callerreport = $this->CallerNameWiseModel->getCallerStatus($start_date,$end_date,$process,$all_user,$city);
            $dates = $this->datesBetween($start_date, $end_date);
            $response = [
                'success' => true,
                'getalluniqueuser' => $all_user,
                'caller_report' => $callerreport,
                'dates' => $dates,
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $this->session();
            $this->load->view('include/admin_header.php');
            $process_id = $this->session->userdata('process_id');
            $process = $this->CallerNameWiseModel->getProcessName($process_id);
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            $dates = $this->datesBetween($start_date, $end_date);
            $all_user = $this->CallerNameWiseModel->getAllUniqueCaller($process_id);
            $callerreport = $this->CallerNameWiseModel->getCallerStatus($start_date,$end_date,$process,$all_user, "Mumbai Call Center");
            $this->load->view('caller_name_wise.php', [
                'getalluniqueuser' => $all_user,
                'caller_report' => $callerreport,
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
                $start_date_timestamp = strtotime($start_date);
                $end_date_timestamp = strtotime($end_date);
                if ($start_date_timestamp >= $end_date_timestamp) {
                    $errors = ['Invalid date range. Start date must be before end date.'];
                    $response = ['success' => false, 'errors' => $errors];
                } else {
                    $process_id = $this->session->userdata('process_id');
                    $process = $this->CallerNameWiseModel->getProcessName($process_id);
                    $city = $this->input->post('mumbai') ? 'mumbai' : ($this->input->post('pune') ? 'pune' : 'mumbai');
                    if ($city === 'mumbai' || $city === 'pune') {
                        $location = ($city === 'mumbai') ? 'Mumbai Call Center' : 'Pune Call Center';
                    } else {
                        $location = 'Mumbai Call Center';
                    }
                    $getalluser = $this->CallerNameWiseModel->getAllUniqueCaller($process_id);
                    $callerwisereport = $this->CallerNameWiseModel->getCallerStatus($start_date, $end_date, $process, $getalluser, $location);
                    $dates = $this->datesBetween($start_date, $end_date);
                    $results = [];
                    foreach ($dates as $date) {
                        $result = ['date' => $date];
                        foreach ($getalluser as $status) {
                            $result[$status['name']] = 0;
                        }
                        $results[] = $result;
                    }
                    foreach ($callerwisereport as $feedback) {
                        foreach ($results as &$result) {
                            if (isset($feedback['counts'])) {
                                foreach ($feedback['counts'] as $count) {
                                    if ($result['date'] == $count['date']) {
                                        $result[$count['name']] = $count['status_count'];
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

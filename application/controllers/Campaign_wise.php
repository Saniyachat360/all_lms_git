<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Campaign_wise extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('CampaignModel');
    }

    public function session()
    {
        if ($this->session->userdata('username') == "") {
            redirect('login/logout');
        }
    }

    public function campaign_view()
    {
        $this->session();
        $data['sources'] = $this->CampaignModel->select_source();
        $data['sub_sources'] = array();
        $this->load->view('include/admin_header.php');
        $this->load->view('campaign_report_view', $data);
        $this->load->view('include/footer.php');
    }

    public function get_sub_sources()
    {
        $source_name = $this->input->post('source_name');
        $process = $this->session->userdata('process_id');
        $sub_sources = $this->CampaignModel->select_sub_source($source_name, $process);
        echo json_encode($sub_sources);
    }

    public function filterSubmissionProcesses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('source', 'Source', 'required');
            $this->form_validation->set_rules('sub_source', 'Source', 'required');
            $this->form_validation->set_rules('fromdate', 'Start Date', 'required');
            $this->form_validation->set_rules('todate', 'End Date', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                $response = ['success' => false, 'errors' => $errors];
            } else {
                $start_date = $this->input->post('fromdate');
                $end_date = $this->input->post('todate');
                if ($start_date >= $end_date) {
                    $errors = ['Invalid date range.'];
                    $response = ['success' => false, 'errors' => $errors];
                } else {
                    $process_id = $this->session->userdata('process_id');
                    $process =  $this->CampaignModel->getProcessName($process_id);
                    $sublead_source_id = $this->input->post('sub_source');
                    $sublead_source = $this->CampaignModel->getSubSource($sublead_source_id);
                    $lead_count = $this->CampaignModel->getLeadCount($process, $sublead_source, $start_date, $end_date);
                    $connected_count = $this->CampaignModel->getConnectedCount($process, $sublead_source, $start_date, $end_date);
                    $interested_count = $this->CampaignModel->getInterestedCount($process, $sublead_source, $start_date, $end_date);
                    $test_drive_count = $this->CampaignModel->getTestDriveCount($process, $sublead_source, $start_date, $end_date);
                    $booked_count = $this->CampaignModel->getBookedCount($process, $sublead_source, $start_date, $end_date);
                    $dates = $this->datesBetween($start_date, $end_date);
                    $results = [];
                    foreach ($dates as $date) {
                        $result = ['date' => $date];
                        $result['lead_count'] = $this->getCountByDate($lead_count, $date, 'lead_count');
                        $result['connected_count'] = $this->getCountByDate($connected_count, $date, 'connected_count');
                        $result['interested_count'] = $this->getCountByDate($interested_count, $date, 'interested_count');
                        $result['testdrive_count'] = $this->getCountByDate($test_drive_count, $date, 'testdrive_count');
                        $result['booked_count'] = $this->getCountByDate($booked_count, $date, 'booked_count');
                        $results[] = $result;
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


    private function getCountByDate($array, $targetDate, $countType)
    {
        foreach ($array as $item) {
            if ($item['date'] == $targetDate) {
                return $item[$countType];
            }
        }
        return 'NA';
    }

    private function datesBetween($start_date, $end_date)
    {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $end->format('Y-m-d');
        return $dates;
    }
}

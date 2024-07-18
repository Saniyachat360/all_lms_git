<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
ob_start();
class CronJob extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('EDMSModel');
    }
    public function EdmsApiCall()
    {
        $fromDate = date('m/d/Y', strtotime('-1 day'));
        $toDate = date('m/d/Y');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ExcellAutovista.infoman-edms.com/EAMapi/Api/NewCarModule/CustomerOrderData',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                "FromDate" => $fromDate,
                "ToDate" => $toDate,
                "ForAPI" => "Y",
                "AuthToken" => "-1|F5496FB3-38CC-448E-A9E5-31EA2C16E359|bb22d58811f8a0d2"
            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            echo "cURL Error: " . $error;
            return;
        }
        curl_close($curl);
        $data = json_decode($response, true);
        if (!is_array($data) || !isset($data['data'])) {
            echo "No valid data found in API response";
            return;
        }
        foreach ($data['data'] as $entry) {
            if (isset($entry['Mobile No']) && isset($entry['Order Status'])) {
                $mobile_no = $entry['Mobile No'];
                $order_status = $entry['Order Status'];
                $from_date_db = $fromDate;
                $to_date_db = $toDate;
                $leads = $this->EDMSModel->getLeadsByMobileNoAndDateRange($mobile_no, $from_date_db, $to_date_db);
                if ($leads) {
                    $lead = $leads[0];
                    $this->EDMSModel->updateEdmsStatus($lead->contact_no, $order_status);
                    echo "edms_status updated for lead ID {$lead->contact_no} to '{$order_status}' successfully\n";
                } else {
                    echo "No leads found in lead_master table for mobile number: {$mobile_no}\n";
                }
            }
        }
    }
}

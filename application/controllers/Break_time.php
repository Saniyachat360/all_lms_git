<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Break_time extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('break_time_model'); 
        date_default_timezone_set('Asia/Calcutta');
    }
  
    public function session()
    {
        if ($this->session->userdata('username') == "") {
            redirect('login/logout');
        }
    }

     public function index()
    {
        // to get the break times from the tbls using break time model
        header("Refresh: 10");
        $data['break_time'] = $this->break_time_model->get_break_time();
        $this->load->view('include/admin_header.php');
        $this->load->view('break_time_popup_view.php', $data);
        $this->load->view('include/footer.php');
    }
    
    
    public function insert()   
    {
        $this->break_time_model->insert();
        redirect('notification');
    }
}

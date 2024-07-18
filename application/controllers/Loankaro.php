<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Loankaro extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('table', 'form_validation', 'session','pagination'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('LoankaroModel');
    }

    public function session()
    {
        if ($this->session->userdata('username') == "") {
            redirect('login/logout');
        }
    }

    public function index($offset = 0)
    {        
        $this->session();
        $this->load->view('include/admin_header.php');
        $config = array();
        $config['base_url'] = site_url('Loankaro/index');
        $config['total_rows'] = $this->LoankaroModel->countAllLoanDetails(); 
        $config['per_page'] = 10; 
        $config['uri_segment'] = 3; 
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>'; 
        $config['first_link'] = 'First'; 
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li class="page-item">'; 
        $config['last_tag_close'] = '</li>'; 
        $config['prev_link'] = '&laquo; Prev'; 
        $config['prev_tag_open'] = '<li class="page-item">'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_link'] = 'Next &raquo;'; 
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>'; 
        $config['num_tag_open'] = '<li class="page-item">'; 
        $config['num_tag_close'] = '</li>'; 
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['loan_details'] = $this->LoankaroModel->getLoanDetails($config['per_page'], $page);
        $this->load->view('loankaro_view', $data);       
		$this->load->view('include/footer.php');
    }
    
    
    }
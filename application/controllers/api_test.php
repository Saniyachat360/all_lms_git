<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Api_test extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		// $this->load->model('add_user_model');
	}

    public function index(){
        echo "Hello index";
        die;
    }
}
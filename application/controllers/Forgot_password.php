<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session', 'email'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('forgot_password_model');
	}

	public function index() {

		$data['var'] = site_url('forgot_password/forgot_pwd');
		$this -> load -> view('forgot_password_view.php', $data);
	}

	public function forgot_pwd() {

		$email = $this -> input -> post('email');
		$query = $this -> forgot_password_model -> forgot_pwd($email);
		$this -> session -> set_flashdata('message_name', '<div class="alert alert-danger alert-dismissable">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		    New Password Sent on Your Mail Id. Please Check.
		  </div>');
		redirect("login");
	}
}
?>
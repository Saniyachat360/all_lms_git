<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class forgot_password_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function forgot_pwd($email) {

		$email = $this -> input -> post('email');
		$this -> db -> select('*');
		$this -> db -> from('lmsuser');
		$this -> db -> where('email', $email);
		$query = $this -> db -> get() -> result();
		//print_r($query);
		if (count($query) > 0) {

			$email1 = $query[0] -> email;
			$fname = $query[0] -> fname;

			if ($email1 == $email) {

				$password = $query[0] -> empId;

				$msg = "Dear " . $fname . ",\n\nYour New Password is:" . $password . "\n\nThanks and regards,\nTeam Autovista";

				//	echo $msg;

				$this -> db -> query('update lmsuser set password="' . $password . '" where email="' . $email . '"');
				$this -> email -> from('support@autovista.in', 'Admin');
				$this -> email -> to($email);
				$this -> email -> subject('LMS New Password');
				$this -> email -> message($msg);
				$this -> email -> send();
			}

		} else {

			$this -> session -> set_flashdata('message_name1', '<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    Mail Id not Registered. Please Enter Correct Mail Id or contact to Admin.
  </div>');

			//echo "No email found";

			redirect(forgot_password);
		}
	}
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class change_password_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	function change_pwd() {

		$old_pwd = $this -> input -> post('old_pwd');
		$new_pwd = $this -> input -> post('new_pwd');
		$user_id = $this -> session -> userdata('user_id');
		$this -> db -> select('*');
		$this -> db -> from('lmsuser');
		$this -> db -> where('password', $old_pwd);
		$this -> db -> where('id', $user_id);
		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {

			$this -> db -> query('update lmsuser set password="' . $new_pwd . '" where id="' . $user_id . '"');

			redirect('login');

		} else {

			$this -> session -> set_flashdata('message_name', '<div class="alert alert-danger alert-dismissable">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	    Please Enter Correct Old Password.
	  </div>');	
	  redirect("change_password");

		}

		//	redirect('change_password');

	}

}

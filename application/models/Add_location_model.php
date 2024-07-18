<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_location_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_location($location_name, $city)
	{
		$existing_location_query = $this->db->query('SELECT * FROM tbl_location WHERE location="' . $location_name . '" AND location_status="Active"')->result();

		if (count($existing_location_query) > 0) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger"><strong> Location Already Exists ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
		} else {
			// Check if the location exists but is deactivated
			$inactive_location_query = $this->db->query('SELECT * FROM tbl_location WHERE location="' . $location_name . '" AND location_status="Deactive"')->result();

			if (count($inactive_location_query) > 0) {
				// Reactivate the existing location for the specific city
				$query = $this->db->query("UPDATE tbl_location SET location_status='Active' WHERE location='$location_name' AND city='$city'");
			} else {
				// Insert the new location with the city
				$query = $this->db->query("INSERT INTO tbl_location (location, city) VALUES ('$location_name', '$city')");
			}

			// Set flash message for success
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong> Location Added Successfully ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
		}
	}

	public function select_location() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_location');
		//$this -> db -> where('location_status !=','Deactive');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_location($id) {
		$this -> db -> select('location_id,location,city');
		$this -> db -> from('tbl_location');
		$this -> db -> where('location_id', $id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	

	public function delete_location($id) {

		$this -> db -> query('update tbl_location set location_status="Deactive" where location_id="'.$id.'"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Location Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Location Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
	
	public function edit_new_location($id, $location_name, $city)
	{
		$location_query = $this->db->query('SELECT * FROM tbl_location WHERE location="' . $location_name . '"')->result();
		if (count($location_query) > 0) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger"><strong> Location Already Exists ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
		} else {
			$this->db->query('UPDATE tbl_location SET location="' . $location_name . '", city="' . $city . '" WHERE location_id="' . $id . '"');

			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong> Location Updated Successfully ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger"><strong> Location Not Updated Successfully ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
			}
		}
	}

	public function select_table() {
		$this -> db -> select('u.fname,u.lname,u.mobileno,u.email,u.id,u.role,l.location,p.process_name');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_location l', 'l.location_id=u.location');
		$this -> db -> join('tbl_process p', 'p.process_id=u.process_id');
		$this -> db -> where('u.id !=', '0');

		$this -> db -> where('status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}

}

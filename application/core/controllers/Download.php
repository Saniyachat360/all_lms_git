<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class download extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('tracker_model');

		//$this -> load -> model('tracker_model1');

	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this->session();
		$query = $this -> db -> query("select min(created_date) as min_date,max(created_date) as max_date ,created_date from lead_master_lost") -> result();

		$data['select_date'] = $query;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('download_xls_for_lost_view.php', $data);

	}

	public function data() {
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		$query = $this -> query_select($fromdate, $todate);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Customer ID', 'Lead Source' , 'Custmer Name' , 'Contact'  , 'address' , 'Email' , 'Lead Date', 'Showroom Location', 'CSE  Name'  , 'CSE Date', 'CSE Disposition', 'CSE NFD', 'TD/HV Date', 'Booking Within Days', 'CSE Comment'  , 'DSE Name', 'DSE Date', 'DSE Disposition', 'DSE NFD', 'DSE Comment', 'Status' , 'Buyer Type', 'New Model  Name', 'Variant Name', 'Make Name', 'Old Model Name', 'Mfg Year');
		;

		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$excel_row = 2;

		foreach ($query as $row) {
			$cse_name=$row -> cse_fname .' '.$row -> cse_lname;
			$dse_name=$row -> dse_fname .' '.$row -> dse_lname;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $row -> enq_id);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row -> lead_source);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> custmer_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> email);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> lead_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> showroom_location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $cse_name);
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> cse_disposition);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> td_hv_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> cse_comment);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $dse_name);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> dse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> dse_disposition);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> dse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> dse_comment);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> status_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> buyer_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> new_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> variant_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> make_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> old_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> manf_year);
			
			$excel_row++;
		}
		$date=date("Y-m-d");
		$filename='Lost Data '.$date; 
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.".xls");
		$object_writer -> save('php://output');
	}

	/*	$this->load->dbutil();
	 $this->load->helper('file');
	 $this->load->helper('download');
	 $delimiter = ",";
	 $newline = "\r\n";
	 $filename = "download.csv";
	 //$result=$this->query_select($fromdate,$todate);
	 //print_r($result);
	 $result=$this->db->query("SELECT * FROM lead_master_lost WHERE created_date >= '$fromdate' AND created_date<= '$todate'");

	 //	echo $this->db->last_query();
	 $data1 = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	 force_download($filename, $data1);*/
	//print_r($result1);

	public function query_select($fromdate, $todate) {
		$this -> db -> select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,u.role,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	r.assign_to_telecaller,r.assign_by_id,f.td_hv_date,l.address,l.days60_booking,
	l.transfer_id,l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master_lost l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup_lost f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('request_to_lead_transfer_lost r', 'r.request_id=l.transfer_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');

		if ($fromdate != '' && $todate != '') {
			$this -> db -> where('l.created_date>=', $fromdate);
			$this -> db -> where('l.created_date<=', $todate);
		}

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');

		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {
			foreach ($query as $row) {
				$ass_to_telecaller = $row -> assign_to_telecaller;
				$assign_by_id = $row -> assign_by_id;
				$enq_id = $row -> enq_id;
				if ($row -> lead_source == '') {
					$lead_source = "Web";
				} elseif ($row -> lead_source == 'Facebook') {
					$lead_source = $row -> enquiry_for;
				} elseif ($row -> lead_source == 'Carwale') {
					$lead_source = $row -> enquiry_for;
				} else {
					$lead_source = $row -> lead_source;
				}
				if ($row -> transfer_id != 0) {

					$get_cse_name = $this -> get_cse_name($enq_id);
					if (count($get_cse_name) > 0) {
						$cse_fname = $get_cse_name[0] -> cse_fname;
						$cse_lname = $get_cse_name[0] -> cse_lname;
					} else {

						$cse_fname = "";
						$cse_lname = "";
					}
					$get_cse_data = $this -> get_cse_data($enq_id, $assign_by_id);
					if (count($get_cse_data) > 0) {
						$cse_date = $get_cse_data[0] -> date;
						$cse_disposition = $get_cse_data[0] -> disposition_name;
						$cse_comment = $get_cse_data[0] -> comment;
						$cse_nfd = $get_cse_data[0] -> nextfollowupdate;
						//	print_r($get_cse_data);
					} else {
						$cse_date = "";
						$cse_disposition = "";
						$cse_comment = "";
						$cse_nfd = "";
					}
				} else {
					if ($row -> transfer_id == 0 && ($row -> role == 3 or $row -> role == 2)) {

						$cse_fname = $row -> fname;
						$cse_lname = $row -> lname;
						$cse_date = $row -> date;
						$cse_disposition = $row -> disposition_name;
						$cse_comment = $row -> comment;
						$cse_nfd = $row -> nextfollowupdate;
					} else {

						$cse_fname = "";
						$cse_lname = "";
						$cse_date = "";
						$cse_disposition = "";
						$cse_comment = "";
						$cse_nfd = "";
					}
				}
				if ($row -> transfer_id != 0 && ($row -> role == 4 || $row -> role == 5)) {
					$get_dse_name = $this -> get_dse_name($enq_id);
					if (count($get_dse_name) > 0) {
						$dse_fname = $get_dse_name[0] -> dse_fname;
						$dse_lname = $get_dse_name[0] -> dse_lname;
					} else {
						$dse_fname = "";
						$dse_lname = "";

					}
					$get_dse_data = $this -> get_dse_data($enq_id, $ass_to_telecaller);
					if (count($get_dse_data) > 0) {
						$dse_date = $get_dse_data[0] -> date;
						$dse_disposition = $get_dse_data[0] -> disposition_name;
						$dse_comment = $get_dse_data[0] -> comment;
						$dse_nfd = $get_dse_data[0] -> nextfollowupdate;
						//	print_r($get_cse_data);
					} else {

						$dse_date = "";
						$dse_disposition = "";
						$dse_comment = "";
						$dse_nfd = "";
					}
				} else {
					if ($row -> transfer_id == 0 && ($row -> role == 4 || $row -> role == 5)) {
						$dse_fname = $row -> fname;
						$dse_lname = $row -> lname;
						$dse_date = $row -> date;
						$dse_disposition = $row -> disposition_name;
						$dse_comment = $row -> comment;
						$dse_nfd = $row -> nextfollowupdate;
					} else {
						$dse_fname = "";
						$dse_lname = "";
						$dse_date = "";
						$dse_disposition = "";
						$dse_comment = "";
						$dse_nfd = "";
					}
				}
				$select_lead_tracker[] = (object) array('enq_id' => $enq_id, 'lead_source' => $lead_source,'address'=>$row->address,'days60_booking'=>$row->days60_booking,'td_hv_date'=>$row->td_hv_date, 'enquiry_for' => $row -> enquiry_for, 'custmer_name' => $row -> name, 'contact_no' => $row -> contact_no, 'email' => $row -> email, 'lead_date' => $row -> created_date, 'showroom_location' => $row -> location, 'cse_fname' => $cse_fname, 'cse_lname' => $cse_lname, 'dse_fname' => $dse_fname, 'cse_date' => $cse_date, 'cse_disposition' => $cse_disposition, 'cse_nfd' => $cse_nfd, 'cse_comment' => $cse_comment, 'dse_lname' => $dse_lname, 'dse_date' => $dse_date, 'dse_disposition' => $dse_disposition, 'dse_nfd' => $dse_nfd, 'dse_comment' => $dse_comment, 'status_name' => $row -> status_name, 'buyer_type' => $row -> buyer_type, 'new_model_name' => $row -> new_model_name, 'variant_name' => $row -> variant_name, 'make_name' => $row -> make_name, 'old_model_name' => $row -> old_model_name, 'manf_year' => $row -> manf_year, 'color' => $row -> color, 'km' => $row -> km, 'ownership' => $row -> ownership, 'accidental_claim' => $row -> accidental_claim, 'buy_status' => $row -> buy_status);
		
			}
		} else {
			//$select_lead_tracker[]=array('enq_id'=>'','lead_source'=>'','enquiry_for'=>'','custmer_name'=>'','contact_no'=>'','email'=>'','lead_date'=>'','showroom_location'=>'','cse_fname'=>'','cse_lname'=>'','dse_fname'=>'','cse_date'=>'','cse_disposition'=>'','cse_nfd'=>'','cse_comment'=>'','dse_lname'=>'','dse_date'=>'','dse_disposition'=>'','dse_nfd'=>'','dse_comment'=>'','status_name'=>'','buyer_type'=>'','new_model_name'=>'','variant_name'=>'','make_name'=>'','old_model_name'=>'' , 'manf_year'=>'' , 'color'=>'','km'=>'','ownership'=>'','accidental_claim'=> '','buy_status'=>'');
			$select_lead_tracker = array();
		}

		return $select_lead_tracker;
	}

	public function get_cse_name($enq_id) {
		$query_cse1 = $this -> db -> query("SELECT l.lname as cse_lname,l.fname as cse_fname , l.role as role
	   	 from request_to_lead_transfer_lost r 
	   	 join lmsuser l on  r.assign_by_id=l.id  
	   	 where  lead_id='$enq_id' and (role = 3 or role=2)");
		//echo $this->db->last_query();
		return $query_cse1 -> result();

	}

	public function get_cse_data($enq_id, $assign_by_id) {
		$query_cse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
		FROM  lead_followup_lost f 
		LEFT JOIN tbl_disposition_status d ON d.disposition_id =f.disposition 
		join request_to_lead_transfer_lost r on r.assign_by_id=f.assign_to  
		join lmsuser l on  r.assign_by_id=l.id 
		where f.leadid='$enq_id'  and (role = 3 or role=2) ORDER BY f.id DESC  limit 1");

		//echo $this->db->last_query();
		return $query_cse -> result();

	}

	public function get_dse_name($enq_id) {
		$query_dse1 = $this -> db -> query("SELECT l.lname as dse_lname,l.fname as dse_fname 
     from request_to_lead_transfer_lost r 
     join lmsuser l on  r.assign_to_telecaller=l.id  
     where  lead_id='$enq_id' and (role = 4 or role=5) order by request_id desc");

		//echo $this->db->last_query();
		return $query_dse1 -> result();

	}

	public function get_dse_data($enq_id, $assign_to_telecaller) {
		$query_dse = $this -> db -> query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
	  FROM  lead_followup_lost f  
	  JOIN tbl_disposition_status d ON d.disposition_id =f.disposition
	  JOIN request_to_lead_transfer_lost r on r.assign_to_telecaller=f.assign_to   
	   JOIN lmsuser l on  r.assign_to_telecaller=l.id  
	  where f.leadid='$enq_id'  and assign_to='$assign_to_telecaller' and (role = 4 or role=5) ORDER BY f.id DESC  limit 1");

		//echo $this->db->last_query();
		return $query_dse -> result();

	}

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dsewise_dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('dsewise_dashboard_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();
		$data['locations'] = $q = $this -> dsewise_dashboard_model -> select_location();
		//print_r($q);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('Dsewise_dashboard_view.php', $data);
		$this -> load -> view('include/footer.php');

	}

	public function get_dse_name() {

		$location = $this -> input -> post('location');
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		if ($fromdate == '') {
			$fromdate = "2017-01-01";
		}
		if ($todate == '') {

			$todate = date('Y-m-d');

		}
		//echo $location_name;
		$dse_name = $this -> dsewise_dashboard_model -> get_dse_name($location, $fromdate, $todate);
		//print_r($dse_name);
		if ($dse_name == " ") {

			echo "No User Found";
		} else {

			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;
			$data['dsename'] = $dse_name;
			//print_r($dse_name);
			$this -> load -> view('dse_dashboard_filter_view.php', $data);
			//redirect('Next_action');
		}
	}
	public function demo()
	{
		$view = $_SESSION['view'];
		$header_process_id=$_SESSION['process_id'];
		$tracker=0;
		$tracker_array = array("13", "28", "38", "46", "54");	
		$new_lead_array = array("1", "22", "32", "40", "48");
		$assign_lead_array = array("4", "23", "33", "41", "49");
		$assign_transferred_lead_array = array("17", "24", "34", "42", "50");			
		$rightarray=array($tracker_array,$new_lead_array,$assign_lead_array,$assign_transferred_lead_array);
					$namearray=array(0,0,0,0);					
					$c= count($rightarray);						
					for($i=0;$i<$c;$i++)
					{
						
						 $t= $rightarray[$i];
						 print_r($t);
						 $t1=count($rightarray[$i]);
						for($j=0;$j<$t1;$j++)
						{
							$viewvalue=$t[$j];
							if(isset($view[$viewvalue]))
							{ 
								if(($view[$viewvalue]==1 && $header_process_id==6))
								{	$namearray[$i]=1;	}
							}
							if(isset($view[$viewvalue]))
							{ 
								if(($view[$viewvalue]==1 && $header_process_id==7))
								{ $namearray[$i]=1;}
							}
							if(isset($view[$viewvalue]))
							{
								if(($view[$viewvalue]==1 && $header_process_id==1))
								{ $namearray[$i]=1;	}
							}
							if(isset($view[$viewvalue]))
							{
								if(($view[$viewvalue]==1 && $header_process_id==4))
								{ $namearray[$i]=1;	}
							}
							if(isset($view[$viewvalue]))
							{
								if(($view[$viewvalue]==1 && $header_process_id==5))
								{ $namearray[$i]=1;}
							}
						}
					}
print_r($namearray);
	}

}
?>
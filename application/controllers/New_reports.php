<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new_reports extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('new_reports_model'));
		$this -> load -> model(array('New_dashboard_model'));
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function performance_report() {

		$this -> session();
		$data['select_location']=$this -> new_reports_model -> select_location();

	
		$data['var']=site_url().'new_reports/search_dse_performance';

		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/dse_performance_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function get_dse()
	{
		$location=$this->input->post('location');
		echo "$location";
		$select_dse=$this -> new_reports_model -> select_dse($location);
		var_dump($select_dse);
		?>
		
									<select id="user_id" class="form-control"  name="user_id">
									<option value="">Select DSE Name</option>
									<?php foreach($select_dse as $row) { ?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> dse_name; ?></option>
									<?php } ?>
									
									</select>
								
	<?php
		
	}
	public function search_dse_performance()
    {
        $this -> session();
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$date_type=$this->input->post('date_type');
		if($date_type=='As on Date')
		{
			$to_date=$from_date;
			$from_date='2017-01-01';
		}
		$location=$this->input->post('location');
		$dse_name=$this->input->post('dse_id');
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		
        $data['select_leads']=$this->New_dashboard_model->dse_performance($location,$dse_name,$from_date,$to_date);
       
       // $data['var']=site_url().'new_reports/search_dse_performance';

        $this -> load -> view('report/dse_performance_filter_view.php', $data);
      
	}
	public function productivity_report ()
	{
		$this -> session();
		$data['select_location']=$this -> new_reports_model -> select_location();
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/dse_productivity_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_productivity()
	{
		$this -> session();
		
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$date_type=$this->input->post('date_type');
		if($date_type=='As on Date')
		{
			$to_date=$from_date;
			$from_date='2017-01-01';
		}
		$location=$this->input->post('location');
		$dse_name=$this->input->post('dse_id');
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['select_leads']=$this->new_reports_model->dse_productivity($location,$dse_name,$from_date,$to_date); 
		$this -> load -> view('report/dse_productivity_filter_report_view.php', $data);
	
	
		
	}
	
	}
?>
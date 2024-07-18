<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tracker extends CI_Controller {

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
public function leads() {

		$this -> session();
		
		$data['select_lead'] = $this -> tracker_model -> select_lead_dse();
		$data['select_status'] = $this -> tracker_model -> select_status();
		$data['select_telecaller'] = $this -> tracker_model -> select_telecaller();
		$data['select_campaign'] = $this -> tracker_model -> select_campaign();
		$data['lc_data'] = $this -> tracker_model -> lc_data_dse();

		$data['select_lead_source']=$this->tracker_model->select_lead_source();
	
	//print_r($q);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view.php', $data);
		$this -> load -> view('tracker_with_dse_view.php', $data);
		//$this->load->view('include/footer.php');
	}
/*public function leads_test() {

		$this -> session();
		
		$data['select_lead'] = $this -> tracker_model1 -> select_lead_dse();
		$data['select_status'] = $this -> tracker_model1 -> select_status();
		$data['select_telecaller'] = $this -> tracker_model1 -> select_telecaller();
		$data['select_campaign'] = $this -> tracker_model1 -> select_campaign();
		$data['lc_data'] = $this -> tracker_model1 -> lc_data_dse();

		$data['select_lead_source']=$this->tracker_model->select_lead_source();
	
	//print_r($q);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view.php', $data);
		$this -> load -> view('tracker_with_dse_view.php', $data);
		//$this->load->view('include/footer.php');
	}
public function tracker_dse_filter1()
	{
		
		$data['select_lead'] = $this -> tracker_model1 -> select_lead_dse();
	
		$data['lc_data'] = $this -> tracker_model1 -> lc_data_dse();

		
	
		
		$this -> load -> view('tracker_with_dse_filter.php', $data);
	}*/
public function tracker_dse_filter()
	{
		
		$data['select_lead'] = $this -> tracker_model -> select_lead_dse();
	
		$data['lc_data'] = $this -> tracker_model -> lc_data_dse();

		
	
		
		$this -> load -> view('tracker_with_dse_filter.php', $data);
	}
	/*public function telecaller_leads()
	 {
	 $this->session();
	 $data['select_lead']=$this->tracker_model->select_lead();
	 $data['lc_data']=$this->tracker_model->lc_data();
	 $data['select_campaign']=$this->tracker_model->select_campaign();
	 $this->load->view('include/admin_header.php');
	 $this->load->view('telecaller_tracker_top_tab_view.php',$data);
	 $this->load->view('tracker_view.php',$data);
	 $this->load->view('include/footer.php');
	 }*/
	public function team_leader_leads() {

		$this -> session();
		$data['select_lead'] = $this -> tracker_model -> select_lead();
		$data['select_status'] = $this -> tracker_model -> select_status();
		$data['select_telecaller'] = $this -> tracker_model -> select_telecaller();
		$data['select_campaign'] = $this -> tracker_model -> select_campaign();
		$data['lc_data'] = $this -> tracker_model -> lc_data();
		$data['select_lead_source']=$this->tracker_model->select_lead_source();
		//print_r($q);
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tl_tracker_top_tab_view.php', $data);
		$this -> load -> view('tracker_view.php', $data);
		//$this->load->view('include/footer.php');
	}

	public function tl_filter() {

		$this -> session();
		$data['select_lead'] = $this -> tracker_model -> select_lead();
		$data['lc_data'] = $this -> tracker_model -> lc_data();
		//print_r($select_lead1);

		$this -> load -> view('filter_traker_view.php', $data);

	}
	public function reopen() {
		
	
//echo "hi";
	$enq_id=$this->input->get('enq_id');
	//echo $enq_id;
	
	$query = $this -> tracker_model -> reopen($enq_id);
	redirect('website_leads/lms_details/'.$enq_id.'/tracker_lead');
//redirect('tracker/leads');
	
	}
	public function select_disposition() {
	
		$query=$this->tracker_model->select_disposition();
		?>  
		    <div class="form-group">
                 <select class="filter_s col-md-12 col-xs-12 form-control" id="dispostion" name="dispostion">
                      <option value="">Disposition</option>
					<?php foreach ($query as $fetch) {	?>
					<option value="<?php echo $fetch -> disposition_id; ?>"><?php echo $fetch -> disposition_name; ?></option>
                      <?php } ?> 	
                                               
                   </select>
			 </div>
                           
           <?php
	}
	
	public function download_data() {

		$this -> load -> helper('download');
		$select_telecaller = $this -> tracker_model -> select_lead_csv();
		$name = 'mytext.csv';
		force_download($name, $select_telecaller);
	}

	public function download_data1() {
		$this -> load -> helper('download');
		$data = 'Here is some text!';
		$name = 'mytext.csv';
		force_download($name, $data);
	}

}
?>
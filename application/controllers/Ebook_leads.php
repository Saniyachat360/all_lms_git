<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebook_leads extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('ebook_model');
		
	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function payment_all_leads()
	{
		$this->session();
		
			$data['enq']='EBook';
			$data['lead_source']='EBook';
		$data['select_lead']=$this->ebook_model->select_ebook_all_lead();
	$data['select_lead_count']=$this->ebook_model->select_ebook_all_count();
		
		$this -> load -> view('include/admin_header.php');
		
		$this->load->view('ebook_all_filter_view.php',$data);
		$this->load->view('ebook_all_view.php');
		$this->load->view('include/footer.php');
	}
	public function payment_all_filter()
	{
		$this->session();
		$data['enq']='EBook';
		$enq='EBook';
		
		$lead_source=$this->input->post('lead_source');
		$data['lead_source']=$lead_source;
			$data['select_lead']=$this->ebook_model->select_ebook_all_lead();
	$data['select_lead_count']=$this->ebook_model->select_ebook_all_count();
		$this->load->view('ebook_all_filter.php',$data);
	}
	public function payment_all_download()
{
	
	$from_date = $this -> input -> get('payment_fromdate');
		$to_date = $this -> input -> get('payment_todate');

	$query = $this -> ebook_model -> select_payment_all_lead();
	
	//echo  count($query);
	
			$csv= "Sr No,Customer Name,Mobile Number,Email ID,Registration No,Amount,Payment Date,Payment Id,Order Id,Payment Status,Paid Status\n";

	
$i=0;
	foreach ($query as $row) {
		 $i++;
	//}
		if ($row -> status == 'captured') {
			$k='Paid';
		}
		else{
			$k='';
		}
	
			  $csv.= $i.',"'.$row->name.'","'.$row->contact_no.'","'.$row->email.'","'.$row->customer_reg_no.'","'.$row->amount.'","'.$row->created_date.'","'.$row->razorpay_payment_id.'","'.$row->razorpay_order_id.'","'.$row->payment_status.'","'.$k.'"'."\n";

		
  
            }
            //$csv_handler = fopen('php://output', 'w');
$csv_handler = fopen ('tracker3.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Insurance-payment ' . $from_date . ' - ' . $to_date.'.csv';
    $data_file = file_get_contents('https://www.autovista.in/all_lms/payment_all.csv'); // Read the file's contents
 // echo $data_file;
  //  echo "https://www.autovista.in/all_lms/tracker.csv";
       force_download($filename, $csv);
	
}
}
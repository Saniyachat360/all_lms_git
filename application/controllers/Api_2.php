<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_2 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model(array('api_2_model'));
		date_default_timezone_set('Asia/Kolkata');		
	}


	/////////////////////////////////////////////////
	//Spiner
	public function quotation_location() {

		$response["quotation_location"] = $this -> api_2_model -> quotation_location();
		echo json_encode($response);
	}
	public function quotation_model_name() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$response["quotation_model_name"] = $this -> api_2_model -> quotation_model_name($quotation_location);
		echo json_encode($response);
	}
	public function quotation_description() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('qmodel_id');
		$response["quotation_description"] = $this -> api_2_model -> quotation_description($quotation_location,$quotation_model_name);
		echo json_encode($response);
	}
	public function offer_detail() {
		
		$response["select_quotation_onroad_price"] = $this -> api_2_model -> select_quotation_onroad_price();		
		$response["select_quotation_offer"] = $this -> api_2_model -> select_quotation_offer();
		echo json_encode($response);
	}
	public function insert_quotation_data(){
	 $quotation_id=$this->api_2_model->insert_quotation_data();	
	//$response['quotation_data']=$this->api_2_model->select_quotation_sent_data($quotation_id);
	//$response['quotation_finance_data']=$this->api_2_model->select_finance_quotation($quotation_id);
	//echo json_encode($response);
	}
	public function send_quotation_via()
  {
  		$quotation_id=$this->input->post('quotation_id');
  		$customer_name=$this->input->post('customer_name');
  		$contact_no=$this->input->post('contact_no');
  			$enq_id=$this->input->post('booking_id');
  		$email=$this->input->post('email');
   	$sms=$this->input->post('sms');
  $whatsapp=$this->input->post('whatsapp');
  $h_code=$this->input->post('confirmation_code');
  $model_name=$this->input->post('model_name');

  $variant_name=$this->input->post('variant_name');

  if($sms=='1')
  {
  	$this->send_quotation_sms($quotation_id,$contact_no,$customer_name,$h_code,$model_name,$variant_name);
  }
   	$mail=$this->input->post('mail');
  if($mail=='1')
  {
  	$this->send_quotation_mail($quotation_id,$customer_name,$email,$model_name,$variant_name);
  }
   $response["success"] = '1';
				$response["message"] = "Data successfully Updated.";
				echo json_encode($response);
  }
  public function send_quotation_sms($quotation_id,$contact_no,$customer_name,$h_code,$model_name,$variant_name)
  {
	  $msg="Dear ".ucfirst($customer_name)." ,  Greetings Autovista Group. We Thank For Your Interest In Maruti Suzuki ". $model_name .' '.$variant_name.". To download Your Personalized Quotation Please click the link and Update Your 4 Digit Code ". $h_code." " .site_url()."new_quotation_send/download_pdf/".$quotation_id."     Regards, Autovista Group Ph:9209200071";
  	//send sms code
  		//request parameters array
$sendsms =""; //initialize the sendsms variable
$requestParams = array(
	'user' => 'atvsta',
    'password' => 'atvsta',
    'senderid' => 'ATVSTA',
	'channel'=>'Trans',
	'DCS'=>'0',
	'flashsms'=>'0',
	'route'=>'46',
	'number'=>$contact_no,
	'text'=>$msg
	
);

//merge API url and parameters
	$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
foreach($requestParams as $key => $val){
    $apiUrl .= $key.'='.urlencode($val).'&';
}
$apiUrl = rtrim($apiUrl, "&");

//API call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_exec($ch);
curl_close($ch);
			
  }
  public function send_quotation_mail($quotation_id,$customer_name,$email,$model_name,$variant_name)
  { 
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library

		//now pass the data//
		 $this->data['title']="MY PDF TITLE 1.";
		 $this->data['description']="";
		 $this->data['description']="sdfsd";
		 //now pass the data //
		//$quotation_id=5;	
		$quta=$this->data['quotation_data']=$this->api_2_model->select_quotation_sent_data($quotation_id);
		$this->data['quotation_finance_data']=$this->api_2_model->select_finance_quotation($quotation_id);
		$this->data['quotation_id']=$quotation_id;
		$html=$this->load->view('pdf_view',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="Maruti_Car_Quotation.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		//$pdf->Output($pdfFilePath, "D");
		 $content = $pdf->Output($pdfFilePath, "S");
		 
		 $config = Array(       
          'mailtype'  => 'html'
         );
	       	$this->load->library('email', $config);
 $msg="Dear ".$customer_name." ,<br> Greetings Autovista Group. We Thank For Your Interest In Maruti Suzuki ". $model_name .' '.$variant_name.". Attached herewith is your personalized Quotation.<br><br>
 For any queries/information please contact us on 9209200071<br><br>
 Regards,<br>Autovista Group";
	$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
	$this->email->bcc('jamil@autovista.in');
	//$this->email->cc('satyam@autovista.in');
	$this->email->subject('Maruti Quotation From Autovista');
	$this->email->message($msg); 
	$this->email->attach($content, 'attachment', 'Maruti_Car_Quotation.pdf', 'application/pdf');
	$this->email->send();
//		 echo $this->email->print_debugger();
		
  }


public function demo()
{
	$this->db->query("INSERT INTO `lead_count`( `enq_id`, `message`, `contact_no`) VALUES ('1','2','3')");
}
  public function cardekho()
  {

  	// API URL
//$url = 'http://carsales.cardekho.com/rest/updateLeads/excellAutovista';
$url = 'http://carsales-qa.cardekho.com/rest/updateLeads/excellAutovista';
//$url = 'https://www.autovista.in/all_lms/index.php/api_2/demo';
//$url = 'http://vistacars.in/all_lms1/index.php/add_sms/demo';
// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST
$t='17868777';
$data = array(

    'id' => $t,
     'scheduleDate' => '2020-06-25 01:01:01',
      'nextEvent' => 'CallBack',
       'nextStatus' => 'Price Quote Requested',
        'comments' => 'demo lead update response',
         'bookingName' => 'Aman',
          'bookingDate' => '2020-06-09',
           'bookingNumber' => '8376818782',
           'engineNo' => '','chassis' => '','rc' => '',
           'purchasedModelName' => 'Ertiga','purchasedFrom' => 'Autovista','purchasedBrand' => 'Maruti',
    'retailDate' => '2020-06-26'
);
$payload = json_encode($data);

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);
echo $result;
  }





}
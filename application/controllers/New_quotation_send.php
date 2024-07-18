<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class New_quotation_send extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('customer_quotation_model');
	}
	public function check_whatup(){
				//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library

		//now pass the data//
		 $this->data['title']="MY PDF TITLE 1.";
		 $this->data['description']="";
		 $this->data['description']="sdfsd";
		 //now pass the data //
		$quotation_id=5;	
		$this->data['quotation_data']=$this->customer_quotation_model->select_quotation_sent_data($quotation_id);
		$this->data['quotation_finance_data']=$this->customer_quotation_model->select_finance_quotation($quotation_id);
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
		 
		

$apiUrl = "https://web.whatsapp.com/send?phone=917276524406&text=hiiiiiiiiii";
	?>
	<script  src="https://www.autovista.in/all_lms_demo/assets/js/jquery-1.11.3.min.js"></script>
<script>
	$(document).ready(function() { 
	var con="<?php echo $content ;?>";
	//var con1=escape(con);
	window.open("https://web.whatsapp.com/send?phone=917276524406&document="+con); 
	});
	</script>	 
		
<?php
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
		$quta=$this->data['quotation_data']=$this->customer_quotation_model->select_quotation_sent_data($quotation_id);
		$this->data['quotation_finance_data']=$this->customer_quotation_model->select_finance_quotation($quotation_id);
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
  public function pdf_format($quotation_id){
  //	$quotation_id="7";
	$data['quotation_data']=$this->customer_quotation_model->select_quotation_sent_data($quotation_id);
	$data['quotation_finance_data']=$this->customer_quotation_model->select_finance_quotation($quotation_id);
	$data['quotation_id']=$quotation_id;
	  $this->load->view('pdf_view.php',$data);
	  $this->load->view('quotation_button_view.php',$data);
  }
 
  public function send_quotation_via()
  {
  		$quotation_id=$this->input->post('quotation_id');
  		$customer_name=$this->input->post('customer_name');
  		$contact_no=$this->input->post('contact_no');
  			$enq_id=$this->input->post('enq_id');
  		$email=$this->input->post('email');
   	$sms=$this->input->post('sms');
  $whatsapp=$this->input->post('whatsapp');
  $h_code=$this->input->post('h_code');
  $model_name=$this->input->post('model_name');

  $variant_name=$this->input->post('variant_name');

  if($sms=='on')
  {
  	$this->send_quotation_sms($quotation_id,$contact_no,$customer_name,$h_code,$model_name,$variant_name);
  }
   	$mail=$this->input->post('mail');
  if($mail=='on')
  {
  	$this->send_quotation_mail($quotation_id,$customer_name,$email,$model_name,$variant_name);
  }
  if($whatsapp=='on')
  {
       $msg="Dear ".ucfirst($customer_name)." , %0aGreetings Autovista Group. We Thank For Your Interest In Maruti Suzuki ". $model_name .' '.$variant_name.". To download Your Personalized Quotation Please click the link and Update Your 4 Digit Code ". $h_code." " .site_url()."new_quotation_send/download_pdf/".$quotation_id."   %0aRegards,%0aAutovista Group%0aPh:9209200071";
  
  ?>      <script>
    window.onload = load;function load() {
        
        window.open("https://web.whatsapp.com/send?phone=+91"+<?php echo $contact_no;?>+"&text=<?php echo $msg?>","_blank");
      }
      
       
      </script>
      
      <a href='https://www.autovista.in/all_lms/index.php/add_followup_new_car/detail/<?php echo $enq_id ?>/All'>Go to Followup Page</a>
      <?php
  }
  if($whatsapp !='on')
  {
      redirect('add_followup_new_car/detail/'.$enq_id.'/All');
  }	 
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
   public function check_confirmation_code($quotation_id)
  {
      
	
		$this -> db -> select('confirmation_code');
		$this -> db -> from('tbl_quotation_sent');
		$this -> db -> where('quotation_sent_id', $quotation_id);
		
		$query = $this -> db -> get();
		return $query -> result();
	
  }
public function download_pdf($quotation_id)
{
   $q=$this->check_confirmation_code($quotation_id);
   if(count($q)>0)
   {
       $data['code']=$q[0]->confirmation_code;
        $data['quotation_id']=$quotation_id;
 $this->load->view('quotation_confirm_code.php',$data);
   }

}public function download_pdf1()
{
   echo  $h_code=$this->input->post('h_code');
   echo  $code=$this->input->post('code');
    $quotation_id=$this->input->post('quotation_id');
    if($h_code==$code)
    {
        redirect('new_quotation_send/download_pdf_from_sms_link/'.$quotation_id);
    }
    
}
  //when user click on sms link;
  public function download_pdf_from_sms_link($quotation_id)
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
		$quta=$data['quotation_data']=$this->customer_quotation_model->select_quotation_sent_data($quotation_id);
		$data['quotation_finance_data']=$this->customer_quotation_model->select_finance_quotation($quotation_id);
		$data['quotation_id']=$quotation_id;
		$html=$this->load->view('pdf_view',$data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="Maruti_Car_Quotation.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
		// $content = $pdf->Output($pdfFilePath, "S");
	//	redirect('add_followup_new_car/detail/'.$quta[0]->lead_id.'/All');
  }

}
  ?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_payment_booking extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('add_payment_booking_model');
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$this->session();
		$data['select_model'] = $this->add_payment_booking_model->make_models();
		$data['contact_detail'] = $this->add_payment_booking_model->contact_detail();
		
		$this->load->view('include/admin_header.php');
		$this->load->view('add_payment_booking_view.php', $data);
		$this->load->view('include/footer.php');
	}



	public function easycollect()
	{
		$sub = $this->input->post('submit');

		$this->today=date('Y-m-d');
    	$this->time  = date("h:i:s A");
		$name=$this->input->post('name');
		$mobile_no=$this->input->post('phone');
		$email=$this->input->post('email');
		$model_id=$this->input->post('model_id');
		$amount=$this->input->post('amount');
		$message=$this->input->post('message');
		$merchant_txn=$this->input->post('merchant_txn');
		
		if (!preg_match('/^[0-9]{10}+$/', $mobile_no)) {
			echo "<script> alert('Phone Number must be 10 Digit!'); history.back();</script>";
			// exit ;
		}
		if($email!=''){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "<script> alert('Invalid email format!'); history.back();</script>";
			// exit ;
		}
		}
	
		$customer_id = $this -> add_payment_booking_model -> insert_booking($name, $email, $mobile_no, $model_id,$amount,$merchant_txn,$message);
		// $this -> send_mail($name, $email, $mobile_no, $model_id,$amount);

		// $this -> load -> view('include/header.php');
		// $this -> load -> view('add_payment_booking_view.php');
		// $this -> load -> view('include/footer.php');

		// $customer_id = $this->add_payment_booking_model->insert_booking();
		$data['api_name'] = $_GET['api_name'];
		// print_r($data['api_name']);

		$data['$_POST'] = $_POST;
		$data['customer_id'] = $customer_id;
		// print_r($data['$_POST']);
		// print_r($data['customer_id']);
		// exit;
		//$this->load->view('include/header.php');
		$this->load->view('ease/easebuzz_view.php', $data);
		//$this -> load -> view('blog_category_view.php');
		//$this -> load -> view('include/footer.php');
	}

	

	

	public function easy()
	{
// 		$paymenturl=$_POST['paymentdata'];
// 		$email = $_POST['email'];
// 		$name = $_POST['name'];
// 		$amount = $_POST['amount'];
// 		$phone = $_POST['phone'];
// 		$model_id = $_POST['model_id'];
// 		$message = $_POST['message'];

        $paymenturl=$_SESSION['paymentdata'];
		$email = $_SESSION['email'];
		$name = $_SESSION['name'];
		$amount = $_SESSION['amount'];
		$phone = $_SESSION['phone'];
		$model_id = $_SESSION['model_id'];
		$message = $_SESSION['message'];
		
	
		 


		
		$this -> send_mail($name, $email,$amount,$paymenturl,$phone,$model_id,$message);
		redirect('add_payment_booking');
	}



	public function send_mail($name, $email, $amount, $paymenturl,$phone,$model_id,$message) {
        
	

		$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		
		

		$data['contact_detail'] = $this -> add_payment_booking_model -> contact_detail();


		if($model_id !='')
		{
			$q=$this->db->query("select model_name from make_models where model_id='$model_id'")->result();
			if(count($q)>0)
			{
				$data['model_name']=$q[0]->model_name;				
			}
			else {
				$data['model_name']='';	
			}
		}
			else
			{
				$data['model_name']='';	
			}


		$data['email'] = $email;
		$data['name'] = $name;
		$data['paymenturl'] = $paymenturl;
		$data['amount'] = $amount;
		$data['phone'] = $phone;
		$data['model_id'] = $model_id;
		$data['message'] = $message;
		
			

		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to('info@autovista.in');
		$this -> email -> subject('Message from ' . $email . ' via autovista.in');
		$body = $this -> load -> view('receiver_view.php', $data, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();

		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('Auto: Booking Payment Link');
		$body = $this -> load -> view('receiver_view.php', $data, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();

	}


    public function response()
	{	     //$this->load->view('include/header.php');
		$this -> load -> view('ease/response_view.php');
		//$this -> load -> view('blog_category_view.php');
		//$this -> load -> view('include/footer.php');
	    
	}
	
	public function thank_you(){
	    
	    echo "success";
	}
	
	public function thank_you_fail(){
	    
	    echo "fail";
	    
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_web extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('api_web_model');
		
	}
	
	public function website() 
	{

    $response =	$this->api_web_model->insert_lead();
    print_r($response);
	
	}
	
	
	// This is a code for Insurance Enq Comming from marutiinsurance website
     // service complaint
     public function insurance_enq()
     {
         $response = $this->api_web_model->insurance_enq();
         print_r($response);
     }
     // End service complaint
     // End of a code for Insurance Enq Comming from marutiinsurance website
     
     
	 // service complaint
    public function service_complaint()
    {
        $response = $this->api_web_model->service_complaint();
        print_r($response);
    }
    // End service complaint
    
    
	 // Sell your car
    public function sell_your_car()
    {
        $response = $this->api_web_model->sell_your_car();
        print_r($response);
    }
    // End Sell your car
	
	
	// Book a test drive
    public function book_a_test_drive() 
	{
    $response =	$this->api_web_model->book_a_test_drive();
    print_r($response);	
	}
    // ENd Book a test drive
    
    
    // Book a car service appointment
    public function book_a_car_service()
    {
        $response = $this->api_web_model->book_a_car_service();
        print_r($response);
    }
    // End Book a car service appointment
    
    
    // Loan against car
    public function loan_detail()
    {
        $response = $this->api_web_model->loan_detail();
        print_r($response);
    }
    // End Loan against car
	
    // 	Maruti Subscribe
    public function contact_data()
    {
        $response = $this->api_web_model->contact_data();
        print_r($response);
    }
    //  End Maruti Subscribe
    
		public function auto_assign_lead($enq_id=null,$process_id=null,$lead_source_id=null)

    {
        if(isset($enq_id) && isset($process_id) && isset($lead_source_id))
        {
            $this->api_web_model->auto_assign_lead($enq_id,$process_id,$lead_source_id);
        }
        
    }
    	public function auto_assign_cron_new_car() 
	{
        $process_id=6;
        $process_name='New Car';
        $response =	$this->api_web_model->auto_assign_cron($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_cron_poc_sales() 
	{
        $process_id=7;
        $process_name='POC Sales';
        $response =	$this->api_web_model->auto_assign_cron($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_cron_poc_purchase() 
	{
        $process_id=8;
        $process_name='POC Purchase';
        $response =	$this->api_web_model->auto_assign_cron($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_cron_finance() 
	{
        $process_id=1;
        $process_name='Finance';
        $response =	$this->api_web_model->auto_assign_cron($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_cron_service() 
	{
        $process_id=4;
        $process_name='Service';
        $response =	$this->api_web_model->auto_assign_cron($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_facebook_campaign_new_car() 
	{
         $process_id=6;
        $process_name='New Car';
        $response =	$this->api_web_model->auto_assign_facebook_campaign($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_facebook_campaign_poc_sales() 
	{
         $process_id=7;
        $process_name='POC Sales';
        $response =	$this->api_web_model->auto_assign_facebook_campaign($process_id,$process_name);
       // print_r($response);
	
	}
	public function auto_assign_facebook_campaign_poc_purchase() 
	{
         $process_id=8;
        $process_name='POC Purchase';
        $response =	$this->api_web_model->auto_assign_facebook_campaign($process_id,$process_name);
       // print_r($response);
	
	}
		public function auto_assign_facebook_campaign_finance() 
	{
         $process_id=1;
        $process_name='Finance';
        $response =	$this->api_web_model->auto_assign_facebook_campaign($process_id,$process_name);
       // print_r($response);
	
	}
		public function auto_assign_facebook_campaign_service() 
	{
          $process_id=4;
        $process_name='Service';
        $response =	$this->api_web_model->auto_assign_facebook_campaign($process_id,$process_name);
       // print_r($response);
	
	}
	public function demo() 
	{
	    ?>
        <form action="https://www.autovista.in/all_lms_dev/index.php/api_web/auto_assign_facebook_campaign_finance" method="post">
        Full name: <input type="text" name="fullname" value="">
        Phone number:<input type="text" name="phonenumber" value="">
        Email:<input type="email" name="email" value="">
        City:<input type="text" name="city" value="">
        Location:<input type="text" name="customer_location" value="">
        <input type="hidden" name="lead_source" value="Facebook Pune">
        <input type="hidden" name="adname" value="LG - New Car Mum - Sep 20">
        <input type="submit" value="submit">
        </form>
	<?php
	}
	
	
	//saniya code for api website
	
	// Quotation api code
    public function download_quotation() 
	{
    $response =	$this->api_web_model->download_quotation();
    print_r($response);	
	}
    // ENd Quotation api code
    
    // Broucher api code
    public function download_broucher() 
	{
    $response =	$this->api_web_model->download_broucher();
    print_r($response);	
	}
    // ENd Broucher api code
    
     // Get in touch api code
    public function get_in_touch() 
	{
    $response =	$this->api_web_model->get_in_touch();
    print_r($response);	
	}
    // ENd  Get in touch code
    
    
     // Get in sell_your_car
    public function sell_your_car_api() 
	{
    $response =	$this->api_web_model->sell_your_car_api();
    print_r($response);	
	}
    // ENd sell_your_car
    
    // carniwal invicto banner code
    public function carniwal_data() 
	{
    $response =	$this->api_web_model->carniwal_data();
    print_r($response);	
	}
    // ENd  carniwal code
    
	//end saniya code for api website
	
	
	
}
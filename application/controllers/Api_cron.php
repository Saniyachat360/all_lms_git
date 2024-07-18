<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_cron extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('api_cron_model');
		$this->new_car="New Car";
		$this->process_id_new_car='6';
		$this->service='Service';
		$this->process_id_service='4';
		$this->enq_id='';
		$this->created_date='';
		$this->booking_date='';

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}



	public function index() {
		$this -> session();
		
		$data['select_fields'] = $this -> api_cron_model -> select_fields();
		$data['select_templates']=$this-> api_cron_model->select_templates(); 
		$data['var'] = site_url('mail_template/insert_mail_template');
		$this -> load -> view('include/admin_header.php', $data);
		$this -> load -> view('mail_template_view.php');
		$this -> load -> view('include/footer.php');

	}

	public function finance_facility()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Finance Facility");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function finance_facility_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Finance Facility","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
		public function finance_facility_service()
	{
	     $q=$this-> api_cron_model->check_type($this->process_id_service,"Finance Facility");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	         $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	               $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
		public function finance_facility_service_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_service,"Finance Facility","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function exchange_facility()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Exchange Facility");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function exchange_facility_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Exchange Facility","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function exchange_facility_service()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_service,"Exchange Facility");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function exchange_facility_service_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_service,"Exchange Facility","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	
		public function occasional()
	{
	     $date=date('Y-m-d');
	    $q=$this-> api_cron_model->check_type_occassion($this->process_id_new_car,"Occassion",$date);
	    if(count($q)>0)
	    {
	       $msg=$q[0]->description;
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id);
	       if(count($q1)>0)
	       {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	               break;
	            }
	       }
	    }
	}
		public function occasional_mail()
	{
	    $date=date('Y-m-d');
	    $q=$this-> api_cron_model->check_type_occassion_mail($this->process_id_new_car,"Occassion","Email",$date);
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id);
	        echo count($q1);
	        $i=0;
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               
	                echo $i++;
	               echo $email=$row->email1;
	               $row->enq_id;
	               echo "<br>";
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	                if($i==100)
	                {
	                     sleep(3);
	                }
	                if($i==200)
	                {
	                     sleep(3);
	                }
	                if($i==300)
	                {
	                     sleep(3);
	                }
	               if($i=='500'){
	               break;
	               }
	               break;
	               
	            }
	        }
	    }
	}
		public function occasional_service_mail()
	{
	    $date=date('Y-m-d');
	    $q=$this-> api_cron_model->check_type_occassion_mail($this->process_id_service,"Occassion","Email",$date);
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function occasional_service()
	{
	     $date=date('Y-m-d');
	    $q=$this-> api_cron_model->check_type_occassion($this->process_id_service,"Occassion",$date);
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	              echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
		public function new_offers()
	{
	     $day=date('d');
	    if($day=='5'){
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"New Offers");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    } }
	}
	public function new_offers_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"New Offers","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	              //  $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
		public function new_offers_service()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_service,"New Offers");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function new_offers_service_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_service,"New Offers","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$this->created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function accessories()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Accessories");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function accessories_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Accessories","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function accessories_service()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_service,"Accessories");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function accessories_service_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_service,"Accessories","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function vas()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"VAS");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function vas_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"VAS","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
		public function touch_point()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Touch Point");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function touch_point_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Touch Point","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $booking_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$booking_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function delivery_invitation()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Delivery Invitation");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $delivery_date=date('Y-m-d', strtotime('+1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function delivery_invitation_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Delivery Invitation","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function happy_motoring()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Happy Motoring");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function happy_motoring_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Happy Motoring","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
		public function post_delivery_feedback()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Post Delivery Feedback Request");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function post_delivery_feedback_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Post Delivery Feedback Request","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
			public function link_for_digital_post_sales()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Link for digital Post Sales Follow up");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-20 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function link_for_digital_post_sales_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Link for digital Post Sales Follow up","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-20 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
		public function day_document_receipt()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Day Document Receipt Confirmation");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-15 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	
	public function day_document_receipt_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Day Document Receipt Confirmation","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-15 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function registration_plate()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Registration Plate Number Fitment");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-7 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function registration_plate_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Registration Plate Number Fitment","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-7 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function service_no_sharing()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Service Contact Number Sharing");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               echo $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function service_no_sharing_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Service Contact Number Sharing","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	         $date=date('Y-m-d');
	        $delivery_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$this->created_date,$this->enq_id,$this->booking_date,$delivery_date);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function model_benefits()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_new_car,"Model Benefits");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function model_benefits_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_new_car,"Model Benefits","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	         $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_new_car,$this->new_car,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_new_car,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function model_benefits_service()
	{
	    $q=$this-> api_cron_model->check_type($this->process_id_service,"Model Benefits");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $date=date('Y-m-d');
	        echo $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $contact_no=$row->contact_no;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	               // $this->send_sms($contact_no,$dy_msg);
	            }
	        }
	    }
	}
	public function model_benefits_service_mail()
	{
	    $q=$this-> api_cron_model->check_type_mail($this->process_id_service,"Model Benefits","Email");
	    if(count($q)>0)
	    {
	        $msg=$q[0]->description;
	        $subject=$q[0]->subject;
            $attachment_list=$q[0] -> attachment_list;
	        $date=date('Y-m-d');
	        $created_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
	       $q1=$this-> api_cron_model->check_lead_data($this->process_id_service,$this->service,$created_date,$this->enq_id);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	               $email=$row->email;
	                $dy_msg=$this->dynamic_template($this->process_id_service,$msg,$row);
	                $this->send_mail($email,$subject,$dy_msg,$attachment_list);
	            }
	        }
	    }
	}
	public function add_new_lead()
	{
	    $enq_id=$this->input->post('enq_id');
	     $process_id=$this->input->post('process_id');
	     $process_name=$this->input->post('process_name');
	    $enq_id='244765';
	     $process_id='6';
	   $process_name='New Car';
	       $q1=$this-> api_cron_model->check_lead_data($process_id,$process_name,$this->created_date,$enq_id);
	      //  print_r($q1);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $name=$row->name;
	                  $email=$row->email;
	                  $q=$this-> api_cron_model->check_type($process_id,"New Enquiry");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"New Enquiry","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	        $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
	            }
	        }
	    
	}
		public function lead_lost()
	{
	    $enq_id=$this->input->post('enq_id');
	     $process_id=$this->input->post('process_id');
	     $process_name=$this->input->post('process_name');
	    $enq_id='244765';
	     $process_id='6';
	   $process_name='New Car';
	       $q1=$this-> api_cron_model->check_lead_data($process_id,$process_name,$this->created_date,$enq_id);
	      //  print_r($q1);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $name=$row->name;
	                  $email=$row->email;
	                  $q=$this-> api_cron_model->check_type($process_id,"Lost Enquiry");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"Lost Enquiry","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	       echo $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
	            }
	        }
	    
	}
	public function vehicle_allotment()
	{
	    $enq_id=$this->input->post('enq_id');
	     $process_id=$this->input->post('process_id');
	     $process_name=$this->input->post('process_name');
	    $enq_id='244765';
	     $process_id='6';
	   $process_name='New Car';
	       $q1=$this-> api_cron_model->check_lead_data($process_id,$process_name,$this->created_date,$enq_id);
	      //  print_r($q1);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $name=$row->name;
	                  $email=$row->email;
	                  $q=$this-> api_cron_model->check_type($process_id,"Vehicle Allotment");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"Vehicle Allotment","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	       echo $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
	            }
	        }
	    
	}
	public function booking()
	{
	    $enq_id=$this->input->post('enq_id');
	     $process_id=$this->input->post('process_id');
	     $process_name=$this->input->post('process_name');
	    $enq_id='244765';
	     $process_id='6';
	   $process_name='New Car';
	       $q1=$this-> api_cron_model->check_lead_data($process_id,$process_name,$this->created_date,$enq_id);
	      //  print_r($q1);
	        if(count($q1)>0)
	        {
	            foreach($q1 as $row)
	            {
	                $contact_no=$row->contact_no;
	                $name=$row->name;
	                  $email=$row->email;
	                  $q=$this-> api_cron_model->check_type($process_id,"Thank You Booking");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"Thank You Booking","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	       echo $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
                	    $q=$this-> api_cron_model->check_type($process_id,"Waiting Period");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"Waiting Period","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	       echo $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
                	    $q=$this-> api_cron_model->check_type($process_id,"Post Booking Feedback Request");
                	    if(count($q)>0)
                	    {
                	        $msg=$q[0]->description;
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	              //  echo $dy_msg;
                	               // $this->send_sms($contact_no,$dy_msg);
                	              
                	    }
                	   $q2=$this-> api_cron_model->check_type_mail($process_id,"Post Booking Feedback Request","Email");
                	    if(count($q2)>0)
                	    {
                	        $msg=$q2[0]->description;
                	       echo $subject=$q2[0]->subject;
                	        $attachment_list=$q2[0] -> attachment_list;
                	     //   print_r($attachment_list);
                	       $dy_msg=$this->dynamic_template($process_id,$msg,$row);
                	         $this->send_mail($email,$subject,$dy_msg,$attachment_list);
                	               // break;
                	    }
	            }
	        }
	    
	}
	public function dynamic_template($process_id,$msg,$row)
	{   
	    $contact_no=$row->contact_no;
	                $name=$row->name;
	                 $email=$row->email;
	    $fquery=$this->db->query("select field_value,data_value from tbl_mail_dynamic_fields where status=1 and process_id='$process_id'")->result();
	    foreach($fquery as $row)
	    {
	       
	         $d=$row->field_value;
	         $dv=$row->data_value;
	        if($d=='#name')
	        {
	            //echo "hi";
	             $d1=$name;
	        }
	        elseif($d=='#contact_no')
	        {
	             $d1=$contact_no;
	        } elseif($d=='#email')
	        {
	           // echo "hi";
	             $d1=$email;
	        } /*elseif($d=='#feedback_status')
	        {
	           // echo "hi";
	             $d1=$feedbackStatus;
	        }elseif($d=='#next_action'){$d1=$feedbackStatus; }
	        elseif($d=='#address'){$d1=$company_data[0]->address; }*/
	        else
	        {	 $d1='';
	        }
	        if($d1 !='')
	        {
	       // else if
	        $msg= str_replace($d,$d1,$msg);
	        
	        }
	        
	    }
	    return $msg;
	   // print_r($msg);
	}
	public function send_sms($moblie_number,$msg) {
	echo "hi";
	 $msg=strip_tags($msg);
	//	$data = $this -> db -> query("insert into mobile_numbers (mobile_number,verification_code,date) value('$moblie_number','$code','$today')");
        $moblie_number='9834082193';
        $msg="Your OTP for Autovista VMS login :- 1234";
		//request parameters array
		$sendsms = "";
		//initialize the sendsms variable
		$requestParams = array('user' => 'atvsta', 'password' => 'atvsta', 'senderid' => 'ATVSTA', 'channel' => 'Trans', 'DCS' => '0', 'flashsms' => '0', 'route' => '46', 'number' => $moblie_number, 'text' => $msg);

		//merge API url and parameters
		$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
		//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
		foreach ($requestParams as $key => $val) {
			$apiUrl .= $key . '=' . urlencode($val) . '&';
		}
		$apiUrl = rtrim($apiUrl, "&");

		//API call
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_exec($ch);
		curl_close($ch);
	
	}
	public function send_mail($email,$subject,$msg,$attachment_list)
	{
	     
	    	$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this -> email -> from('autovistacars@gmail.com', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject($subject);
	//	$body = $this -> load -> view('send_mail_view.php', TRUE);
    	$body=$msg.". <br><br><br><br> Thanks & Regards,<br>Team Autovista";
		$this -> email -> message($body);
		if( $attachment_list !='')
       {
           $a=explode(',',$attachment_list);
           $c=count($a);
           for($k=0;$k<$c;$k++)
           {
              $attachment_name=$a[$k];
             if($attachment_name !=''){
	        $this->email->attach('./assets/mail_attachment/'.$attachment_name);
	        }
           }
       }
		$this -> email -> send();
	}
}
?>
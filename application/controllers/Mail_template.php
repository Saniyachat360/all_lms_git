<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail_template extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('mail_template_model');
		//	$this -> load -> model('calling_task_model');

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login');
		}
	}



	public function index() {
		$this -> session();
		
		$data['select_fields'] = $this -> mail_template_model -> select_fields();
		$data['select_templates']=$this-> mail_template_model->select_templates(); 
		$data['var'] = site_url('mail_template/insert_mail_template');
		$this -> load -> view('include/admin_header.php', $data);
		$this -> load -> view('mail_template_view.php');
		$this -> load -> view('include/footer.php');

	}

	public function insert_mail_template() {
		$this -> session();
		$i=0;
		  $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
		echo	$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		
			echo	$_FILES["product_image"]["size"][$i][$j];
			 if (($_FILES["product_image"]["size"][$i][$j] > 5000000)) { 
			     echo "hi";
       
        	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Please Upload File Less Than 5MB Size ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
redirect('mail_template');

    }					 
   					
		
	}
		$this -> mail_template_model -> insert_mail_template();
		
		redirect('mail_template');
	}
	public function template_edit($ctype_id) // edit model_id from db 
	
	{
			$data['select_fields'] = $this -> mail_template_model -> select_fields();
		$mod=$data['template_edit']=$this-> mail_template_model->template_edit($ctype_id);
		//print_r($mod);
		$data['var']=site_url('mail_template/update_template'); 
		$this->load->view('include/admin_header.php');
		$this -> load ->view('edit_mail_template_view.php',$data);
		$this->load->view('include/footer.php');

	}
	public function update_template()// update data 
	{
	    	$i=0;
		  $countt=count($_FILES["product_image"]["name"][$i]);
		for($j=0;$j<$countt;$j++){
	        //First Image
		
			$target_dir1 = "./assets/mail_attachment/";
			$target_file1 = $target_dir1 . basename($t_id.$_FILES["product_image"]["name"][$i][$j]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		
			echo	$_FILES["product_image"]["size"][$i][$j];
			 if (($_FILES["product_image"]["size"][$i][$j] > 5000000)) { 
			     echo "hi";
       
        	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Please Upload File Less Than 5MB Size ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
redirect('mail_template');

    }					 
   					
		
	}
		$this-> mail_template_model->update_template();
		redirect('mail_template');
	}
	

	public function template_delete($ctype_id) {
		$this -> session();
		//echo $map_id;
		$this -> mail_template_model -> template_delete($ctype_id);
		redirect('mail_template');
	}

	public function template_action($ctype_id) {
		$this -> session();

		$this -> mail_template_model -> template_action($ctype_id);
		redirect('mail_template');
	}
	public function delete_attachment($attach_id,$t_id) {
		$this -> session();

		$this -> mail_template_model -> delete_attachment($attach_id);
		redirect('mail_template/template_edit/'.$t_id);
	}
	public function send_mail()
	{
	   echo $company_id = $this -> input -> post('booking_id');
	   echo  $t_id = $this -> input -> post('t_id');
	   // $cp_id = $this -> input -> post('spoken_to');
	     $to = $this -> input -> post('to');
	      $cc = $this -> input -> post('cc');
	       $subject = $this -> input -> post('subject');
	        echo  $path = $this -> input -> post('path');
	     // $cp_id=7;
	        $product_description = $this -> input -> post('product_description');
	
	  $mailq=$this->db->query("select t.*,m.attachment_name from tbl_mail_template t left join tbl_mail_attachment m on m.t_id=t.t_id where t.t_id='$t_id' ")->result();
	  if(count($mailq)>0)
	  {
	      echo "hi";
	  
	    $a= $product_description;
	    
echo $a;
	    	$email='jamil.shaikh50@gmail.com';
	//	$email = $get_data['user_email'];
	
		$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this -> email -> to($to);
		if($cc !=''){
		$this -> email -> cc($cc);
		}
		$this -> email -> subject($subject);
		$body = "<html><body><section><div><p>".$a."&nbsp;&nbsp;</p> <div>&nbsp;</div> </div>";
		$this -> email -> message($body);
		  foreach($mailq as $row)
	    {
	        $attachment_name=$row->attachment_name;
	        if($attachment_name !=''){
	        $this->email->attach('./assets/mail_attachment/'.$attachment_name);
	        }
	    }
		
			
		$this -> email -> send();
		echo  $this->email->print_debugger();
		$this->mail_template_model -> mail_history($company_id,$to,$t_id,$cc,$subject,$a);
	}
	
	    	redirect($path);
	   // }
	}



	public function show_mail_desc() {
		$this -> session();
		$ctype_id = $this -> input -> post('template_id');
		$company_id = $this -> input -> post('company_id');
		$m=$this-> mail_template_model->template_edit($ctype_id);
	
	?>
	<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
    <script>
    
  $(function () {
    
	var editor_config = {
    height: "150px"
};

CKEDITOR.replace('product_description', editor_config );
	
	
  })
</script> 

     <div class="col-md-offset-2 col-md-8">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-12 col-sm-12 col-xs-12" > Subject: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        
 <input type="text" id="subject" placeholder="Enter Subject" required name="subject" 
                   autocomplete="off" class="form-control" value="<?php echo $m[0]->subject;?>" >
                        </div>
                     </div>
                     
                  </div>

                          <?php 
	     $company_data=	$this -> mail_template_model -> select_lead($company_id);
	     $name=$company_data[0]->name;
	     //$loan_amount=$company_data[0]->required_amount;
	     $feedbackStatus= $company_data[0]->feedbackStatus;
	     $contact_no= $company_data[0]->contact_no;
	       $email= $company_data[0]->email;
                      $a= $m[0]->description;
                     $process_id= $this -> session -> userdata('process_id');
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
	           // echo "hi";
	             $d1=$contact_no;
	        } elseif($d=='#email')
	        {
	           // echo "hi";
	             $d1=$email;
	        } elseif($d=='#feedback_status')
	        {
	           // echo "hi";
	             $d1=$feedbackStatus;
	        }elseif($d=='#next_action'){$d1=$feedbackStatus; }
	        elseif($d=='#address'){$d1=$company_data[0]->address; }
	        else
	        {	            $d1='';
	        }
	        if($d1 !='')
	        {
	       // else if
	        $a= str_replace($d,$d1,$a);
	        
	        }
	       // echo $a;
	        //break;
	    }?>
	     <div class="col-md-offset-2 col-md-8">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-12 col-sm-12 col-xs-12" > Description: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        
 
                    <textarea id="product_description" name="product_description" rows="10" cols="80">
                     <?php echo $a;?>
                    </textarea>
                        </div>
                     </div>
                     
                  </div>
	    	
                   <?php if($m[0]->attachment_name !=''){?>
                   
                     <div class="col-md-offset-2 col-md-8">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-12 col-sm-12 col-xs-12" > Attachments: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        
  <?php foreach($m as $frow)
                        {
                            ?>
                             <i  >
                                 <a href="<?php echo base_url()?>/assets/mail_attachment/<?php echo $frow->attachment_name;?>" target='_blank'> 
                                 <?php echo $frow->attachment_name;?> </a></i> &nbsp; &nbsp;
                            <?php
                        }?>
                        </div>
                     </div>
                     
                  </div>
                   
                   
               
                   
	<?php }
	}

}
?>
<?php
    // include file
   // include_once('easebuzz-lib/easebuzz_payment_gateway.php');
 include_once('easebuzz_payment_gateway.php');
    // salt for testing env
    $SALT = "5VNXEGR9PJ";

    /*
    * Get the API response and verify response is correct or not.
    *
    * params string $easebuzzObj - holds the object of Easebuzz class.
    * params array $_POST - holds the API response array.
    * params string $SALT - holds the merchant salt key.
    * params array $result - holds the API response array after valification of API response.
    *
    * ##Return values
    *
    * - return array $result - hoids API response after varification.
    * 
    * @params string $easebuzzObj - holds the object of Easebuzz class.
    * @params array $_POST - holds the API response array.
    * @params string $SALT - holds the merchant salt key.
    * @params array $result - holds the API response array after valification of API response.
    *
    * @return array $result - hoids API response after varification.
    *
    */
    $easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
    
    $result = $easebuzzObj->easebuzzResponse( $_POST );
 
   // print_r($result);
    if(isset($result)>0)
    {
        echo "hi";
        echo "<br>";
       $result1= json_decode($result);
      print_r($result1); 
       $status1=$result1->status;
        $data= $result1->data;
      // print_r($data);
       echo $status= $data->status;
       if($status=='success')
       {
     //  echo count($result1);
       echo $easepayid= $data->easepayid;
        $taxnid= $data->txnid; 
       $phone= $data->phone; 
       $a=explode('-',$taxnid);
       echo $customer_id=$a['1'];
       date_default_timezone_set('Asia/Kolkata');
    $today=date('Y-m-d');
    $time  = date("h:i:s A");
      $q= $this->db->query("select * from tbl_payment_customer_all where customer_id='$customer_id' and customer_mobile_no='$phone'")->result();
       if(count($q)>0)
       {$cust_id=$q[0]->customer_id;
          $this->db->query("update tbl_payment_customer_all set payment_status='$status',easepayid='$easepayid', taxnid='$taxnid',payment_done_date='$today',payment_done_time='$time' where customer_id='$customer_id' and customer_mobile_no='$phone'");
         redirect('payment-link/thank-you-success/'.$cust_id);
       }
       
    }else
    {
        echo "failed";
       redirect('payment-link/thank-you-fail');
    }
    }
?>


<!DOCTYPE html>
<html>
	<body>
                <table border="0" cellpadding="0" cellspacing="0" width="700" >
				<!-- <tr><td><a href="<?php echo site_url();?>">
								<img style="margin-top: 2px; width: 193px;" alt="autovista" src="<?php echo site_url();?>assets/images/autovista.png">
							</a></td></tr> -->
              
               <tr><td> <h3>Dear, <?php
		 echo $name; ?>,</h3></td></tr>
               <tr><td><p>Thank you for Choosing Autovista Group !</p></td></tr>

<tr><td><p>Please Click On the below Payment Link to Process the Payment, </p></td></tr>
               <tr><td><p> Name: <?php echo $name;?></p></td></tr>
                 <tr><td><p> Contact No.: <?php echo $phone; ?></p></td></tr>
                 <!--  <tr><td><p> Email ID: <?php echo $email; ?></p></td></tr>   -->
 <tr><td><p> Amount: <?php echo $amount; ?></p></td></tr>  
  <tr><td><p> To procees the payment, Click on <a class="btn btn-info" href="<?php echo $paymenturl; ?>">Pay Now</a></p></td></tr>  				  
                  <tr><td><?php if($model_name !='')
{
                  	?>
	<p>Your Selected Model is <b><?php echo $model_name; ?></b></p>
	<?php } ?></td></tr> 
                  
                     
				  <tr><td> <div></div></td></tr>
 <tr><td><p>For any queries/information, Please contact us on 9209200071 OR Mail us on info@autovista.in	<?php	exit();?></td></tr>		  
                </div>
                <div>&nbsp;</div></td></tr>
                  <tr><td> <div></div></td></tr>
               <tr><td> <div>Thanks and regards,</div></td></tr>
        
               <tr><td> <p>Team Autovista </p>
                </td></tr>
				<tr><td> <div></div></td></tr>
				<!--  <tr><td> <p>If you have any complaints regarding this transaction or email please write to us at info@autovista.in or call us at 9209200071.
</td></tr>   -->             
			   </table>
                </body>
                
                



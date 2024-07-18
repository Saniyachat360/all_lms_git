<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">

<table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
    <tbody><tr>
        <td style="padding-top:5px;padding-bottom:5px" valign="top" align="center">
            
            <center style="max-width:600px;width:100%">
                <table style="border-spacing:0;border-collapse:collapse;background-color:#ffffff;font-family:Arial,sans-serif;border:1px solid #ddd" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                  
                    <tr>
                    	<td style="padding-top:18px;padding-bottom:13px;padding-left:10px;padding-right:10px" valign="middle" height="30" align="left">
                           <p> <a href="#" target="_blank" style="float: left;padding-left: 9px;">
                                <img src="https://www.autovista.in/assets/images/autovista-logo-fixed.png" style="display:block;max-width:100%;" alt="autovista" border="0">
                            </a>
    
    <a style="float: right;font-size: 15px;padding-top: 4px;color: #d81416;">+91-9209200071</a></p>
                        </td>
                     
                    </tr>
                    
                    <tr>
                        <td style="background-color:#205194e3;font-size:0" valign="top" align="center">
                            <a href="https://www.autovista.in/maruti-suzuki/new-cars" class='qmenu' style='display:inline-block;
	width:98px;vertical-align:top;
	background-color:#205194e3;border-left:1px solid #fff;padding-top:13px;padding-bottom:12px;
	text-decoration:none;font-size:12px;
	color:#fff;' target="_blank" >
                                New Car
                            </a>
                              <a href="https://www.autovista.in/nexa-car" class='qmenu' style='display:inline-block;
	width:98px;vertical-align:top;
	background-color:#205194e3;border-left:1px solid #fff;padding-top:13px;padding-bottom:12px;
	text-decoration:none;font-size:12px;
	color:#fff;' target="_blank" >
                                Nexa Car
                            </a>
                             <a href="https://www.autovista.in/car-loan" class='qmenu'  style='display:inline-block;
	width:98px;vertical-align:top;
	background-color:#205194e3;border-left:1px solid #fff;padding-top:13px;padding-bottom:12px;
	text-decoration:none;font-size:12px;
	color:#fff;'  target="_blank" >
                                Car Loan
                            </a>
                             <a href="https://www.autovista.in/contact" class='qmenu' style='border-right:1px solid #fff;display:inline-block;
	width:98px;vertical-align:top;
	background-color:#205194e3;border-left:1px solid #fff;padding-top:13px;padding-bottom:12px;
	text-decoration:none;font-size:12px;
	color:#fff;'  target="_blank" >
                                Contact Us
                            </a>
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:20px;padding-bottom:20px;padding-left:10px;padding-right:10px;font-size:13px;color:#606060;line-height:1.5" valign="top" align="left">
                            <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                    <td style="padding-bottom:20px;font-size:17px;color:#333333;font-weight:bold" valign="top" align="left">
                                        Dear <span><?php echo $customer_name;?></span>,
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:15px" valign="top" align="left">
                                        Thank you for choosing Autovista.in
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="left">
                                        We received your request for On road price of <span>Maruti Suzuki <?php  if(isset($select_data[0]->model_name)){echo $select_data[0]->model_name; }?></span> in <span><?php if(isset($location)){echo $location;}?></span>:
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;padding-right:10px" valign="top" align="center">
                            <table style="border-spacing:0;border-collapse:collapse;border:2px solid #f4f4f4" width="100%" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                    <td style="padding-top:10px;padding-bottom:7px;padding-left:10px;padding-right:10px;background-color:#f4f4f4;font-size:17px;color:#444444;font-weight:bold" valign="top" align="left">
                                        On-Road Price of <span>Maruti Suzuki <?php if(isset($select_data[0]->model_name)){echo $select_data[0]->model_name;}?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color:#f4f4f4" valign="top" align="center">
                                        <img  style="display:block;width:100%" alt="" class="CToWUd">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:15px" valign="top" align="">
                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody><tr>
                                                <td style="font-size:0" valign="top" align="center">
                                                    <div style="display:inline-block;vertical-align:top" width="100%">
                                                        <table style="border-spacing:0;border-collapse:collapse;color:#333333;font-size:13px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                               
                                                            </tr>
                                                            <tr>
															  <td style="padding-bottom:25px;padding-left:15px;padding-right:15px;font-size:15px" valign="top" align="left">
                                                                    Ex-Showroom Price
																	
                                                                </td>
                                                                <td style="padding-left:15px;padding-right:15px;font-size:24px;color:#d6422c" valign="top" align="left">
																<?php 
																
																
																$this->db->select('MIN(ex_showroom) as min_price,MAX(ex_showroom) as max_price');
																
																	$this->db->from('tbl_variant_onroad');
																$this->db->where('model_id',$select_data[0]->model_id);
															
																$query=$this->db->get()->result();
														
																?>
																
																 <span>&#x20B9;&nbsp;<?php if( ($query[0]->min_price!= $query[0]->max_price) && ( $query[0]->min_price!=0) &&  ($query[0]->max_price!=0)){echo $query[0]->min_price.' - '.$query[0]->max_price; } elseif($query[0]->min_price== 0){echo  $query[0]->max_price; }else{ echo $query[0]->min_price; } ?> </span><sup>*</sup>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                              
                                                            </tr>
                                                           
                                                        </tbody></table>
                                                    </div>
													
                                                           
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
								 <tr>
                                    <td style="padding-top:10px;padding-right:15px;padding-bottom:15px;padding-left:15px" valign="top" align="center">
                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
											<tr>
                                               
                                                <td style="font-size:18px;color:#191a19;line-height:1.5" valign="top" align="center">
												<span style="font-size:18"> EMI Started From &#x20B9;&nbsp;<?php
												if(isset($query[0]->min_price)){
													
												
													$amount = $query[0]->min_price;
								$interest = 13;
								$intr = $interest/100/12;
								
								// year is not year its month
								$years = 12;
								$x =pow(1+$intr,$years);
								$monthly1 = ($amount*$x*$intr)/($x-1);
								$monthly1 = round($monthly1);
								echo $monthly1;
												}
								?>
								</span><br>
												
                                                    <a style="display:inline-block;color:#2c77fe" href="https://www.autovista.in/car-loan" target="_blank">
                                                        Get Car Loan EMI Calculation
                                                    </a>
                                                </td>
                                            </tr>
											
                                        </tbody></table>
                                    </td>
                                </tr>
                               
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center"></td>
                    </tr>
                    <tr>
                        <td style="padding-top:20px;padding-left:10px;padding-right:10px" valign="top" align="center">
                            <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                    <td style="padding-bottom:10px;font-size:17px;color:#444444" valign="top" align="center">
                                         <b><span>Maruti Suzuki <?php echo $select_data[0]->model_name ;?></span></b> variants:
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="center"><table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
        <td style="font-size:0" valign="top" align="center">
        	<?php foreach($select_data as $row)
        	{
        		?>
                      <div style="display:inline-block;width:250px;margin:0 18px 15px">
                    <table style="border-collapse:collapse;border:1px solid #bdbdbd" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                            <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px;background-color:#d81416;font-size:13px;color:#ffffff;font-weight:bold" valign="top" align="center">
                                Variant - <a style="color:#ffffff;text-decoration:none" href=""><?php echo $row->variant_name;?></a>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
                                <table style="border-spacing:0;border-collapse:collapse;font-size:13px;color:#444444" width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tbody><tr>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>Ex-Showroom:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="left">
                                               <img src="https://ci5.googleusercontent.com/proxy/qXddpLl3h161zd8agSfo7WRwZ42cLmB3QpQYr8RpaK-w0pc6ycTa1usltcuQE0vamGI0izNIrLVqR-OnP6QFLgt-OfQiK8zr1nvyAXD0hMgA8R6zxTKteMzX5zRh-GZKz8WVCUNUdb0EXRePN59-vSndgArgyheSaR1C_X0=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/48871130-2f34-408d-8bf8-762fb050b59b.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="8" height="11"><span style="display:inline-block;vertical-align:middle"><?php echo $row->ex_showroom;?></span>
                                          </td>
                                    </tr>
                                    <tr style="background-color:#f4f4f4">
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>Registration:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="left">
                                                                                            <img src="https://ci5.googleusercontent.com/proxy/qXddpLl3h161zd8agSfo7WRwZ42cLmB3QpQYr8RpaK-w0pc6ycTa1usltcuQE0vamGI0izNIrLVqR-OnP6QFLgt-OfQiK8zr1nvyAXD0hMgA8R6zxTKteMzX5zRh-GZKz8WVCUNUdb0EXRePN59-vSndgArgyheSaR1C_X0=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/48871130-2f34-408d-8bf8-762fb050b59b.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="8" height="11"><span style="display:inline-block;vertical-align:middle"><?php 
																							if($type=='Company'){ echo round($row->company_registration_with_hp);}else{ echo round($row->individual_registration_with_hp); }
																							?></span>
                                                                                    </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>Insurance:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="left">
                                                                                            <img src="https://ci5.googleusercontent.com/proxy/qXddpLl3h161zd8agSfo7WRwZ42cLmB3QpQYr8RpaK-w0pc6ycTa1usltcuQE0vamGI0izNIrLVqR-OnP6QFLgt-OfQiK8zr1nvyAXD0hMgA8R6zxTKteMzX5zRh-GZKz8WVCUNUdb0EXRePN59-vSndgArgyheSaR1C_X0=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/48871130-2f34-408d-8bf8-762fb050b59b.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="8" height="11"><span style="display:inline-block;vertical-align:middle"><?php echo $row->zero_dep_insurance_with_rti_and_engine_protect;?></span>
                                                                                    </td>
                                    </tr>
									  <tr>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>Nexa/Auto Card:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="left">
                                                                                            <img src="https://ci5.googleusercontent.com/proxy/qXddpLl3h161zd8agSfo7WRwZ42cLmB3QpQYr8RpaK-w0pc6ycTa1usltcuQE0vamGI0izNIrLVqR-OnP6QFLgt-OfQiK8zr1nvyAXD0hMgA8R6zxTKteMzX5zRh-GZKz8WVCUNUdb0EXRePN59-vSndgArgyheSaR1C_X0=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/48871130-2f34-408d-8bf8-762fb050b59b.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="8" height="11"><span style="display:inline-block;vertical-align:middle"><?php echo $row->nexa_card;?></span>
                                                                                    </td>
                                    </tr>
									  <tr>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>Other:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="left">
                                                                                            <img src="https://ci5.googleusercontent.com/proxy/qXddpLl3h161zd8agSfo7WRwZ42cLmB3QpQYr8RpaK-w0pc6ycTa1usltcuQE0vamGI0izNIrLVqR-OnP6QFLgt-OfQiK8zr1nvyAXD0hMgA8R6zxTKteMzX5zRh-GZKz8WVCUNUdb0EXRePN59-vSndgArgyheSaR1C_X0=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/48871130-2f34-408d-8bf8-762fb050b59b.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="8" height="11"><span style="display:inline-block;vertical-align:middle"><?php 
																							if($type=='Company'){ $price_new= round($row->company_on_road_price);}else{ $price_new= round($row->individual_on_road_price); };
																							echo $other=$price_new -($row->ex_showroom+ $row->individual_registration_with_hp + $row->zero_dep_insurance_with_rti_and_engine_protect + $row->nexa_card); ?> </span>
                                                                                    </td>
                                    </tr>
									                                                                         <tr style="background-color:#f4f4f4">
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px" width="50%" valign="top" align="right">
                                            <b>On Road Price:</b>
                                        </td>
                                        <td style="padding-top:7px;padding-bottom:7px;padding-left:5px;padding-right:5px;color:#d6422c;font-weight:bold" width="50%" valign="top" align="left">
                                                                                            <img src="https://ci6.googleusercontent.com/proxy/LE0pPGCnDxTn2E56HhyYPtgXG1TPKoQtaFnSE1sdlsC15na9LbJZ6V8tJ_Om3ftTYLqho4GEzuMhXc3hHARGzrcBAkpNzhm73eTt3zmQkinyt3CrkryQSfXnNeBUMOYbM0w8mFghJxXiCwDAI8SNRSidEHSp412rUDd7BQo=s0-d-e1-ft#https://gallery.mailchimp.com/13a19cc8a86ad7abe7cffd43a/images/04025bd7-6c22-4c91-a2a6-710338272a1e.png" style="display:inline-block;vertical-align:middle" alt="Rupee" class="CToWUd" width="7" height="11"><span style="display:inline-block;vertical-align:middle"><?php if($type=='Company'){ echo round($row->company_on_road_price);}else{ echo round($row->individual_on_road_price); }?></span>
                                                                                    </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <?php } ?>
               
  
                                                                    
              
                                                                                                                                                                                </td>
    </tr>
            <tr>
            <td style="padding-top:20px;padding-left:10px;padding-right:10px" valign="top" align="center">
                <table style="border-collapse:separate;border-radius:2px" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        <td valign="middle" align="center">
                        	<?php if($row->type=='commercial')
                        	{
                        		$link='maruti-commercial/';
                        	}
                        	elseif($row->type=='nexa')
                        	{
                        		$link='/nexa-car/new-car/';
                        	}
                        	else
                        	{
                        		$link='maruti-suzuki/maruti-new-car/';
                        	}?>
						<!--<a href="<?php echo site_url().$link.$row->model_url?>">
<img src="<?php echo base_url();?>assets/images/book_now.png" alt="book test drive" >  </a>-->                     
						</td>
						<td valign="middle" align="center">
                        			<a class="btn-primary site-button bgchange btn-block" href="https://www.autovista.in/<?php echo $link.$row->model_url?>" style="color: #fff;padding: 10px 20px;display: inline-block;font-size: 14px;outline: 0;cursor: pointer;outline: 0;border-width: 0;border-style: solid;border-color: transparent;line-height: 1.42857;font-weight: 400;text-align: center;background-color: #d81416;">
											Book a Test Drive</a>                     
						</td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>
</td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:30px" valign="top" align="center">
                            <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                    <td style="font-size:20px;padding-right:20px;padding-bottom:30px;padding-left:20px;line-height:1.6" valign="top" align="center">
                                     Our Outlets
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0" valign="middle" align="left">
                                        
                                        <div style="display:inline-block;vertical-align:top;width:100%;">
                                            <table style="border-spacing:0;border-collapse:collapse;font-size:13px;line-height:1.4" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody><tr>
                                                    <td valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                                <td style="padding-left:5px;padding-bottom:20px" valign="top" align="left">
                                                                 <a href="https://www.autovista.in/our-outlets/maruti-showroom-in-bandra" target="_blank">
																 Bandra Showroom
																	</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody></table>
                                                    </td>
                                                    <td style="padding-left:5px;padding-right:10px" valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                                <td style="padding-bottom:20px" valign="top" align="left">
																  <a href="https://www.autovista.in/our-outlets/maruti-showroom-in-navi-mumbai" target="_blank">
																Kharghar Showroom</a>
				
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
													 <td style="padding-left:5px;padding-right:10px" valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                                <td style="padding-bottom:20px" valign="top" align="left">
																  <a href="https://www.autovista.in/our-outlets/nexa-showroom-in-thane" target="_blank">
																Thane Nexa Showroom</a>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                        
                                       
										
				 		
									
										 <div style="display:inline-block;vertical-align:top;width:100%;">
                                            <table style="border-spacing:0;border-collapse:collapse;font-size:13px;line-height:1.4" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody><tr>
                                                    <td  valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
															<tr>
															
                                                                <td style="padding-left:5px;padding-bottom:20px" valign="top" align="left">
																  <a href="https://www.autovista.in/our-outlets/maruti-showroom-in-malad" target="_blank">
																Malad Showroom
																</a>
															
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                    <td valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                              <td style="padding-bottom:20px" valign="top" align="left">
															    <a href="https://www.autovista.in/our-outlets/maruti-showroom-in-pune" target="_blank">
																	Magarpatta Showroom
																</a>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
													<td valign="top" align="left">
                                                        <table style="border-spacing:0;border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                              <td style="padding-bottom:20px" valign="top" align="left">
															    <a href="http://nexapune.com" target="_blank">
																	Nexa Baner Showroom
																	</a>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </div>
										
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px;padding-right:15px" valign="top" align="right">
                                        <a href="https://www.autovista.in/contact" style="color:#205194e3;text-decoration:none" target="_blank" >
                                            Know More »
                                        </a>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
   <tr>
                        <td style="background-color:#205194e3;font-size:15px;color:#fff ;border-bottom:1px solid #fff;padding:10px" valign="top" align="center">
                           Payment 100% Advance / Along with order.
                            
                        </td>
                    </tr>
              <tr>
                        <td style="background-color:#205194e3;font-size:15px;color:#fff ;border-bottom:1px solid #fff;padding:10px" valign="top" align="center">
                          Price prevailling at the time of Allotment / Invoicing shall be applicable.
                        </td>
                    </tr>
 <tr>
                        <td style="background-color:#205194e3;font-size:15px;color:#fff ;border-bottom:1px solid #fff;padding:10px" valign="top" align="center">
                          Allotment of vehicle on Seniority of payment (F.O.R. Price / Colour Choice).
                        </td>
                    </tr>
					 <tr>
                        <td style="background-color:#205194e3;font-size:15px;color:#fff ;border-bottom:1px solid #fff;padding:10px" valign="top" align="center">
                         Delivery Subject to availability of Stock & colour with Manufacture.
                        </td>
                    </tr>
 <tr>
                        <td style="background-color:#ffc000;font-size:15px;color:#000 ;border-bottom:1px solid #fff;padding:10px" valign="top" align="center">
                        DD / P.O/CHEQUE IN FAVOUR OF 'EXCELL AUTOVISTA PVT. LTD.
                        </td>
                    </tr>
<?php
	//All Rights put from session
	$form_name = $_SESSION['form_name'];
	$controller_name = $_SESSION['controller_name'];
	$view = $_SESSION['view'];
	if(isset($form_name[15]) && isset($view[15]))
	{
		if($form_name[15]=='Calling Notification' && $view[15]==1)
		{
			?>
				<div class="panel panel-default">
  					<div class="panel-body">  	
					  
					
					  	<?php if($_SESSION['process_id']==9){?>
					  	<a href="<?php echo site_url();?>new_lead/complaint" 	<?php if ($enq == 'New'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>New Leads</a>
					  	<a href="<?php echo site_url();?>today_followup/complaint" <?php if ($enq == 'Today Followup'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Today Followup </a>
					 	<a href="<?php echo site_url();?>pending/complaint_not_attended" <?php if ($enq == 'Pending New'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Pending New </a>
						<a href="<?php echo site_url();?>pending/complaint_attended" <?php if ($enq == 'Pending Followup'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Pending Followup </a>
					 
					  	<?php }else{ ?>
					  	<a href="<?php echo site_url();?>new_lead" <?php if ($enq == 'New'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>New Leads</a>
					  	<a href="<?php echo site_url();?>today_followup"<?php if ($enq == 'Today Followup'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Today Followup </a>
						<a href="<?php echo site_url();?>pending/telecaller_leads_not_attended" <?php if ($enq == 'Pending New'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Pending New </a>
					  	<a href="<?php echo site_url();?>pending/telecaller_leads" <?php if ($enq == 'Pending Followup'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>Pending Followup </a>
					  	
					  		<?php } ?>
					  	
					  
					  
					  
					  	
					  	<?php if($_SESSION['process_id']==6 ||$_SESSION['process_id']==7)
					{?>
					  	<?php if ($enq == 'Home Visit Today'){?>
					  	<a href="<?php echo site_url();?>home_visit/leads" class="btn btn-info">Home Visit Today </a>
					  		<?php }else{?>
					  	<a href="<?php echo site_url();?>home_visit/leads" class="btn btn-defult">Home Visit Today </a>
					  	<?php } ?>
					  		<?php if ($enq == 'Showroom Visit Today'){?>
					  	<a href="<?php echo site_url();?>Showroom_visit/leads" class="btn btn-info">Showroom Visit Today </a>
					  		<?php }else{?>
					  	<a href="<?php echo site_url();?>Showroom_visit/leads" class="btn btn-defult">Showroom Visit Today </a>
					  	<?php } ?>
					  	<?php if ($enq == 'Test Drive Today'){?>
					  	<a href="<?php echo site_url();?>test_drive/leads" class="btn btn-info">Test Drive Today </a>
					  		<?php }else{?>
					  	<a href="<?php echo site_url();?>test_drive/leads" class="btn btn-defult">Test Drive Today </a>
					  	<?php } ?>
					  	<?php if ($enq == 'Evaluation Today'){?>
					  	<a href="<?php echo site_url();?>evaluation/leads" class="btn btn-info">Evaluation Today </a>
					  		<?php }else{?>
					  	<a href="<?php echo site_url();?>evaluation/leads" class="btn btn-defult">Evaluation Today </a>
					  	<?php } ?>
					  		<?php } ?>
					 
					  	<?php if($_SESSION['process_id']==9){?>
					  			<a href="<?php echo site_url();?>website_leads/complaint" <?php if ($enq == 'All'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>All  </a>
					  			 <?php }else{ ?>
					  			 	<a href="<?php echo site_url();?>website_leads/telecaller_leads" <?php if ($enq == 'All'){?>class="btn btn-info" <?php } else{?>class="btn btn-defult"<?php } ?>>All  </a>
					  		<?php }?>
					  
 					</div>
				</div>
			<?php 
		}
	}
?>
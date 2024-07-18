<!DOCTYPE html>
<html><body>
	<div style="text-align: center">
	<h1>Excell Autovista Pvt. Ltd.</h1>												
<h3>257, S. V. Road, Bandra (W), MUMBAI- 400 050, 												
 Tel : <?php echo $select_contact_details[0]->contact_number ;?>, Email : <?php echo $select_contact_details[0]->contact_email ;?>.												
</h3>
</div>
 <table border="1">
 	 <tr>
			
<?php
	for ($j = 1; $j < count($select_coloumns); $j++) {
	
		$coloum=str_replace('_',' ',$select_coloumns[$j] -> COLUMN_NAME);
		echo '<th>'.ucwords($coloum).'</th>';
		}?>
</tr>
 
			
<?php
	foreach ($select_data as $row) {
		echo "<tr>";
		for ($j = 1; $j < count($select_coloumns); $j++) {
		
			$coloum=$select_coloumns[$j] -> COLUMN_NAME;
			echo '<td>'.$row->$coloum.'</td>';
		}
		echo "</tr>";
	}
			
		
		
		?>

</table>

             
              <div>
              	<h4>TERMS & CONDITIONS:</h4>
              	<ul><li>Delivery against full payment in advance</li>
              		<li>Equipment specification & price inclusive of Excise duty & Tax quote above are subject to change without prior notice. </li>
              		<li>Terms & conditions of sale and documents required as per order booking form.</li>
					<li>Prices are subject  to change without prior notice. Prices prevailing at the time of delivery will be applicable irrespective when the initial booking amount was paid.</li>              
 					<li>Cheque, Pay Order or RTGS/NEFT in Favour of <b>'Excell Autovista Pvt. Ltd'</b></li>             	
              	</ul>
              </div>  
				
           <h3>Thanks and regards,</h3>
                <?php if($_SESSION['role']==4){ ?>
        		<h4><?php echo $select_dse_data[0]->fname; ?> </h4>
        		<h4><?php echo $select_dse_data[0]->mobileno; ?> </h4>
        		<?php }else{?>
        			
              <h4>Team Autovista </h4>
             <?php } ?>
             
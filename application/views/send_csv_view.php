<?php

if(isset($select_data))
{

	for ($j = 1; $j < count($select_coloumns); $j++) {
		$coloum=ucwords(str_replace('_',' ',$select_coloumns[$j] -> COLUMN_NAME));
		$coloumn_name1[] = $coloum;
			
		$csv = join(',', $coloumn_name1);
		
		}
	
	foreach ($select_data as $row) {
		$csv.="\n";	

		for ($s = 1; $s < count($select_coloumns); $s++) {
				$coloum=$select_coloumns[$s] -> COLUMN_NAME;
		$value[] = $row->$coloum;
		if($s ==count($select_coloumns)-1){
		
			$csv.=$row->$coloum ;
		}else{
			$csv.=$row->$coloum .',';
		}
		//echo $s;
		//echo count($select_coloumns);
		}
	
	}


	
	 echo $csv;
	
	
$csv_handler = fopen ('car_quotation.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	
}
 /*if(count($select_offer)>0 )
				{
					  	 $csv = "City,Model Name,Description,Amount,MI Disocount,Exchange,Total Benifit \n";//Column headers
	foreach ($select_offer as $record) {

    $csv.= $record->location.','.$record->model.','.$record->description.','.$record->amount.','.$record->mi_discount.','.$record->exchange.','.$record->total_benefit."\n"; //Append data to csv
  
                
    }}
$csv_handler = fopen ('car_consumer_offser.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	*/
				 ?>

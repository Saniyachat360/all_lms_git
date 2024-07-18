
  <script src="<?php echo base_url();?>assets/js/download_excel/FileSaver.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/download_excel/tableexport.min.js"></script>
  <style>
  	.table-condensed caption{
  		display: none;
  	}
  </style>
	<script type="text/javascript">
$(document).ready(function(){
	
	$("table").tableExport({
				headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
				footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
				formats: ["xls"],    // (String[]), filetypes for the export
				fileName: "DSE Daily Report",                    // (id, String), filename for the downloaded file
				bootstrap: true,                   // (Boolean), style buttons using bootstrap
				position: "0,0" ,                // (top, bottom), position of the caption element relative to table
				trimWhitespace:true,
				ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file
				ignoreCols: null,                 // (Number, Number[]), column indices to exclude from the exported file
				ignoreCSS: ".tableexport-ignore"   // (selector, selector[]), selector(s) to exclude from the exported file
				
			});

});
</script>
  <style>
  
  	.btn-toolbar .btn {
	background-color: #1988b6;
	color:#fff;
	float: right;
}
	.btn-default,.btn-default:hover{
		background-color: #1988b6;
	color:#fff;
	float:right;
	}
  </style>
 

<div class="row" id="count_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
<?php if(count($show_data)>0){?>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>DSE name</b></th>
							<th><b>Date/Time</b></th>
							<th><b>Enquiry</b></th>
							<th><b>Walk in</b></th>
							<th><b>Home visit </b></th>
							<th><b>Test Drive</b></th>
							<th><b>Booking</b></th>
							<th><b>Gatepass</b></th>
							<th><b>Evaluation</b></th>
							<th><b>Delivery </b></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; 
					foreach($show_data as $row){
						$i++; 
						?>
					<tr>
						
						<td><?php echo $i;?></td>
							<th><b><?php echo $row->fname.' '.$row->lname;?></b></th>
							<td><?php echo $row->report_date.' / '.$row->report_time;?></td>
							<td><?php echo $row->enquiry_count;?></td>
								<td><?php echo $row->walk_in_count;?></td>
							<td><?php echo $row->home_visit_count;?></td>	
							<td><?php echo $row->test_drive_count;?></td>
								<td><?php echo $row->booking_count;?></td>
									<td><?php echo $row->gatepass_count;?></td>
									<td><?php echo $row->evaluation_count;?></td>
										<td><?php echo $row->delivery_count;?></td>
										
											
					</tr>
					<?php } ?>
				</tbody>
			</table>
			</div>
	
	<?php } else{
		echo "<div class='text-center'>No Record Found</div>";
	}
	?>
	
</div>
					


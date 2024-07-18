<?php if (count($select_leads_tb) > 0) { ?>
	<h1 style="text-align:center; ">Break time Report</h1>

	<div class="col-md-12">
		<table class="table table-bordered datatable" id="table-4">
			<thead>

				<tr>
					<th rowspan="2" class="text-center">Location</th>
					<th rowspan="2" class="text-center">Username</th>
					<th colspan="3" class="text-center">Lunch Break</th>
					<th colspan="3" class="text-center">Tea Break</th>
					<th rowspan="2" class="text-center">Emergancy Break total</th>
					<th rowspan="2" class="text-center">Total Time</th>
					<th rowspan="2" class="text-center">Extra Working Time</th>
				</tr>
				<tr>

					<th>Start Time</th>
					<th>End time</th>
					<th>Total</th>
					<th>Start Time</th>
					<th>End time</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>


			<tbody>


				<?php foreach ($select_leads_tb as $row) {
					//-------Lunch break calculations---------//
					$start_lunchbreak = $row->start_lunchbreak;
					$end_lunchbreak = $row->end_lunchbreak;
					if ($start_lunchbreak != '' && $end_lunchbreak == '00:00:00') {
						$total_lunchbreak_count = 00;
					} else {
						$startTime = new DateTime($start_lunchbreak);
						$endTime = new DateTime($end_lunchbreak);
						// Calculate the difference
						$interval = $startTime->diff($endTime);
						// Extract hours and minutes
						$total_lunchbreak_hours = $interval->h;
						$total_lunchbreak_minutes = $interval->i;
						// Output the result in hours and minutes format
						$total_lunchbreak_count = sprintf('%02d:%02d', $total_lunchbreak_hours, $total_lunchbreak_minutes);
					}
					//-----------eof Lunch break calculate-------------//


					// ---------Tea break calculations-------------//
					$start_teabreak = $row->start_teabreak;
					$end_teabreak = $row->end_teabreak;
					if ($start_teabreak != '' && $end_teabreak == '00:00:00') {
						$total_teabreakcount = 00;
					} else {
						$startTime_t = new DateTime($start_teabreak);
						$endTime_t = new DateTime($end_teabreak);
						// Calculate the difference
						$interval_t = $startTime_t->diff($endTime_t);
						// Extract hours and minutes
						$total_teabreak_hours = $interval_t->h;
						$total_teabreak_minutes = $interval_t->i;
						// Output the result in hours and minutes format
						$total_teabreakcount = sprintf('%02d:%02d', $total_teabreak_hours, $total_teabreak_minutes);
					}
					//-----------eof Tea break calculate-------------//


					//-----------Emergency break-------------//
					$em_break_start_1 = $row->em_break_start_1;
					$em_break_end_1 = $row->em_break_end_1;
					if ($em_break_start_1 != '' && $em_break_end_1 == '00:00:00') {
						$total_em_break_count_1 = 00;
					} else {
						// Convert the string representations to DateTime objects
						$startTime_em = new DateTime($em_break_start_1);
						$endTime_em = new DateTime($em_break_end_1);
						// Calculate the difference
						$interval_em = $startTime_em->diff($endTime_em);
						// Extract hours and minutes
						$total_em_break_hours = $interval_em->h;
						$total_em_break_minutes = $interval_em->i;
						// Output the result in hours and minutes format
						$total_em_break_count_1 = sprintf('%02d:%02d', $total_em_break_hours, $total_em_break_minutes);
					}


					$em_break_start_2 = $row->em_break_start_2;
					$em_break_end_2 = $row->em_break_end_2;
					// Convert the string representations to DateTime objects
					if ($em_break_start_2 != '' && $em_break_end_2 == '00:00:00') {
						$total_em_break_count_2 = 00;
					} else {
						$startTime_em2 = new DateTime($em_break_start_2);
						$endTime_em2 = new DateTime($em_break_end_2);
						// Calculate the difference
						$interval_em2 = $startTime_em2->diff($endTime_em2);
						// Extract hours and minutes
						$total_em_break_hours_2 = $interval_em2->h;
						$total_em_break_minutes_2 = $interval_em2->i;
						// Output the result in hours and minutes format
						$total_em_break_count_2 = sprintf('%02d:%02d', $total_em_break_hours_2, $total_em_break_minutes_2);
					}


					$em_break_start_3 = $row->em_break_start_3;
					$em_break_end_3 = $row->em_break_end_3;
					// Convert the string representations to DateTime objects
					if ($em_break_start_3 != '' && $em_break_end_3 == '00:00:00') {
						$total_em_break_count_3 = 00;
					} else {
						$startTime_em3 = new DateTime($em_break_start_3);
						$endTime_em3 = new DateTime($em_break_end_3);
						// Calculate the difference
						$interval_em3 = $startTime_em3->diff($endTime_em3);
						// Extract hours and minutes
						$total_em_break_hours_3 = $interval_em3->h;
						$total_em_break_minutes_3 = $interval_em3->i;
						// Output the result in hours and minutes format
						$total_em_break_count_3 = sprintf('%02d:%02d', $total_em_break_hours_3, $total_em_break_minutes_3);
					}


					$em_break_start_4 = $row->em_break_start_4;
					$em_break_end_4 = $row->em_break_end_4;
					// Convert the string representations to DateTime objects
					if ($em_break_start_4 != '' && $em_break_end_4 == '00:00:00') {
						$total_em_break_count_4 = 00;
					} else {
						$startTime_em4 = new DateTime($em_break_start_4);
						$endTime_em4 = new DateTime($em_break_end_4);
						// Calculate the difference
						$interval_em4 = $startTime_em4->diff($endTime_em4);
						// Extract hours and minutes
						$total_em_break_hours_4 = $interval_em4->h;
						$total_em_break_minutes_4 = $interval_em4->i;
						// Output the result in hours and minutes format
						$total_em_break_count_4 = sprintf('%02d:%02d', $total_em_break_hours_4, $total_em_break_minutes_4);
					}


					$em_break_start_5 = $row->em_break_start_5;
					$em_break_end_5 = $row->em_break_end_5;
					// Convert the string representations to DateTime objects
					if ($em_break_start_5 != '' && $em_break_end_5 == '00:00:00') {
						$total_em_break_count_5 = 00;
					} else {
						$startTime_em5 = new DateTime($em_break_start_5);
						$endTime_em5 = new DateTime($em_break_end_5);
						// Calculate the difference
						$interval_em5 = $startTime_em5->diff($endTime_em5);
						// Extract hours and minutes
						$total_em_break_hours_5 = $interval_em5->h;
						$total_em_break_minutes_5 = $interval_em5->i;
						// Output the result in hours and minutes format
						$total_em_break_count_5 = sprintf('%02d:%02d', $total_em_break_hours_5, $total_em_break_minutes_5);
					}



					$em_break_start_6 = $row->em_break_start_6;
					$em_break_end_6 = $row->em_break_end_6;
					if ($em_break_start_6 != '' && $em_break_end_6 == '00:00:00') {
						$total_em_break_count_6 = 00;
					} else {
						// Convert the string representations to DateTime objects
						$startTime_em6 = new DateTime($em_break_start_6);
						$endTime_em6 = new DateTime($em_break_end_6);
						// Calculate the difference
						$interval_em6 = $startTime_em6->diff($endTime_em6);
						// Extract hours and minutes
						$total_em_break_hours_6 = $interval_em6->h;
						$total_em_break_minutes_6 = $interval_em6->i;
						// Output the result in hours and minutes format
						$total_em_break_count_6 = sprintf('%02d:%02d', $total_em_break_hours_6, $total_em_break_minutes_6);
					}



					$em_break_start_7 = $row->em_break_start_7;
					$em_break_end_7 = $row->em_break_end_7;
					if ($em_break_start_7 != '' && $em_break_end_7 == '00:00:00') {
						$total_em_break_count_7 = 00;
					} else {
						// Convert the string representations to DateTime objects
						$startTime_em7 = new DateTime($em_break_start_7);
						$endTime_em7 = new DateTime($em_break_end_7);
						// Calculate the difference
						$interval_em7 = $startTime_em7->diff($endTime_em7);
						// Extract hours and minutes
						$total_em_break_hours_7 = $interval_em7->h;
						$total_em_break_minutes_7 = $interval_em7->i;
						// Output the result in hours and minutes format
						$total_em_break_count_7 = sprintf('%02d:%02d', $total_em_break_hours_7, $total_em_break_minutes_7);
					}



					$em_break_start_8 = $row->em_break_start_8;
					$em_break_end_8 = $row->em_break_end_8;
					if ($em_break_start_8 != '' && $em_break_end_8 == '00:00:00') {
						$total_em_break_count_8 = 00;
					} else {
						// Convert the string representations to DateTime objects
						$startTime_em8 = new DateTime($em_break_start_8);
						$endTime_em8 = new DateTime($em_break_end_8);
						// Calculate the difference
						$interval_em8 = $startTime_em8->diff($endTime_em8);
						// Extract hours and minutes
						$total_em_break_hours_8 = $interval_em8->h;
						$total_em_break_minutes_8 = $interval_em8->i;
						// Output the result in hours and minutes format
						$total_em_break_count_8 = sprintf('%02d:%02d', $total_em_break_hours_8, $total_em_break_minutes_8);
					}


					$em_break_start_9 = $row->em_break_start_9;
					$em_break_end_9 = $row->em_break_end_9;
					// Convert the string representations to DateTime objects
					if ($em_break_start_9 != '' && $em_break_end_9 == '00:00:00') {
						$total_em_break_count_9 = 00;
					} else {
						$startTime_em9 = new DateTime($em_break_start_9);
						$endTime_em9 = new DateTime($em_break_end_9);
						// Calculate the difference
						$interval_em9 = $startTime_em9->diff($endTime_em9);
						// Extract hours and minutes
						$total_em_break_hours_9 = $interval_em9->h;
						$total_em_break_minutes_9 = $interval_em9->i;
						// Output the result in hours and minutes format
						$total_em_break_count_9 = sprintf('%02d:%02d', $total_em_break_hours_9, $total_em_break_minutes_9);
					}


					$em_break_start_10 = $row->em_break_start_10;
					$em_break_end_10 = $row->em_break_end_10;
					// Convert the string representations to DateTime objects
					if ($em_break_start_10 != '' && $em_break_end_10 == '00:00:00') {
						$total_em_break_count_10 = 00;
					} else {
						$startTime_em10 = new DateTime($em_break_start_10);
						$endTime_em10 = new DateTime($em_break_end_10);
						// Calculate the difference
						$interval_em10 = $startTime_em10->diff($endTime_em10);
						// Extract hours and minutes
						$total_em_break_hours_10 = $interval_em10->h;
						$total_em_break_minutes_10 = $interval_em10->i;
						// Output the result in hours and minutes format
						$total_em_break_count_10 = sprintf('%02d:%02d', $total_em_break_hours_10, $total_em_break_minutes_10);
					}


					if (!function_exists('convertToMinutes')) {
						// Function to convert time format to minutes
						function convertToMinutes($time)
						{
							list($hours, $minutes) = explode(':', $time);
							return $hours * 60 + $minutes;
						}
					}

					// Convert time durations to minutes
					if ($total_em_break_count_1 == '') {
						$total_em_break_count_1 = 00;
					} else {
						$total_em_break_count_1 = convertToMinutes($total_em_break_count_1);
					}

					if ($total_em_break_count_2 == '') {
						$total_em_break_count_2 = 00;
					} else {
						$total_em_break_count_2 = convertToMinutes($total_em_break_count_2);
					}

					if ($total_em_break_count_3 == '') {
						$total_em_break_count_3 = 00;
					} else {
						$total_em_break_count_3 = convertToMinutes($total_em_break_count_3);
					}

					if ($total_em_break_count_4 == '') {
						$total_em_break_count_4 = 00;
					} else {
						$total_em_break_count_4 = convertToMinutes($total_em_break_count_4);
					}

					if ($total_em_break_count_5 == '') {
						$total_em_break_count_5 = 0;
					} else {
						$total_em_break_count_5 = convertToMinutes($total_em_break_count_5);
					}

					if ($total_em_break_count_6 == '') {
						$total_em_break_count_6 = 00;
					} else {
						$total_em_break_count_6 = convertToMinutes($total_em_break_count_6);
					}

					if ($total_em_break_count_7 == '') {
						$total_em_break_count_7 = 00;
					} else {
						$total_em_break_count_7 = convertToMinutes($total_em_break_count_7);
					}

					if ($total_em_break_count_8 == '') {
						$total_em_break_count_8 = 00;
					} else {
						$total_em_break_count_8 = convertToMinutes($total_em_break_count_8);
					}

					if ($total_em_break_count_9 == '') {
						$total_em_break_count_9 = 00;
					} else {
						$total_em_break_count_9 = convertToMinutes($total_em_break_count_9);
					}

					if ($total_em_break_count_10 == '') {
						$total_em_break_count_10 = 00;
					} else {
						$total_em_break_count_10 = convertToMinutes($total_em_break_count_10);
					}
					// Calculate total time in minutes
					$total_time_minutes_em = $total_em_break_count_1 + $total_em_break_count_2 + $total_em_break_count_3 + $total_em_break_count_4 + $total_em_break_count_5 + $total_em_break_count_6 + $total_em_break_count_7 + $total_em_break_count_8 + $total_em_break_count_9 + $total_em_break_count_10;
					// Convert total time back to hh:mm format
					$total_sum_lms = sprintf('%02d:%02d', floor($total_time_minutes_em / 60), $total_time_minutes_em % 60);
					//-----------eof Emergency break-------------//


					//total time calculate
					if ($total_teabreakcount == '') {
						$total_teabreakcount1 = 00;
					} else {
						$total_teabreakcount1 = convertToMinutes($total_teabreakcount);
					}

					if ($total_lunchbreak_count == '') {
						$total_lunchbreak_count1 = 00;
					} else {
						$total_lunchbreak_count1 = convertToMinutes($total_lunchbreak_count);
					}

					if ($total_sum_lms == '') {
						$total_sum_lms1 = 00;
					} else {
						$total_sum_lms1 = convertToMinutes($total_sum_lms);
					}



					// Calculate total time in minutes
					$total_time_minutes = $total_teabreakcount1 + $total_lunchbreak_count1 + $total_sum_lms1;
					// Convert total time back to hh:mm format
					$total_time = sprintf('%02d:%02d', floor($total_time_minutes / 60), $total_time_minutes % 60);
					//-----------eof total time calculate-------------//



					//extra working time calculate
					$total_time_minutes = convertToMinutes($total_time);
					// Check if total time is less than 60 minutes
					if ($total_time_minutes < 60) {
						// If less than 60 minutes, calculate extra working time as 60 minutes minus total time
						$extra_working_minutes = 60 - $total_time_minutes;
					} else {
						// If 60 minutes or more, subtract 60 minutes (1 hour) for extra working time
						$extra_working_minutes = $total_time_minutes - 60;
					}
					// Convert extra working time back to hh:mm format
					$extra_working_time = sprintf('%02d:%02d', floor($extra_working_minutes / 60), $extra_working_minutes % 60);
					//-----------eof extra working time-------------//


				?>

					<tr>
						<td><?php echo $row->location; ?></td>
						<td><?php echo $row->fname; ?></td>
						<td><?php echo $start_lunchbreak; ?></td>
						<td><?php echo $end_lunchbreak; ?></td>
						<td><?php echo "Total Lunch Break: " . $total_lunchbreak_count; ?></td>
						<td><?php echo $start_teabreak; ?></td>
						<td><?php echo $end_teabreak; ?></td>
						<td><?php echo "Total Tea Break: " . $total_teabreakcount; ?></td>
						<td><?php echo "Total EM Break: " . $total_sum_lms; ?></td>
						<td><?php echo $total_time ?></td>
						<td><?php if ($total_time_minutes < 60) {
								echo "<span style='color: green;'>No Extra Work: $extra_working_time</span>";
							} else {
								echo "<span style='color: red;'>Extra Work Time: $extra_working_time</span>";
							} ?>
						</td>

					</tr>
				<?php } ?>

			</tbody>

		</table>
	</div>
<?php } else {
	echo "<div class='text-center'>No Record Found</div>";
}
?>
</div>
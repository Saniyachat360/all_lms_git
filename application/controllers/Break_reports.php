<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Break_reports extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('break_reports_model'));
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$this->session();
		$to_date = $this->input->post('to_date');
		$location = $this->input->post('location');
		$data['to_date'] = $to_date;
		$data['select_location'] = $this->break_reports_model->select_location();
		$data['select_leads_tb'] = $this->break_reports_model->select_leads_break($location, $to_date);
		$this->load->view('include/admin_header.php');
		$this->load->view('report/breaktime_report_view.php', $data);
		$this->load->view('include/footer.php');
	}

	public function search_break()
	{
		$this->session();
		$to_date = $this->input->post('to_date');
		$location = $this->input->post('location');
		$data['to_date'] = $to_date;
		$data['select_leads_tb'] = $this->break_reports_model->select_leads_break($location, $to_date);
		//var_dump($data['select_leads_tb']);die;
		$this->load->view('report/breaktime_filter_report_view.php', $data);
	}

	public function break_time_all_download()
	{
		$location = $this->input->post('location');
		//echo "hii--".$location;die;
		$to_date = $this->input->post('to_date');
		$query = $this->break_reports_model->select_break_time_excel_download();



		$csv = "Sr No, Location, Name, Start Lunch break , End Lunch break, Total Lunch Time, Start Tea Break, End Tea Break, Total Tea break, Total Emergancy break, Total time(waste time),Extra Working time\n";

		$i = 0;
		foreach ($query as $row) {
			$i++;
			//-------Lunch break calculations---------//
			$start_lunchbreak = $row->start_lunchbreak;
			$end_lunchbreak = $row->end_lunchbreak;
			$startTime = new DateTime($start_lunchbreak);
			$endTime = new DateTime($end_lunchbreak);
			// Calculate the difference
			$interval = $startTime->diff($endTime);
			// Extract hours and minutes
			$total_lunchbreak_hours = $interval->h;
			$total_lunchbreak_minutes = $interval->i;
			// Output the result in hours and minutes format
			$total_lunchbreak_count = sprintf('%02d:%02d', $total_lunchbreak_hours, $total_lunchbreak_minutes);
			//-----------eof Lunch break calculate-------------//


			// ---------Tea break calculations-------------//
			$start_teabreak = $row->start_teabreak;
			$end_teabreak = $row->end_teabreak;
			$startTime_t = new DateTime($start_teabreak);
			$endTime_t = new DateTime($end_teabreak);
			// Calculate the difference
			$interval_t = $startTime_t->diff($endTime_t);
			// Extract hours and minutes
			$total_teabreak_hours = $interval_t->h;
			$total_teabreak_minutes = $interval_t->i;
			// Output the result in hours and minutes format
			$total_teabreakcount = sprintf('%02d:%02d', $total_teabreak_hours, $total_teabreak_minutes);
			//-----------eof Tea break calculate-------------//


			//-----------Emergency break-------------//
			$em_break_start_1 = $row->em_break_start_1;
			$em_break_end_1 = $row->em_break_end_1;
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

			$em_break_start_2 = $row->em_break_start_2;
			$em_break_end_2 = $row->em_break_end_2;
			// Convert the string representations to DateTime objects
			$startTime_em2 = new DateTime($em_break_start_2);
			$endTime_em2 = new DateTime($em_break_end_2);
			// Calculate the difference
			$interval_em2 = $startTime_em2->diff($endTime_em2);
			// Extract hours and minutes
			$total_em_break_hours_2 = $interval_em2->h;
			$total_em_break_minutes_2 = $interval_em2->i;
			// Output the result in hours and minutes format
			$total_em_break_count_2 = sprintf('%02d:%02d', $total_em_break_hours_2, $total_em_break_minutes_2);

			$em_break_start_3 = $row->em_break_start_3;
			$em_break_end_3 = $row->em_break_end_3;
			// Convert the string representations to DateTime objects
			$startTime_em3 = new DateTime($em_break_start_3);
			$endTime_em3 = new DateTime($em_break_end_3);
			// Calculate the difference
			$interval_em3 = $startTime_em3->diff($endTime_em3);
			// Extract hours and minutes
			$total_em_break_hours_3 = $interval_em3->h;
			$total_em_break_minutes_3 = $interval_em3->i;
			// Output the result in hours and minutes format
			$total_em_break_count_3 = sprintf('%02d:%02d', $total_em_break_hours_3, $total_em_break_minutes_3);

			$em_break_start_4 = $row->em_break_start_4;
			$em_break_end_4 = $row->em_break_end_4;
			// Convert the string representations to DateTime objects
			$startTime_em4 = new DateTime($em_break_start_4);
			$endTime_em4 = new DateTime($em_break_end_4);
			// Calculate the difference
			$interval_em4 = $startTime_em4->diff($endTime_em4);
			// Extract hours and minutes
			$total_em_break_hours_4 = $interval_em4->h;
			$total_em_break_minutes_4 = $interval_em4->i;
			// Output the result in hours and minutes format
			$total_em_break_count_4 = sprintf('%02d:%02d', $total_em_break_hours_4, $total_em_break_minutes_4);

			$em_break_start_5 = $row->em_break_start_5;
			$em_break_end_5 = $row->em_break_end_5;
			// Convert the string representations to DateTime objects
			$startTime_em5 = new DateTime($em_break_start_5);
			$endTime_em5 = new DateTime($em_break_end_5);
			// Calculate the difference
			$interval_em5 = $startTime_em5->diff($endTime_em5);
			// Extract hours and minutes
			$total_em_break_hours_5 = $interval_em5->h;
			$total_em_break_minutes_5 = $interval_em5->i;
			// Output the result in hours and minutes format
			$total_em_break_count_5 = sprintf('%02d:%02d', $total_em_break_hours_5, $total_em_break_minutes_5);

			$em_break_start_6 = $row->em_break_start_6;
			$em_break_end_6 = $row->em_break_end_6;
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

			$em_break_start_7 = $row->em_break_start_7;
			$em_break_end_7 = $row->em_break_end_7;
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

			$em_break_start_8 = $row->em_break_start_8;
			$em_break_end_8 = $row->em_break_end_8;
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

			$em_break_start_9 = $row->em_break_start_9;
			$em_break_end_9 = $row->em_break_end_9;
			// Convert the string representations to DateTime objects
			$startTime_em9 = new DateTime($em_break_start_9);
			$endTime_em9 = new DateTime($em_break_end_9);
			// Calculate the difference
			$interval_em9 = $startTime_em9->diff($endTime_em9);
			// Extract hours and minutes
			$total_em_break_hours_9 = $interval_em9->h;
			$total_em_break_minutes_9 = $interval_em9->i;
			// Output the result in hours and minutes format
			$total_em_break_count_9 = sprintf('%02d:%02d', $total_em_break_hours_9, $total_em_break_minutes_9);

			$em_break_start_10 = $row->em_break_start_10;
			$em_break_end_10 = $row->em_break_end_10;
			// Convert the string representations to DateTime objects
			$startTime_em10 = new DateTime($em_break_start_10);
			$endTime_em10 = new DateTime($em_break_end_10);
			// Calculate the difference
			$interval_em10 = $startTime_em10->diff($endTime_em10);
			// Extract hours and minutes
			$total_em_break_hours_10 = $interval_em10->h;
			$total_em_break_minutes_10 = $interval_em10->i;
			// Output the result in hours and minutes format
			$total_em_break_count_10 = sprintf('%02d:%02d', $total_em_break_hours_10, $total_em_break_minutes_10);

			if (!function_exists('convertToMinutes')) {
				// Function to convert time format to minutes
				function convertToMinutes($time)
				{
					list($hours, $minutes) = explode(':', $time);
					return $hours * 60 + $minutes;
				}
			}

			// Convert time durations to minutes
			$total_em_break_count_1 = convertToMinutes($total_em_break_count_1);
			$total_em_break_count_2 = convertToMinutes($total_em_break_count_2);
			$total_em_break_count_3 = convertToMinutes($total_em_break_count_3);
			$total_em_break_count_4 = convertToMinutes($total_em_break_count_4);
			$total_em_break_count_5 = convertToMinutes($total_em_break_count_5);
			$total_em_break_count_6 = convertToMinutes($total_em_break_count_6);
			$total_em_break_count_7 = convertToMinutes($total_em_break_count_7);
			$total_em_break_count_8 = convertToMinutes($total_em_break_count_8);
			$total_em_break_count_9 = convertToMinutes($total_em_break_count_9);
			$total_em_break_count_10 = convertToMinutes($total_em_break_count_10);
			// Calculate total time in minutes
			$total_time_minutes_em = $total_em_break_count_1 + $total_em_break_count_2 + $total_em_break_count_3 + $total_em_break_count_4 + $total_em_break_count_5 + $total_em_break_count_6 + $total_em_break_count_7 + $total_em_break_count_8 + $total_em_break_count_9 + $total_em_break_count_10;
			// Convert total time back to hh:mm format
			$total_sum_lms = sprintf('%02d:%02d', floor($total_time_minutes_em / 60), $total_time_minutes_em % 60);
			//-----------eof Emergency break-------------//


			//total time calculate
			$total_teabreak_minutes = convertToMinutes($total_teabreakcount);
			$total_lunchbreak_minutes = convertToMinutes($total_lunchbreak_count);
			$total_emergencybreak_minutes = convertToMinutes($total_sum_lms);
			// Calculate total time in minutes
			$total_time_minutes = $total_teabreak_minutes + $total_lunchbreak_minutes + $total_emergencybreak_minutes;
			// Convert total time back to hh:mm format
			$total_time = sprintf('%02d:%02d', floor($total_time_minutes / 60), $total_time_minutes % 60);
			//-----------eof total time calculate-------------//

			//extra working time calculate
			$total_time_minutes = convertToMinutes($total_time);
			// Subtract 60 minutes (1 hour) for extra working time
			$extra_working_minutes = $total_time_minutes - 60;
			// Convert extra working time back to hh:mm format
			$extra_working_time = sprintf('%02d:%02d', floor($extra_working_minutes / 60), $extra_working_minutes % 60);
			//-----------eof extra working time-------------//

			$csv .= $i . ',"' . $row->location . '","' . $row->fname . '","' . $row->start_lunchbreak . '","' . $row->end_lunchbreak . '","' . $total_lunchbreak_count . '","' . $row->start_teabreak . '","' . $row->end_teabreak . '","' . $total_teabreakcount . '","' . $total_sum_lms . '","' . $total_time . '","' . $extra_working_time . '"' . "\n";
		}
		
		//$csv_handler = fopen('php://output', 'w');
		$csv_handler = fopen('tracker3.csv', 'w');
		fwrite($csv_handler, $csv);
		fclose($csv_handler);

		$this->load->helper('download');
		$filename = 'break_time_report' . $location . ' - ' . $to_date . '.csv';
		$data_file = file_get_contents('https://www.autovista.in/all_lms/payment_all.csv'); // Read the file's contents
		// echo $data_file;
		//  echo "https://www.autovista.in/all_lms/tracker.csv";
		force_download($filename, $csv);
	}
}

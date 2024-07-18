<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_dialer extends CI_Controller
{

	

	public function session_id_dialer()
	{
		// Initialize cURL
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crm5.cloud-connect.in/CCC_api/v1.4/clickToCallManual',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
			"action":"Call",
			"agent_id":"3322",
			"agent_session_id":"524833",
			"customer_phone":"7827966682",
			"camp_id":"2115",
			"tenant_id":"1205"
}',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
}

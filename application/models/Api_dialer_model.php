<?php
defined('BASEPATH') or exit('No direct script access allowed');
class api_dialer_model extends CI_model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->today = date('Y-m-d');
		$this->time = date("h:i:s A");
	}

	public function getsession_api($agent_username, $agent_password)
	{
		// echo "agentusername--" . $agent_username;
		// echo "password--" . $agent_password;


		$data = array(
			"agent_username" => $agent_username,
			"agent_password" => $agent_password,
			"loginType" => "AUTO",
			"campaign_name" => "6010",
			"token" => "iA77xYjSu7zWC4Mw",
			"tenant_id" => "1205"
		);

		$payload = json_encode($data);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crm5.cloud-connect.in/CCC_api/v1.4/createSession',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $payload,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

		$response1 = json_decode($response, true);
		var_dump($response1);
		
		$sessionValue = $response1["session"];
		//session_start();
       echo  "seddd-".$_SESSION['session'] =  $sessionValue;

	//	header("Location: website_leads/telecaller_leads");
	//edirect('website_leads/telecaller_leads');

	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class upload_quotation_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');
	
		$this -> process_id = $_SESSION['process_id'];
		
	}

	public function upload($upload_id,$location,$model_id,$model,$variant,$ex_showroom,$registration,$insurance,$nexa_card,$warranty,$on_road_price,$date)
		
		 {

		$date = date("Y-m-d");
		
		$query = $this -> db -> query("INSERT INTO `tbl_quotation`(`location`, `model_id`, `model`, `variant`, `ex_showroom`, `registration`, `insurance`, `nexa_card`, `warranty`, `on_road_price`, `date`,`upload_id`) 
		VALUES ('$location','$model_id','$model','$variant','$ex_showroom','$registration','$insurance','$nexa_card','$warranty','$on_road_price','$date','$upload_id')");
	}
	public function upload_corporate($corporate_name,$date){
		//$test=$this->escape_str($corporate_name);
		$corporate_name=addslashes($corporate_name);
		$this->db->query("INSERT INTO `tbl_corporate`(`corporate_name`,`created_date`) VALUES ('$corporate_name','$date')");
	}
		


}

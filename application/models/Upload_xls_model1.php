<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class upload_xls_model1 extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	

	public function upload($outlet_name,$supplier_category,$supplier,$model,$sub_model_code,$submodel,$color_code,$color,$fuel_type,$chassis_number,$engine_number,$key_no,$dealer_vin_no,$vehicle_status,$acc_issued_amount,$quality_status,$octroi,$manuf_fin_number,$manuf_fin_date,$gp_number,$veh_order_cat,$INF_financier,$receipt_number,$receipt_date,$order_number,$customer_name,$alloted_date,$rto_invoiceNo,$rto_invoice_date,$purchase_price,$stock_location,$assigned_location,$bin_no,$dse_executive,$team_leader,$purchase_remarks,$damage_remarks,$year_of_mfr_invoice,$rebilled,$gate_pass_no,$gate_pass_date,$ageing)
	 {
		
	
			$created_date = date("Y-m-d");
		
			$this -> db -> select('model_id');
			$this -> db -> from('make_models');

			if($model == 'WAGON-R')
			{
				
				$this -> db -> where('model_name', 'Wagon R');
				
			}
		else {
			
		$this -> db -> where('model_name', $model);
			}
		
			$query = $this -> db -> get() -> result();
			
		//	print_r($query);
			
			foreach ($query as $row) {

			$model_id = $row -> model_id;

			echo $model_id;
		
			if($vehicle_status == 'FREE' || $vehicle_status == 'BLOCKED' )
			{
				
			$query=$this->db->query("insert into tbl_stock_in_hand_new (`outlet_name`,`supplier_category`,`supplier`,`model`,`sub_model_code`,`submodel`,`color_code`,`color`,`fuel_type`,`chassis_number`,`engine_number`,`key_no`,`dealer_vin_no`,`vehicle_status`,`acc_issued_amount`,`quality_status`,`octroi`,`manuf_fin_number`,`manuf_fin_date`,`gp_number`,`veh_order_cat`,`INF_financier`,`receipt_number`,`receipt_date`,`order_number`,`customer_name`,`alloted_date`,`rto_invoiceNo`,`rto_invoice_date`,`purchase_price`,`stock_location`,`assigned_location`,`bin_no`,`dse_executive`,`team_leader`,`purchase_remarks`,`damage_remarks`,`year_of_mfr_invoice`,`rebilled`,`gate_pass_no`,`gate_pass_date`,`ageing`,`created_date`)
			
			values('".$outlet_name."','".$supplier_category."','".$supplier."','".$model_id."','".$sub_model_code."','".$submodel."','".$color_code."','".$color."','".$fuel_type."','".$chassis_number."','".$engine_number."','".$key_no."','".$dealer_vin_no."','".$vehicle_status."','".$acc_issued_amount."','".$quality_status."','".$octroi."','".$manuf_fin_number."','".$manuf_fin_date."','".$gp_number."','".$veh_order_cat."','".$INF_financier."','".$receipt_number."','".$receipt_date."','".$order_number."','".$customer_name."','".$alloted_date."','".$rto_invoiceNo."','".$rto_invoice_date."','".$purchase_price."','".$stock_location."','".$assigned_location."','".$bin_no."','".$dse_executive."','".$team_leader."','".$purchase_remarks."','".$damage_remarks."','".$year_of_mfr_invoice."','".$rebilled."','".$gate_pass_no."','".$gate_pass_date."','".$ageing."','".$created_date."')");
		
			}
			
		
			
		}
		
		
	}

		public function upload2($outlet_name, $make, $model, $submodel, $color, $fuel_type, $rto_no, $reg_date, $chassis_number, $engine_number, $mfg_year, $mfg_month, $owner, $odo_meter,$insurance_type, $insurance_expiry_date, $category, $rc_status, $quality_status, $expt_selling_price,$ageing, $stock_location)
	 {
	echo	$make_count=count($make);
		//echo count($model);
	//	print_r($submodel);
		$query=$this->db->query("delete from tbl_stock_in_hand_poc");
		for($i=0;$i<$make_count;$i++){
		   /* if($i==90)
		    {
		        break;
		    }*/
				$created_date = date("Y-m-d");		
				//echo "hi";
		
	
			$this -> db -> select('make_id');
			$this -> db -> from('makes');
			$this->db->where('make_name',$make[$i]);
			$query=$this->db->get()->result();
		//	print_r($query);
			
			
			$make_id_count=count($query);
			
			if($make_id_count < 1)
			{
			    if($make[$i] !='')
			    {
				
				$query1=$this->db->query("insert into makes (`make_name`) values('".$make[$i]."')");
				$insert_id = $this->db->insert_id();
				$make_id=$insert_id;
			    }
				else
				{
				    $make_id=0;
				}
			}
			
			else {
			
			$make_id=$query[0]->make_id;
				
			
				}



				$query=$this->db->query
				
				("insert into tbl_stock_in_hand_poc (`outlet_name`,`make`,`model`,`submodel`,`color`,`fuel_type`,`rto_no`,`reg_date`,`chassis_number`,
				
				`engine_number`,`mfg_year`,`mfg_month`,`owner`,`odo_meter`,`insurance_type`,`insurance_expiry_date`,`category`,`rc_status`,`quality_status`,
				
				`expt_selling_price`,`ageing`,`stock_location`,`created_date`)
				
				values('".$outlet_name[$i]."','".$make_id."','".$model[$i]."','".$submodel[$i]."','".$color[$i]."','".$fuel_type[$i]."','".$rto_no[$i]."','".$reg_date[$i]."','".$chassis_number[$i]."',
				
				'".$engine_number[$i]."','".$mfg_year[$i]."','".$mfg_month[$i]."','".$owner[$i]."','".$odo_meter[$i]."','".$insurance_type[$i]."','".$insurance_expiry_date[$i]."','".$category[$i]."','".$rc_status[$i]."','".$quality_status[$i]."','".$expt_selling_price[$i]."','".$ageing[$i]."','".$stock_location[$i]."','".$created_date."'
			
				)");
				
				
				
				
				//	echo $this->db->last_query();
					
			
			}
	 
	 }
	



}
?>
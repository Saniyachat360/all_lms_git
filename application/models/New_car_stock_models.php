<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class new_car_stock_models extends CI_model {
	function __construct() {
		parent::__construct();
	}
	function select_new_stock(){
		//$make=$this->input->post('make');
		$assigned_location=$this->input->post('assigned_location');
		 $model=$this->input->post('model');
		
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
	//	print_r($max_id1);
		foreach($max_id1 as $row)
		{
		 	$upload_id = $row->upload_id;
			
		}	
	//	echo 	$upload_id;
		$this -> db -> select('count(st.submodel) as model_count,st.submodel,model_name,assigned_location');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models mk', 'mk.model_id=st.model','left');
		$this -> db -> where('upload_id', $upload_id);
			if($model!=''){
			$this -> db -> where('submodel',$model);
		}
			if($assigned_location!=''){
			$this -> db -> where('st.assigned_location', $assigned_location);
		}
		/*if($make!=''){
			$this -> db -> where('make', $make);
		}
		*/
		$this->db->group_by('st.submodel');
		$query1 = $this -> db -> get()-> result();
		//echo $this->db->last_query();
		
		//echo count($query1);
		//print_r($query1);
		if(count($query1)>0){
		foreach($query1 as $row){
		//	echo $row->submodel;
			$a1=1;
			$a2=2;
			$a3=3;
			$a4=4;
			$vehicle_status_1=$this->select_new_stock_vehicle_status($row->submodel,$upload_id,$a1,$assigned_location);
			$vehicle_status_2=$this->select_new_stock_vehicle_status($row->submodel,$upload_id,$a2,$assigned_location);
		
			$ageing_1=$this->select_ageing($row->submodel,$upload_id,$a1,$assigned_location);
			$ageing_2=$this->select_ageing($row->submodel,$upload_id,$a2,$assigned_location);
			$ageing_3=$this->select_ageing($row->submodel,$upload_id,$a3,$assigned_location);
			$ageing_4=$this->select_ageing($row->submodel,$upload_id,$a4,$assigned_location);
			
			$price_1=$this->select_price($row->submodel,$upload_id,$a1,$assigned_location);
			$price_2=$this->select_price($row->submodel,$upload_id,$a2,$assigned_location);
			$price_3=$this->select_price($row->submodel,$upload_id,$a3,$assigned_location);
			$price_4=$this->select_price($row->submodel,$upload_id,$a4,$assigned_location);
			
			
			
			$select_data[]=array('model_name'=>$row->model_name,'assigned_location'=>$assigned_location,'submodel'=>$row->submodel,'model_count'=>$row->model_count,'vehicle_status_1'=>$vehicle_status_1,'vehicle_status_2'=>$vehicle_status_2,'ageing_1'=>$ageing_1,'ageing_2'=>$ageing_2,'ageing_3'=>$ageing_3,'ageing_4'=>$ageing_4,'price_1'=>$price_1,'price_2'=>$price_2,'price_3'=>$price_3,'price_4'=>$price_4);
		
		}
		}else{
			$select_data=array();
		}
		return $select_data;
	}
	function select_new_stock_vehicle_status($submodel,$upload_id,$filterElement,$assigned_location){
		$this -> db -> select('count(id) as vehicle_status');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		if($filterElement==1)
		{
			$this->db->where('st.vehicle_status ','FREE');
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.vehicle_status ','BLOCKED');
		}
		
		/*if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}*/
			if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
			}
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
			$query = $this -> db -> get()->result();
		$tcount=$query[0]->vehicle_status;
	//	echo $this->db->last_query();
		return $tcount; 
	}
	function select_ageing($submodel,$upload_id,$filterElement,$assigned_location)
	{
		$this -> db -> select('count(id) as ageing');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		if($filterElement==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		elseif($filterElement==4)
		{
			$this->db->where('st.ageing >',60);
		}
		/*if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}*/
			if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->ageing;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_price($submodel,$upload_id,$filterElement,$assigned_location)
	{
		$this -> db -> select('count(id) as price');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		if($filterElement==1)
		{
			$this->db->where('st.purchase_price <','400000');	
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.purchase_price <=',600000);
			$this->db->where('st.purchase_price >=',400000);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.purchase_price <=',800000);
			$this->db->where('st.purchase_price >=',600000);
		}
		elseif($filterElement==4)
		{
			
			$this->db->where('st.purchase_price >=',800000);
		}
	/*	if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}*/
			if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->price;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_stock()
	{
		

		$this->db->select_max('created_date');
		$this->db->from('tbl_stock_in_hand_new');
		$max_date1=$this->db->get()->result();
		
		foreach($max_date1 as $row)
		{
			$max_date=$row->created_date;
			
		}

		$this -> db -> select('st.submodel,st.color,st.fuel_type,st.vehicle_status,st.assigned_location,st.ageing,st.created_date,st.created_date,m.model_name');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models m', 'm.model_id=st.model');
		$this->db->where('created_date',$max_date);
		$query = $this -> db -> get();
		return $query -> result();
	}
	function select_model() {
		$this->db->distinct();	
		$this -> db -> select('model_id,model_name');
		$this -> db -> from('tbl_stock_in_hand_new t');
		$this -> db -> from('make_models m','m.model_id=t.model');
		$query = $this -> db -> get();
		return $query -> result();
	}

		function select_submodel() {
			$model=$this->input->post('model');
		$this->db->distinct();	
		$this -> db -> select('submodel');
		$this -> db -> from('tbl_stock_in_hand_new');
		$this->db->where('model',$model);
		$query = $this -> db -> get();
		return $query -> result();
	}


		function assigned_location() {
		$this->db->distinct();		
		$this -> db -> select('assigned_location');
		$this -> db -> from('tbl_stock_in_hand_new');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function select_stock_list()
	{
		$submodel=$this->input->get('submodel');
		$assigned_location=$this->input->get('assigned_location');
		$filterElement=$this->input->get('id');
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}

		$this -> db -> select('mk.model_name,st.submodel,st.color,st.fuel_type,st.vehicle_status,st.assigned_location,st.ageing,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models mk', 'mk.model_id=st.model');
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		
		if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		if($filterElement==1)
		{
			$this->db->where('st.vehicle_status ','FREE');
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.vehicle_status ','BLOCKED');
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.ageing <',15);	
		}
		elseif($filterElement==4)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		elseif($filterElement==5)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		elseif($filterElement==6)
		{
			$this->db->where('st.ageing >',60);
		}
		elseif($filterElement==7)
		{
			$this->db->where('st.purchase_price  <',400000);	
		}
		elseif($filterElement==8)
		{
			$this->db->where('st.purchase_price  <=',600000);
			$this->db->where('st.purchase_price  >=',400000);
		}
		elseif($filterElement==9)
		{
			$this->db->where('st.purchase_price  <=',800000);
			$this->db->where('st.purchase_price  >=',600000);
		}
		elseif($filterElement==10)
		{
			$this->db->where('st.expt_selling_price >',800000);
		}
		

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	function new_stock_filter($model,$assigned_location,$created_date) {
		$this -> db -> select('st.submodel,st.color,st.fuel_type,st.vehicle_status,st.assigned_location,st.ageing,m.model_name,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_new st');
		$this -> db -> join('make_models m', 'm.model_id=st.model');
		
		if($model != '')
		{
		$this -> db -> where('model', $model);	
		}
		
		if($assigned_location != '')
		{
				$this -> db -> where('assigned_location', $assigned_location);
		}
		
		if($created_date != '')
		{
			$this -> db -> where('created_date', $created_date);	
			
		}
	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	
public function select_new_stock_model(){
	$model=$this->input->get('model');
	$submodel=$this->input->get('submodel');
	$stock_location=$this->input->get('stock_location');
	$vehicle_status=$this->input->get('vehicle_status');
	$ageing=$this->input->get('ageing');
	$price=$this->input->get('price');
	$id=$this->input->get('id');
	
	$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}	
	
	if($id!=1){
	$this->db->select('*,m.model_name,count(submodel) as model_count');
	}else{
		$this->db->select('*,m.model_name');
	}
	$this->db->from('tbl_stock_in_hand_new st');
	$this -> db -> join('make_models m', 'm.model_id=st.model');
	$this -> db -> where('st.upload_id', $upload_id);
	if($model!=''){
		$this->db->where('st.model',$model);
	}
	if($submodel!=''){
	$this->db->where('st.submodel',$submodel);
	}
		
		
		if($stock_location!=''){
			$this -> db -> where('assigned_location', $stock_location);
		}
		if($vehicle_status!='')
		{
			$this->db->where('st.vehicle_status ',$vehicle_status);
		}
		if($ageing!=''){
		
		if($ageing==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		elseif($ageing==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		elseif($ageing==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		elseif($ageing==4)
		{
			$this->db->where('st.ageing >',60);
		}
		}
		if($price!=''){
		if($price==1)
		{
			$this->db->where('st.purchase_price  <',400000);	
		}
		elseif($price==2)
		{
			$this->db->where('st.purchase_price  <=',600000);
			$this->db->where('st.purchase_price  >=',400000);
		}
		elseif($price==3)
		{
			$this->db->where('st.purchase_price  <=',800000);
			$this->db->where('st.purchase_price  >=',600000);
		}
		elseif($price==4)
		{
			$this->db->where('st.expt_selling_price >',800000);
		}
		}
		

	
	if($id!=1){
	$this->db->group_by('submodel');
	}
	$this->db->order_by('submodel');
	$query = $this -> db -> get();
//	echo $this->db->last_query();
		return $query -> result();
}
//////////////////////// POC ///////////////////////////////////
function select_poc_make() {
		$this->db->distinct();	
		$this -> db -> select('make_id,make_name');
		$this -> db -> from('tbl_stock_in_hand_poc t');
		$this -> db -> from('makes m','m.make_id=t.make');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	function select_poc_model($make) {
		$this->db->distinct();	
		$this -> db -> select('model');
		$this -> db -> from('tbl_stock_in_hand_poc t');
		$this->db->where('make',$make);
		$query = $this -> db -> get();
		
		return $query -> result();
	}
	function stock_budget() {
		$this->db->distinct();		
		$this -> db -> select('*');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function stock_location() {
		$this->db->distinct();		
		$this -> db -> select('stock_location');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function select_poc_stock() {
		$make=$this->input->post('make');
		$model=$this->input->post('model');
		$fuel_type=$this->input->post('fuel_type');
		$stock_location=$this->input->post('stock_location');
		$ageing=$this->input->post('ageing');
		$this -> db -> select('t.*,m.make_name');
		$this -> db -> from('tbl_stock_in_hand_poc t');
		$this -> db -> join('makes m','m.make_id=t.make');
		if($make!=''){
			$this->db->where('make',$make);
		}
		if($model!=''){
			$this->db->where('model',$model);
		}
		if($fuel_type!=''){
			$this->db->where('fuel_type',$fuel_type);
		}
		if($stock_location!=''){
			$this->db->where('stock_location',$stock_location);
		}
		if($ageing!=''){
			if($ageing==1)
		{
			$this->db->where('ageing <',15);	
		}
		elseif($ageing==2)
		{
			$this->db->where('ageing <=',30);
			$this->db->where('ageing >=',15);
		}
		elseif($ageing==3)
		{
			$this->db->where('ageing <=',60);
			$this->db->where('ageing >=',31);
		}
		elseif($ageing==4)
		{
			$this->db->where('ageing <=',90);
			$this->db->where('ageing >=',61);
		}
				elseif($ageing==5)
		{
			$this->db->where('ageing >',90);
		}
		}
		
		$query = $this -> db -> get();
			//	echo  $this->db->last_query();

		return $query -> result();
	}

	//select budget
	function select_poc_stock_budget($budget_from,$budget_to,$make,$model) {
			$q = $this->db->query("SELECT model_name FROM `make_models` WHERE model_id='$model'")->result();
		if(count($q)>0)
		{
			$modelname = $q[0]->model_name; 
		}
		else
		{
			$modelname = "";
		}

		$q1 = $this->db->query("SELECT created_date FROM `tbl_stock_in_hand_poc` ORDER BY created_date desc")->result();

		if(count($q1)>0)
		{
			$created_date = $q1[0]->created_date; 
		}
		else
		{
			$created_date = "";
		}


		$this -> db -> select('t.*,m.make_name');
		$this -> db -> from('tbl_stock_in_hand_poc t');
		$this -> db -> join('makes m','m.make_id=t.make');
		
		 if($make!=''){
			$this->db->where('make',$make);
		}
		 if($budget_from!=''){
			$this->db->where('expt_selling_price >=',$budget_from);
		}

		 if($budget_to!=''){
			$this->db->where('expt_selling_price <=',$budget_to);
		}

		if($modelname!='')
		{
		$this->db->like('model', $modelname);
		}

		//created max date 
		if($created_date!='')
		{
		$this->db->where('created_date', $created_date);
		}



		$query = $this -> db -> get();
		//echo  $this->db->last_query();

		return $query -> result();
	}
	
}
?>
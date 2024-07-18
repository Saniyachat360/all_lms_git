<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class used_car_stock_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	function select_old_stock()
	{
		$make=$this->input->post('make');
		$stock_location=$this->input->post('stock_location');
		$model=$this->input->post('model');
		
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
			
		}	
		$this -> db -> select('mk.make_name,st.submodel,count(st.submodel) as model_count');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		$this -> db -> where('upload_id', $upload_id);
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$this->db->group_by('st.submodel');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query=$query-> result();
		foreach($query as $row){
			$a1=1;
			$a2=2;
			$a3=3;
			$a4=4;
			$mfg_year_1=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$mfg_year_2=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$mfg_year_3=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			$mfg_year_4=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a4,$make,$model,$stock_location);
		
			$owner_1=$this->select_old_stock_owner($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$owner_2=$this->select_old_stock_owner($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$owner_3=$this->select_old_stock_owner($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			
			$ageing_1=$this->select_ageing($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$ageing_2=$this->select_ageing($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$ageing_3=$this->select_ageing($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			$ageing_4=$this->select_ageing($row->submodel,$upload_id,$a4,$make,$model,$stock_location);
			
			$price_1=$this->select_price($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$price_2=$this->select_price($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$price_3=$this->select_price($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			
			
			$select_data[]=array('make_name'=>$row->make_name,'stock_location'=>$stock_location,'submodel'=>$row->submodel,'model_count'=>$row->model_count,'mfg_year_1'=>$mfg_year_1,'mfg_year_2'=>$mfg_year_2,'mfg_year_3'=>$mfg_year_3,'mfg_year_4'=>$mfg_year_4,'owner_1'=>$owner_1,'owner_2'=>$owner_2,'owner_3'=>$owner_3
			,'ageing_1'=>$ageing_1,'ageing_2'=>$ageing_2,'ageing_3'=>$ageing_3,'ageing_4'=>$ageing_4,'price_1'=>$price_1,'price_2'=>$price_2,'price_3'=>$price_3);
		}
		return $select_data;
	}
	function select_price($submodel,$upload_id,$filterElement,$make,$model,$stock_location)
	{
		$this -> db -> select('count(id) as price');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		if($filterElement==1)
		{
			$this->db->where('st.expt_selling_price <','200000');	
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.expt_selling_price <=',500000);
			$this->db->where('st.expt_selling_price >=',200000);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.expt_selling_price >',500000);
		}
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->price;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_ageing($submodel,$upload_id,$filterElement,$make,$model,$stock_location)
	{
		$this -> db -> select('count(id) as ageing');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		
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
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->ageing;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_old_stock_mfg_year($submodel,$upload_id,$filterElement,$make,$model,$stock_location)
	{
		$this -> db -> select('count(id) as mfg_year');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		if($filterElement==1)
		{
			$this->db->where('st.mfg_year <',2010);
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.mfg_year <=',2012);
			$this->db->where('st.mfg_year >=',2010);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.mfg_year <=',2015);
			$this->db->where('st.mfg_year >=',2012);
		}
		elseif($filterElement==4)
		{
				$this->db->where('st.mfg_year >',2015);
		}
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->mfg_year;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_old_stock_owner($submodel,$upload_id,$filterElement,$make,$model,$stock_location)
	{
		$this -> db -> select('count(id) as owner');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		if($filterElement==1)
		{
			$this->db->where('st.owner ',1);
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.owner ',2);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.owner >',2);
		}
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
			$query = $this -> db -> get()->result();
		$tcount=$query[0]->owner;
		//echo $this->db->last_query();
		return $tcount; 
	}
	
	
	function select_stock_list()
	{
		$submodel=$this->input->get('submodel');
		$stock_location=$this->input->get('stock_location');
		$filterElement=$this->input->get('id');
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}	
		$this -> db -> select('mk.make_name,st.submodel,st.color,st.fuel_type,st.owner,st.mfg_year,st.odo_meter,st.mileage,st.insurance_type,st.insurance_expiry_date,st.category,st.vehicle_status,st.stock_location,st.expt_selling_price,st.stock_ageing,st.total_landing_cost,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		if($filterElement==1)
		{
			$this->db->where('st.mfg_year <',2010);
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.mfg_year <=',2012);
			$this->db->where('st.mfg_year >=',2010);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.mfg_year <=',2015);
			$this->db->where('st.mfg_year >=',2012);
		}
		elseif($filterElement==4)
		{
				$this->db->where('st.mfg_year >',2015);
		}
		elseif($filterElement==5)
		{
			$this->db->where('st.owner ',1);
		}
		elseif($filterElement==6)
		{
			$this->db->where('st.owner ',2);
		}
		elseif($filterElement==7)
		{
			$this->db->where('st.owner >',2);
		}
		elseif($filterElement==8)
		{
			$this->db->where('st.ageing <',15);	
		}
		elseif($filterElement==9)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		elseif($filterElement==10)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		elseif($filterElement==11)
		{
			$this->db->where('st.ageing >',60);
		}
		elseif($filterElement==12)
		{
			$this->db->where('st.expt_selling_price <',200000);	
		}
		elseif($filterElement==13)
		{
			$this->db->where('st.expt_selling_price <=',500000);
			$this->db->where('st.expt_selling_price >=',200000);
		}
		elseif($filterElement==14)
		{
			$this->db->where('st.expt_selling_price >',500000);
		}
		

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	function select_old_stock_count()
	{
		ini_set('memory_limit', '-1');

		
		$this->db->select_max('created_date');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_date1 = $this -> db -> get()->result();
		
		foreach($max_date1 as $row)
		{
			$max_date = $row->created_date;
			
		}	
		$this -> db -> select('count(id) as lead_count');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		$this -> db -> where('created_date', $max_date);
		
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

	
	function select_make() {
		$this->db->distinct();	
		$this -> db -> select('make_name,make_id');
		$this -> db -> from('makes');
		$this -> db -> where('make_name !=','');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
		function select_model() {
		$this->db->distinct();	
		$this -> db -> select('model_name,model_id');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id =','1');
		$query = $this -> db -> get();
		return $query -> result();
	}
		function select_model_make() {
			$this -> db -> select_max('upload_id');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$max_date1 = $this -> db -> get() -> result();
		foreach ($max_date1 as $row) {
			$max_date = $row -> upload_id;
		}
			$make=$this->input->post('make');
		$this->db->distinct();	
		$this -> db -> select('submodel,model');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$this -> db -> where('make =',$make);
		$this -> db -> where('upload_id', $max_date);
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


	function old_stock_filter($make,$stock_location,$budget_from,$budget_to,$created_date) {
		
		$this -> db -> select('mk.make_name,st.make,st.total_landing_cost,st.submodel,st.color,st.fuel_type,st.owner,st.mfg_year,st.odo_meter,st.mileage,st.insurance_type,st.insurance_expiry_date,st.category,st.vehicle_status,st.stock_location,st.expt_selling_price,st.stock_ageing,st.created_date,st.total_landing_cost');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		
		if($make !='')
		{
		$this -> db -> where('make', $make);	
		}
		
		if($stock_location !='')
		{
		$this -> db -> where('stock_location', $stock_location);	
		}
		
	
		
		if($budget_from !='')
		{
			
			//echo "hi";
			$this -> db -> where('expt_selling_price >=', $budget_from);
		}
		if($budget_to !='')
		{
			$this -> db -> where('expt_selling_price <=', $budget_to);
		}
		
			if($created_date !='')
		{
			$this -> db -> where('created_date', $created_date);
		}
		
	
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
		
		
		
	}
	function select_used_stock_model()
	{

		
		$make=$this->input->get('make');
		$model=$this->input->get('submodel');
		$stock_location=$this->input->get('stock_location');
		$mfg_year=$this->input->get('mfg_year');
		$owner=$this->input->get('owner');
		$ageing=$this->input->get('ageing');
		$price=$this->input->get('price');
		$id=$this->input->get('id');
		
		
		
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}	
		if($id!=1){
		$this->db->select('*,mk.make_name,count(submodel) as model_count');
		}else{
			$this->db->select('*,mk.make_name');
		}
		$this->db->from('tbl_stock_in_hand_poc st');
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		
		$this -> db -> where('upload_id', $upload_id);
		if($make!=''){
			$this->db->where('st.make',$make);
		}
		if($model!=''){
		$this->db->where('st.submodel',$model);
		}
		if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		if($mfg_year!=''){
		if($mfg_year==1)
		{
			$this->db->where('st.mfg_year <',2010);
		}
		elseif($mfg_year==2)
		{
			$this->db->where('st.mfg_year <=',2012);
			$this->db->where('st.mfg_year >=',2010);
		}
		elseif($mfg_year==3)
		{
			$this->db->where('st.mfg_year <=',2015);
			$this->db->where('st.mfg_year >=',2012);
		}
		elseif($mfg_year==4)
		{
				$this->db->where('st.mfg_year >',2015);
		}
		}
		if($owner!=''){
		if($owner==1)
		{
			$this->db->where('st.owner ',1);
		}
		elseif($owner==2)
		{
			$this->db->where('st.owner ',2);
		}
		elseif($owner==3)
		{
			$this->db->where('st.owner >',2);
		}
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
			$this->db->where('st.expt_selling_price <',200000);	
		}
		elseif($price==2)
		{
			$this->db->where('st.expt_selling_price <=',500000);
			$this->db->where('st.expt_selling_price >=',200000);
		}
		elseif($price==3)
		{
			$this->db->where('st.expt_selling_price >',500000);
		}
		}
		if($id!=1){
		$this->db->group_by('submodel');
		}
		$this->db->order_by('submodel');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}




}
?>
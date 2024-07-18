<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_user_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->date=date('Y-m-d');
		 $this->user_id=$this -> session -> userdata('user_id');
		 $this -> role = $this -> session -> userdata('role');
		 $this -> process_id =  $this -> session -> userdata('process_id');
			$this -> process_name =  $this -> session -> userdata('process_name');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7 || $this -> process_id == 8) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';			
		}
		else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';		
		}
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
	}
	// Get max Employee ID
	public function maxEmpId() {
		$query=$this->db->query("SELECT  empId FROM lmsuser s
	   JOIN (SELECT MAX(id) AS mid FROM lmsuser GROUP BY id) max  ON s.id = max.mid order by s.id desc limit 1");
			/*$this -> db -> select_max('empId');
			$this -> db -> from('lmsuser');
			//	$this -> db -> where('empId','');
			$query = $this -> db -> get();*/
			/*if($this->user_id=='1')
			{
				echo $this->db->last_query();	
			}*/
			return $query -> result();
	
		}
	//For select all Process
	public function select_process() {
	$userId=$_SESSION['user_id'];
	$order=" FIELD(process_id,'6', '7', '1', '4', '5','10')";
	$query1 = $this->db->query("select p.process_id ,p.process_name 
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$userId' group by p.process_id order by FIELD(p.process_id, '6', '7', '8','1', '4', '5','10')");
									
								
			//	echo $this->db->last_query();		
	
		return $query1 -> result();

	}
	//Select Location
	public function select_location($process_id)
	{
		$this->db->select('l.location_id ,l.location');
		$this->db->from('lmsuser u');
		$this->db->join('tbl_manager_process p','u.id=p.user_id');
		$this->db->join('tbl_location l','p.location_id=l.location_id');
		$this->db->where('p.user_id',$_SESSION['user_id']);
		foreach ($process_id as $row) {
			
		$this->db->or_where('p.process_id',$row->process_id);
		
		}
	
		$this->db->group_by('l.location_id');
		$query=$this->db->get();
	//	echo $this->db->last_query();
		return $query->result();
	}
	// Select Location using process Id
	public function select_map_location($id) {
		$this -> db -> select('m.location_id,m.process_id,l.location');
			$this -> db -> from('tbl_map_process m1');
		$this->db->join('tbl_manager_process m','m.location_id=m1.location_id');
		$this->db->join('tbl_location l','l.location_id=m.location_id');
		if ($id!='') {
			$this -> db -> where('m1.process_id', $id);
			$this -> db -> where('m.process_id', $id);
			
		}
	//	if($this->user_id!=1){
		$this -> db -> where('user_id', $this->user_id);
	//	}
		$this->db->group_by('l.location_id');
		$this->db->where('m.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	// Show Lms user Table details 
	public function select_table() {
	
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$process_array=array();				
		$location_array=array();		
		$process=$this->select_process();				
		foreach ($process as $row) {
			array_push($process_array,$row->process_id);
			$query=$this->select_map_location($row->process_id);
				foreach ($query as $row) {
					array_push($location_array,$row->location_id);
				}
			
		}
		
		$this -> db -> select('umd.fname as tl_fname,umd.lname as tl_lname,md.tl_id,u.fname,u.lname,u.mobileno,u.email,u.password,u.id,u.role,group_concat(distinct(l.location)) as location,group_concat(distinct(p.process_name)) as process_name,u.role_name,u.empId,u.status,u.cross_lead_user');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id','left');
		$this -> db -> join('tbl_process p', 'p.process_id=m.process_id','left');
		$this -> db -> join('tbl_mapdse md', 'md.dse_id=u.id','left');
		$this -> db -> join('lmsuser umd', 'md.tl_id=umd.id','left');
		$this -> db -> where('u.id !=', '0');
		//$this->db->where_in('m.process_id',$process_array);
		//$this->db->where_in('m.location_id',$location_array);
	//	$this->db->where('u.role',4);
		//	$this->db->where('u.status','1');
		$name = $this -> input -> post('userName');
		if (isset($_POST['userName'])) {
		$this -> db -> where("CONCAT(u.fname, ' ', u.lname) LIKE '%$name%' ");
		}
		/*if($_SESSION['role']!=1){*/
		$this -> db -> where('u.role !=', 1);
		//}
		if($this->input->get('id')==''){
		$this -> db -> limit($rec_limit, $offset);
			}
		
		$this -> db -> group_by('u.id');
		$this->db->order_by('u.id','desc');
		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		return $query1 -> result();

	}
	// Count of select lmsuser data
		public function select_lmsuser() {
		$process_array=array();				
		$process=$this->select_process();				
		$location_array=array();			
		foreach ($process as $row) {
			array_push($process_array,$row->process_id);
			$query=$this->select_map_location($row->process_id);
				foreach ($query as $row) {
					array_push($location_array,$row->location_id);
				}
			
		}
		$this -> db -> select('id as lmscount');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id','left');
		$this -> db -> join('tbl_process p', 'p.process_id=m.process_id','left');
		$this -> db -> where('u.id !=', '0');
		//$this->db->where_in('m.process_id',$process_array);
		//$this->db->where_in('m.location_id',$location_array);
		$name = $this -> input -> post('userName');
		if (isset($_POST['userName'])) {
			$this -> db -> where("CONCAT(u.fname, ' ', u.lname) LIKE '%$name%' ");
		}
		//	if($_SESSION['role']!=1){
		$this -> db -> where('u.role !=', 1);
	//		}
		$this->db->group_by('u.id');
		$this->db->order_by('u.id','desc');
		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		return $query1 -> result();

	}
	
	
	
	// Add LMS user In database
	public function add_user($fname, $lname, $email, $pnum,$role, $date, $password, $group_id,$role_name,$status,$location_array) {
		// check user already exist
		$this -> db -> select('email');
		$this -> db -> from('lmsuser');
		$this -> db -> where('email', $email);
		//$this -> db -> where('status', 1);
		$q = $this -> db -> get() -> result();
		
		if (count($q) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> User Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		} else {
			$query=$this->db->query("select id from lmsuser where email='$email' and status='-1'")->result();
		//	echo count($query);
		if(count($query)>0){
					$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> User Already Exists Please Active It ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
		}else{
		// else add in database
		$empId = $this -> input -> post('empId');
		$tl_name = $this -> input -> post('tl_name');
			$cross_lead_user=$this -> input -> post('cross_lead_user');
		
		// Insert in lmsuser
		$query = $this -> db -> query("insert into lmsuser(empId,`fname`,`lname`,`email`,`mobileno`,`role`,`date`,`status`,`is_active`,`password`,role_name,last_updated_by,last_updated_date,cross_lead_user)
		values('$empId','$fname','$lname','$email','$pnum','$role','$date','$status','Offline','$password','$role_name','$this->user_id','$this->date','$cross_lead_user')");
		$user_id = $this -> db -> insert_id();
			
		// Add location and process in database
		for($i=0;$i<count($location_array);$i++){
			$explode_value=explode('#',$location_array[$i]);
			$process_id=$explode_value[0];
			$location_id=$explode_value[1];
			//echo $process_id.'-'.$location_id.'<br>';
			$query = $this -> db -> query("INSERT INTO `tbl_manager_process`(`user_id`, `process_id`,`location_id`,`status`) VALUES ('$user_id','$process_id','$location_id','1')");
		}
		// if user is dse then map dse to tl
		if ($tl_name != '') {
			$query = $this -> db -> query("INSERT INTO `tbl_mapdse`(`tl_id`, `dse_id`) VALUES ($tl_name,$user_id)");
		}
		if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Added Successfully...! Please Assign Rights.</strong></div>');
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> LMS User Not Added Successfully...!</strong></div>');
		}

		}
		}
	}
		function check_user_location($id,$process,$new_role){
		echo $id; 
				$q=$this->db->query("select role from lmsuser where id='$id'")->result();
		$role=$q[0]->role;	
		
		
		$get_user_process=$this->db->query("select * from tbl_manager_process where user_id='$id'")->result();
		 foreach ($get_user_process as $old_process) {
		 	 	$get_user_process1[]=$old_process->process_id;
			 }
			$not_in_process=array_diff($get_user_process1,$process);
			$not_in_process=array_values($not_in_process);
			echo count($not_in_process);
			
			
			
			if(count($not_in_process)>0){
					
			for($i=0;$i<count($not_in_process);$i++){
				$process_name_not_in=$this->db->query("select process_name from tbl_process where process_id=' $not_in_process[$i]'")->result();
				$this -> db -> select('l.enq_id');
				
				if($not_in_process[$i]==6 ||  $not_in_process[$i]==7 ){
					$this -> db -> from( 'lead_master l');
				} elseif($not_in_process[$i]==8){
						$this -> db -> from( 'lead_master_evaluation l');
				}else{
					$this -> db -> from('lead_master_all  l');	
				}
				
				if ($not_in_process[$i] == 8) {
					$this -> db -> where('l.evaluation', 'Yes');
				} else {
					$this -> db -> where('l.process', $process_name_not_in[0]->process_name);
				}
				
				$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
				$this -> db -> where('l.nextAction !=', 'Close');
				
				if($role=='4')
				{
					$this -> db -> where('l.assign_to_dse', $id);
				}
				elseif($role == '5')
				{
					$this -> db -> where('l.assign_to_dse_tl',$id);
					$this -> db -> where('l.assign_to_dse',0);
				}
				elseif($role == '15')
				{
					$this -> db -> where('l.assign_to_e_tl',$id);
					$this -> db -> where('l.assign_to_e_exe', 0);				
				}		
				elseif ($role == '16') {				
					$this -> db -> where('l.assign_to_e_exe', $id);			
				}
				elseif (in_array($role,$this->executive_array)) {			
					$this -> db -> where('l.assign_to_cse', $id);
				}
				elseif(in_array($role,$this->tl_array)){
					$this -> db -> where('l.assign_to_cse', $id);
				}
			
				$query1 = $this -> db -> get();
			//echo $this->db->last_query();
				$query1->result();
			
				if( $query1->num_rows()>0)
				{
				
					$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Active Leads found in Users Unchecked Process..Please Transfer to Another User First..!</strong></div>');
					//$update_user_data='0';		
					redirect('add_lms_user');
				}
				}	
						
						}		

		if($role!=$new_role){
		$tl_array1=array("15","5","2","7","9","11","13");
					if(in_array($role,$tl_array1)){
						$this->db->select('m.map_id');
						$this->db->from('tbl_mapdse m');
						$this->db->join('lmsuser l','l.id=m.dse_id','left');
						$this->db->where('m.tl_id',$id);
						$this->db->where('l.status',1);
						$map_query=$this->db->get()->result();
						echo count($map_query);
						if(count($map_query)>0)
						{
						
							$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Active CSE/DSE found Under this Users (Team leaders) Unchecked Process.Please Transfer these active CSE/DSE under Another TL...!</strong></div>');
						redirect('add_lms_user');
						//	$update_user_data='0';
						}
						}
						}
			$update_user_data=1;
		return $update_user_data;
	}
	
function update_user($fname, $lname, $email, $pnum,$role, $id,$role_name,$location_array,$process) {
		$update_user_data=0;
		
		$status = $this -> input -> post('status');
		$tl_name = $this -> input -> post('tl_name');
		$cross_lead_user= $this -> input -> post('cross_lead_user');
		
		if($status=='-1'){
			$this->delete_user($id);
		}else{
		$update_user_data=$this->check_user_location($id,$process,$role);
		
	if($update_user_data==1){
		$executive_array1=array("16","4","3","8","10","12","14");
		if(in_array($role,$executive_array1)){
			/* new code for change assign to dse tl from lead master*/
			if($role=='4'){
				$check_old_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$id'")->result();
				echo count($check_old_tl);
				if(count($check_old_tl)>0){
					$old_tl=$check_old_tl[0]->tl_id;
					if($old_tl !=$tl_name)
					{
						//echo "diff tl";
						$select_lm=$this->db->query("select enq_id from lead_master where assign_to_dse='$id' and assign_to_dse_tl='$old_tl' and nextAction !='Close' limit 15 ")->result();
						foreach($select_lm as $lrow){
							$enq_id=$lrow->enq_id;
							$this->db->query("update lead_master set assign_to_dse_tl='$tl_name' where enq_id='$enq_id'");
								echo $this->db->last_query();
						}
					}
				}
			}
			/*end */
			$this -> db -> query("delete from tbl_mapdse WHERE dse_id='$id'");
		}
		elseif($role=='5')
		{
		    	$this -> db -> query("delete from tbl_mapdse WHERE dse_id='$id'");
		}
		$this -> db -> query("delete from tbl_manager_process WHERE user_id ='$id'");
		
		$query = $this -> db -> query('update lmsuser set cross_lead_user="'.$cross_lead_user.'" , status="' . $status . '",fname="' . $fname . '",lname="' . $lname . '",email="' . $email . '",mobileno="' . $pnum . '",role="' . $role . '",role_name="' . $role_name . '",last_updated_by="'.$this->user_id.'" ,last_updated_date="'.$this->date.'"   where id="' . $id . '"');
		echo $this->db->last_query();
		// Add location and process in database
		for($i=0;$i<count($location_array);$i++){
			$explode_value=explode('#',$location_array[$i]);
			$process_id=$explode_value[0];
			$location_id=$explode_value[1];
			//echo $process_id.'-'.$location_id.'<br>';
			$query = $this -> db -> query("INSERT INTO `tbl_manager_process`(`user_id`, `process_id`,`location_id`,`status`) VALUES ('$id','$process_id','$location_id','1')");
			echo $this->db->last_query();		
		}
		
	/*	if ($tl_name != '') {
			$query = $this -> db -> query("INSERT INTO `tbl_mapdse`(`tl_id`, `dse_id`) VALUES ($tl_name,$id)");
		}*/
		$exe_array1=array("16","4","3","8","10","12","14");
		if(in_array($role,$exe_array1)){
		    	$query = $this -> db -> query("INSERT INTO `tbl_mapdse`(`tl_id`, `dse_id`) VALUES ($tl_name,$id)");
		}
		//}
		
		if ($this->db->affected_rows()>0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Updated Successfully...! </strong></div>');
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Not Updated Successfully...!</strong></div>');

		}
	}
	}
		// }
		 
		//$process_id_single = $this -> input -> post('process_id_single');

}
	
	public function edit_user($id) {
		$this -> db -> select('u.empId,u.status,
		md.tl_id,
		u.fname,u.lname,u.mobileno,u.email,u.id,u.role,u.role_name,u.cross_lead_user
		');
		$this -> db -> from('lmsuser u');
	
	//	$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
	//	$this -> db -> join('tbl_process p', 'p.process_id=m.process_id');
	//		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id', 'left');
		$this -> db -> join('tbl_mapdse md', 'md.dse_id=u.id', 'left');

		$this -> db -> where('id', $id);
		$this->db->group_by('id');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_user_process($id) {
		$this -> db -> select('process_id,location_id');
		$this -> db -> from('tbl_manager_process');

		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();

		return $query -> result();

	}

	public function edit_dse($id) {

		$this -> db -> select('*');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_mapdse md', 'md.tl_id=u.id', 'left');
		$this -> db -> where('md.dse_id', $id);
		$this -> db -> group_by('u.id');
		$query1 = $this -> db -> get();
		// echo $this->db->last_query();
		return $query1 -> result();

	}

		public function delete_user($id) {

		$q=$this->db->query("select role from lmsuser where id='$id'")->result();
		$role=$q[0]->role;		
		$get_user_process=$this->db->query("select p.process_id,p.process_name from tbl_manager_process m join tbl_process p on m.process_id=p.process_id where m.user_id='$id'")->result();
		foreach ($get_user_process as $row) {
			$this -> db -> select('l.enq_id');
			if($row->process_id==6 || $row->process_id==7 || $row->process_id==8){
			$this -> db -> from( 'lead_master l');
			}else{
					$this -> db -> from( 'lead_master_all l');
			}
			if ($row -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			} else {
				$this -> db -> where('l.process', $row -> process_name);
			} 
			$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
			$this -> db -> where('l.nextAction !=', 'Close');
			
			if($role=='4')
			{
				$this -> db -> where('l.assign_to_dse', $id);
			}
			elseif($role == '5')
			{
				$this -> db -> where('l.assign_to_dse_tl',$id);
				$this -> db -> where('l.assign_to_dse',0);
			}
			elseif($role == '15')
			{
				$this -> db -> where('l.assign_to_e_tl',$id);
				$this -> db -> where('l.assign_to_e_exe', 0);				
			}		
			elseif ($role == '16') {				
				$this -> db -> where('l.assign_to_e_exe', $id);			
			}
			elseif (in_array($role,$this->executive_array)) {			
				$this -> db -> where('l.assign_to_cse', $id);
			}
			elseif(in_array($role,$this->tl_array)){
				$this -> db -> where('l.assign_to_cse', $id);
			}
			
			$query1 = $this -> db -> get()->result();
			if(count($query1)>0)
			{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Active Leads found in Users Account..Please Transfer to Another User First..!</strong></div>');
				redirect('add_lms_user');				
			}else
			{
				$tl_array1=array("15","5","2","7","9","11","13");
				if(in_array($role,$tl_array1)){
					$this->db->select('map_id');
					$this->db->from('tbl_mapdse m');
					$this->db->join('lmsuser l','l.id=m.dse_id','left');
					$this->db->where('m.tl_id',$id);
						$this->db->where('l.status',1);
					$map_query=$this->db->get()->result();
					if(count($map_query)>0)
					{
						$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Active CSE/DSE found Under this Users (Team leaders) Account...!</strong></div>');
						redirect('add_lms_user');	
					}
					else {
						$remove_user=1;
					}
				}
				else {
					$remove_user=1;
				}				
				$remove_user=1;
			}
		}
			
			if(isset($remove_user))
			{
				//echo "Removed";		
			$query = $this -> db -> query("update lmsuser set status='-1',last_updated_by='$this->user_id' ,last_updated_date='$this->date'  WHERE id='$id'");
			//$query = $this -> db -> query("delete from tbl_rights WHERE user_id='$id'");
		//	$query = $this -> db -> query("DELETE FROM `tbl_mapdse` WHERE dse_id='$id'");
		//	$query = $this -> db -> query("DELETE FROM `tbl_manager_process` WHERE user_id='$id'");
			if ($query) {
				$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Deactive Successfully...! </strong></div>');
	
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Not Deactive Successfully...!</strong></div>');
	
			}
			}
	}
	/*public function delete_user1() {
		$id = $this -> input -> get('id');
		//$query = $this -> db -> query("delete from tbl_user_group WHERE user_id='$id'");
		$query = $this -> db -> query("update lmsuser set status='-1',last_updated_by='$this->user_id' ,last_updated_date='$this->date'  WHERE id='$id'");
		$query = $this -> db -> query("delete from tbl_rights WHERE user_id='$id'");
		$query = $this -> db -> query("DELETE FROM `tbl_mapdse` WHERE dse_id='$id'");
		$query = $this -> db -> query("DELETE FROM `tbl_manager_process` WHERE user_id='$id'");
		if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Deleted Successfully...! </strong></div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>LMS User Not Deleted Successfully...!</strong></div>');

		}
	}*/

	public function select_tl($role) {
		$location=$this->input->post('location');
	if($role == 3 )
	{
		$roleTl='2';	
	}else if($role == 4){
		$roleTl='5';
		
	}else if($role == 12){
		$roleTl='11';
		
	}else if($role == 8){
		
		$roleTl='7';
	}else if($role == 10){
		$roleTl='9';
		
	}else if($role == 14){
		$roleTl='13';
		
	}
	else if($role == 16){
		$roleTl='15';
		
	}
		//$role = array(2,5, 7, 9, 11, 13);
		$this -> db -> select("fname,lname,id");
		$this -> db -> from("lmsuser u");
		$this->db->join('tbl_manager_process p','p.user_id=u.id','left');
		//$this -> db -> where('process_id', $_SESSION['process_id']);
		$this -> db -> where_in('u.role', $roleTl);
		if($role == 3 )
			{
				$this -> db -> where('u.role_name', 'CSE Team Leader');
			}
		$this -> db -> where_in('p.location_id', $location );
		$this->db->group_by('u.id');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	/*********************************************************************************************/
	
	// Show Lms user Table details 
	public function select_table1() {
	
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$process_array=array();				
		$location_array=array();		
		$process=$this->select_process1();				
		foreach ($process as $row) {
			array_push($process_array,$row->process_id);
			$query=$this->select_map_location($row->process_id);
				foreach ($query as $row) {
					array_push($location_array,$row->location_id);
				}
			
		}
		$this -> db -> select('u.fname,u.lname,u.mobileno,u.email,u.password,u.id,u.role,group_concat(distinct(l.location)) as location,group_concat(distinct(p.process_name)) as process_name,u.role_name,empId,u.status');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id','left');
		$this -> db -> join('tbl_process p', 'p.process_id=m.process_id','left');
		$this -> db -> where('u.id !=', '0');
		//$this->db->where_in('m.process_id',$process_array);
		//$this->db->where_in('m.location_id',$location_array);
	//	$this->db->where('u.role',4);
		//	$this->db->where('u.status','1');
		$name = $this -> input -> post('userName');
		if (isset($_POST['userName'])) {
		$this -> db -> where("CONCAT(u.fname, ' ', u.lname) LIKE '%$name%' ");
		}
		/*if($_SESSION['role']!=1){*/
		$this -> db -> where('u.role !=', 1);
		//}
		if($this->input->get('id')==''){
		$this -> db -> limit($rec_limit, $offset);
			}
		
		$this -> db -> group_by('u.id');
	//$this->db->order_by('u.id','desc');
		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		return $query1 -> result();

	}
	//For select all Process
	public function select_process1() {
	$userId='1';
	$order=" FIELD(process_id,'6', '7', '1', '4', '5')";
	$query1 = $this->db->query("select p.process_id ,p.process_name 
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$userId' group by p.process_id order by FIELD(p.process_id, '6', '7', '8','1', '4', '5')");
									
								
			//	echo $this->db->last_query();		
	
		return $query1 -> result();

	}

}

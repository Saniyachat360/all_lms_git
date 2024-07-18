<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_lms_user extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_user_model');
		}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$process_id=$data['select_process'] = $this -> add_user_model -> select_process();
		$test=$data['select_location'] = $this -> add_user_model -> select_location($process_id);
		//print_r($test);
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
		$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
		$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
public function searchuser() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$data['select_process'] = $this -> add_user_model -> select_process();
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
	//	print_r($data['maxEmpId']);
		//$data['select_location'] = $this -> add_user_model -> select_location();		
		$data['var'] = site_url('add_lms_user/add_user');
		
		$this -> load -> view('add_lms_user_filter_view.php', $data);
	

	}

	public function paging_next() {
		$this -> session();
		$query1 = $this -> add_user_model -> select_table();
		$data['count_data']=$query2 = $this -> add_user_model -> select_lmsuser();
		$data['select_table'] = $query1;
		$data['select_process'] = $this -> add_user_model -> select_process();
		$data['maxEmpId'] = $this -> add_user_model -> maxEmpId();
		
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
			$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
	//	print_r($data['maxEmpId']);
	//	$data['select_location'] = $this -> add_user_model -> select_location();		
		$data['var'] = site_url('add_lms_user/add_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_lms_user_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	
	public function add_user() {
		$process=$this->input->post('process');
		$finance_location=$this->input->post('finance_location');
		$insurance_location=$this->input->post('insurance_location');
		$service_location=$this->input->post('service_location');
		$accessories_location=$this->input->post('accessories_location');
		$new_car_location=$this->input->post('new_car_location');
		$used_car_location=$this->input->post('used_car_location');
		$evaluation_location=$this->input->post('evaluation_location');
		$complaint_location=$this->input->post('complaint_location');
		$location_array=array();
		if(is_array($finance_location)){
			$location_array=array_merge($location_array,$finance_location);
		}
		if(is_array($insurance_location)){
			$location_array=array_merge($location_array,$insurance_location);
		}
		if(is_array($service_location)){
			$location_array=array_merge($location_array,$service_location);
		}
		if(is_array($accessories_location)){
			$location_array=array_merge($location_array,$accessories_location);
		}
		if(is_array($new_car_location)){
			$location_array=array_merge($location_array,$new_car_location);
		}
		if(is_array($used_car_location)){
			$location_array=array_merge($location_array,$used_car_location);
		}
		if(is_array($evaluation_location)){
			$location_array=array_merge($location_array,$evaluation_location);
		}
			if(is_array($complaint_location)){
			$location_array=array_merge($location_array,$complaint_location);
		}
		//print_r($location_array);
		
	
		 $fname = $this -> input -> post('fname');
		$lname = $this -> input -> post('lname');
		$email = $this -> input -> post('email');
		$pnum = $this -> input -> post('pnum');

		$location = $this -> input -> post('location');
		$role1 = $this -> input -> post('role');
		$role2=explode('#',$role1);
		$role=$role2[0];
		$role_name=$role2[1];
		//$process_id = $this -> input -> post('process_id');
		//if(count(process_id ==0))
		//{
			//$process_id=$this->input->post('process_id_single');
		//}
		
		$group_id = $this -> input -> post('group_id');
		$date = date('Y/m/d');
		//$password = rand(0, 10000);
		$password =$this -> input -> post('password');
		$status =$this -> input -> post('status');
	
		$query = $this -> add_user_model -> add_user($fname, $lname, $email, $pnum,$role, $date, $password, $group_id,$role_name,$status,$location_array);
		
		/*$data['email'] = $email;
		$data['password'] = $password;
		$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this -> email -> from('info@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('LMS User Details');
		$body = $this -> load -> view('send_mail_view.php', $data, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();*/
	redirect('add_lms_user');

	}

	/*public function get_group_name(){
					
		$process_id=$this->input->post('process_id');		
		$select_group =$this->add_user_model->select_group($process_id);
		if(count($select_group)>0)
		{			
					
		?>	
			<label class="control-label col-md-2 col-sm-2 col-xs-12" >Group Name: </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<?php foreach ($select_group as $row) {?>
				<label class="checkbox-inline">
					<input type="checkbox"  name="group_id[]" value="<?php echo $row -> group_id; ?>" >
					&nbsp;&nbsp;<?php echo $row -> group_name; ?>
				</label>
				<?php } ?>
			</div>
	
		<?php 
		}
		else {
			?>
			<label class="control-label col-md-2 col-sm-2 col-xs-12" > </label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type='hidden' required>
				<label class="control-label" >No Groups Found !! Please Add Group First.</label>
				
			</div>
			<?php
		}
	}*/
		
	public function edit_user() {
		$this -> session();
		$id = $this -> input -> get('id');
		$data['select_process'] = $this -> add_user_model -> select_process();

		//$data['select_location'] = $this -> add_user_model -> select_location();
		$query = $this -> add_user_model -> edit_user($id);
		$data['edit_dse'] = $this -> add_user_model -> edit_dse($query[0]->id);
		$data['edit_process'] = $this -> add_user_model -> edit_user_process($id);
		//Location Name
		$data['select_finance_location']= $this -> add_user_model -> select_map_location(1);
		$data['select_insurance_location']= $this -> add_user_model -> select_map_location(2);
		$data['select_service_location']= $this -> add_user_model -> select_map_location(4);
		$data['select_accessories_location']= $this -> add_user_model -> select_map_location(5);
		$data['select_new_car_location']= $this -> add_user_model -> select_map_location(6);
		$data['select_used_car_location']= $this -> add_user_model -> select_map_location(7);
		$data['select_evaluation_location']= $this -> add_user_model -> select_map_location(8);
		$data['select_complaint_location']= $this -> add_user_model -> select_map_location(9);
		
		//print_r($query);
		$data['edit_user'] = $query;
		//$data['var1'] = site_url('add_lms_user/update_user');
		$data['var1'] = site_url('add_lms_user/update_user');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_user_view', $data);
		$this -> load -> view('include/footer');

	}

	function update_user() {

		$id = $this -> input -> post('id');
		
		$group_id = $this -> input -> post('group_id');
		//print_r($group_id);
		
		$fname = $this -> input -> post('fname');
		$lname = $this -> input -> post('lname');
		$email = $this -> input -> post('email');
		$pnum = $this -> input -> post('pnum');

		//$location = $this -> input -> post('location');
		$role1 = $this -> input -> post('role');
		$role2=explode('#',$role1);
		 $role=$role2[0];
		 $role_name=$role2[1];
		/* $process_id = $this -> input -> post('process_id');
		 if(count(process_id ==0))
		{
			$process_id=$this->input->post('process_id_single');
		}*/
		$process=$this->input->post('process');
		$finance_location=$this->input->post('finance_location');
		$insurance_location=$this->input->post('insurance_location');
		$service_location=$this->input->post('service_location');
		$accessories_location=$this->input->post('accessories_location');
		$new_car_location=$this->input->post('new_car_location');
		$used_car_location=$this->input->post('used_car_location');
		$evaluation_location=$this->input->post('evaluation_location');
		$complaint_location=$this->input->post('complaint_location');
		$location_array=array();
		if(is_array($finance_location)){
			$location_array=array_merge($location_array,$finance_location);
		}
		if(is_array($insurance_location)){
			$location_array=array_merge($location_array,$insurance_location);
		}
		if(is_array($service_location)){
			$location_array=array_merge($location_array,$service_location);
		}
		if(is_array($accessories_location)){
			$location_array=array_merge($location_array,$accessories_location);
		}
		if(is_array($new_car_location)){
			$location_array=array_merge($location_array,$new_car_location);
		}
		if(is_array($used_car_location)){
			$location_array=array_merge($location_array,$used_car_location);
		}
		if(is_array($evaluation_location)){
			$location_array=array_merge($location_array,$evaluation_location);
		}
			if(is_array($complaint_location)){
			$location_array=array_merge($location_array,$complaint_location);
		}
	
		$q = $this -> add_user_model -> update_user($fname, $lname, $email, $pnum,$role, $id,$role_name,$location_array);
	
	redirect('add_lms_user');
	}

	function delete_user() {
		$q = $this -> add_user_model -> delete_user();
		//redirect('add_lms_user');
	}
	public function get_tl_name()
	{
		$role=$this->input->post('role');
		 $select_tl=$this -> add_user_model -> select_tl($role);?>
		   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Team Leader:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <select name="tl_name" id="tl_name" required  class="form-control">
                                                  	<option value=''>Please Select</option>
                                                  	<?php foreach ($select_tl as $row) {?>
                                                  	<option value='<?php echo $row -> id; ?>'><?php  echo $row -> fname . ' ' . $row -> lname; ?></option>	
                                                  	<?php } ?>
													</select>
													</div>	  
													  <?php
														}
	
	
	public function test_data()
	{
		

	
		$this -> db -> select('DISTINCT (l.location_id),l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->join('tbl_map_process p1','p1.location_id=p.location_id');
		$this->db->where('p.process_id',$_SESSION['process_id']);
		$this -> db -> where('p.user_id', $_SESSION['user_id']);
		$this -> db -> where('p.status !=','-1');
		$this -> db -> where('p1.status !=','-1');
		 $this->db->where('l.location_status !=','Deactive');
			/*if($this->role !='1' && $this->role !='2')
			{*/
				
		//$this -> db -> where('l.location_id', $this->location_id);
	//	}
		//$this->db->group_by('l.location_id');
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();

	}
	
	

														}
													?>
													




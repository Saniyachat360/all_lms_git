<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_call_center_tl_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	    date_default_timezone_set('Asia/Calcutta');
		$this->date = date("Y-m-d");
		$this->time = date("h:i:s A");
		$this->time1=date("H:i:s");
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
			$this -> process_name = $this -> session -> userdata('process_name');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup';
		
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation';
		
	
	
		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all';
	

		}
	}

	public function insert_tl($call_center_tl_id) {

//echo $call_center_tl_id;
echo $date= date("Y-m-d");

		//select id and status=1; 
	$query=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where call_center_tl_id='$call_center_tl_id' AND process_id=$this->process_id AND status='1'")->result();
	if(count($query)>0)//to check record is already have or not.
	 {
		 $this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> TL  Already Exists ...!</strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			
	 }else{
		$query1=$this ->db->query("select call_center_tl_id from tbl_default_call_center_tl where call_center_tl_id='$call_center_tl_id' AND process_id=$this->process_id AND status='-1'")->result(); 
			 if(count($query1)>0) 
			 {
			 $this->db->query("update tbl_default_call_center_tl set status='-1' where process_id=$this->process_id");
			 $query=$this->db->query("update tbl_default_call_center_tl set status='1', updated_date='$date' where call_center_tl_id='$call_center_tl_id'  AND process_id=$this->process_id");
			 
			 } else {
			$this->db->query("update tbl_default_call_center_tl set status='-1' where process_id=$this->process_id");
			$data= $query = $this -> db -> query("insert into tbl_default_call_center_tl (`call_center_tl_id`,process_id,status,created_date,updated_by)values('$call_center_tl_id','$this->process_id','1','$date','$this->user_id')");


			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> TL Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}	 
	 }
		//	$this->db->query("update tbl_default_call_center_tl set status='-1' where process_id=$this->process_id");
			
			
		//	$query = $this -> db -> query("insert into tbl_default_call_center_tl (`call_center_tl_id`,process_id,status,created_date,updated_by)values('$call_center_tl_id','$this->process_id','1','$date','$this->user_id')");


			//$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> TL Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		
	}

	public function select_tl() {
		//echo $this->process_id;
		$this -> db -> select('*');
		$this -> db -> from('lmsuser l');
		$this->db->join('tbl_manager_process m','l.id=m.user_id');
		$this -> db -> where('m.process_id',$this->process_id);
		
		$this->db->where('role_name =','CSE Team Leader');
		$query = $this -> db -> get();
		return $query -> result();

	}
		public function select_table_data() {
		    
		    $this -> db -> select('a.id,a.user_id,l1.fname,l1.lname');
		$this -> db -> from('tbl_assign_lead_to_user a');
		$this->db->join('lmsuser l1','l1.id=a.user_id');
		$this -> db -> where('a.process_id',$this->process_id);
		$this->db->group_by('a.user_id');
		$query = $this -> db -> get()->result();
		if(count($query)>0)
		{
		    foreach($query as $row){
		    $user_id=$row->user_id;
		    $name=$row->fname.' '.$row->lname;
		    	$this -> db -> select('l.lead_source_name');
		$this -> db -> from('tbl_assign_lead_to_user a');
		
		$this->db->join('lead_source l','l.id=a.lead_source_id');
		$this -> db -> where('a.user_id',$user_id);
	//	$this->db->group_by('a.user_id');
		$query = $this -> db -> get()->result();
		//echo $this->db->last_query();
		//return $query -> result();
		$data[] = array('id'=>$row -> id,'username'=>$name,'lead_source'=>$query);
		    }
		}
		else
		{
		    $data = array();
		}
	return	$data;

	}
		public function lead_source() {
		//echo $this->process_id;
		$this -> db -> select('*');
		$this -> db -> from('lead_source l');
		$this -> db -> where('l.process_id',$this->process_id);
			$this -> db -> where('l.leadsourceStatus !=','Deactive');
			$this->db->order_by('lead_source_name','asc');
	//	$this->db->limit('10');
		$query = $this -> db -> get();
		return $query -> result();

	}
		public function check_lead_source() {
		$user_id=$this->input->post('userid');
		$this -> db -> select('lead_source_id');
		$this -> db -> from('tbl_assign_lead_to_user m');
		$this -> db -> where('user_id',$user_id);
			$this -> db -> where('m.process_id',$this->process_id);
		$query = $this -> db -> get();
		return $query -> result();

	}
		public function select_user() {
		//echo $this->process_id;
		$this -> db -> select('l.id, l.fname, l.lname');
		$this -> db -> from('lmsuser l');
		$this->db->join('tbl_manager_process m','l.id=m.user_id');
		$this -> db -> where('m.process_id',$this->process_id);
		
		$this->db->where('role','3');
		$this->db->where('l.status','1');
		$query = $this -> db -> get();
		return $query -> result();

	}
		public function select_count() {
		//echo $this->process_id;
		$this -> db -> select('*');
		$this -> db -> from('tbl_assign_lead_count');
			$this -> db -> where('process_id',$this->process_id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_table_tl() {
		$this -> db -> select('l.id,d.call_center_tl_id,l.fname,l.lname,p.process_name');
		$this -> db -> from('tbl_default_call_center_tl d');
		$this->db->join('lmsuser l','l.id=d.call_center_tl_id');
		$this->db->join('tbl_process p','p.process_id=d.process_id');
		//$this -> db -> where('location_status !=','Deactive');
		$this -> db -> where('d.process_id',$this->process_id);
		$this->db->where('d.status =','1');
		$query = $this -> db -> get();
		return $query -> result();

	}
		public function insert_auto_assign() {
	echo	$count_number=$this->input->post('count_number');
	$userid=$this->input->post('userid');
	$lead_source=$this->input->post('lead_source');
	$from_time=$this->input->post('from_time');
	$to_time=$this->input->post('to_time');
	print_r($lead_source);
//echo $call_center_tl_id;
echo $date= date("Y-m-d");
$cquery=$this->db->query("select * from tbl_assign_lead_count where process_id='$this->process_id'")->result();
if(count($cquery)>0)
{
     $this->db->query("update tbl_assign_lead_count set count_number='$count_number',from_time='$from_time',to_time='$to_time',updated_date='$this->date',updated_time='$this->time' where process_id='$this->process_id'");
}
else
{
    $query = $this -> db -> query("insert into tbl_assign_lead_count(count_number,`updated_date`,`updated_time`,process_id,from_time,to_time)
	values('$count_number','$this->date','$this->time','$this->process_id','$from_time','$to_time')"); 
		
}
$this->db->query("DELETE FROM `tbl_assign_lead_to_user` where user_id='$userid'");
$c=count($lead_source);
for($i=0;$i<$c;$i++)
{
    $query = $this -> db -> query("insert into tbl_assign_lead_to_user(user_id,lead_source_id,`updated_date`,`updated_time`,process_id,date)
	values('$userid','$lead_source[$i]','$this->date','$this->time','$this->process_id','$this->date')"); 
}
if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

	
		
	}
	public function auto_assign_lead($enq_id,$process_id,$lead_source_id)
	{
	    	if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
		//	$table_name1 = 'lead_followup';
		
		}
		elseif ($process_id == 8) {
			$table_name = 'lead_master_evaluation';
		//	$table_name1 = 'lead_followup_evaluation';
		
	
	
		} else {
			$table_name = 'lead_master_all';
		//	$table_name1 = 'lead_followup_all';
		}
	
		    $q1=$this->db->query("select * from tbl_assign_lead_count where process_id='$process_id'")->result();
		    if(count($q1)>0)
		    {
		        echo $count_number=$q1[0]->count_number;
		        echo $from_time=$q1[0]->from_time;
		        echo $to_time=$q1[0]->to_time;
		        echo $this->time1;
		        if($this->time1 > $from_time && $this->time1 < $to_time)
		        {
		            echo "assign";
		            $q=$this->db->query("select * from ".$table_name." where enq_id='$enq_id'")->result();
            		if(count($q)>0)
            		{
            		    echo "lead";
            		    $q2=$this->db->query("select * from tbl_assign_lead_to_user where process_id='$process_id' and date='$this->date'")->result();
                		if(count($q2)>0)
                		{
                		    //echo "lead";
                		}else
                		{
                		    $this->db->query("update tbl_assign_lead_to_user set count=0,date='$this->date' where process_id='$process_id' ");
                		}
                		$q3=$this->db->query("select u.* from tbl_assign_lead_to_user u 
                		join tbl_login_history h on h.user_id=u.user_id where process_id='$process_id' and u.date='$this->date' and h.login_date='$this->date' 
                		and lead_source_id='$lead_source_id' and count < '$count_number' ORDER BY count asc")->result();
                		print_r($q3);
                		if(count($q3)>0)
                		{
                		    echo "check leads";
                		    $q4=$this->db->query("select * from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
                		    if(count($q4)>0)
                		    {
                		        $assign_by=$q4[0]->call_center_tl_id;
                		    }
                		    else
                		    {
                		        $assign_by='1';
                		    }
                		    foreach($q3 as $row)
                		    {
                		        echo $user_id= $row->user_id;
                		        $id=$row->id;
                		        $count_n=$row->count +1 ;
                		      /*  $this->db->query ("update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'");*/
                		        echo "update ".$table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$this->date',
                		        assign_to_cse_time='$this->time',assign_to_cse='$user_id' where enq_id='$enq_id'";
			
                		        $this->db->query("update tbl_assign_lead_to_user set count='$count_n' where user_id='$user_id' and process_id='$process_id'");
                		        $this->db->query("INSERT INTO `tbl_assign_lead_to_user_history`(`user_id`, `lead_source_id`, `process_id`, `date`, `count`,created_time,enq_id) 
                		        VALUES ('$user_id','$lead_source_id','$process_id','$this->date','1','$this->time','$enq_id')");
                		        break;
                		    }
                		    
                		}
            		}
		        }
		        else
		        {
		            echo "dont";
		        }
		    }
		
	}

}

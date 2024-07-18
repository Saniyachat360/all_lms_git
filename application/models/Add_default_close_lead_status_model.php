<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_default_close_lead_status_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_defult_close_lead_status($naction_name,$process_id) {

		
		/*$q = $this -> db -> query('select * from tbl_add_default_close_lead_status where nextActionName="' . $naction_name . '" and process_id="'.$process_id.'" and default_close_lead_status=" "') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {*/
		$old_data = $this -> db -> query('select * from tbl_add_default_close_lead_status where process_id="'.$process_id.'" and default_close_lead_status="Active"') -> result();
		echo $this->db->last_query();
		$next_action_array=array();
		
		
            if(isset($old_data[0]->nextActionName)){
                array_push($next_action_array,$naction_name);
                $old_next_action=json_decode($old_data[0]->nextActionName	);
                
                $next_action_array=array_merge($next_action_array,$old_next_action);
				print_r($next_action_array);
				    $next_action_array=json_encode($next_action_array);
						print_r($next_action_array);
					$id=$old_data[0]->default_close_lead_id;
        	$query = $this -> db -> query("UPDATE `tbl_add_default_close_lead_status` SET `nextActionName`='$next_action_array' WHERE default_close_lead_id='$id'");

            }else{
                array_push($next_action_array,$naction_name);
				$next_action_array=json_encode($next_action_array);
				$status='Active';
				$query = $this -> db -> query("insert into tbl_add_default_close_lead_status (`nextActionName`,`process_id`,default_close_lead_status)values('$next_action_array','$process_id','$status')");

            }
            
        
		
		

		
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		
	}

	public function select_defult_close_lead_status() {
		$this -> db -> select('n.default_close_lead_id,n.nextActionName,p.process_id,p.process_name,n.default_close_lead_status');
		$this -> db -> from('tbl_add_default_close_lead_status n');
		$this -> db -> join('tbl_process p','p.process_id=n.process_id','left');
		//$this -> db -> where('default_close_lead_status!=','Deactive');
		$this -> db -> where('p.process_name',$_SESSION['process_name']);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_next_action_status($process_id) {
		$this -> db -> select('nextActionId,nextActionName');
		$this -> db -> from('tbl_nextaction');
		$this -> db -> where('process_id',$process_id);
		$this -> db -> where('nextActionstatus!=','Deactive');
		//echo $this->db->last_query();
		$query = $this -> db -> get();
		return $query -> result();

	}

	

	public function delete_deafault_close_lead_status($id,$nextAction) {

		$old_data = $this -> db -> query("select * from tbl_add_default_close_lead_status where default_close_lead_id='$id' and default_close_lead_status='Active'") -> result();
		$nextAction=trim($nextAction); 
		
		 $nextAction=str_ireplace("%20"," ",$nextAction);
		$nextActionArray=json_decode ($old_data[0]->nextActionName);
		$pos = array_search($nextAction, $nextActionArray);

	//	echo 'Linus Trovalds found at: ' . $pos;
		// Remove from array
		unset($nextActionArray[$pos]);

		//print_r($nextActionArray);
		
		$arrayCount=count($nextActionArray);
		
		if($arrayCount>0)
		{
			//echo "if";
			 $nextActionArray1=json_encode(array_values($nextActionArray));
			$this -> db -> query("update tbl_add_default_close_lead_status set nextActionName='$nextActionArray1' where default_close_lead_id= '$id'");
		}
		else
		{
			//echo "else";
			$this -> db -> query("delete from tbl_add_default_close_lead_status where default_close_lead_id='$id'");
		}
		
		
		
		//$this -> db -> query("update tbl_add_default_close_lead_status set nextActionName='$nextActionArray1' where default_close_lead_id= '$id'");

		//$this -> db -> query("delete from tbl_nextaction where default_close_lead_id='$id'");
		//$this -> db -> query('update tbl_add_default_close_lead_status set default_close_lead_status="Deactive"  where default_close_lead_id="' . $id . '"');
		/*if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Next Action Status Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Next Action Status Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}*/

	}

	public function select_process()
{
		$this -> db -> select('process_id,process_name');
		$this -> db -> from('tbl_process');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}

}

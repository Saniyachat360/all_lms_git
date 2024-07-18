<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class lms_user_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//fetch  data from lmsuser whose role is dse
	function lms_user_data() {

		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser');
		$this -> db -> where('role_name', 'DSE');
		$query = $this -> db -> get();
		return $query -> result();
	}

	//fetch the data from lmsuser whose role is Team leader
	function lms2_user_data($process_id) {
		//select only id fname lname from lmsuser
		$tl_id=array(3,5,7,9);
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser');
		$this -> db -> where('process_id',$process_id);
		$this -> db -> where_in('role',$tl_id);
		$query2 = $this -> db -> get();
		
		return $query2 -> result();

	}
	
	/*function locationwise_dse($tlname) {
		//select only id fname lname from lmsuser
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser');
		$this -> db -> where('role_name', 'DSE Team Leader');
		$query2 = $this -> db -> get();
		return $query2 -> result();

	}
	*/
	function locationwise_dse($tlname) {
		//select only id fname lname from lmsuser
		$this -> db -> select('id,location');
		$this -> db -> from('lmsuser');
		$this -> db -> where('id', $tlname);
		$query2 = $this -> db -> get();
		return $query2 -> result();

	}
	
	function locationwise_dse_name($location,$process_id) {
		//select only id fname lname from lmsuser
			$tl_id=array(4,6,8,10);
		$this -> db -> select('fname,lname,id');
		$this -> db -> from('lmsuser');
		$this -> db -> where('location', $location);
		$this -> db -> where('process_id',$process_id);
		$this -> db -> where_in('role',$tl_id);
		$query2 = $this -> db -> get();
		return $query2 -> result();

	}
	
	function mapwise_dse($tlname) {
		//select only id fname lname from lmsuser
		$this -> db -> select('tl_id,dse_id');
		$this -> db -> from('tbl_mapdse');
		$this -> db -> where('tl_id', $tlname);
		//$this -> db -> where('role', 4);
		$query2 = $this -> db -> get();
		return $query2 -> result();

	}
	
	function fetch_all_data($process_id) {
		//we are join the table lmsuser and mapdse
		
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
		$this -> db -> select('d.map_id,l.fname,l.lname,l1.fname as tlfname,l1.lname as tllname');
		$this -> db -> from('tbl_mapdse d');
		$this -> db -> join('lmsuser l', 'l.id=d.dse_id');
		$this -> db -> join('lmsuser l1', 'l1.id=d.tl_id');
		$this -> db -> where('l1.process_id',$process_id);
		$this->db->order_by('tl_id','asc');
		$this -> db -> limit($rec_limit, $offset);
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}

	function user() {
		//we are join the table lmsuser and mapdse
		$this -> db -> select('count(l1.fname) as lmscount');
		$this -> db -> from('tbl_mapdse d');
		$this -> db -> join('lmsuser l', 'l.id=d.dse_id');
		$this -> db -> join('lmsuser l1', 'l1.id=d.tl_id');
		$this->db->order_by('tl_id','asc');
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}
	
	function insert_map() {
		
		echo $tlname = $this -> input -> post('tlname');
		 $dse_name = $this -> input -> post('dse_name');
		print_r($dse_name);
				$this -> db -> query("delete from tbl_mapdse where tl_id='$tlname'");
				if(isset($_POST["dse_name"])) //checks if any interest is checked
    {
    	$check = array();
        foreach($_POST["dse_name"] as $dse_name) //Iterate the interest array and get the values
        {
		 $dse_name;
		 //$query = $this -> lms_user_model -> insert_map($tlname, $dsename);
		$query = $this -> db -> query("insert into tbl_mapdse (`tl_id`,`dse_id`)values('$tlname','$dse_name')");	
        }
    }
				
				//$query = $this -> db -> query("insert into tbl_mapdse (`tl_id`,`dse_id`)values('$tlname','$dsename')");
		//	$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>DSE Mapped Successfully...</strong> </div>');

		
			
		

	}

	/*function insert_map($tlname, $dsename) {
		$q = $this -> db -> query('select * from tbl_mapdse where tl_id="' . $tlname . '" and dse_id="' . $dsename . '"') -> result();
		if (count($q) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>DSE Already Mapped ...</strong> </div>');
			
			} else {
				$query = $this -> db -> query("insert into tbl_mapdse (`tl_id`,`dse_id`)values('$tlname','$dsename')");
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>DSE Mapped Successfully...</strong> </div>');

		
			
		}

	}
*/
	function delete_map_lms($id) {

		$this -> db -> query("delete from tbl_mapdse where map_id='$id'");

		$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Record Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}

	function edit_map_lms($id1) {
		$this -> db -> select('d.dse_id,d.tl_id,d.map_id,l.fname,l.lname,l1.fname as tlfname,l1.lname as tllname');
		$this -> db -> from('tbl_mapdse d');
		$this -> db -> join('lmsuser l', 'l.id=d.dse_id');
		$this -> db -> join('lmsuser l1', 'l1.id=d.tl_id');
		$this -> db -> where('map_id', $id1);
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}

	public function update_map_lms($tlname, $dsename, $id3) {
		$q = $this -> db -> query('select * from tbl_mapdse where tl_id="' . $tlname . '" and dse_id="' . $dsename . '"') -> result();
		if (count($q) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>DSE Already Mapped ...</strong> </div>');
			
			
		} else {
			$this -> db -> query('update tbl_mapdse set tl_id="' . $tlname . '", dse_id="' . $dsename . '" where map_id="' . $id3 . '"');
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>DSE Mapped Updated Successfully...</strong> </div>');
			
		}

	}

	function select_lms() {
		//we are join the table lmsuser and mapdse
		$locationName = $this -> input -> post('locationName');
		
		
		$this -> db -> select('d.map_id,l.fname,l.lname,l1.fname as tlfname,l1.lname as tllname');
		$this -> db -> from('tbl_mapdse d');
		$this -> db -> join('lmsuser l', 'l.id=d.dse_id');
		$this -> db -> join('lmsuser l1', 'l1.id=d.tl_id');
		$this->db->order_by('tl_id','asc');
		
		if($locationName !='')
		{
			//$this -> db   ->where("CONCAT_WS(l.fname,l.lname) LIKE '%$locationName%'");
			$this -> db   ->where("CONCAT(l1.fname,' ',l1.lname) LIKE '%$locationName%'");
			$this -> db   ->or_where("CONCAT(l.fname,' ',l.lname) LIKE '%$locationName%'");
			//$this -> db -> where('location',$locationName);
		}
		//$this -> db -> limit($rec_limit, $offset);
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}


}
?>

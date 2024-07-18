<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_car_stock extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('new_car_stock_models');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function index() {
		$this -> session();
	
		$data['select_stock']=$this->new_car_stock_models->select_stock();	
		$data['select_new_stock']=$this->new_car_stock_models->select_new_stock();	
		
		$data['select_model']=$this->new_car_stock_models->select_model();
		$data['assigned_location']=$this->new_car_stock_models->assigned_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('New_car_stock_views.php',$data);
		$this -> load -> view('include/footer.php');
	}
		public function with_model() {
		$this -> session();
	
		$data['select_stock']=$this->new_car_stock_models->select_stock();	
		$data['select_new_stock']=$this->new_car_stock_models->select_new_stock_model();	
		
		$data['select_model']=$this->new_car_stock_models->select_model();
		$data['assigned_location']=$this->new_car_stock_models->assigned_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('new_car_stock_using_model_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
			public function select_model_div() {
		$this -> session();
	
		$select_submodel=$this->new_car_stock_models->select_submodel();	?>
		<select class="filter_s col-md-12 col-xs-12 form-control" name="submodel" id="submodel" >

		<option value="">Submodel</option>
	<?php foreach($select_submodel as $fetch){?>
	<option value="<?php echo $fetch->submodel; ?>"><?php echo $fetch->submodel; ?></option>
	<?php } ?>
		</select>
		<?php
			}
	public function stock_list() {
		$this -> session();
	
		$data['select_stock']=$this->new_car_stock_models->select_stock_list();	
		//$data['select_old_stock_count']=$this->used_car_stock_model->select_old_stock_count();	
		
		
		$data['select_model']=$this->new_car_stock_models->select_model();
		$data['assigned_location']=$this->new_car_stock_models->assigned_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('New_car_stock_list_views.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function stock_list1() {
		$this -> session();
	
		$data['select_stock']=$this->new_car_stock_models->select_new_stock_model();	
		//$data['select_old_stock_count']=$this->used_car_stock_model->select_old_stock_count();	
		
		
		$data['select_model']=$this->new_car_stock_models->select_model();
		$data['assigned_location']=$this->new_car_stock_models->assigned_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('New_car_stock_list_views.php',$data);
		$this -> load -> view('include/footer.php');
	}
	
	public function with_model_filter(){
		//echo "hi";
		
		
		$select_new_stock=$this->new_car_stock_models->select_new_stock_model();	
		
		//print_r($select_stock_filetr);

	?>
	 <script>
	$(document).ready(function() {
	
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
				scrollCollapse : true,
			/*fixedColumns:   true,
			fixedColumns : {
				leftColumns : 1,
				rightColumns : 0
			}*/
		});
		
	}); 
</script>

		<table id="example" class="stripe row-border order-column" style="width:100%">
        <thead>
            <tr>
			<th>SR No</th>
                <th>Model</th>
				 <th>Variant</th>
               <th>Count</th>
            </tr>
           
        </thead>
		<tbody>
          <?php 
					$i=0;
						foreach($select_new_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch->model_name;  ?></td>
						
						<td><?php echo $fetch->submodel; ?></td>
						<td><a onclick="stock_list('<?php echo $fetch->submodel;?>')" style="cursor:pointer"><?php echo $fetch->model_count ?></a></td>
            </tr>
						<?php }?>
					
					</tbody>
				</table>
<?php
	}

	
		public function new_stock_filter()
	{
		//echo "hi";
		
		
		$select_new_stock=$this->new_car_stock_models->select_new_stock();	
		
		//print_r($select_stock_filetr);

	?>
	 <script>
	$(document).ready(function() {
	
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
				scrollCollapse : true,
			/*fixedColumns:   true,
			fixedColumns : {
				leftColumns : 1,
				rightColumns : 0
			}*/
		});
		
	}); 
</script>

		<table id="example" class="stripe row-border order-column" style="width:100%">
        <thead>
            <tr>
				<th rowspan="2">SR No</th>
                <th rowspan="2">Model</th>
				 <th rowspan="2">Varient</th>
                <th colspan="2" style="text-align:center">Vehicle Status</th>
                <th colspan="4" style="text-align:center">Ageing</th>
				<th colspan="4" style="text-align:center">Price</th>
            </tr>
            <tr>
			
                <th>FREE</th>
                <th>BLOCKED</th>
          
				
				<th>Before 15 Days</th>
				<th>15 to 30 Days</th>
				<th>31 To 60 Days</th>
				<th>More Than 60 Days</th>
				
				<th>Less than 4 lakh</th>
				<th>4 To 6 Lakh</th>
				<th>6 To 8 Lakh</th>
				<th>More than 8 Lakh</th>
				
            </tr>
        </thead>
		<tbody>
          <?php 
					$i=0;
					//print_r($select_new_stock);
						foreach($select_new_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch['model_name']; ?></td>
						
						<td><?php echo $fetch['submodel'].  '    ('. $fetch['model_count'].')'; ?></td>
						
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=1&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['vehicle_status_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=2&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['vehicle_status_2']; ?></a></td>
						
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=3&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=4&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_2']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=5&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_3']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=6&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_4']; ?></a></td>
					
				
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=7&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=8&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_2']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=9&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_3']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=10&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_4']; ?></a></td>
					
               
            </tr>
						<?php }?>
				
					</tbody>
				</table>
<?php
	}

	}
?>

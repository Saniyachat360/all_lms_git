<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class used_car_stock extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('used_car_stock_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function stock() {
		$this -> session();
	
		$data['select_old_stock']=$this->used_car_stock_model->select_old_stock();	
		//$data['select_old_stock_count']=$this->used_car_stock_model->select_old_stock_count();	
		
		
		$data['select_make']=$this->used_car_stock_model->select_make();
		$data['stock_location']=$this->used_car_stock_model->stock_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('used_car_stock_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function with_model() {
		$this -> session();
	
		$data['select_old_stock']=$this->used_car_stock_model->select_used_stock_model();	
		//$data['select_old_stock_count']=$this->used_car_stock_model->select_old_stock_count();	
		
		
		$data['select_make']=$this->used_car_stock_model->select_make();
		$data['stock_location']=$this->used_car_stock_model->stock_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('used_car_stock_using_model_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	
		public function with_model_filter()
	{
		//echo "hi";
		
	
		
		$select_old_stock=$this->used_car_stock_model->select_used_stock_model();	
		
		//print_r($select_stock_filetr);
		?>	<script>
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
                <th>Make</th>
				 <th>Model</th>
				  <th>submodel</th>
               <th>Count</th>
            </tr>
           
        </thead>
		<tbody>
          <?php 
					$i=0;
						foreach($select_old_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch->make_name;  ?></td>
						
						<td><?php echo $fetch->model; ?></td>
						<td><?php echo $fetch->submodel ;?></td>
						<td><a onclick="stock_list('<?php echo $fetch->submodel;?>')" style="cursor:pointer"><?php echo $fetch->model_count ; ?></a></td>
            </tr>
						<?php }?>
					
					</tbody>
				</table>
				
		
	
  
<?php
	
	}
	public function stock_list() {
		$this -> session();
	
		$data['select_old_stock']=$this->used_car_stock_model->select_stock_list();	
		//$data['select_old_stock_count']=$this->used_car_stock_model->select_old_stock_count();	
		
		
		$data['select_make']=$this->used_car_stock_model->select_make();
		$data['stock_location']=$this->used_car_stock_model->stock_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('used_car_stock_list_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function stock_list1() {
		$this -> session();
	
		$data['select_old_stock']=$this->used_car_stock_model->select_used_stock_model();	
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('used_car_stock_list_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	
	public function select_model_div(){
		$select_model=$this->used_car_stock_model->select_model_make();	?>
		
		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model" >

		<option value="">Model</option>
		
		<?php foreach($select_model as $row){?>
		<option value="<?php echo $row->submodel; ?>"><?php echo $row->submodel; ?></option>
		<?php }?>
		</select>
	<?php }
		public function old_stock_filter()
	{
		//echo "hi";
		
	
		
		$select_old_stock=$this->used_car_stock_model->select_old_stock();	
		
		//print_r($select_stock_filetr);
		?>	<script>
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
                <th rowspan="2">Make</th>
				 <th rowspan="2">Model</th>
                <th colspan="4" style="text-align:center">Mfg Year</th>
				  <th colspan="3" style="text-align:center">Owner</th>
                <th colspan="4" style="text-align:center">Ageing</th>
				<th colspan="3" style="text-align:center">Price</th>
            </tr>
            <tr>
			
                <th>Before 2010</th>
                <th>2010-12</th>
                <th>2012-15</th>
                <th>After 2015</th>
				
                <th>One</th>
				<th>Two</th>
				<th>More than two</th>
				
				<th>Before 15 Days</th>
				<th>15 to 30 Days</th>
				<th>31 To 60 Days</th>
				<th>More Than 60 Days</th>
				
				<th>Less than 2 lakh</th>
				<th>2 To 5 Lakh</th>
				<th>More than 5 Lakh</th>
				
            </tr>
        </thead>
		<tbody>
          <?php 
					$i=0;
						foreach($select_old_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch['make_name']; ?></td>
						
						<td><?php echo $fetch['submodel'].  '    ('. $fetch['model_count'].')'; ?></td>
						
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=1&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['mfg_year_1']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=2&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['mfg_year_2']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=3&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['mfg_year_3']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=4&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['mfg_year_4']; ?></a></td>
						
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=5&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['owner_1']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=6&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['owner_2']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=7&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['owner_3']; ?></a></td>
					
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=8&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['ageing_1']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=9&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['ageing_2']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=10&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['ageing_3']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=11&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['ageing_4']; ?></a></td>
						
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=12&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['price_1']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=13&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['price_2']; ?></a></td>
						<td><a href="<?php echo site_url('used_car_stock/stock_list/?id=14&submodel='.$fetch['submodel'].'&stock_location='.$fetch['stock_location']);?>"><?php echo $fetch['price_3']; ?></a></td>
						
						
               
            </tr>
						<?php }?>
					
					</tbody>
				</table>
				
		
	
  
<?php
	
	}

	}
?>

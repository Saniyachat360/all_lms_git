<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poc_stock extends CI_Controller {

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
	
		$data['select_stock']=$this->new_car_stock_models->select_poc_stock();	
		
		$data['select_make']=$this->new_car_stock_models->select_poc_make();
		
		$data['stock_location']=$this->new_car_stock_models->stock_location();
		
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('poc_car_stock_view.php',$data);
		$this -> load -> view('include/footer.php');
		
	}

	//select budget
	public function budget() {
		$this -> session();
		$budget_from=$this->input->get('from_budget');
		$budget_to=$this->input->get('from_budget_to');
		$make=$this->input->get('make');
		$model=$this->input->get('model');
		$data['select_stock']=$this->new_car_stock_models->select_poc_stock_budget($budget_from,$budget_to,$make,$model);
		$this -> load -> view('include/admin_header.php');		
		$this -> load -> view('poc_car_stock_budget_view.php',$data);
		$this -> load -> view('include/footer.php');
		
	}


	public function stock_filter(){
				$select_stock=$this->new_car_stock_models->select_poc_stock();	

		?>
			<script>
	$(document).ready(function() {
	
	if($("#example").width()>1308){
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
		}else{
				var table = $('#example').DataTable({
				searching:false,
				scrollY : "400px",
				scrollX : false,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
				
			}
		
	}); 
</script>
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>

	<table class="table table-bordered  datatable" id="example"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Make</th>
							<th>Model</th>
							<th>Color</th>
							<th>Fuel Type</th>
							
							<th>Location</th>
							<th>Ageing</th>
							<th>Last Updated</th>
						</tr>	
					</thead>
					<tbody>
				
					 <?php 
					 $i=0;
						foreach($select_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
							<td><?php echo $fetch -> make; ?></td>
						
							<td><?php echo $fetch -> model; ?></td>
						
						<td><?php echo $fetch -> color; ?></td>
						
						
							<td><?php echo $fetch -> fuel_type; ?></td>
								
							
							<td><?php echo $fetch -> stock_location; ?></td> 
							<td><?php echo $fetch -> ageing; ?></td>   
							<td><?php echo $fetch -> created_date; ?></td>                   
						 </tr>
						 
						 	 <?php } ?>
						 
					
					</tbody>
				</table>
				<?php
	}
	public function select_model_div() {
		$this -> session();
	$make=$this->input->post('make');
		$select_submodel=$this->new_car_stock_models->select_poc_model($make);	?>
		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model"  >

		<option value="">Car Model</option>
		<?php foreach($select_submodel as $fetch){?>
	<option value="<?php echo $fetch->model; ?>"><?php echo $fetch->model; ?></option>
	<?php } ?>
		</select>
		
		<?php
			}
	}
?>
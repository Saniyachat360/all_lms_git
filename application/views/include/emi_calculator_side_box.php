<style>.slide_button {
    position: fixed;
    bottom: 46%;
    right: 1px;
    background-color: #154a87;
    border-radius: 0;
    width: 40px;
    height: 40px;
    z-index: 100;
    padding: 0;
}</style><button id="slide_button" type="button" data-toggle="modal" data-target="#myModal" class="slide_button btn btn-lg">
	<i id="info_click_id_tracking" class="entypo-doc-text-inv" aria-hidden="true" style="font-size: 25px;color:#fff"> </i>
</button>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>EMI Calculator</h3>
      </div>
      <div class="modal-body">
    	 	<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
			
								<div class="col-md-12" style="border: 1px solid #ddd">
							
							<div class="col-md-6">
							  <div class="form-group col-md-12">
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" >Loan Amount:</label>
                                         	<div class="col-md-6 col-sm-6 col-xs-12">
                                               <input type="text" id="loanamount" value="400000" class="form-control col-md-8" name="loanamount" maxlength="100" title="Name" placeholder="Amount" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Amount'">
                                         	</div>
                                      </div>
		  <div class="form-group col-md-12">
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" >Rate of Interest(%):</label>
                                         	<div class="col-md-6 col-sm-6 col-xs-12">
                                           <input type="text" id="interest" value="12.5" class="form-control col-md-8" name="interest" maxlength="10" placeholder="Interest" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Interest'">
</div>
                                      </div>
		

							<div class="col-md-12" style="margin-bottom: 20px">
							<button type="button" onclick="emical()" class="btn btn-primary col-md-offset-4 col-md-4 col-xs-12 col-sm-12" >Calculate EMI</button>
							</div>
							</div>
							<br>
		
							<div class="col-md-offset-1 col-md-4" Style="margin-top:-20px;margin-bottom:10px;">
							<table class="table table-bordered">
    <thead>
      <tr>
        <th>Months</th>
        <th>EMI per Month</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>12</td>
        <td id="monthly1"></td>
      </tr>
      <tr>
        <td>24</td>
        <td id="monthly2"></td>
      </tr>
      <tr>
        <td>36</td>
        <td id="monthly3"></td>
      </tr>
	   <tr>
        <td>48</td>
        <td id="monthly4"></td>
      </tr>
	   <tr>
        <td>60</td>
        <td id="monthly5"></td>
      </tr>
	   <tr>
        <td>72</td>
        <td id="monthly6"></td>
      </tr>
	   <tr>
        <td>84</td>
        <td id="monthly7"></td>
      </tr>
    </tbody>
  </table>
       
	   </div>
	  </div>
	  </div></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	<script>	$(window).on('load', function() {
					
							emical();
					});		
							
							function emical(){
								//alert("hi");
								var amount = document.getElementById('loanamount').value;
								var interest = document.getElementById('interest').value;
								var intr = interest/100/12;
								
								// year is not year its month
								var years = 12;
								var x = Math.pow(1+intr,years);
								var monthly1 = (amount*x*intr)/(x-1);
								var monthly1 = Math.round(monthly1);
								//alert(monthly1);
								
								var years2 = 24;
								var x = Math.pow(1+intr,years2);
								var monthly2 = (amount*x*intr)/(x-1);
								var monthly2 = Math.round(monthly2);
								//alert(monthly2);
								
								var years3 = 36;
								var x = Math.pow(1+intr,years3);
								var monthly3 = (amount*x*intr)/(x-1);
								var monthly3 = Math.round(monthly3);
								//alert(monthly3);
								
								var years4 = 48;
								var x = Math.pow(1+intr,years4);
								var monthly4 = (amount*x*intr)/(x-1);
								var monthly4 = Math.round(monthly4);
								
								var years = 60;
								var x = Math.pow(1+intr,years);
								var monthly5 = (amount*x*intr)/(x-1);
								var monthly5 = Math.round(monthly5);
								
								var years = 72;
								var x = Math.pow(1+intr,years);
								var monthly6 = (amount*x*intr)/(x-1);
								var monthly6 = Math.round(monthly6);
								
								var years = 84;
								var x = Math.pow(1+intr,years);
								var monthly7 = (amount*x*intr)/(x-1);
								var monthly7 = Math.round(monthly7);
								
								document.getElementById('monthly1').innerHTML = monthly1;
								document.getElementById('monthly2').innerHTML = monthly2;
								document.getElementById('monthly3').innerHTML = monthly3;
								document.getElementById('monthly4').innerHTML = monthly4;
								document.getElementById('monthly5').innerHTML = monthly5;
								document.getElementById('monthly6').innerHTML = monthly6;
								document.getElementById('monthly7').innerHTML = monthly7;
								
								
							}</script>
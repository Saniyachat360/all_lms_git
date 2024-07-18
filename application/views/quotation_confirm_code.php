<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script  src="https://www.autovista.in/all_lms/assets/js/jquery-1.11.3.min.js"></script>
		<script  src="https://autovista.in/assets/js/jquery-1.12.2.min.js"></script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
<script>
function test()
{//alert("hi");
  $('#myModal').show();
   // document.getElementById("myModal").showModal();
}
</script>
</head>
<body onload='test()'>


<!-- Trigger/Open The Modal -->
<button id="myBtn">Open confirmation Box</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
 				  <!---send quotation-->
  				
  				
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               
                <h3>Confirm Code and Download Quotation</h3> </div>
            <div class="modal-body">
                <div class="row">
					<form action="<?php echo site_url();?>new_quotation_send/download_pdf1" method="POST">
					
						<input type="hidden" name="quotation_id" value="<?php echo $quotation_id; ?>" />
						<input type="hidden" name="h_code" value="<?php echo $code; ?>" />
				 <div class="col-md-12" >
											<div class="panel panel-primary">
				
						<div class="panel-body">
							<div class="col-md-12">
						<div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name" style='margin:10px'>Enter Your Code:    </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text"  style='margin:10px' placeholder="Enter Confirmation Code"  name='code'  id="code" required class="form-control" tabindex="2"/>
                                            </div>
                                        </div>
                                         </div>
              
	 
							
       	</div>
       	</div></div></div></div>
       	 <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" style='margin:10px' >Submit </button>
      </div>
      </form>
       	</div>
       	</div>
       	</div>
      
       <!---/send quotation-->

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>

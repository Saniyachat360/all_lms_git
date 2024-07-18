  
  
  <script>
/*	$(document).ready(function() {
    if($("#example").width()>1308){
		var table = $('#example').DataTable({

			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,
 			 searching: false,
 			 
			fixedColumns : {
				leftColumns : 2,
				rightColumns : 1
			}
			
		});
  }else{
      var table = $('#example').DataTable({

      scrollY : "400px",
      scrollX : false,
      scrollCollapse : true,
       searching: false,
      fixedColumns : {
        leftColumns : 2,
        rightColumns : 1
      }
    });
  }
	});*/
	function exportTableToCSV(filename) {
    var csv = [];
    var rows = $("#example tr");
    var t=",,Login History,,";
     csv.push(t);  
    for (var i = 0; i < rows.length; i++) {
    	
        var row = [], cols = rows[i].querySelectorAll("td, th");
       
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
	</script>
  <?php if(isset($_SESSION['delete_master']))
      {
        $delete_master = $_SESSION['delete_master'];
      }
      else {
        $delete_master='';
      }
    if(isset($delete_master[17]))
        {if($delete_master[17]==1){?>
	<?php $filename='Login_History_'.$sd.'_to_'.$ed.'.csv'; ?>
	<button class="btn btn-sm btn-info " style="float:right!important" onclick="exportTableToCSV('<?php echo $filename;?>')"> Export CSV <i class="fa fa-download"></i></button><?php }  } ?>
	<table id="example"  class="table table-bordered">
                <thead>
                <tr>
                  <th>Sr No</th>
                  <th>User Name</th>
               
                  <th>Date</th>                  
                  <th>Login Time</th>
                   <th>First Call Time</th>
                    <th>Last Call Time</th>
                  <th>Logout Time</th>  
                  
              
                    
                </tr>
                </thead>
                <tbody>

                  <?php
        $i=0;
   /* if($_SESSION['user_id']==1)
    {
      print_r($summery_counts);
      if($summery_counts[0] !='')
      {
        echo "hi";
      }
    }*/
         if($summery_counts[0] !=''){ 
        foreach($summery_counts as $row)
        {

        $i++; 
        ?>
                <tr>
                   
                  
                  <td><?php echo $i;?></td>
 				          <td><?php echo 
 				          $row['user_name'];
 				         ?></td>
                  <td><?php echo   $row['login_date']; ?></td>
                  <td><?php echo   $row['login_time'];?></td>
                  <td><?php echo   $row['first_call']; ?></td>
                  <td><?php echo   $row['last_call']; ?></td>
                  
                  <td><?php echo   $row['logout_time'];?></td>
                 
               
               
                 
                
              
                 
                </tr>
<?php
	
}  } ?>
                 

              

                </tbody>

 
              </table>
             